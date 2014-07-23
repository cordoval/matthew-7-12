<?php

namespace Grace\Collabs;

use Alchemy\Zippy\Zippy;

class ZipperZippy implements Zipper
{
    protected $fs;
    protected $zipAdapter;

    public function __construct(FileSystem $fs)
    {
        $this->fs = $fs;
        $zippy = Zippy::load();
        $this->zipAdapter = $zippy->getAdapterFor('zip');
    }

    public function zipAndBreak(array $patches)
    {
        // creates
        $archiveZip = $zippy->create('archive.zip');

        // updates
        $archiveZip->addMembers([
                '/path/to/file',
                '/path/to/file2',
                '/path/to/dir'
            ],
            $recursive = false
        );

        // lists
        foreach ($archiveZip as $member) {
            if ($member->isDir()) {
                continue;
            }

            echo $member->getLocation(); // outputs /path/to/file
        }

        // zip
        // zip -s 2 --output split_zip_
        $files = $finder->file()->in()->expr();
        foreach ($files as $file) {
            $manyCompressed[] = $file->getName();
        }

        return $manyCompressed;
    }

    public function unzipAndJoin()
    {
        foreach (['archive.zip', 'archive2.zip', 'archive3.zip'] as $path) {
            $archive = $zipAdapter->open($path);
        }

        // extracts
        $archiveZip->extract('/to/directory');
    }

    public static function callback(array $args)
    {
        return (new self(new FileSystemSymfony()))->zipAndBreak($args[0]);
    }
}
