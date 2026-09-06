@php
    $p = is_array($pedagang ?? null) ? (object) $pedagang : ($pedagang ?? (object) []);
    $genderText = match ($p->jenis_kelamin ?? '') {
        'L', 'Laki-laki' => 'Laki-laki',
        'P', 'Perempuan' => 'Perempuan',
        default => $p->jenis_kelamin ?? '...................................................',
    };
    $tglLahir = ! empty($p->tanggal_lahir)
        ? (strtotime($p->tanggal_lahir) ? \Carbon\Carbon::parse($p->tanggal_lahir)->translatedFormat('d F Y') : $p->tanggal_lahir)
        : '..................';
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Permohonan Menjadi Pedagang</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 1.8cm 2.2cm 1.8cm 2.2cm;
        }
        body {
            font-family: 'Times-Roman', 'Times New Roman', serif;
            font-size: 11pt;
            line-height: 1.35;
            color: #111;
            margin: 0;
            padding: 0;
            position: relative;
        }
        .watermark {
            position: fixed;
            top: 35%;
            left: 5%;
            width: 90%;
            text-align: center;
            font-size: 34pt;
            font-weight: bold;
            color: rgba(220, 53, 69, 0.16);
            transform: rotate(-35deg);
            z-index: -1000;
        }
        .judul {
            text-align: center;
            font-weight: bold;
            font-size: 13pt;
            margin-bottom: 2px;
        }
        .judul-line {
            border-bottom: 2px solid #000;
            width: 70%;
            margin: 0 auto 16px auto;
        }
        .kepada-wrapper {
            width: 100%;
            margin-bottom: 12px;
        }
        .kepada-table {
            width: 100%;
            border-collapse: collapse;
        }
        .kepada-table td {
            vertical-align: top;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11pt;
            margin: 4px 0;
        }
        table.data-table td {
            padding: 2px 0;
            vertical-align: top;
        }
        ol.syarat {
            margin: 4px 0 10px 20px;
            padding-left: 0;
        }
        ol.syarat li {
            margin-bottom: 2px;
        }
        .ttd-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }
        .ttd-table td {
            text-align: center;
            vertical-align: top;
        }
    </style>
</head>
<body>
    @if (isset($isLengkap) && $isLengkap)
        <div class="watermark">SURAT PERMOHONAN RESMI</div>
    @else
        <div class="watermark">DRAFT SURAT PERMOHONAN</div>
    @endif

    {{-- Judul Surat --}}
    <div class="judul">SURAT PERMOHONAN MENJADI PEDAGANG</div>
    <div class="judul-line"></div>

    {{-- Tujuan Surat --}}
    <div class="kepada-wrapper">
        <table class="kepada-table">
            <tr>
                <td style="width: 58%;"></td>
                <td style="width: 42%; text-align: left;">
                    Kepada<br>
                    Yth. Kepala Dinas Perdagangan<br>
                    Di-<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tempat
                </td>
            </tr>
        </table>
    </div>

    {{-- Hal --}}
    <p style="margin: 6px 0;"><strong>Hal :</strong> Permohonan Menjadi Pedagang</p>

    {{-- Identitas Pemohon --}}
    <p style="margin: 8px 0 4px 0;">Yang bertanda tangan di bawah ini :</p>
    <table class="data-table">
        <tr>
            <td style="width: 200px;">- Nama Lengkap</td>
            <td style="width: 10px;">:</td>
            <td><strong>{{ $p->nama ?? '...................................................' }}</strong> ({{ $genderText }})</td>
        </tr>
        <tr>
            <td>- Tempat, Tanggal Lahir</td>
            <td>:</td>
            <td>{{ $p->tempat_lahir ?? '..................' }}, {{ $tglLahir }}</td>
        </tr>
        <tr>
            <td>- No. NIK / KTP</td>
            <td>:</td>
            <td>{{ $p->nik ?? '...................................................' }}</td>
        </tr>
        <tr>
            <td>- No. Telp / Handphone</td>
            <td>:</td>
            <td>{{ $p->no_telp ?? '..................' }}</td>
        </tr>
        <tr>
            <td>- Alamat</td>
            <td>:</td>
            <td>{{ $p->alamat ?? '...................................................' }}</td>
        </tr>
    </table>

    {{-- Permohonan Tempat --}}
    <p style="margin: 10px 0 4px 0;">Mengajukan permohonan untuk menjadi Pedagang pada:</p>
    <table class="data-table">
        <tr>
            <td style="width: 25px;">a.</td>
            <td style="width: 175px;">Nama Pasar</td>
            <td style="width: 10px;">:</td>
            <td><strong>{{ $p->nama_pasar ?? '...................................................' }}</strong></td>
        </tr>
        <tr>
            <td>b.</td>
            <td>Lahan / Tempat Dasaran</td>
            <td>:</td>
            <td>
                {{ ucfirst($p->tipe_tempat ?? '................') }} di Nomor <strong>{{ $p->nomor_tempat ?? '........' }}</strong>
                @if(!empty($p->lokasi))
                    (Lokasi: {{ $p->lokasi }})
                @endif
            </td>
        </tr>
        <tr>
            <td>c.</td>
            <td>Luas Ukuran</td>
            <td>:</td>
            <td>{{ $p->luas ?? '................' }} m<sup>2</sup></td>
        </tr>
        <tr>
            <td>d.</td>
            <td>Jenis Dagangan / Komoditas</td>
            <td>:</td>
            <td>{{ $p->jenis_dagangan ?? '...................................................' }}</td>
        </tr>
        <tr>
            <td>e.</td>
            <td>Jam Operasional</td>
            <td>:</td>
            <td>
                {{ !empty($p->jam_buka) ? \Carbon\Carbon::parse($p->jam_buka)->format('H:i') : '........' }} s.d.
                {{ !empty($p->jam_tutup) ? \Carbon\Carbon::parse($p->jam_tutup)->format('H:i') : '........' }} WIB
            </td>
        </tr>
    </table>

    {{-- Persyaratan --}}
    <p style="margin: 10px 0 4px 0;">Sebagai kelengkapan persyaratan, bersama ini kami lampirkan berkas:</p>
    <ol class="syarat">
        <li>Nomor Induk Berusaha (NIB)</li>
        <li>Fotokopi Nomor Pokok Wajib Pajak (NPWP)</li>
        <li>Fotokopi Kartu Tanda Penduduk (KTP)</li>
        <li>Fotokopi Kartu Keluarga (KK)</li>
        <li>Pas Foto terbaru ukuran 3x4 berwarna</li>
    </ol>

    <p style="margin: 8px 0;">Demikian surat permohonan ini kami sampaikan, atas perhatian dan persetujuannya diucapkan terima kasih.</p>

    {{-- Tanda Tangan --}}
    <table class="ttd-table">
        <tr>
            <td style="width: 55%;"></td>
            <td style="width: 45%;">
                <p style="margin: 0;">Dumai, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                <p style="margin: 4px 0 50px 0;">Pemohon,</p>
                <p style="margin: 0; font-weight: bold; text-decoration: underline;">( {{ $p->nama ?? '...................................' }} )</p>
            </td>
        </tr>
    </table>
</body>
</html>
