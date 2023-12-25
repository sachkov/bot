<?php

namespace App\Services\Pray;

use App\Contracts\Pray\PrayServiceContract;
use App\Models\Pray;
use App\Models\User;
use Carbon\Carbon;
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
        if ($total > 5) {
            $next = true;
            Cache::put($cache_key, json_encode(array_merge($seen, $showed)), 12*60*60);
        } else {
            Cache::forget($cache_key);
        }

        Pray::query()
            ->whereIn('id', $showed)
            ->increment('showed');

        return [$text, $next];
    }
}
