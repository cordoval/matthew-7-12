<?php

namespace Grace\Domain;

interface HookPost
{
    public function getFrom();
    public function getTo();
    public function getVendor();
    public function getName();
}