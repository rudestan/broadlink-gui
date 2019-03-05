<?php

namespace BRMControl\Device\Traits;

use Ramsey\Uuid\Uuid;

trait HashableTrait
{
    private function generateHash(string $str, ?string $nameSpace = Uuid::NAMESPACE_OID): string
    {
        return Uuid::uuid5($nameSpace, $str);
    }
}
