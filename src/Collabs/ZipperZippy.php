<?php

namespace Grace\Collabs;

use Alchemy\Zippy\Zippy;
use Symfony\Component\Finder\Finder;

class ZipperZippy implements Zipper
{
    protected $fs;
    protected $zipAdapter;
    protected $helper;

    public function __construct(FileSystem $fs, Helper $helper)
    {
        $this->fs = $fs;
        $this->helper = $helper;
        $zippy = Zippy::load();
        $this->zipAdapter = $zippy->getAdapterFor('zip');
    }

    public static function callback(array $args)
    {
        return (new self(
            new FileSystemSymfony(),
            new Helper()
        ))->zipAndBreak($args[0])
            ;
    }

    public function zipAndBreak(array $patches)
    {
        $cwd = pathinfo($patches[0])['dirname'];
        $this->zipAdapter
            ->create($cwd.'/compressAllFirst.zip', $patches, false)
        ;

        $files = (new Finder())
            ->files()
            ->in($cwd)
            ->name('*.patch')
        ;

        $this->fs->remove($files);
        $process = $this->helper->run('zip -v -s 2 '.$cwd.'/compressAllFirst.zip --out '.$cwd.'/splits.zip');

        //$this->fs->remove($cwd.'/compressAllFirst.zip');
ladybug_dump_die($process->getOutput());
        $files = (new Finder())
            ->files()
            ->in($cwd)
            ->name('*.zip')
        ;

        $manyCompressed = [];
        /** @var \SplFileInfo $file */
        foreach ($files as $file) {
            $manyCompressed[] = $file->getRealPath();
        }

        return $manyCompressed;
    }

    public function unzipAndJoin()
    {
        foreach (['archive.zip', 'archive2.zip', 'archive3.zip'] as $path) {
            $archive = $this->zipAdapter->open($path);
        }

        // extracts
        $archive->extract('/to/directory');
    }

}
