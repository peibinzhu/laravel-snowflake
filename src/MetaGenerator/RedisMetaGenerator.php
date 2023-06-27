<?php

declare(strict_types=1);

namespace PeibinLaravel\Snowflake\MetaGenerator;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;
use PeibinLaravel\Coroutine\Locker;
use PeibinLaravel\RedisPool\RedisProxy;
use PeibinLaravel\Snowflake\Contracts\ConfigurationInterface;
use PeibinLaravel\Snowflake\MetaGenerator;
use Redis;

abstract class RedisMetaGenerator extends MetaGenerator
{
    public const DEFAULT_REDIS_KEY = 'laravel:snowflake:workerId';

    protected ?int $workerId = null;

    protected ?int $dataCenterId = null;

    public function __construct(
        protected Container $container,
        ConfigurationInterface $configuration,
        int $beginTimestamp,
        protected Repository $config
    ) {
        parent::__construct($configuration, $beginTimestamp);
    }

    public function init()
    {
        if (is_null($this->workerId) || is_null($this->dataCenterId)) {
            if (Locker::lock(static::class)) {
                try {
                    $this->initDataCenterIdAndWorkerId();
                } finally {
                    Locker::unlock(static::class);
                }
            }
        }
    }

    public function getDataCenterId(): int
    {
        $this->init();

        return $this->dataCenterId;
    }

    public function getWorkerId(): int
    {
        $this->init();

        return $this->workerId;
    }

    private function initDataCenterIdAndWorkerId(): void
    {
        if (is_null($this->workerId) || is_null($this->dataCenterId)) {
            $pool = $this->config->get(sprintf('snowflake.%s.pool', static::class), 'default');

            /** @var Redis $redis */
            $redis = $this->container->make(RedisProxy::class, ['pool' => $pool]);

            $key = $this->config->get(sprintf('snowflake.%s.key', static::class), static::DEFAULT_REDIS_KEY);
            $id = $redis->incr($key);

            $this->workerId = $id % $this->configuration->maxWorkerId();
            $this->dataCenterId =
                intval($id / $this->configuration->maxWorkerId())
                %
                $this->configuration->maxDataCenterId();
        }
    }
}
