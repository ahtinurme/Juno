<?php

use Symfony\Component\HttpKernel\Debug\ErrorHandler;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/henrikbjorn/raekke/vendor/autoload.php';

ErrorHandler::register();

$debug = in_array($_SERVER['REMOTE_ADDR'], array(
    '127.0.0.1',
    'fe80::1',
    '::1',
    '::ffff:127.0.0.1',
));

$app = new Juno\Application($rootDir = __DIR__ . '/..', true);
$app->inject(array(
    'routing.resource' => $rootDir . '/src/Juno/Resources/config/routing.xml',
    'predis.clients' => array(
        'raekke' => array(
            'parameters' => 'tcp://localhost',
            'options' => array('prefix' => 'raekke:'),
        ),
    ),
));

// Run the thing
$app->run();
