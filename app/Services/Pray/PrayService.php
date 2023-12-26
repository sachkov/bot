<?php

namespace App\Services\Pray;

use App\Contracts\Pray\PrayServiceContract;
use App\Library\Enum\CallbackEnum;
use App\Library\Telegram\Keyboards\InlineKeyboardButton;
use App\Library\Telegram\Keyboards\InlineKeyboardMarkup;
use App\Models\Pray;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Cache;

class PrayService implements PrayServiceContract
{
    public function saveDescription(string $description, User $user, ?Pray $pray = null): Pray
    {
        if (is_null($pray)) {
            return $this->quickAdd($description, $user);
        }

        $pray->description = $description;
        $pray->save();

        return $pray;
    }

    public function setLength(Pray $pray, string $date): Pray
    {
        if (is_numeric($date)) {
            $end = Carbon::parse($pray->created_at);
            $pray->end_date = $end->addDays($date);
        } else {
            $pray->end_date = Carbon::parse($date);
        }
        $pray->save();

        return $pray;
    }

    public function increaseLength(Pray $pray, string $date): Pray
    {
        $end = Carbon::parse($pray->end_date);
        $pray->end_date = $end->addDays($date);
        $pray->save();

        return $pray;
    }

    public function quickAdd(string $text, User $user): Pray
    {
        $end_date = Carbon::now()
            ->addDays(config('params.default.pray_length'))
            ->format('Y-m-d');

        return Pray::create([
            'description'   => $text,
            'end_date'      => $end_date,
            'author_id'     => $user->id,
            'showed'        => 0,
        ]);
    }

    public function list(User $user, int $page=1): array
    {
        $order = config('params.list.default_order');
        $limit = config('params.list.limit');

        $cache_key = 'prays_' . $user->id;

        $seen = json_decode(Cache::get($cache_key)) ?? [];
        $offset = ($page - 1) * $limit;

        $query = Pray::query()
            ->where('author_id', $user->id)
            ->where('end_date', '>', Carbon::now())
            ->whereNotIn('id', $seen)
            ->offset($offset)
            ->orderBy($order);

        $total = $query->count();

        $prays = $query
            ->limit($limit)
            ->get();

        $text = '';
        $showed = [];
        foreach ($prays as $pray) {
            $text .= $pray->description . PHP_EOL;
            $showed[] = $pray->id;
        }

        $next = false;
        if ($total > $limit) {
            $next = true;
            Cache::put($cache_key, json_encode(array_merge($seen, $showed)), config('params.list.cache_ttl'));
        } else {
            Cache::forget($cache_key);
        }

        Pray::query()
            ->whereIn('id', $showed)
            ->increment('showed');

        return [$text, $next];
    }

    public function getEditMessage(User $user, int $page=1): array
    {
        $order = config('params.edit.default_order');
        $limit = config('params.edit.limit');

        $cache_key = 'prays_edit_' . $user->id;

        $seen = json_decode(Cache::get($cache_key)) ?? [];
        $offset = ($page - 1) * $limit;

        $query = Pray::query()
            ->where('author_id', $user->id)
            ->where('end_date', '>', Carbon::now()->subDay())
            ->whereNotIn('id', $seen)
            ->offset($offset)
            ->orderBy($order);

        $total = $query->count();

        $prays = $query
            ->limit($limit)
            ->get();

        $text = '';
        $i = 1;
        $buttons = [];
        $showed = [];
        $level = 0;
        $cb_data_num = ['h' => CallbackEnum::EDIT_PRAY_SHOW->value];
        foreach ($prays as $pray) {
            $text .= $i . ') ' . mb_substr($pray->description, 0, 15) . '...' . PHP_EOL;

            $cb_data_num['pray'] = $pray->id;
            $buttons[$level][] = new InlineKeyboardButton($i, $cb_data_num);

            if (!$level && $i > 3) {
                $level++;
            }
            $showed[] = $pray->id;
            $i++;
        }
        $text .= 'Выберете номер молитвы для редактирования';

        $res = ['text' => $text];

        $next = false;
        if ($total > $limit) {
            $next = true;
            Cache::put($cache_key, json_encode(array_merge($seen, $showed)), config('params.edit.cache_ttl'));
        } else {
            Cache::forget($cache_key);
        }

        if ($next) {
            $cb_data_next = [
                'h' => CallbackEnum::EDIT_PRAY->value,
                'page' => $page + 1
            ];
            $buttons[$level][] = new InlineKeyboardButton('next', $cb_data_next);
        }
        $keyboard = new InlineKeyboardMarkup($buttons);
        $res['reply_markup'] = $keyboard->toJson();

        return $res;
    }
}
