<h1 align="center">Menvel-Setting-Locale</h1>

Menvel-Setting-Locale is a setting locale helper for Lumen and Laravel.

Getting Started
---

Installation :

```
$ composer require hsbmaulana/menvel-setting-locale
```

How to use it :

- Put `Menvel\SettingLocale\SettingLocaleServiceProvider` to service provider configuration list.

- Migrate.

```
$ php artisan migrate
```

- Sample usage.

```php
use Menvel\SettingLocale\Contracts\Repository\ISettingLocaleRepository;

$repository = app(ISettingLocaleRepository::class);
// $repository->setUser(...); //
// $repository->getUser(); //

// $repository->setLocale('id-ID'); //
// $repository->translate('...'); //
// $repository->language(); //
```

Author
---

- Hasby Maulana ([@hsbmaulana](https://linkedin.com/in/hsbmaulana))
