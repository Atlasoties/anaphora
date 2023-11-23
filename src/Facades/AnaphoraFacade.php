<?php
namespace Jaktech\Anaphora\Facades;

use Illuminate\Support\Facades\Facade;

class Anaphora extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'anaphora';
    }
}