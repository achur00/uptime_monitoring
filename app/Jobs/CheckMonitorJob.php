<?php

namespace App\Jobs;

use App\Models\Monitor;
use App\Models\MonitorEvent;
use App\Services\MonitorCheckerService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use App\Mail\SiteStatusMail;

class CheckMonitorJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Monitor $monitor
    ) {}

    public function handle(
        MonitorCheckerService $service
    ): void
    {
        $result = $service->check($this->monitor->url);

        MonitorEvent::create([
            'monitor_id' => $this->monitor->id,
            'status_code' => $result['status_code'],
            'response_time_ms' => $result['response_time_ms'],
            'is_up' => $result['is_up'],
            'checked_at' => now()
        ]);

        $this->updateStatus($result['is_up']);
        $this->updateUptime();

        $this->monitor->update([
            'last_checked_at' => now()
        ]);
    }


    private function updateStatus(bool $isUp): void
    {
        if (!$isUp) {

            $this->monitor->increment('consecutive_failures');
            $this->monitor->refresh();

            if (
                $this->monitor->consecutive_failures >= $this->monitor->threshold &&
                !$this->monitor->notification_sent
            ) {
                $this->monitor->update([
                    'status' => 'down',
                    'notification_sent' => true
                ]);

                $this->sendMail('down');
            }

            return;
        }

        if ($this->monitor->status === 'down') {
            $this->sendMail('up');
        }

        $this->monitor->update([
            'status' => 'up',
            'consecutive_failures' => 0,
            'notification_sent' => false
        ]);
    }

    private function sendMail(string $status): void
    {
        $email = config('services.monitoring.alert_email');

        if (!$email) return;

        Mail::to($email)->send(
            new SiteStatusMail($this->monitor, $status)
        );
    }

private function updateUptime(): void
{
    $total = $this->monitor->checks()->count();

    if ($total === 0) return;

    $up = $this->monitor->checks()->where('is_up', true)->count();

    $percentage = ($up / $total) * 100;

    $this->monitor->update([
        'uptime_percentage' => round($percentage, 2)
    ]);
}
}