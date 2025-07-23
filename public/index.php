<?php

use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

file_put_contents('/tmp/debug.log', 'index.php loaded'.PHP_EOL, FILE_APPEND);

return function (array $context) {
    file_put_contents('/tmp/debug.log', 'Kernel created'.PHP_EOL, FILE_APPEND);
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
