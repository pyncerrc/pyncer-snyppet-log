<?php
namespace Pyncer\Snyppet\Sentry\Middleware;

use Psr\Http\Message\ResponseInterface as PsrResponseInterface;
use Psr\Http\Message\ServerRequestInterface as PsrServerRequestInterface;
use Psr\Log\LoggerInterface as PsrLoggerInterface;
use Pyncer\App\Identifier as ID;
use Pyncer\Data\Mapper\MapperAdaptorInterface;
use Pyncer\Exception\UnexpectedValueException;
use Pyncer\Http\Server\MiddlewareInterface;
use Pyncer\Http\Server\RequestHandlerInterface;
use Pyncer\Log\DatabaseLogger;
use Pyncer\Log\GroupLogger;

class InitializeLoggerMiddleware implements MiddlewareInterface
{
    protected bool $enabled;

    public function __construct(
        bool $enabled = false,
    ) {
        $this->setEnabled($enabled);
    }

    public function getEnabled(): bool
    {
        return $this->enabled;
    }
    public function setEnabled(bool $value): static
    {
        $this->enabled = $value;
        return $this;
    }

    public function __invoke(
        PsrServerRequestInterface $request,
        PsrResponseInterface $response,
        RequestHandlerInterface $handler
    ): PsrResponseInterface
    {
        if (!$this->getEnabled()) {
            return $handler->next($request, $response);
        }

        if (!$handler->has(ID::mapperAdaptor('log'))) {
            throw new UnexpectedValueException('Mapper adaptor expected.');
        }

        $mapperAdaptor = $handler->get(ID::mapperAdaptor('log'));
        if (!$mapperAdaptor instanceof MapperAdaptorInterface) {
            throw new UnexpectedValueException(
                'Invalid mapper adaptor.'
            );
        }

        $logger = new DatabaseLogger($mapperAdaptor);

        if ($handler->has(ID::LOGGER)) {
            $existingLogger = $handler->get(ID::LOGGER);

            if ($existingLogger instanceof GroupLogger) {
                $existingLogger->addLogger($logger);
            } elseif ($existingLogger instanceof PsrLoggerInterface) {
                $logger->inherit($existingLogger);
                $handler->set(ID::LOGGER, $logger);
            } else {
                throw new UnexpectedValueException('Invalid logger.');
            }
        } else {
            $handler->set(ID::LOGGER, $logger);
        }

        return $handler->next($request, $response);
    }
}