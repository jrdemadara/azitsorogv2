<?php

namespace App\Console\Commands;

use App\Models\Gatelog\GateLog;
use App\Models\Gatelog\NotificationDelivery;
use App\Models\Gatelog\ParentDevice;
use App\Services\Gatelog\PushNotificationService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ProcessGatelogNotifications extends Command
{
    protected $signature = 'gatelog:process-notifications {--limit=200}';

    protected $description = 'Process pending GateLog push notification deliveries';

    public function handle(PushNotificationService $pushService): int
    {
        $limit = max((int) $this->option('limit'), 1);

        $deliveries = NotificationDelivery::query()
            ->where('status', 'pending')
            ->orderBy('id')
            ->limit($limit)
            ->get();

        $processed = 0;

        foreach ($deliveries as $delivery) {
            $gateLog = GateLog::query()->find($delivery->gate_log_id);
            if (!$gateLog) {
                $delivery->status = 'failed';
                $delivery->provider_message = 'Gate log not found';
                $delivery->save();
                continue;
            }

            $device = ParentDevice::query()
                ->where('school_id', $delivery->school_id)
                ->where('user_id', $delivery->user_id)
                ->where('is_active', true)
                ->latest('id')
                ->first();

            if (!$device) {
                $delivery->status = 'failed';
                $delivery->provider_message = 'No active device';
                $delivery->save();
                continue;
            }

            $ok = $pushService->send($device, $gateLog);

            if ($ok) {
                $delivery->parent_device_id = $device->id;
                $delivery->status = 'sent';
                $delivery->delivered_at = Carbon::now();
                $delivery->provider_message = null;
                $delivery->save();

                $gateLog->push_notified = true;
                $gateLog->push_notified_at = Carbon::now();
                $gateLog->save();
            } else {
                $delivery->status = 'failed';
                $delivery->provider_message = 'Provider send failed';
                $delivery->save();
            }

            $processed++;
        }

        $this->info("Processed {$processed} deliveries.");

        return self::SUCCESS;
    }
}
