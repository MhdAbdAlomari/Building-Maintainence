<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveFcmTokenRequest;
use Illuminate\Http\JsonResponse;

class NotificationTokenController extends Controller
{
    public function store(SaveFcmTokenRequest $request): JsonResponse
    {
        $user = $request->user();

        $user->update([
            'fcm_token' => $request->fcm_token,
        ]);

        return response()->json([
            'message' => 'FCM token saved successfully',
            'data' => [
                'fcm_token' => $user->fcm_token,
            ],
        ]);
    }
}
