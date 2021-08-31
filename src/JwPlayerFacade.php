<?php

namespace App\JwPlayer;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\JwPlayer\JwPlayer
 */
class JwPlayerFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'jwplayer';
    }
}
