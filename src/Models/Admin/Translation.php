<?php

namespace Menvel\SettingLocale\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var array
     */
    protected $fillable = [ 'id', 'translate', ];

    /**
     * @var array
     */
    protected $hidden = [ 'language_id', ];
}