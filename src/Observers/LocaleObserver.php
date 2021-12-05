<?php

namespace Menvel\SettingLocale\Observers;

use Menvel\SettingLocale\SettingLocaleServiceProvider;
use Menvel\SettingLocale\Contracts\Repository\ISettingLocaleRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LocaleObserver
{
    /**
     * @var \Menvel\SettingLocale\Contracts\Repository\ISettingLocaleRepository
     */
    protected $locale;

    /**
     * @param \Menvel\SettingLocale\Contracts\Repository\ISettingLocaleRepository $locale
     * @return void
     */
    public function __construct(ISettingLocaleRepository $locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return void
     */
    public function __destruct()
    {}

    /**
     * @param \Illuminate\Contracts\Auth\Authenticatable $data
     * @return void
     */
    public function created($data)
    {
        $this->locale->setUser($data);

        $this->locale->setLocale(SettingLocaleServiceProvider::$locale);
    }
}