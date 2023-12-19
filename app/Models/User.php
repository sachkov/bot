<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getNameAttribute()
    {
        if ($this->first_name && $this->second_name) {
            return $this->first_name . ', ' . $this->second_name;
        }
        return $this->first_name ?: $this->second_name;
    }

    public function state(): BelongsTo
    {
        return $this->BelongsTo(State::class);
    }
}
