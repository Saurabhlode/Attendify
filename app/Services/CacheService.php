<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class CacheService
{
    // Shorter cache times for faster responses
    const DASHBOARD_TTL = 60; // 1 minute
    const USER_DATA_TTL = 180; // 3 minutes
    
    public static function clearUserCache($userId)
    {
        $patterns = [
            "teacher.{$userId}.subjects",
            "student.{$userId}.subjects",
            "admin.dashboard.stats",
            "admin.dashboard.attendance_stats"
        ];

        foreach ($patterns as $pattern) {
            Cache::forget($pattern);
        }
    }

    public static function clearDashboardCache()
    {
        Cache::forget('admin.dashboard.stats');
        Cache::forget('admin.dashboard.attendance_stats');
    }
    
    public static function clearAllUserCaches()
    {
        // Clear all user-specific caches when major changes occur
        Cache::flush();
    }
}