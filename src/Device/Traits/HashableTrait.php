<?php

namespace BRMControl\Device\Traits;

trait HashableTrait
{
    private function generateHash(string $str): string
    {
        return sha1($str);
    }
}
