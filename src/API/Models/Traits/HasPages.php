<?php

namespace App\JwPlayer\API\Models\Traits;

use Illuminate\Support\Arr;

trait HasPages
{
    public function page()
    {
        return Arr::get($this->data, 'page');
    }

    public function pageLength()
    {
        return Arr::get($this->data, 'page_length');
    }

    public function getTotal()
    {
        return Arr::get($this->data, 'total');
    }
}
