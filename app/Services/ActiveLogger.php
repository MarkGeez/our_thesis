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
        ActiveLog::create([
            'user_id'=> auth()->id(),
            'module' => $module,
            'action'=> $action,
            'record_id'=> $record_id,
            'description' => $description
        ]);
    }
}
