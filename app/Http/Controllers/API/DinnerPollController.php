<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Events\DinnerVoteUpdated;

class DinnerPollController extends Controller
{
    public function vote(Request $request) {
        $request->validate([
            'name' => ['required', 'string', 'max:30'],
            'choice' => ['required', 'integer', 'between:1,4'],
        ]);

        Redis::hset('poll:dinner:votes', $request->input('name'), $request->input('choice'));
        
        $results = $this->results();
        broadcast(new DinnerVoteUpdated($results));
        
        return response()->json([
            'status' => 'success',
        ]);
    }
    
    public function results() {
        $allVotes = Redis::hgetall('poll:dinner:votes');

        $results = [
            1 => ['id' => 1, 'title' => '🍜 กินก๋วยเตี๋ยวหกคน', 'voters' => []],
            2 => ['id' => 2, 'title' => '🍗 ข้าวมันไก่มานี่มา', 'voters' => []],
            3 => ['id' => 3, 'title' => '🥩 บุฟเฟต์ปิ้งย่าง', 'voters' => []],
            4 => ['id' => 4, 'title' => '🍲 ชาบูไม่อั้น', 'voters' => []],
        ];

        foreach ($allVotes as $name => $choice) {
            if (isset($results[$choice])) {
                $results[$choice]['voters'][] = $name;
            }
        }

        return array_values($results);
    }
}