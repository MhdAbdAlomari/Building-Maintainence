<?php

namespace App\Services;

use App\Models\Request as WorkRequest;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Throwable;

class FirebaseNotificationService
{
    protected $messaging;

    public function __construct()
    {
        $this->messaging = app('firebase.messaging');
    }

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

    public function sendRequestStatusNotification(WorkRequest $request): ?array
    {
        $request->loadMissing('tenant');

        if (!$request->tenant || !$request->tenant->fcm_token) {
            return null;
        }

        [$title, $body] = match ($request->status) {
            'estimate_price' => [
                'تم إرسال السعر التقديري',
                'تم إرسال السعر التقديري لطلبك.',
            ],
            'processing' => [
                'بدأت الصيانة',
                'تم بدء العمل على طلبك.',
            ],
            'awaiting_final_approval' => [
                'موافقة مطلوبة',
                'تمت إضافة تكاليف إضافية ويُرجى مراجعتها والموافقة عليها.',
            ],
            'completed' => [
                'اكتمل الطلب',
                'تم الانتهاء من طلب الصيانة الخاص بك.',
            ],
            'cancelled' => [
                'تم إلغاء الطلب',
                'تم إلغاء طلب الصيانة الخاص بك.',
            ],
            'rejected' => [
                'تم رفض الطلب',
                'تم رفض الطلب أو السعر التقديري الخاص به.',
            ],
            default => [
                'تحديث على الطلب',
                'تم تحديث حالة طلبك.',
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

    public function sendRequestActionToTechnician(WorkRequest $request): ?array
    {
        $request->loadMissing('technician');

        if (!$request->technician || !$request->technician->fcm_token) {
            return null;
        }

        [$title, $body] = match ($request->status) {
            'confirmed' => [
                'تمت الموافقة على السعر',
                'قام العميل بالموافقة على السعر التقديري للطلب.',
            ],
            'rejected' => [
                'تم رفض السعر التقديري',
                'قام العميل برفض السعر التقديري للطلب.',
            ],
            'processing' => [
                'تمت الموافقة على الإضافات',
                'قام العميل بالموافقة على التكاليف الإضافية ويمكن متابعة التنفيذ.',
            ],
            'cancelled' => [
                'تم إلغاء الطلب',
                'قام العميل برفض التكاليف الإضافية وتم إلغاء الطلب.',
            ],
            default => [
                'تحديث على الطلب',
                'تم إجراء تحديث جديد على الطلب.',
            ],
        };

        return $this->sendToToken(
            token: $request->technician->fcm_token,
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