<?php

declare(strict_types=1);

use PeibinLaravel\Snowflake\Contracts\MetaGeneratorInterface;
use PeibinLaravel\Snowflake\MetaGenerator\RedisMilliSecondMetaGenerator;
use PeibinLaravel\Snowflake\MetaGenerator\RedisSecondMetaGenerator;

return [
    'begin_second'                       => MetaGeneratorInterface::DEFAULT_BEGIN_SECOND,
    RedisMilliSecondMetaGenerator::class => [
        'pool' => 'default',
    ],
    RedisSecondMetaGenerator::class      => [
        'pool' => 'default',
    ],
];
