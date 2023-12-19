<?php

namespace App\Library\Telegram\Commands;

use App\Models\State;
use Telegram\Bot\Commands\Command;

abstract class AbstractCommand extends Command
{
    public function handle()
    {
        // TODO: Implement handle() method.
        $this->manage();

        $state = State::where('user_id', $this->getUpdate()->getMessage()->from->id)->first();

        $state->class = self::class;
    }

    abstract public function manage();
}
