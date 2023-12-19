<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function state(): BelongsTo
    {
        return $this->BelongsTo(State::class);
    }
}
