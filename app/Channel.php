<?php

namespace App;

use App\Model;

class Channel extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
