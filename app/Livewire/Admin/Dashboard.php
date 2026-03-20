<?php

namespace App\Livewire\Admin;

use App\Models\Attendance;
use App\Models\Leave;
use App\Models\User;
use Livewire\Component;
use Carbon\Carbon;

class Dashboard extends Component
{
    public string $chartRange = '7'; // Default to 7 days

    public function render()
    {
        $user = auth()->user();
        $managedClassIds = $user->managedClassrooms()->pluck('id')->toArray();
        $isGlobalAdmin = empty($managedClassIds); // If not assigned to any specific class, assume global for now or we can use a role

        $stats = [
            'total_users' => User::where('role', 'user')
                ->when(!$isGlobalAdmin, function($q) use ($managedClassIds) {
                    $q->whereHas('classrooms', fn($sq) => $sq->whereIn('classroom_id', $managedClassIds));
                })->count(),
            'present_today' => Attendance::whereDate('date', Carbon::today())
                ->when(!$isGlobalAdmin, function($q) use ($managedClassIds) {
                    $q->whereIn('classroom_id', $managedClassIds);
                })->count(),
            'pending_leaves' => Leave::where('status', 'pending')
                ->when(!$isGlobalAdmin, function($q) use ($managedClassIds) {
                    // This is tricky as leaves are not directly tied to classrooms in current schema
                    // We check if the user requesting leave is in one of the managed classes
                    $q->whereHas('user.classrooms', fn($sq) => $sq->whereIn('classroom_id', $managedClassIds));
                })->count(),
            'online_now' => User::where('last_active_at', '>', Carbon::now()->subMinutes(5))
                ->when(!$isGlobalAdmin, function($q) use ($managedClassIds) {
                    $q->whereHas('classrooms', fn($sq) => $sq->whereIn('classroom_id', $managedClassIds));
                })->count(),
        ];

        $recent_attendances = Attendance::with('user')
            ->when(!$isGlobalAdmin, function($q) use ($managedClassIds) {
                $q->whereIn('classroom_id', $managedClassIds);
            })
            ->latest()
            ->take(5)
            ->get();

        // Chart Data (Dynamic Range)
        $chartLabels = [];
        $chartData = [];
        $days = (int) $this->chartRange;

        for ($i = ($days - 1); $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartLabels[] = $days > 7 ? $date->format('d/m') : $date->translatedFormat('D');
            $chartData[] = Attendance::whereDate('date', $date)
                ->when(!$isGlobalAdmin, function($q) use ($managedClassIds) {
                    $q->whereIn('classroom_id', $managedClassIds);
                })->count();
        }

        return view('livewire.admin.dashboard', [
            'stats' => $stats,
            'recent_attendances' => $recent_attendances,
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
        ])->layout('layouts.admin');
    }
}
