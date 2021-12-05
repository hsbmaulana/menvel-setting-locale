<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Menvel\SettingLocale\SettingLocaleServiceProvider;
use Menvel\SettingLocale\Contracts\Repository\Admin\ISettingLocaleLanguageRepository;
use Menvel\SettingLocale\Contracts\Repository\Admin\ISettingLocaleTranslationRepository;

class CreateLocalesTable extends Migration
{
    /**
     * @var \Menvel\SettingLocale\Contracts\Repository\Admin\ISettingLocaleLanguageRepository
     */
    protected $language;

    /**
     * @var \Menvel\SettingLocale\Contracts\Repository\Admin\ISettingLocaleTranslationRepository
     */
    protected $translation;

    /**
     * @return void
     */
    public function __construct()
    {
        $this->language = app(ISettingLocaleLanguageRepository::class);
        $this->translation = app(ISettingLocaleTranslationRepository::class);
    }

    /**
     * @return void
     */
    public function __destruct()
    {}

    /**
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {

            $table->char('id', 5);

            $table->string('locale');

            $table->primary('id');
        });

        Schema::create('translations', function (Blueprint $table) {

            $table->string('id');
            $table->char('language_id', 5);

            $table->text('translate');

            $table->primary([ 'id', 'language_id', ]);
            $table->foreign('language_id')->references('id')->on('languages')->onUpdate('cascade')->onDelete('cascade');
        });

        $this->language->add([ 'id' => SettingLocaleServiceProvider::$locale, 'locale' => SettingLocaleServiceProvider::$description, ]);
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('translations');
        Schema::dropIfExists('languages');
    }
}