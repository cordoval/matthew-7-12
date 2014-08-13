<?php

namespace Grace\PushCode;

class RepoPush
{
    protected $baseurl;
    protected $vendor;
    protected $name;
    protected $dir;
    protected $cloned;
    protected $cwd;

    public function _construct($vendor, $name, $dir, $baseurl = 'github.com')
    {
        $this->baseurl = $baseurl;
        $this->vendor = $vendor;
        $this->name = $name;
        $this->dir = $dir;
        $this->cloned = false;
        $this->cwd = uniqid('container_folder_');
    }

    public function getBaseUrl()
    {
        return $this->baseurl;
    }

    public function isCloned()
    {
        return $this->cloned;
    }

    public function wasCloned()
    {
        $this->cloned = true;
    }

    public function getCwd()
    {
        return $this->cwd;
    }

}