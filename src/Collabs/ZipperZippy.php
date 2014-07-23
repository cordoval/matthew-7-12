<?php

namespace Grace\Collabs;

use Alchemy\Zippy\Zippy;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Process\ProcessBuilder;

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
        $this->zipAdapter
            ->create($cwd.'/compressAllFirst.zip')
            ->addMembers($patches, $recursive = false)
        ;

        (new ProcessBuilder('zip -s 2 compressAllFirst.zip --output splitzips'))
            ->setWorkingDirectory($cwd)
            ->setTimeout(3600)
            ->getProcess()
            ->run()
        ;

        $finder = (new Finder())
            ->files()
            ->in($cwd.'/splitzips')
            ->name('*.zip')
        ;

        $manyCompressed = [];
        /** @var \SplFileInfo $file */
        foreach ($finder as $file) {
            $manyCompressed[] = $file->getRealPath();
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
