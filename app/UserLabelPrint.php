<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLabelPrint extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'raw_data', 'printed', 'user_id', 'quantity', 'creator'
    ];
}
