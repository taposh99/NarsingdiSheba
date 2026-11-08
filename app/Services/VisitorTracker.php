<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\SiteVisit;

class VisitorTracker
{
    public static function track(Request $request): void
    {
        // Don't track API, asset or boost requests
        if ($request->is('_boost*') || $request->is('build*') || $request->is('icons*')) {
            return;
        }

        $today = now()->toDateString();
        $ip = $request->ip() ?? '127.0.0.1';
        $sessionId = session()->getId();

        // 1. Track Active Live Visitor (Expires in 5 minutes)
        if ($sessionId) {
            $activeKey = 'online_user_' . $sessionId;
            Cache::put($activeKey, true, now()->addMinutes(5));

            $activeUsers = Cache::get('active_user_list', []);
            $activeUsers[$sessionId] = now()->timestamp;
            
            // Clean up stale users (> 5 min)
            $cutoff = now()->subMinutes(5)->timestamp;
            $activeUsers = array_filter($activeUsers, fn($time) => $time > $cutoff);
            Cache::put('active_user_list', $activeUsers, now()->addMinutes(10));
        }

        // 2. Track Unique Daily Visitor
        $visitorKey = 'daily_visitor_' . $today . '_' . md5($ip);

        $visit = SiteVisit::firstOrCreate(
            ['date' => $today],
            ['unique_visitors' => 0, 'page_views' => 0]
        );

        $isNewUnique = false;
        if (!Cache::has($visitorKey)) {
            Cache::put($visitorKey, true, now()->endOfDay());
            $visit->increment('unique_visitors');
            $isNewUnique = true;
        }

        $visit->increment('page_views');
    }

    public static function getStats(): array
    {
        $today = now()->toDateString();
        $todayVisit = SiteVisit::where('date', $today)->first();

        // Baseline numbers to look mature and established
        $baselineLifetime = 14520;
        $baselineToday = 185;

        $dbTotalUnique = (int) SiteVisit::sum('unique_visitors');
        $dbTotalViews = (int) SiteVisit::sum('page_views');

        $activeUsers = Cache::get('active_user_list', []);
        $onlineCount = max(count($activeUsers), 3); // realistic minimum online active users

        $todayUnique = ($todayVisit ? $todayVisit->unique_visitors : 0) + $baselineToday;
        $totalLifetime = $dbTotalUnique + $baselineLifetime;
        $history = SiteVisit::orderByDesc('date')->take(7)->get();

        return [
            'online' => $onlineCount,
            'today' => $todayUnique,
            'total' => $totalLifetime,
            'total_views' => $dbTotalViews + ($baselineLifetime * 3),
            'history' => $history,
        ];
    }
}
