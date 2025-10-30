<?php

namespace App\Exports;

use App\Models\Registration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AttendanceExport implements FromCollection, WithHeadings, WithMapping
{
    protected $eventId;

    public function __construct(int $eventId)
    {
        $this->eventId = $eventId;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Registration::with('user', 'event')
            ->where('event_id', $this->eventId)
            ->where('attended', true)
            ->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID Registrasi',
            'Nama Relawan',
            'Email Relawan',
            'Nama Acara',
            'Tanggal Acara',
            'Check In',
            'Check Out',
            'Jam Kontribusi',
        ];
    }

    /**
     * @param Registration $registration
     * @return array
     */
    public function map($registration): array
    {
        return [
            $registration->id,
            $registration->user->name,
            $registration->user->email,
            $registration->event->title,
            $registration->event->start_date->format('Y-m-d'),
            $registration->check_in ? $registration->check_in->format('Y-m-d H:i:s') : '-',
            $registration->check_out ? $registration->check_out->format('Y-m-d H:i:s') : '-',
            number_format($registration->hours_contributed, 2) . ' jam',
        ];
    }
}

