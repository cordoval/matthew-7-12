<?php

namespace Grace\Domain;

Interface HookInput {
    public function getVendor();
    public function getName();
}