<?php

namespace Birakdar\EasyBuild\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateModule extends Command
{
    protected $signature = 'easy-build:generate {name*}';

    protected $description = 'Generate module with all files';

    public function handle(): void
    {
        foreach ($this->argument('name') as $name)
            $this->make(Str::ucfirst(Str::singular($name)));
        $this->info('Flush all cache files');
        $this->call("optimize:clear");
    }

    public function make($name)
    {
        $this->info('Generate module from package');
        if ($this->call("override-module-make-command", ['name' => [$name]]) == 0)
            $this->generate($name);
    }

    public function generate($name)
    {
        $this->info('Generate model');
        $this->call("override-model-make-command", ['model' => $name, 'module' => $name, '--fillable' => 'name', '--migration' => true]);
        $this->info('Generate repository');
        $this->call("generate:repository", ['repository' => 'Web/'. $name . 'Repository ', 'module' => $name, '--interface' => true, '--i' => true]);
        $this->info('Generate api repository');
        $this->call("generate:repository", ['repository' => 'Api/V1/'. $name . 'Repository ', 'module' => $name, '--interface' => true, '--i' => true]);
        $this->info('Generate Web Controller');
        $this->call('override-controller-make-command', ['controller' => 'Web/' . $name . 'Controller', 'module' => $name]);
        $this->info('Generate Api Controller');
        $this->call('override-controller-make-command', ['controller' => 'Api/V1/' . $name . 'Controller', 'module' => $name, '--api' => true]);
        $this->info('Generate Web Request');
        $this->call('override-request-make-command', ['name' => 'Web/' . $name . 'Request', 'module' => $name]);
        $this->info('Generate Api Request');
        $this->call('override-request-make-command', ['name' => 'Api/V1/' . $name . 'Request', 'module' => $name]);
        $this->info('Generate Api Resource');
        $this->call('override-resource-make-command', ['name' => 'Api/V1/' . $name . 'Resource', 'module' => $name]);
        $this->info('Generate Factory');
        $this->call('override-factory-make-command', ['name' => $name , 'module' => $name]);
    }
}
