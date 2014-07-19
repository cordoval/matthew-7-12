<?php

namespace Grace\Collabs;

use Grace\Domain\Patch;

class Collabs
{
    public function zipper(Patch $patch)
    {
        return (new ZipperZippy())->zipAndBreak($patch);
    }

    public function mail(array $list, $manyCompressed)
    {
        foreach ($manyCompressed as $zipFile) {
            (new MailerSwift())
                ->create($list)
                ->attach($zipFile)
                ->send()
            ;
        }

        return true;
    }
}
