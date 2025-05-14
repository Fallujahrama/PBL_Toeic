@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
   <div class="card-header">
       <h3 class="card-title">{{ $page->title }}</h3>
       <div class="card-tools">
           <a class="btn btn-sm btn-primary mt-1" href="{{ url('mahasiswa/create') }}">Tambah</a>
       </div>
   </div>
   <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Filter:</label>
                    <div class="col-3">
                        <select class="form-control" id="kampus_id" name="kampus_id" required>
                            <option value="">- Semua Kampus -</option>
                            @foreach ($kampus as $item)
                                <option value="{{ $item->kampus }}">{{ $item->kampus }}</option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Kampus</small>
                    </div>
                </div>
            </div>
        </div>        

        <table class="table table-bordered table-striped table-hover table-sm">
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Jurusan</th>
                    <th>Program Studi</th>
                    <th>Kampus</th>
                    <th>No WhatsApp</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mahasiswa as $mhs)
                    <tr>
                        <td>{{ $mhs->nim }}</td>
                        <td>{{ $mhs->nama }}</td>
                        <td>{{ $mhs->jurusan }}</td>
                        <td>{{ $mhs->program_studi }}</td>
                        <td>{{ $mhs->kampus }}</td>
                        <td>{{ $mhs->no_whatsapp }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('css')
<!-- Optional: Custom CSS -->
@endpush

@push('js')
<!-- Optional: Custom JS -->
@endpush
