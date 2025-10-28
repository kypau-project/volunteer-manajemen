<?php

namespace App\Livewire\Volunteer;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\VolunteerProfile;

class VolunteerProfileForm extends Component
{
    public $address;
    public $skills;
    public $bio;
    public $phone;

    protected $rules = [
        'address' => 'nullable|string|max:500',
        'skills' => 'nullable|string|max:500',
        'bio' => 'nullable|string|max:1000',
        'phone' => 'nullable|string|max:15',
    ];

    public function mount()
    {
        $user = Auth::user();
        $this->phone = $user->phone;

        $profile = $user->profile;

        if ($profile) {
            $this->address = $profile->address;
            // Convert array back to string for the form
            $this->skills = is_array($profile->skills) ? implode(', ', $profile->skills) : $profile->skills;
            $this->bio = $profile->bio;
        }
    }

    public function saveProfile()
    {
        $this->validate();

        $user = Auth::user();
        $user->phone = $this->phone;
        $user->save();

        // Convert comma-separated string to array for storage
        $skillsArray = array_filter(array_map('trim', explode(',', $this->skills)));

        VolunteerProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'address' => $this->address,
                'skills' => $skillsArray, // Store as array/JSON in DB
                'bio' => $this->bio,
            ]
        );

        session()->flash('status', 'Profil relawan berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.volunteer.volunteer-profile-form');
    }
}

