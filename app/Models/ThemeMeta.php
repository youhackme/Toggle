<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThemeMeta extends Model
{
    protected $table = 'thememeta';

    protected $fillable = [
        'themeid',
        'slug',
        'screenshotExternalUrl',
        'screenshotHash',
        'authorname',
        'authorurl',
        'status',
    ];


    public function setslugAttribute($value)
    {
        $this->attributes['slug'] = trim(strtolower($value));
    }
}
