<?php

namespace App\Console\Commands;

use App\Services\Gatelog\NotificationDeliveryProcessor;
use App\Services\Gatelog\PushNotificationService;
use Illuminate\Console\Command;

class ProcessGatelogNotifications extends Command
{
    protected $signature = "gatelog:process-notifications {--limit=200}";

    protected $description = "Process pending GateLog push notification deliveries";

    public function handle(
        PushNotificationService $pushService,
        NotificationDeliveryProcessor $processor,
    ): int {
        $limit = max((int) $this->option("limit"), 1);
        $processed = $processor->processPending($pushService, $limit);

        $this->info("Processed {$processed} deliveries.");

        return self::SUCCESS;
    }
}
