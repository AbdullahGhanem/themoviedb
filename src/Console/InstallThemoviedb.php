<?php

namespace Ghanem\Themoviedb\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallThemoviedb extends Command
{
    protected $signature = 'themoviedb:install';

    protected $description = 'Install the Themoviedb';

    public function handle()
    {
        $this->info('Installing Themoviedb...');

        $this->info('Publishing configuration...');
        
        if (! $this->configExists('themoviedb.php')) {
            $this->publishConfiguration();
            $this->info('Published configuration');
        } else {
            if ($this->shouldOverwriteConfig()) {
                $this->info('Overwriting configuration file...');
                $this->publishConfiguration($force = true);
            } else {
                $this->info('Existing configuration was not overwritten');
            }
        }
        
        $this->info('Installed Themoviedb');
    }
    
    private function configExists($fileName)
    {
        return File::exists(config_path($fileName));
    }
    
    private function shouldOverwriteConfig()
    {
        return $this->confirm(
            'Config file already exists. Do you want to overwrite it?', 
            false
        );
    }

    private function publishConfiguration($forcePublish = false)
    {
        $params = [
            '--provider' => "Ghanem\Themoviedb\ThemoviedbServiceProvider",
            '--tag' => "config"
        ];
        
        if ($forcePublish === true) {
            $params['--force'] = '';
        }

       $this->call('vendor:publish', $params);
    }
}