<?php

declare(strict_types=1);

namespace PeibinLaravel\Snowflake\MetaGenerator;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;
use PeibinLaravel\Snowflake\Contracts\ConfigurationInterface;

class RedisSecondMetaGenerator extends RedisMetaGenerator
{
    public function __construct(
        protected Container $container,
        ConfigurationInterface $configuration,
        int $beginTimestamp,
        Repository $config
    ) {
        parent::__construct($container, $configuration, $beginTimestamp, $config);
    }

    public function getTimestamp(): int
    {
        return time();
    }

    public function getNextTimestamp(): int
    {
        return $this->lastTimestamp + 1;
    }

    protected function clockMovedBackwards($timestamp, $lastTimestamp)
    {
        // Don't throw exception
    }
}
