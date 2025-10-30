<?php

namespace App\Livewire\Admin;

use App\Models\Registration;
use App\Models\User;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardStats extends Component
{
    public $chartData;

    public function mount()
    {
        $this->generateChartData();
    }

    public function generateChartData()
    {
        // Data for registrations per month (Bar Chart)
        $registrations = Registration::select(
                DB::raw('count(id) as count'),
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $labels = $registrations->pluck('month')->map(fn($m) => Carbon::parse($m . '-01')->format('M Y'))->toArray();
        $data = $registrations->pluck('count')->toArray();

        $this->chartData = [
            'labels' => $labels,
            'data' => $data,
        ];
    }

    public function render()
    {
        $totalVolunteers = User::where('role', 'volunteer')->count();
        $totalHours = User::where('role', 'volunteer')->with('profile')->get()->sum(fn($user) => $user->profile->total_hours ?? 0);
        $totalEvents = \App\Models\Event::count();

        return view('livewire.admin.dashboard-stats', [
            'totalVolunteers' => $totalVolunteers,
            'totalHours' => $totalHours,
            'totalEvents' => $totalEvents,
        ]);
    }
}

