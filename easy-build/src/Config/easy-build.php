<?php

return [
    'stubs' => [
        'files' => [
            'routes/web' => 'Routes/web.php',
            'routes/api' => 'Routes/api.php',
            'views/index' => 'Resources/views/index.blade.php',
            'views/create' => 'Resources/views/create.blade.php',
            'views/edit' => 'Resources/views/edit.blade.php',
            'views/show' => 'Resources/views/show.blade.php',
            'scaffold/config' => 'Config/config.php',
        ],
        'replacements' => [
            'routes/web' => ['LOWER_NAME', 'STUDLY_NAME', 'LOWER_NAME_PLURAL'],
            'routes/api' => ['LOWER_NAME', 'STUDLY_NAME', 'LOWER_NAME_PLURAL'],
            'json' => ['LOWER_NAME', 'STUDLY_NAME', 'MODULE_NAMESPACE', 'PROVIDER_NAMESPACE'],
            'views/index' => ['LOWER_NAME', 'STUDLY_NAME_PLURAL'],
            'views/create' => ['LOWER_NAME', 'STUDLY_NAME_PLURAL', 'LOWER_NAME_PLURAL'],
            'views/edit' => ['LOWER_NAME', 'STUDLY_NAME_PLURAL', 'LOWER_NAME_PLURAL'],
            'views/show' => ['LOWER_NAME', 'STUDLY_NAME_PLURAL', 'LOWER_NAME_PLURAL'],
            'scaffold/config' => ['STUDLY_NAME'],
        ],
    ],
];
