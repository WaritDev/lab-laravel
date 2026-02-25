<?php

namespace App\Service;

use App\Models\PointHistory;
use App\Models\PointLedger;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PointService
{
    private function cachekey(User $user) {
        return "user_points:{$user->id}";
    }

    private function cachekeyByQuarter(User $user) {
        return "user_points_by_quarter:{$user->id}";
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

    public function earnPoints(User $user, int $amount, ?string $description = null)
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
                'description' => $description,
            ]);
        });

        $cacheKey = $this->cachekey($user);
        Cache::forget($cacheKey);
        Cache::forget($this->cachekeyByQuarter($user));
    }

    public function redeemPoints(User $user, int $amountToRedeem, ?string $description = null)
    {
        if ($this->getTotalPoints($user) < $amountToRedeem) {
            throw new \Exception("Insufficient points to redeem {$amountToRedeem} points.");
        }

        DB::transaction(function () use ($user, $amountToRedeem, $description) {
            $ledgers = PointLedger::query()
                ->where('user_id', $user->id)
                ->where('balance', '>', 0)
                ->where('expires_at', '>', now())
                ->orderBy('expires_at')
                ->orderBy('balance')
                ->get();

            $amount = $amountToRedeem;

            foreach ($ledgers as $ledger) {
                if ($amount <= 0) {
                    break;
                }
                if ($ledger->balance >= $amount) {
                    $ledger->used_amount += $amount;
                    $ledger->balance -= $amount;
                    $amount = 0;
                } else {
                    $amount -= $ledger->balance;
                    $ledger->used_amount += $ledger->balance;
                    $ledger->balance = 0;
                }
                $ledger->save();
            }

            PointHistory::query()->create([
                'user_id' => $user->id,
                'type' => 'redeemed',
                'amount' => $amountToRedeem,
                'description' => $description,
            ]);
        });
        $cacheKey = $this->cachekey($user);
        Cache::forget($cacheKey);
        Cache::forget($this->cachekeyByQuarter($user));
    }

    public function getPointsByQuarter(User $user)
    {
        Cache::remember($this->cachekeyByQuarter($user), now()->addMinutes(10), function () use ($user) {
            $ledgers = PointLedger::query()
                ->select(
                    DB::raw("DATE(expires_at) as expires_date"),
                    DB::raw("SUM(balance) as total_points")
                )
                ->where('user_id', $user->id)
                ->where('balance', '>', 0)
                ->where('expires_at', '>', now())
                ->groupBy('expires_date')
                ->orderBy('expires_date')
                ->get();

            return $ledgers->map(function ($ledger) {
                $date = Carbon::parse($ledger->expires_date);
                return [
                    'expires_at' => $date->format('Y-m-d'),
                    'total_points' => $ledger->total_points,
                    'quarter_label' => "Q{$date->quarter} {$date->year}",
                ];
            });
        });
    }

    public function expirePoints()
    {
        // Implement logic to expire points that have reached their expiration date
    }
}