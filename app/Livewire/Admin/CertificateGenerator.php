<?php

namespace App\Livewire\Admin;

use App\Models\Registration;
use App\Models\Certificate;
use Livewire\Component;
use PDF; // Alias for Barryvdh\DomPDF\Facade\Pdf
use Illuminate\Support\Facades\Response;

class CertificateGenerator extends Component
{
    public Registration $registration;

    public function mount(Registration $registration)
    {
        // Check if the volunteer attended and checked out
        if (!$registration->attended || !$registration->check_out) {
            session()->flash('error', 'Sertifikat hanya dapat dibuat untuk relawan yang sudah check-out dan hadir.');
            return redirect()->route('admin.events.attendance', $registration->event);
        }

        $this->registration = $registration;
    }

    public function generateCertificate()
    {
        // Check if certificate already exists
        if ($this->registration->certificate) {
            session()->flash('error', 'Sertifikat sudah pernah dibuat.');
            return;
        }

        // 1. Create a unique certificate number
        $certificateNumber = 'CERT-' . now()->format('Ymd') . '-' . $this->registration->id;

        // 2. Save the certificate record
        $certificate = Certificate::create([
            'registration_id' => $this->registration->id,
            'certificate_number' => $certificateNumber,
            'issue_date' => now(),
        ]);

        // 3. Update registration with certificate ID
        $this->registration->certificate_id = $certificate->id;
        $this->registration->save();

        session()->flash('message', 'Sertifikat berhasil dibuat!');
        return $this->downloadCertificate($certificate);
    }

    public function downloadCertificate(Certificate $certificate = null)
    {
        $certificate = $certificate ?? $this->registration->certificate;

        if (!$certificate) {
            session()->flash('error', 'Sertifikat belum dibuat.');
            return;
        }

        $data = [
            'name' => $this->registration->user->name,
            'eventTitle' => $this->registration->event->title,
            'hours' => number_format($this->registration->hours_contributed, 2),
            'issueDate' => $certificate->issue_date->format('d F Y'),
            'certificateNumber' => $certificate->certificate_number,
        ];

        $pdf = PDF::loadView('certificates.template', $data)->setPaper('a4', 'landscape');

        return Response::streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'Sertifikat-' . \Str::slug($this->registration->user->name) . '-' . \Str::slug($this->registration->event->title) . '.pdf');
    }

    public function render()
    {
        return view('livewire.admin.certificate-generator');
    }
}

