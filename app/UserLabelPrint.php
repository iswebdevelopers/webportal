<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\UserScope;
use Carbon\Carbon;

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

    /**
     * Get the user label print updated at field.
     *
     * @param  string  $value
     * @return string
     */
    public function getUpdatedAtAttribute($value)
    {
    	return Carbon::parse($value)->toDayDateTimeString();
    }

    /**
     * Scope print.
     *
     * @param  string  $query
     * @return string
     */
    public function scopePrint($query)
    {
        return $query->where('printed','0');
    }

    /**
     * Scope Archived.
     *
     * @param  string  $query
     * @return string
     */
    public function scopeArchived($query)
    {
        return $query->where('printed','1');
    }    
}
