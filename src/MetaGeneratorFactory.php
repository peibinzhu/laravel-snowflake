<?php

declare(strict_types=1);

namespace PeibinLaravel\Snowflake;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;
use PeibinLaravel\Snowflake\Contracts\ConfigurationInterface;
use PeibinLaravel\Snowflake\Contracts\MetaGeneratorInterface;
use PeibinLaravel\Snowflake\MetaGenerator\RedisMilliSecondMetaGenerator;

class MetaGeneratorFactory
{
    public function __invoke(Container $container)
    {
        $config = $container->get(Repository::class);
        $beginSecond = $config->get('snowflake.begin_second', MetaGeneratorInterface::DEFAULT_BEGIN_SECOND);

        return $container->make(RedisMilliSecondMetaGenerator::class, [
            'configuration'  => $container->get(ConfigurationInterface::class),
            'beginTimestamp' => $beginSecond,
            'config'         => $config,
        ]);
    }
}
