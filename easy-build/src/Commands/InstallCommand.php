<?php

namespace Birakdar\EasyBuild\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'easy-build:install';

    protected $description = 'Install package';

    public function handle()
    {
        $this->publish();
        $this->composer();
        $this->table(
            ['Publish Assets', 'Composer dump-autoload', 'Install package'],
            [['Done', $this->dump, 'Done']]
        );
        $this->info("Now you can create many Module by type");
        $this->alert('php artisan easy-build:generate User Category Product');
    }

    private function publish()
    {
        $this->call("vendor:publish", [
            '--tag' => ['easy-build-assets', 'easy-build-route'],
        ]);
    }

    private string $dump = 'Not necessary';

    private function composer()
    {
        $this->line("Add Modules to composer");
        $composer = json_decode(file_get_contents(base_path('composer.json')), true);
        if (! array_key_exists('Modules\\', $composer['autoload']['psr-4'])) {
            $composer['autoload']['psr-4']['Modules\\'] = 'Modules/';
            $json = json_encode($composer, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            file_put_contents(base_path('composer.json'), $json);
            $this->dumpAutoload();
        }
    }

    private function dumpAutoload()
    {
        $this->line("Composer dump-autoload Start");
        $this->alert('Dumping please wait');
        if (app()->version()[0] == '9'){
            $this->dump9();
        } else {
            $this->dump10();
        }
    }

    private function dump9()
    {
        exec('composer dump-autoload');
        $this->line("Composer dump-autoload Done");
        $this->dump = 'Done';
    }

    private function dump10()
    {
        $result = \Illuminate\Support\Facades\Process::run('composer dump-autoload');
        echo $result->output();
        if ($result->successful()){
            $this->line("Composer dump-autoload Done");
            $this->dump = 'Done';
        } else {
            $this->dump = 'Error';
        }
    }

}
