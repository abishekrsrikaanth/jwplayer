<?php

namespace App\JwPlayer\Commands;

use Illuminate\Console\Command;

class JwPlayerCommand extends Command
{
    public $signature = 'jwplayer';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
