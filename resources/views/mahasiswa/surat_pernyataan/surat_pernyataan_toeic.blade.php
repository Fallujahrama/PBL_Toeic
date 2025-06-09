<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan TOEIC</title>
    <style>
        @page {
            margin: 2cm;
        }
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            line-height: 1.2;
            margin: 0;
            padding: 0;
        }
        .container {
            position: relative;
            width: 100%;
        }
        .header {
            position: relative;
            margin-bottom: 10px;
        }
        .logo-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 85px;
            height: auto;
        }
        .logo {
            width: 80px;
            height: auto;
        }
        .kop-wrapper {
            width: 100%;
            text-align: center;
        }
        .kop-surat {
            text-align: center;
            font-size: 11pt;
            line-height: 1.2;
            text-transform: uppercase;
            font-weight: bold;
        }
        .kop-details {
            text-align: center;
            font-size: 10pt;
            line-height: 1.1;
            font-weight: normal;
        }
        .title {
            text-align: center;
            font-weight: bold;
            font-size: 12pt;
            margin: 25px 0 3px;
            text-decoration: underline;
            text-transform: uppercase;
        }
        .nomor {
            text-align: center;
            margin-bottom: 20px;
            font-size: 10pt;
        }
        .content {
            padding: 0 15px;
        }
        p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 8px 0;
            font-size: 11pt;
        }
        table td {
            padding: 2px 0;
        }
        .align-top {
            vertical-align: top;
        }
        hr {
            border: 1px solid black;
            margin-bottom: 8px;
            width: 100%;
            margin-top: 5px;
        }
        .signature-area {
            width: 45%;
            float: right;
            margin-top: 20px;
            text-align: center;
            font-size: 11pt;
        }
        .ttd-img {
            width: 120px;
            height: auto;
            margin: 0 auto;
            display: block;
        }
        .lampiran {
            margin-top: 30px;
            font-size: 10pt;
            clear: both;
        }
        .spaced {
            letter-spacing: 1px;
        }

        /* Untuk menyejajarkan konten dalam tabel */
        .left-part {
            width: 5%;
            text-align: left;
        }
        .label-part {
            width: 25%;
            text-align: left;
        }
        .separator {
            width: 5%;
            padding-left: 30px;
        }
        .right-part {
            width: 65%;
            text-align: left;
            padding-left: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo-container">
                <img src="{{ public_path('img/logo-poltek.png') }}" class="logo" alt="Logo Polinema">
            </div>
            <div class="kop-wrapper">
                <div class="kop-surat">
                    Kementerian Pendidikan Tinggi, Sains, dan Teknologi<br>
                    Unit Penunjang Akademik Bahasa<br>
                    Politeknik Negeri Malang
                </div>
                <div class="kop-details">
                    Jl. Soekarno Hatta No.9 Malang 65141<br>
                    Telp (0341) 404424 – 404425 Fax (0341) 404420<br>
                    Laman://www.polinema.ac.id
                </div>
            </div>
            <hr>
        </div>

        <div class="title">Surat Keterangan Sudah Mengikuti TOEIC</div>
        <div class="nomor">Nomor: {{ $data['document_number'] ?? '....../PL2. UPA BHS/2024' }}</div>

        <div class="content">
            <p>Yang bertanda tangan di bawah ini</p>

            <table>
                <tr>
                    <td class="left-part align-top">1.</td>
                    <td class="label-part align-top spaced">N a m a</td>
                    <td class="separator align-top">:</td>
                    <td class="right-part align-top">Atiqah Nurul Asri, S.Pd., M.Pd.</td>
                </tr>
                <tr>
                    <td class="left-part align-top">2.</td>
                    <td class="label-part align-top spaced">N I P</td>
                    <td class="separator align-top">:</td>
                    <td class="right-part align-top">197606252005012001</td>
                </tr>
                <tr>
                    <td class="left-part align-top">3.</td>
                    <td class="label-part align-top">Pangkat, golongan, ruang</td>
                    <td class="separator align-top">:</td>
                    <td class="right-part align-top">Penata Tingkat 1/ III D</td>
                </tr>
                <tr>
                    <td class="left-part align-top">4.</td>
                    <td class="label-part align-top spaced">J a b a t a n</td>
                    <td class="separator align-top">:</td>
                    <td class="right-part align-top">Kepala UPA Bahasa</td>
                </tr>
            </table>

            <p>dengan ini menyatakan dengan sesungguhnya bahwa:</p>

            <table>
                <tr>
                    <td class="left-part align-top">6.</td>
                    <td class="label-part align-top spaced">N a m a</td>
                    <td class="separator align-top">:</td>
                    <td class="right-part align-top">{{ $data['nama'] }}</td>
                </tr>
                <tr>
                    <td class="left-part align-top">7.</td>
                    <td class="label-part align-top spaced">N I M</td>
                    <td class="separator align-top">:</td>
                    <td class="right-part align-top">{{ $data['nim'] }}</td>
                </tr>
                <tr>
                    <td class="left-part align-top">8.</td>
                    <td class="label-part align-top">Jurusan</td>
                    <td class="separator align-top">:</td>
                    <td class="right-part align-top">{{ $data['jurusan'] }}</td>
                </tr>
                <tr>
                    <td class="left-part align-top">9.</td>
                    <td class="label-part align-top">Program Studi</td>
                    <td class="separator align-top">:</td>
                    <td class="right-part align-top">{{ $data['prodi'] }}</td>
                </tr>
                <tr>
                    <td class="left-part align-top">10.</td>
                    <td class="label-part align-top spaced">A l a m a t</td>
                    <td class="separator align-top">:</td>
                    <td class="right-part align-top">{{ $data['alamat'] }}</td>
                </tr>
            </table>

            <p>telah mengikuti ujian TOEIC dan mendapat sertifikat yang diterbitkan oleh ETS sebanyak dua kali dengan nilai di bawah 400 untuk Program D-III dan 450 untuk Program D-IV dengan bukti sertifikat terlampir (dua berkas).</p>

            <p>Demikian surat keterangan ini dibuat sebagai pengganti <strong>syarat pengambilan ijazah</strong> dan agar dapat dipergunakan sebagaimana mestinya.</p>

            <div class="signature-area">
                <p>Kepala UPA Bahasa,</p>
                @if(isset($data['signature_path']))
                    <img src="{{ $data['signature_path'] }}" class="ttd-img" alt="Tanda Tangan">
                @else
                    <br><br>
                @endif
                <p style="margin-bottom: 0;">Atiqah Nurul Asri, S.Pd., M.Pd.</p>
                <p style="margin-top: 0;">NIP. 197606252005012001</p>
            </div>

            <div style="clear: both;"></div>

            <div class="lampiran">
                <p>Lampiran:<br>
                Salinan 2 sertifikat TOEIC yang diterbitkan oleh ETS dan masih berlaku.</p>
            </div>
        </div>
    </div>
</body>
</html>
