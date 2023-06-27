<?php

declare(strict_types=1);

namespace PeibinLaravel\Snowflake\Contracts;

use PeibinLaravel\Snowflake\Meta;

interface IdGeneratorInterface
{
    /**
     * Generate an ID by meta, if meta is null, then use the default meta.
     */
    public function generate(?Meta $meta = null): int;

    /**
     * Degenerate the meta by ID.
     */
    public function degenerate(int $id): Meta;
}
