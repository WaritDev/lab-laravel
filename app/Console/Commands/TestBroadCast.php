<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Broadcast;

class TestBroadcast extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:broadcast
                {--event=}
                {--channel=}
                {--data=}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test broadcast';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $data = $this->option('data');
        $data = collect(json_decode($data))->toArray();
        Broadcast::on($this->option('channel'))
            ->as($this->option('event'))
            ->with($data)
            ->sendNow();
    }
}
