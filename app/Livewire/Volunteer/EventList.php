<?php

namespace App\Livewire\Volunteer;

use App\Models\Event;
use App\Models\Registration;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class EventList extends Component
{
    use WithPagination;

    public $search = '';
    public $categoryFilter = '';

    protected $queryString = ['search', 'categoryFilter'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function register(Event $event)
    {
        // Check if already registered
        if (Registration::where('user_id', Auth::id())->where('event_id', $event->id)->exists()) {
            session()->flash('error', 'Anda sudah terdaftar untuk acara ini.');
            return;
        }

        // Check if quota is full
        if ($event->registrations()->whereIn('status', ['approved', 'pending'])->count() >= $event->quota) {
            session()->flash('error', 'Kuota acara ini sudah penuh.');
            return;
        }

        // Create registration
        Registration::create([
            'user_id' => Auth::id(),
            'event_id' => $event->id,
            'status' => 'pending', // Default status is pending approval
        ]);

        session()->flash('message', 'Pendaftaran berhasil! Menunggu persetujuan koordinator.');
    }

    public function render()
    {
        $events = Event::query()
            ->where('status', 'published') // Only show published events
            ->where('start_date', '>', now()) // Only show upcoming events
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('location', 'like', '%' . $this->search . '%');
            })
            ->when($this->categoryFilter, function ($query) {
                $query->where('category', $this->categoryFilter);
            })
            ->orderBy('start_date', 'asc')
            ->paginate(9);

        $registeredEventIds = Auth::user() ? Auth::user()->registrations->pluck('event_id')->toArray() : [];

        return view('livewire.volunteer.event-list', [
            'events' => $events,
            'registeredEventIds' => $registeredEventIds,
            'categories' => Event::where('status', 'published')->where('start_date', '>', now())->distinct()->pluck('category')->filter(),
        ]);
    }
}

