<?php

namespace Menvel\SettingLocale\Repositories\Eloquent\Admin;

use Error;
use Exception;
use Illuminate\Support\Facades\DB;
use Menvel\SettingLocale\Models\Admin\Language;
use Menvel\SettingLocale\Contracts\Repository\Admin\ISettingLocaleLanguageRepository;

class SettingLocaleLanguageRepository implements ISettingLocaleLanguageRepository
{
    /**
     * @param array $querystring
     * @return mixed
     */
    public function all($querystring = [])
    {
        $querystring =
        [
            'language_limit' => $querystring['language_limit'] ?? 10,
            'language_current_page' => $querystring['language_current_page'] ?? 1,
            'language_sort' => $querystring['language_sort'] ?? null,
            'language_search' => $querystring['language_search'] ?? null,
        ];
        extract($querystring);

        $content = Language::query()->
        when($language_sort, $language_sort)->
        when($language_search, $language_search)->
        paginate($language_limit, '*', 'language_current_page', $language_current_page)->appends($querystring);

        return $content;
    }

    /**
     * @param int|string $identifier
     * @param array $querystring
     * @return mixed
     */
    public function get($identifier, $querystring = [])
    {
        $content = Language::findOrFail($identifier);

        return $content;
    }

    /**
     * @param int|string $identifier
     * @param array $data
     * @return mixed
     */
    public function modify($identifier, $data)
    {
        $content = Language::findOrFail($identifier);

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
     * @param array $data
     * @return mixed
     */
    public function add($data)
    {
        $content = null;

        DB::beginTransaction();

        try {

            $content = Language::create($data);

            DB::commit();

        } catch (Exception $exception) {

            DB::rollback();
        }

        return $content;
    }

    /**
     * @param int|string $identifier
     * @return mixed
     */
    public function remove($identifier)
    {
        $content = Language::findOrFail($identifier);

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