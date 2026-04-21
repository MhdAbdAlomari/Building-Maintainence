<?php

namespace App\Http\Controllers;

use App\Services\FirebaseNotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TestFirebaseNotificationController extends Controller
{
    public function send(Request $request, FirebaseNotificationService $firebase): JsonResponse
    {
        $user = $request->user();

        if (!$user->fcm_token) {
            return response()->json([
                'message' => 'User does not have an FCM token',
            ], 422);
        }

        $result = $firebase->sendToToken(
            token: $user->fcm_token,
            title: 'Test Notification',
            body: 'Firebase notification from Laravel is working',
            data: [
                'type' => 'test',
                'user_id' => $user->id,
            ]
        );

        return response()->json($result, $result['success'] ? 200 : 500);
    }
}
