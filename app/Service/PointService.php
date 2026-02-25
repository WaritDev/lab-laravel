<?php

namespace App\Service;

use App\Models\PointHistory;
use App\Models\PointLedger;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PointService
{
    private function cachekey(User $user) {
        return "user_points:{$user->id}";
    }

    public function getTotalPoints(User $user)
    {
        $cacheKey = $this->cachekey($user);
        return cache()->remember($cacheKey, now()->addMinutes(10), function () use ($user) {
            return PointLedger::query()
                ->where('user_id', $user->id)
                ->where('balance', '>', 0)
                ->where('expires_at', '>', now())
                ->sum('balance');
        });
    }

    public function earnPoints(User $user, int $amount, string $description = null)
    {
        DB::transaction(function () use ($user, $amount, $description) {
            $expiresAt = now()->addQuarter()->endOfQuarter()->endOfDay();

            PointLedger::query()->create([
                'user_id' => $user->id,
                'amount' => $amount,
                'used_amount' => 0,
                'balance' => $amount,
                'expires_at' => $expiresAt,
            ]);
            
            PointHistory::query()->create([
                'user_id' => $user->id,
                'type' => 'earned',
                'amount' => $amount,
            ]);
        });

        $cacheKey = $this->cachekey($user);
        Cache::forget($cacheKey);
    }

    public function redeemPoints(User $user, int $amount, string $description = null)
    {
        // Implement logic to deduct points from the user's account and record the history
    }

    public function getPointsByQuarter(User $user, int $year, int $quarter)
    {
        // Implement logic to calculate points earned and redeemed by the user in a specific quarter
    }

    public function expirePoints()
    {
        // Implement logic to expire points that have reached their expiration date
    }
}