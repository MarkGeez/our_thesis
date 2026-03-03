<?php

namespace App\Services;
use App\Models\ActiveLog;

class ActiveLogger
{
    public static function log(
        string $module,
        string $action,
        ?int $record_id,
        ?string $description
    ){
        $actorId = auth()->id();

        // Some flows (e.g. public registration) run without an authenticated user.
        // Avoid failing inserts into active_logs where user_id is NOT NULL.
        if (!$actorId) {
            return;
        }

        ActiveLog::create([
            'user_id'=> $actorId,
            'module' => $module,
            'action'=> $action,
            'record_id'=> $record_id,
            'description' => $description
        ]);
    }
}
