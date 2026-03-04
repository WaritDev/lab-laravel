<?php

namespace App\Console\Commands;

use App\Events\TestMessageEvent;
use Illuminate\Console\Command;

class SendTestMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:broadcast:message {message : Message body} {--C|channel=test-channel : Channel name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Broadcast test message via Reverb WebSocket';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $text = $this->argument('message');
        $channel = $this->option('channel');

        broadcast(new TestMessageEvent($text, $channel));

        $this->info("✅ Message \"{$text}\" has been sent to channel \"{$channel}\"");
    }
}