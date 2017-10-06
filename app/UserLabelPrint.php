<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\UserScope;

class UserLabelPrint extends Model
{
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new UserScope);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'raw_data', 'printed', 'user_id', 'quantity', 'creator'
    ];
}
