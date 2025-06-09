<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h2 {
            margin-bottom: 5px;
            color: #333;
            font-size: 18px;
        }
        .header p {
            margin-top: 0;
            color: #666;
            font-size: 12px;
        }
        .filter-info {
            margin-bottom: 15px;
            font-style: italic;
            background-color: #f0f0f0;
            padding: 8px;
            border-radius: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th {
            background-color: #4a5568;
            color: white;
            font-weight: bold;
            text-align: center;
            padding: 8px 4px;
            font-size: 9px;
        }
        td {
            padding: 6px 4px;
            font-size: 8px;
            text-align: left;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 8px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .no-data {
            text-align: center;
            font-style: italic;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>{{ $title }}</h2>
        <p>Dicetak pada: {{ $date }}</p>
    </div>
    
    @if($kampusFilter)
    <div class="filter-info">
        <strong>Filter Diterapkan:</strong> Kampus {{ $kampusFilter }}
    </div>
    @endif
    
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 12%;">NIM</th>
                <th style="width: 20%;">Nama</th>
                <th style="width: 12%;">NIK</th>
                <th style="width: 15%;">Jurusan</th>
                <th style="width: 15%;">Program Studi</th>
                <th style="width: 10%;">Kampus</th>
                <th style="width: 11%;">WhatsApp</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $mahasiswa)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $mahasiswa->nim }}</td>
                <td>{{ $mahasiswa->nama }}</td>
                <td>{{ $mahasiswa->nik ?? '-' }}</td>
                <td>{{ $mahasiswa->jurusan }}</td>
                <td>{{ $mahasiswa->program_studi }}</td>
                <td>{{ $mahasiswa->kampus }}</td>
                <td>{{ $mahasiswa->no_whatsapp ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="no-data">Tidak ada data mahasiswa yang ditemukan</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="footer">
        <p><strong>Sistem PBL TOEIC</strong> | Total Data: {{ $data->count() }} mahasiswa</p>
        <p>Dokumen ini digenerate secara otomatis pada {{ $date }}</p>
    </div>
</body>
</html>
