<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class EvilUser extends Model
{
    protected $table = 'user_of_evil';

    protected $hidden = [
        'password', 'salt',
    ];
}
