<?php

namespace App\JwPlayer\API\Models\Traits;

trait HasSite
{
    protected function getSiteId()
    {
        if (!config('jwplayer.site_id')) {
            throw new Exception('Site Id not specified on the Package Configuration');
        }

        return config('jwplayer.site_id');
    }
}
