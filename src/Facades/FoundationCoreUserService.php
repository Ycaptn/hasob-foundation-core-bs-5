<?php

namespace Hasob\FoundationCore\Facades;

use Illuminate\Support\Facades\Facade;

class FoundationCoreUserService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'FoundationCoreUserService';
    }
}