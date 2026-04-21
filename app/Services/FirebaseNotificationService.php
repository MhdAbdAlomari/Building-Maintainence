<?php

namespace App\Services;

use App\Models\Request as MaintenanceRequest;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Throwable;

class FirebaseNotificationService
{
    public function __construct(
        protected Messaging $messaging
    ) {}

    public function sendToToken(
        string $token,
        string $title,
        string $body,
        array $data = []
    ): array {
        try {
            $message = CloudMessage::withTarget('token', $token)
                ->withNotification(Notification::create($title, $body))
                ->withData(
                    collect($data)->map(fn ($value) => (string) $value)->toArray()
                );

            $this->messaging->send($message);

            return [
                'success' => true,
                'message' => 'Notification sent successfully',
            ];
        } catch (Throwable $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function sendRequestStatusNotification(MaintenanceRequest $request): ?array
    {
        $request->loadMissing('tenant');

        if (!$request->tenant || !$request->tenant->fcm_token) {
            return null;
        }

        [$title, $body] = match ($request->status) {
            'estimate_price' => [
                'New Estimate',
                'A price estimate has been sent for your request.'
            ],
            'processing' => [
                'Maintenance Started',
                'The technician has started working on your request.'
            ],
            'awaiting_final_approval' => [
                'Approval Needed',
                'Additional costs were added and your approval is required.'
            ],
            'completed' => [
                'Request Completed',
                'Your maintenance request has been completed.'
            ],
            'cancelled' => [
                'Request Cancelled',
                'Your request has been cancelled.'
            ],
            'rejected' => [
                'Estimate Rejected',
                'Your estimate has been rejected.'
            ],
            default => [
                'Request Updated',
                'Your request status has been updated.'
            ],
        };

        return $this->sendToToken(
            token: $request->tenant->fcm_token,
            title: $title,
            body: $body,
            data: [
                'type' => 'request_status_update',
                'request_id' => $request->id,
                'status' => $request->status,
            ]
        );
    }
}