<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public function __construct($user)
    {
        $this->user = $user;
    }
}
