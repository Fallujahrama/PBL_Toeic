<?php

namespace App\Exports;

use App\Models\MahasiswaModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MahasiswaExport implements FromCollection, WithHeadings, WithMapping, WithTitle, ShouldAutoSize, WithStyles
{
    protected $kampusFilter;

    /**
     * Constructor to accept filters
     */
    public function __construct($kampusFilter = null)
    {
        $this->kampusFilter = $kampusFilter;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return MahasiswaModel::when($this->kampusFilter, function ($query, $kampusFilter) {
            return $query->where('kampus', $kampusFilter);
        })->orderBy('created_at', 'desc')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'NIM',
            'Nama',
            'NIK',
            'Jurusan',
            'Program Studi',
            'Kampus',
            'No. WhatsApp',
            'Alamat Asal',
            'Alamat Saat Ini',
            'Tanggal Registrasi'
        ];
    }

    /**
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        return [
            $row->nim,
            $row->nama,
            $row->nik,
            $row->jurusan,
            $row->program_studi,
            $row->kampus,
            $row->no_whatsapp,
            $row->alamat_asal,
            $row->alamat_saat_ini,
            $row->created_at ? $row->created_at->format('d/m/Y H:i') : '-'
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Data Mahasiswa';
    }

    /**
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row (header row) as bold
            1 => ['font' => ['bold' => true]],
        ];
    }
}
