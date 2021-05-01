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

to change Number of Records in **.env** add your num_of_records
```bash
THEMOVIEDB_NUM_OF_RECORDS=95
```
> by default 100 recourds

to use laravel Queue to handle the seeder task just enable it in **.env**:

```bash
THEMOVIEDB_ENABLE_QUEUE=true
```
> by default false

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
## schedule seed movies

to schedule seed movies we need to use  **php cron job** and laravel Task Scheduling.
in `app/Console/Kernel.php` file's `schedule` method just add 

```bash
     $schedule->command('themoviedb:seed top_rated_movies --force')->daily();
```

and can change daily to ather method that laravel accepts [here](https://laravel.com/docs/5.8/scheduling#schedule-frequency-options) 
