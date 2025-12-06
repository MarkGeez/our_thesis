<?php

namespace App\Services;

use App\Models\Archive;

class ArchiveService
{
    public function archive($model, $reason = null){
        Archive::create([
            'record_type'=> $model->getTable(),
            'record_id'=> $model->id,
            'data' => $model->toArray(),
            'archived_by' => auth()->user()->id ?? "System",
            "reason" => $reason
        ]);

        $model->delete();
    }
}