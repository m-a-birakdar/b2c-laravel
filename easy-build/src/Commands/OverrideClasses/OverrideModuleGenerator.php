<?php

namespace Birakdar\EasyBuild\Commands\OverrideClasses;

use Illuminate\Support\Str;
use Nwidart\Modules\Generators\ModuleGenerator;
use Nwidart\Modules\Support\Config\GenerateConfigReader;

class OverrideModuleGenerator extends ModuleGenerator
{
    public function generateResources()
    {
        if (GenerateConfigReader::read('seeder')->generate() === true) {
            $this->console->call('override-seed-make-command', [
                'name' => $this->getName(),
                'module' => $this->getName(),
                '--master' => true,
            ]);
        }

        if (GenerateConfigReader::read('provider')->generate() === true) {
            $this->console->call('override-provider-make-command', [
                'name' => $this->getName() . 'ServiceProvider',
                'module' => $this->getName(),
                '--master' => true,
            ]);
            $this->console->call('module:route-provider', [
                'module' => $this->getName(),
            ]);
        }
    }

    protected function getLowerNamePluralReplacement(): string
    {
        return Str::plural(strtolower($this->getName()));
    }
    protected function getStudlyNamePluralReplacement(): string
    {
        return Str::ucfirst(Str::plural(strtolower($this->getName())));
    }

    protected function getStubContents($stub): string
    {
        return (new OverrideStub(
            '/' . $stub . '.stub',
            $this->getReplacement($stub)
        )
        )->render();
    }

    public function getFiles()
    {
        return config('easy-build.stubs.files');
    }

    protected function getReplacement($stub): array
    {
        $replacements = config('easy-build.stubs.replacements');
        if (!isset($replacements[$stub])) {
            return [];
        }

        $keys = $replacements[$stub];

        $replaces = [];

        if ($stub === 'json' || $stub === 'composer') {
            if (in_array('PROVIDER_NAMESPACE', $keys, true) === false) {
                $keys[] = 'PROVIDER_NAMESPACE';
            }
        }
        foreach ($keys as $key) {
            if (method_exists($this, $method = 'get' . ucfirst(Str::studly(strtolower($key))) . 'Replacement')) {
                $replaces[$key] = $this->$method();
            } else {
                $replaces[$key] = null;
            }
        }
        return $replaces;
    }
}
