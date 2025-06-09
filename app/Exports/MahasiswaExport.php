<?php

namespace App\Exports;

use App\Models\MahasiswaModel;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MahasiswaExport implements FromQuery, WithHeadings, WithMapping
{
    protected $kampusFilter;

    public function __construct($kampusFilter = null)
    {
        $this->kampusFilter = $kampusFilter;
    }

    public function query()
    {
        return MahasiswaModel::query()
            ->whereHas('pendaftaran') // Only export students who have registered
            ->when($this->kampusFilter, function ($query, $kampusFilter) {
                return $query->where('kampus', $kampusFilter);
            })
            ->orderBy('created_at', 'desc');
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama',
            'NIM',
            'Email',
            'Kampus',
            'Created At',
            'Updated At',
        ];
    }

    public function map($mahasiswa): array
    {
        return [
            $mahasiswa->id,
            $mahasiswa->nama,
            $mahasiswa->nim,
            $mahasiswa->email,
            $mahasiswa->kampus,
            $mahasiswa->created_at,
            $mahasiswa->updated_at,
        ];
    }
}
