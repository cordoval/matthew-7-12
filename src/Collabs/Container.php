<?php

namespace Grace\Collabs;

use Grace\Domain\Repo;
use Symfony\Component\Finder\Finder;

class Container
{
    protected $helper;
    protected $basePath;
    protected $fs;

    public function __construct(Helper $helper, FileSystem $fs, $basePath = '/tmp/grace')
    {
        $this->helper = $helper;
        $this->basePath = $basePath;
        $this->fs = $fs;
        $this->fs->mkdir($this->basePath);
    }

    public function gitClone(Repo $repo)
    {
        $this->fs->mkdir($this->basePath.$repo->getCwd());

        $this->helper->run(
            sprintf(
                'git clone git@%s:%s/%s.git .',
                $repo->getBaseUrl(),
                $repo->getHookPost()->getVendor(),
                $repo->getHookPost()->getName()
            ),
            $this->basePath.$repo->getCwd()
        );

        $repo->wasCloned();
    }

    public function checkout(Repo $repo, $reference)
    {
        $this->helper->run(
            sprintf(
                'git checkout -b %s -f',
                $reference
            ),
            $this->basePath.$repo->getCwd()
        );
    }

    public function formatPatch(Repo $repo, $from)
    {
        $this->helper->run(
            sprintf(
                'git format-patch %s',
                $from
            ),
            $this->basePath.$repo->getCwd()
        );

        $fileNames = [];
        $finder = (new Finder())
            ->files()
            ->in($this->basePath.$repo->getCwd())
            ->name('*.patch')
        ;
        /** @var \SplFileInfo $file */
        foreach ($finder as $file) {
            $fileNames[] = $file->getRealPath();
        }

        return $fileNames;
    }

    public function destroy(Repo $repo)
    {
        $this->fs->remove($this->basePath.$repo->getCwd());
    }

    public function gitClonePush($vendor, $name, $baseurl = 'github.com')
    {
        $repoPath = $this->basePath.uniqid($vendor.'_'.$name);
        $this->fs->mkdir($repoPath);

        $this->helper->run(
            sprintf(
                'git clone git@%s:%s/%s.git .',
                $baseurl,
                $vendor,
                $name
            ),
            $repoPath
        );

        return $repoPath;
    }

    public function gitApplyPatch($repoPath, $patchPath)
    {
        if ($handle = opendir($patchPath)) {
            while (false !== ($patchFile = readdir($handle))) {
                if ($patchFile != '.' && $patchFile != '..' && $patchFile != false) {
                    $this->helper->run(
                        sprintf(
                            'git am %s/%s',
                            $patchPath,
                            $patchFile
                        ),
                        $repoPath
                    );
                }
            }
            closedir($handle);
        }

        $this->helper->run(
            sprintf(
                'git push origin master'
            ),
            $repoPath
        );

        return true;
    }
}
