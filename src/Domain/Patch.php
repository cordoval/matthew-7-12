<?php

namespace Grace\Domain;

class Patch extends BaseDomain
{
    protected $filename;

    public static function from($filename)
    {
        $patch = new self;
        $patch->filename = $filename;

        return $patch;
    }
}
