<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Event\EventIndex;
use App\Models\Registration;
use App\Livewire\Admin\Event\EventForm;
use App\Livewire\Admin\EventCalendar;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'welcome');

Route::get('dashboard', function () {
    if (auth()->user()->isVolunteer()) {
        return redirect()->route('volunteer.dashboard');
    } elseif (auth()->user()->isAdmin() || auth()->user()->isCoordinator()) {
        return redirect()->route('admin.dashboard');
    }
    return view('dashboard');
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Volunteer Routes
Route::middleware(['auth', 'verified', 'role:volunteer'])->prefix('volunteer')->name('volunteer.')->group(function () {
    // Feature 3: Profil Relawan
    Route::get('profile/edit', \App\Livewire\Volunteer\VolunteerProfileForm::class)->name('profile.edit');
    // Feature 3: Riwayat Partisipasi
    Route::get('dashboard', \App\Livewire\Volunteer\VolunteerDashboard::class)->name('dashboard');
    // Feature 2: Pendaftaran Acara
    Route::get("events", \App\Livewire\Volunteer\EventList::class)->name("events.index");

    // Feature 12: Feedback
    Route::get("registrations/{registration}/feedback/create", \App\Livewire\Volunteer\FeedbackForm::class)->name("feedback.create");
});

// Admin/Coordinator Routes
Route::middleware(['auth', 'verified', 'role:admin,coordinator'])->prefix('admin')->name('admin.')->group(function () {
    // Feature 5: Dashboard Statistik
    Route::get('dashboard', \App\Livewire\Admin\DashboardStats::class)->name('dashboard');

    // Feature 6: Kalender Acara
    Route::get('calendar', \App\Livewire\Admin\EventCalendar::class)->name('calendar');

    // Event Management (Feature 1)
    Route::get("events", EventIndex::class)->name("events.index");
    Route::get("events/create", EventForm::class)->name("events.create");
    Route::get("events/{event}/edit", EventForm::class)->name("events.edit");

    // Feature 4: Manajemen Kehadiran
    Route::get("events/{event}/attendance", \App\Livewire\Admin\Attendance\AttendanceManager::class)->name("events.attendance");

    // Feature 9: Laporan & Export
    Route::get("reports", \App\Livewire\Admin\ReportGenerator::class)->name("reports.index");

    // Feature 11: Manajemen Peran & Permission
    Route::get("users/roles", \App\Livewire\Admin\UserRoleManager::class)->name("users.roles");

    // Feature 10: Sistem Penghargaan
    Route::get("registrations/{registration}/certificate/generate", \App\Livewire\Admin\CertificateGenerator::class)->name("certificates.generate");
    Route::get("registrations/{registration}/certificate/download", function (Registration $registration) {
        $generator = new \App\Livewire\Admin\CertificateGenerator();
        $generator->registration = $registration;
        return $generator->downloadCertificate();
    })->name("certificates.download");

    // Add other admin/coordinator routes here later
    // ...
});

require __DIR__.'/auth.php';

