<?php

namespace Hasob\FoundationCore\Facades;

use Illuminate\Support\Facades\Facade;

class FoundationCoreSiteManagerService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'FoundationCoreSiteManagerService';
    }
}