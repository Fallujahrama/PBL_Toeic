@extends('layouts.template')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0">Hasil Ujian TOEIC</h5>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p>Berikut adalah file Hasil Ujian TOEIC.</p>
                <p>Status file akan diperbarui secara otomatis.</p>
                
                <!-- Tabel Status -->
                <table class="table">
                <tbody>
                    <tr>
                        <td><strong>Status</strong></td>
                        <td style="width: 10px;">:</td>
                        <td>
                            <div id="fileStatus" class="badge badge-{{ $isAvailable ? 'success' : 'secondary' }}">
                                {{ $isAvailable ? 'Available' : 'Not Available' }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>File PDF</strong></td>
                        <td>:</td>
                        <td><div id="fileName">{{ $fileName }}</div></td>
                    </tr>
                    <tr>
                        <td><strong>Terakhir Update</strong></td>
                        <td>:</td>
                        <td><div id="lastUpdated">{{ $lastUpdated }}</div></td>
                    </tr>
                </tbody>
            </table>

                <!-- Tombol Lihat Hasil -->
                <a href="{{ url('hasil-ujian/result') }}" class="btn btn-primary {{ $isAvailable ? '' : 'disabled' }}">
                    <i class="fa fa-eye"></i> Lihat Hasil
                </a>
            </div>
        </div>
    </div>
</div>

</div>
@endsection
