<?php 

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Jobs\SendPointNotification;
use App\Models\PointLedger;
use App\Models\PointHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Service\PointService;
use App\Mail\PointEarned;
use App\Mail\PointRedeemed;

class PointController extends Controller
{
    public function index(Request $request, PointService $pointService)
    {
        $user = $request->user();
        return response()->json([
            'data' => $pointService->getPointsByQuarter($user),
            'ledgers' => PointLedger::query()->where('user_id', $user->id)->where('expires_at', '>', now())->orderBy('expires_at')->orderBy('balance')->get(),
            'histories' => PointHistory::query()->where('user_id', $user->id)->oldest()->get(),
        ]);
    }

    public function show(Request $request, PointService $pointService)
    {
        $user = $request->user();
        $totalPoints = $pointService->getTotalPoints($user);
        return response()->json(['total_points' => $totalPoints]);
    }

    public function earn(Request $request, PointService $pointService)
    {
        $request->validate([
            'amount' => ['required', 'integer', 'min:1'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);
        $user = $request->user();
        $amount = $request->input('amount');
        $description = $request->input('description', 'Earned points');
        $pointService->earnPoints($user, $amount, $description);
        SendPointNotification::dispatch($user, new PointEarned($amount, $pointService->getTotalPoints($user)));
        return response()->json([
            'success' => true,
            'message' => "Earned {$amount} points.",
            'total_points' => $pointService->getTotalPoints($user)
        ]);
    }

    public function redeem(Request $request, PointService $pointService)
    {
        $request->validate([
            'amount' => ['required', 'integer', 'min:1'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);
        try {
            $pointService->redeemPoints($request->user(), $request->amount, $request->description);
            SendPointNotification::dispatch($request->user(), new PointRedeemed($request->amount, $pointService->getTotalPoints($request->user())));
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'total_points' => $pointService->getTotalPoints($request->user())
            ])->setStatusCode(400);
        }
        return response()->json([
            'success' => true,
            'message' => "Redeemed {$request->input('amount')} points.",
            'total_points' => $pointService->getTotalPoints($request->user())
        ]);
    }

}