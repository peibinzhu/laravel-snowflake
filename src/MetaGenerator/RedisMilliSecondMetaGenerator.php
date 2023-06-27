<?php

declare(strict_types=1);

namespace PeibinLaravel\Snowflake\MetaGenerator;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;
use PeibinLaravel\Snowflake\Contracts\ConfigurationInterface;

class RedisMilliSecondMetaGenerator extends RedisMetaGenerator
{
    public function __construct(
        protected Container $container,
        ConfigurationInterface $configuration,
        int $beginTimestamp,
        Repository $config
    ) {
        parent::__construct($container, $configuration, $beginTimestamp * 1000, $config);
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
