<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuditObserver
{
    /**
     * Handle the Model "created" event.
     */
    public function created(Model $model): void
    {
        $this->logAudit($model, 'create', null, $model->getAttributes());
    }

    /**
     * Handle the Model "updated" event.
     */
    public function updated(Model $model): void
    {
        $this->logAudit($model, 'update', $model->getOriginal(), $model->getChanges());
    }

    /**
     * Handle the Model "deleted" event.
     */
    public function deleted(Model $model): void
    {
        $this->logAudit($model, 'delete', $model->getAttributes(), null);
    }

    /**
     * Log audit trail
     */
    private function logAudit(Model $model, string $action, ?array $oldValues, ?array $newValues): void
    {
        try {
            DB::table('audit_trails')->insert([
                'table_name' => $model->getTable(),
                'action' => $action,
                'record_id' => $model->getKey(),
                'old_values' => $oldValues ? json_encode($oldValues) : null,
                'new_values' => $newValues ? json_encode($newValues) : null,
                'user_id' => auth()->id(),
                'ip_address' => request()->ip(),
                'created_at' => now(),
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to log audit trail: ' . $e->getMessage());
        }
    }
}
