<?php

namespace Menvel\SettingLocale;

use Menvel\SettingLocale\Observers\LocaleObserver;
use Menvel\Repository\RepositoryServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class SettingLocaleServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    public static $locale = 'id-ID';

    /**
     * @var string
     */
    public static $description = 'Indonesia';

    /**
     * @var array
     */
    protected $map =
    [
        \Menvel\SettingLocale\Contracts\Repository\ISettingLocaleRepository::class => \Menvel\SettingLocale\Repositories\Eloquent\SettingLocaleRepository::class,
        \Menvel\SettingLocale\Contracts\Repository\Admin\ISettingLocaleLanguageRepository::class => \Menvel\SettingLocale\Repositories\Eloquent\Admin\SettingLocaleLanguageRepository::class,
        \Menvel\SettingLocale\Contracts\Repository\Admin\ISettingLocaleTranslationRepository::class => \Menvel\SettingLocale\Repositories\Eloquent\Admin\SettingLocaleTranslationRepository::class,
    ];

    /**
     * @return void
     */
    public function boot()
    {
        parent::boot();

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->dataEventListener();
    }

    /**
     * @return void
     */
    public function dataEventListener()
    {
        call_user_func(Auth::guard()->getProvider()->getModel() . '::' . 'observe', LocaleObserver::class);
    }
}