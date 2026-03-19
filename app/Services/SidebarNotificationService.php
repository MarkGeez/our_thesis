<?php

namespace App\Services;

use App\Models\ModuleVisit;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SidebarNotificationService
{
    public const MODULE_USERS = 'users';
    public const MODULE_HOUSEHOLD = 'household';
    public const MODULE_ACTIVITY_LOGS = 'activity_logs';
    public const MODULE_COMPLAINTS_RECORDS = 'complaints_records';
    public const MODULE_CERTIFICATE_REQUESTS = 'certificate_requests';

    /**
     * @return array<string, bool>
     */
    public function forUser(?User $user): array
    {
        $defaults = [
            self::MODULE_USERS => false,
            self::MODULE_HOUSEHOLD => false,
            self::MODULE_ACTIVITY_LOGS => false,
            self::MODULE_COMPLAINTS_RECORDS => false,
            self::MODULE_CERTIFICATE_REQUESTS => false,
        ];

        if (!$user || !in_array($user->role, ['admin', 'subadmin'], true) || !Schema::hasTable('module_visits')) {
            return $defaults;
        }

        $visits = ModuleVisit::query()
            ->where('user_id', $user->id)
            ->whereIn('module_key', array_keys($defaults))
            ->get()
            ->keyBy('module_key');

        foreach (array_keys($defaults) as $moduleKey) {
            $latestEntryAt = $this->latestEntryTimestamp($moduleKey);
            $lastVisitedAt = $visits->get($moduleKey)?->last_visited_at;

            $defaults[$moduleKey] = $latestEntryAt !== null
                && ($lastVisitedAt === null || $latestEntryAt->gt($lastVisitedAt));
        }

        return $defaults;
    }

    public function markVisited(User $user, string $moduleKey): void
    {
        if (!Schema::hasTable('module_visits')) {
            return;
        }

        ModuleVisit::query()->updateOrCreate(
            [
                'user_id' => $user->id,
                'module_key' => $moduleKey,
            ],
            [
                'last_visited_at' => now(),
            ]
        );
    }

    public function resolveTrackedModuleKey(?string $routeName): ?string
    {
        return match ($routeName) {
            'admin.users' => self::MODULE_USERS,
            'admin.household' => self::MODULE_HOUSEHOLD,
            'admin.activityLogs' => self::MODULE_ACTIVITY_LOGS,
            'admin.complaintRequest',
            'subadmin.complaintRequest' => self::MODULE_COMPLAINTS_RECORDS,
            'admin.certificateRequest',
            'subadmin.certificateRequest' => self::MODULE_CERTIFICATE_REQUESTS,
            default => null,
        };
    }

    private function latestEntryTimestamp(string $moduleKey): ?Carbon
    {
        return match ($moduleKey) {
            self::MODULE_USERS => $this->maxTimestampFromTables(['users']),
            self::MODULE_HOUSEHOLD => $this->maxTimestampFromTables([
                'streets',
                'houses',
                'households',
                'household_resident',
                'family_members',
            ]),
            self::MODULE_ACTIVITY_LOGS => $this->maxTimestampFromTables(['active_logs']),
            self::MODULE_COMPLAINTS_RECORDS => $this->maxTimestampFromTables(['complaints']),
            self::MODULE_CERTIFICATE_REQUESTS => $this->maxTimestampFromTables(['certificate_requests']),
            default => null,
        };
    }

    private function maxTimestampFromTables(array $tables): ?Carbon
    {
        $timestamps = collect($tables)
            ->filter(fn (string $table) => Schema::hasTable($table) && Schema::hasColumn($table, 'created_at'))
            ->map(function (string $table) {
                return DB::table($table)->max('created_at');
            })
            ->filter()
            ->map(fn ($value) => Carbon::parse($value));

        return $timestamps->isEmpty() ? null : $timestamps->max();
    }
}
