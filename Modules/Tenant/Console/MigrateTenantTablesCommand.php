<?php

namespace Modules\Tenant\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;

class MigrateTenantTablesCommand extends Command
{
    protected $name = 'tenant:migration';

    protected $description = 'MigrateTenantTablesCommand';

    public function handle()
    {
        $this->call('tenants:migrate-fresh');
        $dirs = Arr::map(array_map('basename', File::directories(base_path('Modules'))), function (string $value) {
            return 'Modules/' . $value . '/database/migrations/tenant';
        });
        foreach ($dirs as $dir)
            $this->call('tenants:migrate', [
                '--path' => $dir
            ]);
        $this->call('tenants:seed');
    }
}
