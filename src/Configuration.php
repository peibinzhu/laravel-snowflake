<?php

declare(strict_types=1);

namespace PeibinLaravel\Snowflake;

use PeibinLaravel\Snowflake\Contracts\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    protected int $millisecondBits = 41;

    protected int $dataCenterIdBits = 5;

    protected int $workerIdBits = 5;

    protected int $sequenceBits = 12;

    public function maxWorkerId(): int
    {
        return -1 ^ (-1 << $this->workerIdBits);
    }

    public function maxDataCenterId(): int
    {
        return -1 ^ (-1 << $this->dataCenterIdBits);
    }

    public function maxSequence(): int
    {
        return -1 ^ (-1 << $this->sequenceBits);
    }

    public function getTimestampLeftShift(): int
    {
        return $this->sequenceBits + $this->workerIdBits + $this->dataCenterIdBits;
    }

    public function getDataCenterIdShift(): int
    {
        return $this->sequenceBits + $this->workerIdBits;
    }

    public function getWorkerIdShift(): int
    {
        return $this->sequenceBits;
    }

    public function getTimestampBits(): int
    {
        return $this->millisecondBits;
    }

    public function getDataCenterIdBits(): int
    {
        return $this->dataCenterIdBits;
    }

    public function getWorkerIdBits(): int
    {
        return $this->workerIdBits;
    }

    public function getSequenceBits(): int
    {
        return $this->sequenceBits;
    }
}
