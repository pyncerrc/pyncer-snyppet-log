<?php
namespace Pyncer\Snyppet\Log\Table\Log;

use Pyncer\Data\Mapper\AbstractMapper;
use Pyncer\Data\Model\ModelInterface;
use Pyncer\Snyppet\Log\Table\Log\LogModel;

class LogMapper extends AbstractMapper
{
    public function getTable(): string
    {
        return 'log';
    }

    public function forgeModel(iterable $data = []): ModelInterface
    {
        return new LogModel($data);
    }

    public function isValidModel(ModelInterface $model): bool
    {
        return ($model instanceof LogModel);
    }
}
