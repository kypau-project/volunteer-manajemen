<?php

namespace App\Livewire\Volunteer;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class VolunteerDashboard extends Component
{
    use WithPagination;

    public function render()
    {
        $user = Auth::user();
        $registrations = $user->registrations()
            ->with("event")
            ->orderBy("created_at", "desc")
            ->paginate(10);

        $totalHours = $user->profile ? $user->profile->total_hours : 0;

        return view("livewire.volunteer.volunteer-dashboard", [
            "registrations" => $registrations,
            "totalHours" => $totalHours,
        ]);
    }
}

