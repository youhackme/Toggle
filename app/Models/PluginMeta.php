<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PluginMeta extends Model
{
    protected $table = 'pluginmeta';

    protected $fillable = [
        'pluginid',
        'slug',
        'status',

    ];


    public function plugin()
    {
        return $this->belongsTo(Plugin::class, 'pluginid', 'id')->withDefault([
            'name'        => null,
            'description' => null,
        ]);
    }
}
