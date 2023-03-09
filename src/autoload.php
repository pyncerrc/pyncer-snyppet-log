<?php
use Pyncer\Snyppet\SnyppetManager;
use Pyncer\Snyppet\Snyppet;

SnyppetManager::register(new Snyppet(
    'log',
    dirname(__DIR__),
    [
        'initialize' => ['Initialize']
    ],
));
