<?php

namespace App\Services;

class CacheService
{
    // Cache disabled for production stability
    const DASHBOARD_TTL = 0;
    const USER_DATA_TTL = 0;
    
    public static function clearUserCache($userId)
    {
        // Cache disabled - no action needed
    }

    public static function clearDashboardCache()
    {
        // Cache disabled - no action needed
    }
    
    public static function clearAllUserCaches()
    {
        // Cache disabled - no action needed
    }
}