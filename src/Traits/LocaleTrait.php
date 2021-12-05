<?php

namespace Menvel\SettingLocale\Traits;

use Menvel\Setting\Models\Setting;
use Menvel\SettingLocale\Models\Admin\Language;
use Illuminate\Support\Str;

trait LocaleTrait
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function locale()
    {
        return $this->hasOneThrough(Language::class, Setting::class, Str::of($this->getTable())->singular() . '_' . 'id', 'id', 'id', 'value');
    }
}