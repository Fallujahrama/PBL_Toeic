@extends('layouts.template')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-info text-white text-center">
        <h3 class="mb-0 fw-bold">Surat Pernyataan TOEIC</h3>
    </div>

    <div class="card-body text-center">
        <div class="mb-4"></div> <!-- Gap antara header dan embed -->

        <embed src="{{ $filePath }}" width="100%" height="600px" type="application/pdf" class="mb-4 border rounded">

        <div class="mt-3">
            <a href="{{ route('hasil_ujian.hasil.ujian') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection