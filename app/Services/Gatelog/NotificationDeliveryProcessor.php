<?php

namespace App\Services\Gatelog;

use App\Models\Gatelog\GateLog;
use App\Models\Gatelog\NotificationDelivery;
use App\Models\Gatelog\ParentDevice;
use Carbon\Carbon;

class NotificationDeliveryProcessor
{
    public function processPending(
        PushNotificationService $pushService,
        int $limit = 200,
        ?int $gateLogId = null,
    ): int {
        $limit = max($limit, 1);

        $query = NotificationDelivery::query()
            ->where("status", "pending")
            ->orderBy("id")
            ->limit($limit);

        if ($gateLogId) {
            $query->where("gate_log_id", $gateLogId);
        }

        $deliveries = $query->get();
        $processed = 0;

        foreach ($deliveries as $delivery) {
            $gateLog = GateLog::query()->find($delivery->gate_log_id);
            if (!$gateLog) {
                $delivery->status = "failed";
                $delivery->provider_message = "Gate log not found";
                $delivery->save();
                continue;
            }

            $device = ParentDevice::query()
                ->where("user_id", $delivery->user_id)
                ->where("is_active", true)
                ->latest("id")
                ->first();

            if (!$device) {
                // Keep pending so it can be retried when a device token is registered.
                continue;
            }

            $ok = $pushService->send($device, $gateLog);

            if ($ok) {
                $delivery->parent_device_id = $device->id;
                $delivery->status = "sent";
                $delivery->delivered_at = Carbon::now();
                $delivery->provider_message = null;
                $delivery->save();

                $gateLog->push_notified = true;
                $gateLog->push_notified_at = Carbon::now();
                $gateLog->save();
            } else {
                $delivery->status = "failed";
                $delivery->provider_message =
                    $pushService->lastErrorMessage() ?? "Provider send failed";
                $delivery->save();
            }

            $processed++;
        }

        return $processed;
    }
}
