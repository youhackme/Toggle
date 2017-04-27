<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Plugin.
 */
class Plugin extends Model
{
    /**
     * @var string
     */
    protected $table = 'plugins';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uniqueidentifier',
        'name',
        'screenshoturl',
        'category',
        'description',
        'provider',
        'type',
        'previewlink',
        'downloadlink',

    ];

    /**
     * @param $value
     */
    public function setuniqueidentifierAttribute($value)
    {
        $this->attributes['uniqueidentifier'] = trim(strtolower($value));
    }

    /**
     * @param $value
     */
    public function setnameAttribute($value)
    {
        $this->attributes['name'] = trim(strtolower($value));
    }

    /**
     * @param $value
     */
    public function setdescriptionAttribute($value)
    {
        $this->attributes['description'] = trim(strtolower($value));
    }

    /**
     * @param $value
     */
    public function setpreviewlinkAttribute($value)
    {
        $this->attributes['previewlink'] = trim(strtolower($value));
    }
}
