<?php

declare(strict_types=1);

namespace PeibinLaravel\Snowflake\MetaGenerator;

use PeibinLaravel\Snowflake\Contracts\ConfigurationInterface;
use PeibinLaravel\Snowflake\MetaGenerator;

class RandomMilliSecondMetaGenerator extends MetaGenerator
{
    public function __construct(ConfigurationInterface $configuration, int $beginTimestamp)
    {
        parent::__construct($configuration, $beginTimestamp * 1000);
    }

    public function getDataCenterId(): int
    {
        return rand(0, 31);
    }

    public function getWorkerId(): int
    {
        return rand(0, 31);
    }

    public function getTimestamp(): int
    {
        return intval(microtime(true) * 1000);
    }

    public function getNextTimestamp(): int
    {
        $timestamp = $this->getTimestamp();
        while ($timestamp <= $this->lastTimestamp) {
            $timestamp = $this->getTimestamp();
        }

        return $timestamp;
    }
}
