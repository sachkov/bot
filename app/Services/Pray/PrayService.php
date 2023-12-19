<?php

namespace App\Services\Pray;

use App\Contracts\Pray\PrayServiceContract;
use App\Models\Pray;
use App\Models\User;
use Carbon\Carbon;

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

    public function changeLength(string $date, Pray $pray): Pray
    {
        if (is_numeric($date)) {
            $end = Carbon::parse($pray->end_date);
            $pray->end_date = $end->addDays($date);
        } else {
            $pray->end_date = Carbon::parse($date);
        }
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
}
