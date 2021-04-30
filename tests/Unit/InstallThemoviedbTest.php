<?php

namespace Ghanem\Themoviedb\Tests\Unit;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Ghanem\Themoviedb\Tests\TestCase;

class InstallThemoviedbTest extends TestCase
{
    /** @test */
    function the_install_command_copies_the_configuration()
    {
        // make sure we're starting from a clean state
        if (File::exists(config_path('themoviedb.php'))) {
            unlink(config_path('themoviedb.php'));
        }

        $this->assertFalse(File::exists(config_path('themoviedb.php')));

        Artisan::call('themoviedb:install');

        $this->assertTrue(File::exists(config_path('themoviedb.php')));
    }
}