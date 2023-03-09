<?php
namespace Pyncer\Snyppet\Log\Table\Log;

use DateTime;
use DateTimeInterface;
use Pyncer\Data\Model\AbstractModel;

use function Pyncer\date_time as pyncer_date_time;

use const Pyncer\DATE_TIME_FORMAT as PYNCER_DATE_TIME_FORMAT;

class LogModel extends AbstractModel
{
    public function getLevel(): string
    {
        return $this->get('level');
    }
    public function setLevel(string $value): static
    {
        $this->set('level', $value);
        return $this;
    }

    public function getMessage(): string
    {
        return $this->get('message');
    }
    public function setMessage(string $value): static
    {
        $this->set('message', $value);
        return $this;
    }

    public function getContext(): ?string
    {
        return $this->get('context');
    }
    public function setContext(?string $value): static
    {
        $this->set('context', $this->nullify($value));
        return $this;
    }

    public function getInsertDateTime(): DateTime
    {
        $value = $this->get('insert_date_time');
        return pyncer_date_time($value);
    }
    public function setInsertDateTime(string|DateTimeInterface $value): static
    {
        if ($value instanceof DateTimeInterface) {
            $value = $value->format(PYNCER_DATE_TIME_FORMAT);
        }
        $this->set('insert_date_time', $value);
        return $this;
    }

    public static function getDefaultData(): array
    {
        $dateTime = pyncer_date_time()->format(PYNCER_DATE_TIME_FORMAT);

        return [
            'id' => 0,
            'level' => '',
            'message' => '',
            'context' => null,
            'insert_date_time' => $dateTime,
        ];
    }
}
