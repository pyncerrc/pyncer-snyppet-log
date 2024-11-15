<?php
namespace Pyncer\Snyppet\Log;

use Psr\Http\Server\MiddlewareInterface as PsrMiddlewareInterface;
use Pyncer\Http\Server\MiddlewareInterface;
use Pyncer\Snyppet\Log\Middleware\InitializeLoggerMiddleware;
use Pyncer\Snyppet\Snyppet as BaseSnyppet;

use const Pyncer\Snyppet\Log\ENABLED as PYNCER_LOG_ENABLED;

class Snyppet extends BaseSnyppet
{
    /**
     * @inheritdoc
     */
    protected function initializeMiddleware(string $class): PsrMiddlewareInterface|MiddlewareInterface
    {
        if ($class === InitializeLoggerMiddleware::class) {
            return new $class(
                enabled: PYNCER_LOG_ENABLED,
            );
        }

        return parent::initializeMiddleware($class);
    }
}
