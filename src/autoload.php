<?php
use Pyncer\Snyppet\Snyppet;
use Pyncer\Snyppet\SnyppetManager;

SnyppetManager::register(new Snyppet(
    'log',
    dirname(__DIR__),
    [
        'initialize' => ['Initialize', 'InitializeLogger']
    ],
));
