<?php

namespace App\Livewire\Admin\Attendance;

use App\Models\Event;
use App\Models\Registration;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceManager extends Component
{
    use WithPagination;

    public $event;
    public $search = '';
    public $statusFilter = '';

    protected $queryString = ['search', 'statusFilter'];

    public function mount(Event $event)
    {
        $this->event = $event;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function checkIn(Registration $registration)
    {
        if ($registration->check_in) {
            session()->flash('error', 'Relawan ini sudah check-in.');
            return;
        }

        $registration->update([
            'check_in' => now(),
            'status' => 'approved', // Set status to approved upon check-in
        ]);

        session()->flash('message', 'Check-in berhasil untuk ' . $registration->user->name);
    }

    public function checkOut(Registration $registration)
    {
        if (!$registration->check_in) {
            session()->flash('error', 'Relawan ini belum check-in.');
            return;
        }
        if ($registration->check_out) {
            session()->flash('error', 'Relawan ini sudah check-out.');
            return;
        }

        $checkOutTime = now();
        $checkInTime = Carbon::parse($registration->check_in);
        $hoursContributed = $checkOutTime->diffInMinutes($checkInTime) / 60;

        $registration->update([
            'check_out' => $checkOutTime,
            'hours_contributed' => $hoursContributed,
            'attended' => true,
        ]);

        // Update total_hours in volunteer_profiles
        $profile = $registration->user->profile;
        if ($profile) {
            $profile->total_hours += $hoursContributed;
            $profile->save();
        }

        session()->flash('message', 'Check-out berhasil untuk ' . $registration->user->name . '. Kontribusi: ' . number_format($hoursContributed, 2) . ' jam.');
    }

    public function render()
    {
        $registrations = $this->event->registrations()
            ->whereIn('status', ['pending', 'approved']) // Only show relevant registrations
            ->with('user')
            ->when($this->search, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderBy('created_at', 'asc')
            ->paginate(10);

        return view('livewire.admin.attendance.attendance-manager', [
            'registrations' => $registrations,
        ]);
    }
}

