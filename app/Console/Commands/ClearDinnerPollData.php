<?php

namespace App\Console\Commands;

use App\Events\DinnerVoteUpdated;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class ClearDinnerPollData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:dinner-poll:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear dinner poll data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Redis::del('poll:dinner:votes');

        $results = [
            1 => ['id' => 1, 'title' => '🍜 กินก๋วยเตี๋ยวหกคน', 'voters' => []],
            2 => ['id' => 2, 'title' => '🍗 ข้าวมันไก่มานี่มา', 'voters' => []],
            3 => ['id' => 3, 'title' => '🥩 บุฟเฟต์ปิ้งย่าง', 'voters' => []],
            4 => ['id' => 4, 'title' => '🍲 ชาบูไม่อั้น', 'voters' => []],
        ];

        $results = array_values($results);

        broadcast(new DinnerVoteUpdated($results));

        $this->info('Dinner poll data cleared!');
    }
}