<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plugin extends Model
{

    protected $table = 'plugins';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uniqueidentifier',
        'name',
        'screenshotUrl',
        'category',
        'demolink',
        'description',
        'provider',
        'type',
        'url',
        'downloadlink',

    ];


    public function setuniqueidentifierAttribute($value)
    {
        $this->attributes['uniqueidentifier'] = trim(strtolower($value));
    }

    public function setnameAttribute($value)
    {
        $this->attributes['name'] = trim(strtolower($value));
    }

    public function setdescriptionAttribute($value)
    {
        $this->attributes['description'] = trim(strtolower($value));
    }


}
