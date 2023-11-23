<?php
namespace Jaktech\Anaphora;

use Illuminate\Support\Facades\Facade;

class AnaphoraFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'anaphora';
    }
}