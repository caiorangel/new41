<?php

declare(strict_types=1);

namespace Billing\Domain\ValueObjects;

use JsonSerializable;

enum Status: int implements JsonSerializable
{
    case INACTIVE = 0;
    case ACTIVE = 1;

    /** @return int  */
    public function jsonSerialize(): int
    {
        return $this->value;
    }
}
