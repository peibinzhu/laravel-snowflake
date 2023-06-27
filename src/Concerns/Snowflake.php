<?php

declare(strict_types=1);

namespace PeibinLaravel\Snowflake\Concerns;

use Illuminate\Container\Container;
use PeibinLaravel\Snowflake\Contracts\IdGeneratorInterface;

trait Snowflake
{
    public function creating(): void
    {
        if (!$this->getKey()) {
            $container = Container::getInstance();
            $generator = $container->get(IdGeneratorInterface::class);
            $this->{$this->getKeyName()} = $generator->generate();
        }
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'int';
    }
}
