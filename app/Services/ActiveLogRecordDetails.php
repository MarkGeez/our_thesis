<?php

namespace App\Services;

use App\Models\Announcement;
use App\Models\Archive;
use App\Models\Blotter;
use App\Models\CertificateRequest;
use App\Models\Complaints;
use App\Models\GeneratedReport;
use App\Models\Official;
use App\Models\Resident;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ActiveLogRecordDetails
{
    public static function enrich(Collection $logs): Collection
    {
        if ($logs->isEmpty()) {
            return $logs;
        }

        $idsByModule = [];
        foreach ($logs as $log) {
            $module = self::normalizeModule($log->module ?? '');
            $recordId = (int) ($log->record_id ?? 0);
            if ($module !== '' && $recordId > 0) {
                $idsByModule[$module][] = $recordId;
            }
        }

        $lookups = self::loadLookups($idsByModule);

        foreach ($logs as $log) {
            $base = trim((string) ($log->description ?? ''));
            $detail = trim(self::resolveDetail($log, $lookups));
            $log->resolved_record_id = self::resolveRecordId($log, $lookups);

            if ($base !== '' && $detail !== '') {
                $log->resolved_description = $base . ' | ' . $detail;
            } elseif ($base !== '') {
                $log->resolved_description = $base;
            } elseif ($detail !== '') {
                $log->resolved_description = $detail;
            } else {
                $log->resolved_description = 'N/A';
            }
        }

        return $logs;
    }

    private static function normalizeModule(string $module): string
    {
        return strtolower(trim($module));
    }

    private static function uniqueIds(array $idsByModule, array $keys): array
    {
        $ids = [];
        foreach ($keys as $key) {
            if (!empty($idsByModule[$key])) {
                $ids = array_merge($ids, $idsByModule[$key]);
            }
        }
        return array_values(array_unique(array_map('intval', $ids)));
    }

    private static function loadLookups(array $idsByModule): array
    {
        $userIds = self::uniqueIds($idsByModule, ['user', 'users']);
        $residentIds = self::uniqueIds($idsByModule, ['resident', 'residents']);
        $announcementIds = self::uniqueIds($idsByModule, ['announcement', 'announcements']);
        $reportIds = self::uniqueIds($idsByModule, ['report', 'reports']);
        $complaintIds = self::uniqueIds($idsByModule, ['complaint', 'complaints']);
        $certificateIds = self::uniqueIds($idsByModule, ['certificate', 'certificates']);
        $blotterIds = self::uniqueIds($idsByModule, ['blotter', 'blotters']);
        $settingIds = self::uniqueIds($idsByModule, ['setting', 'settings']);
        $archiveIds = self::uniqueIds($idsByModule, ['archive', 'archives']);
        $officialIds = self::uniqueIds($idsByModule, ['official', 'officials']);
        $householdIds = self::uniqueIds($idsByModule, ['household', 'households']);
        $feedbackIds = self::uniqueIds($idsByModule, ['feedback', 'feedbacks']);

        return [
            'users' => empty($userIds) ? collect() : User::query()
                ->whereIn('id', $userIds)
                ->get(['id', 'firstName', 'lastName', 'email', 'role', 'status'])
                ->keyBy('id'),
            'residents' => empty($residentIds) ? collect() : Resident::query()
                ->whereIn('id', $residentIds)
                ->get(['id', 'firstName', 'middleName', 'lastName', 'sex', 'age'])
                ->keyBy('id'),
            'announcements' => empty($announcementIds) ? collect() : Announcement::query()
                ->whereIn('id', $announcementIds)
                ->get(['id', 'title', 'created_at'])
                ->keyBy('id'),
            'reports' => empty($reportIds) ? collect() : GeneratedReport::query()
                ->whereIn('id', $reportIds)
                ->get(['id', 'report_name', 'report_type', 'total_records'])
                ->keyBy('id'),
            'complaints' => empty($complaintIds) ? collect() : Complaints::query()
                ->whereIn('id', $complaintIds)
                ->get(['id', 'complainantName', 'status', 'address'])
                ->keyBy('id'),
            'certificates' => empty($certificateIds) ? collect() : CertificateRequest::query()
                ->whereIn('id', $certificateIds)
                ->get(['id', 'certificate_type', 'status', 'purpose'])
                ->keyBy('id'),
            'blotters' => empty($blotterIds) ? collect() : Blotter::query()
                ->whereIn('id', $blotterIds)
                ->get(['id', 'plaintiffName', 'plaintiffLastName', 'defendantName', 'defendantLastName', 'current_status', 'created_at'])
                ->keyBy('id'),
            'settings' => empty($settingIds) ? collect() : Setting::query()
                ->whereIn('id', $settingIds)
                ->get(['id', 'barangay_name', 'contact_number'])
                ->keyBy('id'),
            'archives' => empty($archiveIds) ? collect() : Archive::query()
                ->whereIn('id', $archiveIds)
                ->get(['id', 'record_type', 'record_id', 'reason'])
                ->keyBy('id'),
            'officials' => empty($officialIds) ? collect() : Official::query()
                ->whereIn('id', $officialIds)
                ->get(['id', 'resident_id', 'position', 'start', 'end', 'created_at'])
                ->keyBy('id'),
            'households' => empty($householdIds) ? collect() : \App\Models\Household::query()
                ->whereIn('id', $householdIds)
                ->get(['id', 'house_id', 'created_at'])
                ->keyBy('id'),
            'feedbacks' => empty($feedbackIds) ? collect() : \App\Models\Feedbacks::query()
                ->whereIn('id', $feedbackIds)
                ->get(['id', 'user_id', 'created_at'])
                ->keyBy('id'),
        ];
    }

    private static function resolveRecordId(object $log, array $lookups): string
    {
        $module = self::normalizeModule((string) ($log->module ?? ''));
        $recordId = (int) ($log->record_id ?? 0);

        if ($recordId <= 0) {
            return '-';
        }

        if (in_array($module, ['resident', 'residents'], true)) {
            return (string) ($lookups['residents']->get($recordId)?->formatted_id ?? $recordId);
        }

        if (in_array($module, ['user', 'users'], true)) {
            return (string) ($lookups['users']->get($recordId)?->formatted_id ?? $recordId);
        }

        if (in_array($module, ['blotter', 'blotters'], true)) {
            return (string) ($lookups['blotters']->get($recordId)?->formatted_id ?? $recordId);
        }

        if (in_array($module, ['certificate', 'certificates'], true)) {
            return (string) ($lookups['certificates']->get($recordId)?->formatted_id ?? $recordId);
        }

        if (in_array($module, ['complaint', 'complaints'], true)) {
            return (string) ($lookups['complaints']->get($recordId)?->formatted_id ?? $recordId);
        }

        if (in_array($module, ['official', 'officials'], true)) {
            return (string) ($lookups['officials']->get($recordId)?->formatted_id ?? $recordId);
        }

        if (in_array($module, ['archive', 'archives'], true)) {
            return (string) ($lookups['archives']->get($recordId)?->formatted_id ?? $recordId);
        }

        if (in_array($module, ['announcement', 'announcements'], true)) {
            return (string) ($lookups['announcements']->get($recordId)?->formatted_id ?? $recordId);
        }

        if (in_array($module, ['feedback', 'feedbacks'], true)) {
            return (string) ($lookups['feedbacks']->get($recordId)?->formatted_id ?? $recordId);
        }

        if (in_array($module, ['household', 'households'], true)) {
            return (string) ($lookups['households']->get($recordId)?->formatted_id ?? $recordId);
        }

        if (in_array($module, ['active log', 'active logs', 'activelog', 'activity', 'activities'], true)) {
            $year = $log->created_at?->format('Y') ?? now()->format('Y');
            return sprintf('ACTL-%s-%06d', $year, $recordId);
        }

        return (string) $recordId;
    }

    private static function fullName(?string $first, ?string $middle, ?string $last): string
    {
        return trim(ucwords(strtolower(trim(($first ?? '') . ' ' . ($middle ?? '') . ' ' . ($last ?? '')))));
    }

    private static function resolveDetail(object $log, array $lookups): string
    {
        $module = self::normalizeModule((string) ($log->module ?? ''));
        $recordId = (int) ($log->record_id ?? 0);

        if ($recordId <= 0) {
            return '';
        }

        if (in_array($module, ['user', 'users'], true)) {
            $record = $lookups['users']->get($recordId);
            if (!$record) {
                return "Record ID: {$recordId}";
            }
            $name = self::fullName($record->firstName, null, $record->lastName);
            return "User: {$name} (Role: {$record->role}, Status: {$record->status}, Email: {$record->email})";
        }

        if (in_array($module, ['resident', 'residents'], true)) {
            $record = $lookups['residents']->get($recordId);
            if (!$record) {
                return "Record ID: {$recordId}";
            }
            $name = self::fullName($record->firstName, $record->middleName, $record->lastName);
            return "Resident: {$name} (Sex: " . ucfirst((string) $record->sex) . ", Age: {$record->age})";
        }

        if (in_array($module, ['announcement', 'announcements'], true)) {
            $record = $lookups['announcements']->get($recordId);
            if (!$record) {
                return "Record ID: {$recordId}";
            }
            $title = Str::limit((string) $record->title, 80);
            return "Announcement: \"{$title}\"";
        }

        if (in_array($module, ['report', 'reports'], true)) {
            $record = $lookups['reports']->get($recordId);
            if (!$record) {
                return "Record ID: {$recordId}";
            }
            $type = ucfirst((string) $record->report_type);
            return "Report: {$record->report_name} ({$type}, Records: {$record->total_records})";
        }

        if (in_array($module, ['complaint', 'complaints'], true)) {
            $record = $lookups['complaints']->get($recordId);
            if (!$record) {
                return "Record ID: {$recordId}";
            }
            $name = Str::limit((string) $record->complainantName, 60);
            return "Complaint by {$name} (Status: {$record->status}, Address: " . Str::limit((string) $record->address, 40) . ")";
        }

        if (in_array($module, ['certificate', 'certificates'], true)) {
            $record = $lookups['certificates']->get($recordId);
            if (!$record) {
                return "Record ID: {$recordId}";
            }
            return "Certificate: " . ucfirst((string) $record->certificate_type) . " (Status: {$record->status}, Purpose: " . Str::limit((string) $record->purpose, 40) . ")";
        }

        if (in_array($module, ['blotter', 'blotters'], true)) {
            $record = $lookups['blotters']->get($recordId);
            if (!$record) {
                return "Record ID: {$recordId}";
            }
            $plaintiff = trim(ucwords(strtolower(trim(($record->plaintiffName ?? '') . ' ' . ($record->plaintiffLastName ?? '')))));
            $defendant = trim(ucwords(strtolower(trim(($record->defendantName ?? '') . ' ' . ($record->defendantLastName ?? '')))));
            return "Blotter {$record->formatted_blotter_number}: {$plaintiff} vs {$defendant} (Status: {$record->current_status})";
        }

        if (in_array($module, ['setting', 'settings'], true)) {
            $record = $lookups['settings']->get($recordId);
            if (!$record) {
                return "Record ID: {$recordId}";
            }
            return "Setting: {$record->barangay_name} (Contact: {$record->contact_number})";
        }

        if (in_array($module, ['archive', 'archives'], true)) {
            $record = $lookups['archives']->get($recordId);
            if (!$record) {
                return "Record ID: {$recordId}";
            }
            return "Archive: {$record->record_type} #{$record->record_id} (Reason: " . Str::limit((string) $record->reason, 50) . ")";
        }

        if (in_array($module, ['official', 'officials'], true)) {
            $record = $lookups['officials']->get($recordId);
            if (!$record) {
                return "Record ID: {$recordId}";
            }
            return "Official: Position {$record->position} (Resident ID: {$record->resident_id})";
        }

        return "Record ID: {$recordId}";
    }
}
