<?php

namespace App\Models\Concerns;

trait HasFormattedPublicId
{
    protected function buildFormattedPublicId(string $prefix): string
    {
        $year = $this->created_at?->format('Y') ?? now()->format('Y');

        return sprintf('%s-%s-%06d', strtoupper($prefix), $year, (int) $this->getKey());
    }
}
