<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $table = 'themes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uniqueidentifier',
        'name',
        'url',
        'downloadlink',
        'previewlink',
        'description',
        'screenshoturl',
        'provider',
        'type',
    ];

    /**
     * Get the meta associated with a theme
     */
    public function themeMeta()
    {
        return $this->hasMany(ThemeMeta::class, 'themeid', 'id');
    }

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
