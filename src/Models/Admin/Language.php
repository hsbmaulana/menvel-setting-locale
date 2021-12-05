<?php

namespace Menvel\SettingLocale\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
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
    protected $fillable = [ 'id', 'locale', ];

    /**
     * @var array
     */
    protected $hidden = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function translations()
    {
        return $this->hasMany(Translation::class);
    }
}