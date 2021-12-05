<?php

namespace Menvel\SettingLocale\Repositories\Eloquent;

use Error;
use Exception;
use Illuminate\Support\Facades\DB;
use Menvel\Repository\AbstractRepository;
use Menvel\Setting\Scopes\StrictScope;
use Menvel\SettingLocale\Events\Localing;
use Menvel\SettingLocale\Events\Localed;
use Menvel\Setting\Contracts\Repository\ISettingRepository;
use Menvel\SettingLocale\Contracts\Repository\ISettingLocaleRepository;
use Menvel\SettingLocale\Contracts\Repository\Admin\ISettingLocaleLanguageRepository;
use Menvel\SettingLocale\Contracts\Repository\Admin\ISettingLocaleTranslationRepository;

class SettingLocaleRepository extends AbstractRepository implements ISettingLocaleRepository
{
    /**
     * @var string
     */
    protected $space;

    /**
     * @var \Menvel\Setting\Contracts\Repository\ISettingRepository
     */
    protected $setting;

    /**
     * @var \Menvel\SettingLocale\Contracts\Repository\Admin\ISettingLocaleLanguageRepository
     */
    protected $language;

    /**
     * @var \Menvel\SettingLocale\Contracts\Repository\Admin\ISettingLocaleTranslationRepository
     */
    protected $translation;

    /**
     * @param \Menvel\Setting\Contracts\Repository\ISettingRepository $setting
     * @param \Menvel\SettingLocale\Contracts\Repository\Admin\ISettingLocaleLanguageRepository $language
     * @param \Menvel\SettingLocale\Contracts\Repository\Admin\ISettingLocaleTranslationRepository $translation
     * @return void
     */
    public function __construct(ISettingRepository $setting, ISettingLocaleLanguageRepository $language, ISettingLocaleTranslationRepository $translation)
    {
        $this->space = StrictScope::$space . '.' . 'locale';
        $this->setting = $setting;
        $this->language = $language;
        $this->translation = $translation;
    }

    /**
     * @return void
     */
    public function __destruct()
    {}

    /**
     * @return mixed
     */
    public function language()
    {
        $user = $this->user; $content = null;

        try {

            $content = $user->load('locale')->locale->id;

        } catch (Error | Exception $throwable) {

            $content = null;
        }

        return $content;
    }

    /**
     * @param int|string $translation
     * @return mixed
     */
    public function translate($translation)
    {
        $user = $this->user; $content = null;

        try {

            $content = $user->load([ 'locale.translations' => function ($query) use ($translation) { return $query->where('id', $translation)->firstOrFail(); } , ])->locale->translations->firstOrFail()->translate;

        } catch (Error | Exception $throwable) {

            $content = $translation;
        }

        return $content;
    }

    /**
     * @param int|string|null $identifier
     * @param array $data
     * @return mixed
     */
    public function modify($identifier, $data)
    {
        $this->setting->setUser($this->getUser());

        $content = $this->setting->setup($this->space, $this->language->get($data['locale'])->getKey());

        event(new Localed($content));

        return $content;
    }

    /**
     * @param string $language
     * @return mixed
     */
    public function setLocale($language)
    {
        return $this->modify(null, [ 'locale' => $language, ]);
    }
}