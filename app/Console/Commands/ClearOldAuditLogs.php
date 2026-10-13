<?php

namespace App\Console\Commands;

use App\Models\Audit;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class ClearOldAuditLogs extends Command
{
    protected $signature = 'audit:clear-old-logs';

    protected $description = 'Elimina i dati più vecchi, per garanzie di privacy';

    public function handle()
    {
        $this->clearUserLogs();

        return self::SUCCESS;
    }

    public function clearUserLogs(): void
    {
        $targetDay = Carbon::now()->subMonths(24)->startOfDay();
        $deletedCount = Audit::query()->where('auditable_type', User::class)->where('created_at', '<', $targetDay)->delete();
        $this->info("Pulizia completata: eliminati {$deletedCount} log di accesso più vecchi di 24 mesi.");
    }
}
