<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Broadcast;

class TestBroadCasr extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:broadcast:test {--channel=test-channel : Channel name to listen} 
                                                --event=TestMessageEvent : Event class to broadcast
                                                --data= : Data to broadcast (JSON string)';

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
        $channel = $this->option('channel', 'test-channel');
        $event = $this->option('event', 'TestMessageEvent');
        $data = $this->option('data', '{}');

        $eventClass = "App\\Events\\{$event}";
        broadcast(new $eventClass(json_decode($data, true)))->toOthers();
    }
}