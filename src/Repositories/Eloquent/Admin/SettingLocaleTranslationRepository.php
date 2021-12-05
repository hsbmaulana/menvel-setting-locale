<?php

namespace Menvel\SettingLocale\Repositories\Eloquent\Admin;

use Error;
use Exception;
use Illuminate\Support\Facades\DB;
use Menvel\SettingLocale\Models\Admin\Language;
use Menvel\SettingLocale\Models\Admin\Translation;
use Menvel\SettingLocale\Contracts\Repository\Admin\ISettingLocaleTranslationRepository;

class SettingLocaleTranslationRepository implements ISettingLocaleTranslationRepository
{
    /**
     * @param int|string $languageid
     * @param array $querystring
     * @return mixed
     */
    public function all($languageid, $querystring = [])
    {
        $querystring =
        [
            'translation_limit' => $querystring['translation_limit'] ?? 10,
            'translation_current_page' => $querystring['translation_current_page'] ?? 1,
            'translation_sort' => $querystring['translation_sort'] ?? null,
            'translation_search' => $querystring['translation_search'] ?? null,
        ];
        extract($querystring);

        $content = Language::findOrFail($languageid);
        $content = $content->setRelation('translations', $content->translations()->when($translation_sort, $translation_sort)->when($translation_search, $translation_search)->paginate($translation_limit, '*', 'translation_current_page', $translation_current_page)->appends($querystring));
        $content = $content->loadCount('translations');

        return $content;
    }

    /**
     * @param int|string $languageid
     * @param int|string $translationid
     * @param array $querystring
     * @return mixed
     */
    public function get($languageid, $translationid, $querystring = [])
    {
        $content = Language::findOrFail($languageid)->translations()->where('id', $translationid)->firstOrFail();

        return $content;
    }

    /**
     * @param int|string $languageid
     * @param int|string $translationid
     * @param array $data
     * @return mixed
     */
    public function modify($languageid, $translationid, $data)
    {
        $content = Language::findOrFail($languageid)->translations()->where('id', $translationid);

        DB::beginTransaction();

        try {

            $content = $content->update($data);

            DB::commit();

        } catch (Exception $exception) {

            DB::rollback();
        }

        return $content;
    }

    /**
     * @param int|string $languageid
     * @param array $data
     * @return mixed
     */
    public function add($languageid, $data)
    {
        $content = Language::findOrFail($languageid);

        DB::beginTransaction();

        try {

            $content = $content->translations()->create($data);

            DB::commit();

        } catch (Exception $exception) {

            DB::rollback();
        }

        return $content;
    }

    /**
     * @param int|string $languageid
     * @param int|string $translationid
     * @return mixed
     */
    public function remove($languageid, $translationid)
    {
        $content = Language::findOrFail($languageid)->translations()->where('id', $translationid);

        DB::beginTransaction();

        try {

            $content->delete();

            DB::commit();

        } catch (Exception $exception) {

            DB::rollback();
        }

        return $content;
    }
}