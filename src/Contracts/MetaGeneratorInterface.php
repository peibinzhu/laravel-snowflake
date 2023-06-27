<?php

declare(strict_types=1);

namespace PeibinLaravel\Snowflake\Contracts;

use PeibinLaravel\Snowflake\Meta;

interface MetaGeneratorInterface
{
    public const DEFAULT_BEGIN_SECOND = 1560960000;

    public function generate(): Meta;

    public function getBeginTimestamp(): int;

    public function getConfiguration(): ConfigurationInterface;
}
