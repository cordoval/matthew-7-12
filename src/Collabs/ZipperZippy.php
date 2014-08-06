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

        $this->helper->run(
            sprintf(
                'zip -v -s 2 %s/compressAllFirst.zip --out %s/splits.zip',
                $cwd,
                $cwd
            )
        );

        $this->fs->remove($cwd.'/compressAllFirst.zip');

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

    public static function callback($args)
    {
        return (new self(
                new FileSystemSymfony(),
                new Helper()
            )
        )->zipAndBreak($args);
    }
}
