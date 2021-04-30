# Laravel Package for Seed themoviedb


[![Total Downloads](https://img.shields.io/packagist/dt/ghanem/themoviedb.svg?style=flat-square)](https://packagist.org/packages/ghanem/themoviedb)
## Installation

You can install the package via composer:

```bash
composer require ghanem/themoviedb
```

first you should run migration it will make migration
```bash
php artisan migrate
```

now you need to publish the config file with:
```bash
php artisan vendor:publish --provider="Ghanem\Themoviedb\ThemoviedbServiceProvider" --tag="config"
```

## Integration

first you need to create account in [themoviedb](https://www.themoviedb.org/) and submit to get key

in **.env** add your key
```bash
THEMOVIEDB_KEY=5ff64c4b2fa1a61026e627a62XxXxX
```

## Seed Movies

this package create command to seed Movies and Genres
```bash
php artisan themoviedb:seed top_rated_movies
```

## Endpoint Movies

you can access Endpoint form 
```bash
{domian}/movies
```
if you need add prefix or midlware just open **config/themoviedb.php**
```bash
return [
     ....
    'prefix' => '/',
    'middleware' => ['web'],
];
```
