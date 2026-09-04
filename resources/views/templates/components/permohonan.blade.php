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

<div class="permohonan-preview-container bg-white text-dark p-4 p-md-5 rounded shadow-sm border mx-auto" style="max-width: 800px; font-family: 'Times New Roman', Times, serif; font-size: 11pt; line-height: 1.4; position: relative;">
    <style>
        .permohonan-preview-container table {
            margin: 4px 0;
            page-break-inside: avoid;
        }
        .permohonan-preview-container p {
            margin: 4px 0;
        }
        .permohonan-preview-container .judul {
            text-align: center;
            font-weight: bold;
            margin-top: 10px;
            font-size: 13pt;
        }
        .permohonan-preview-container .judul::after {
            content: '';
            display: block;
            border-bottom: 2px solid #000;
            width: 70%;
            margin: 4px auto 16px auto;
        }
        .permohonan-preview-container .isi {
            margin: 10px 15px;
        }
        .permohonan-preview-container .syarat {
            margin-left: 25px;
            margin-bottom: 10px;
        }
        .permohonan-preview-container .kepada-container {
            text-align: right;
            margin-right: 5px;
            margin-bottom: 15px;
        }
        .permohonan-preview-container .kepada {
            display: inline-block;
            text-align: left;
        }
        .permohonan-preview-container .ttd {
            width: 100%;
            margin-top: 30px;
        }
        .permohonan-preview-container .ttd .kanan {
            text-align: right;
            float: right;
            margin-right: 20px;
        }
        .permohonan-preview-container .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 32px;
            font-weight: bold;
            color: rgba(220, 53, 69, 0.25);
            z-index: 1;
            pointer-events: none;
            text-align: center;
            width: 100%;
        }
    </style>

    @if (isset($isLengkap) && $isLengkap)
        <div class="watermark">SURAT PERMOHONAN RESMI</div>
    @else
        <div class="watermark">DRAFT SURAT PERMOHONAN</div>
    @endif

    {{-- Judul --}}
    <div class="judul">
        <p>SURAT PERMOHONAN MENJADI PEDAGANG</p>
    </div>

    {{-- Kepada --}}
    <div class="isi">
        <div class="kepada-container">
            <div class="kepada">
                <p>
                    Kepada<br>
                    Yth. Kepala Dinas Perdagangan<br>
                    Di-<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tempat
                </p>
            </div>
        </div>

        {{-- Hal --}}
        <p><strong>Hal :</strong> Permohonan Menjadi Pedagang</p>

        {{-- Identitas Pemohon --}}
        <p class="mt-3">Yang bertanda tangan di bawah ini :</p>
        <table style="border-collapse: collapse; width: 100%; font-size: 11pt;">
            <tr>
                <td style="width: 220px;">- Nama Lengkap</td>
                <td style="width: 10px;">:</td>
                <td>
                    <strong>{{ $p->nama ?? '...................................................' }}</strong>
                    ({{ $genderText }})
                </td>
            </tr>
            <tr>
                <td>- Tempat, Tanggal Lahir</td>
                <td>:</td>
                <td>
                    {{ $p->tempat_lahir ?? '..................' }},
                    {{ $tglLahir }}
                </td>
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
                <td style="vertical-align: top;">- Alamat</td>
                <td style="vertical-align: top;">:</td>
                <td>{{ $p->alamat ?? '...................................................' }}</td>
            </tr>
        </table>

        {{-- Permohonan --}}
        <p class="mt-3">Mengajukan permohonan untuk menjadi Pedagang pada:</p>
        <table style="border-collapse: collapse; width: 100%; font-size: 11pt;">
            <tr>
                <td style="width: 25px; vertical-align: top;">a.</td>
                <td style="width: 195px;">Nama Pasar</td>
                <td style="width: 10px;">:</td>
                <td><strong>{{ $p->nama_pasar ?? '...................................................' }}</strong></td>
            </tr>
            <tr>
                <td style="vertical-align: top;">b.</td>
                <td>Lahan / Tempat Dasaran</td>
                <td>:</td>
                <td>
                    {{ ucfirst($p->tipe_tempat ?? '................') }}
                    di Nomor <strong>{{ $p->nomor_tempat ?? '........' }}</strong>
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
                    {{ $p->jam_buka ? \Carbon\Carbon::parse($p->jam_buka)->format('H:i') : '........' }} s.d.
                    {{ $p->jam_tutup ? \Carbon\Carbon::parse($p->jam_tutup)->format('H:i') : '........' }} WIB
                </td>
            </tr>
        </table>

        {{-- Syarat --}}
        <p class="mt-3">Sebagai kelengkapan persyaratan, bersama ini kami lampirkan berkas:</p>
        <ol class="syarat">
            <li>Nomor Induk Berusaha (NIB)</li>
            <li>Fotokopi Nomor Pokok Wajib Pajak (NPWP)</li>
            <li>Fotokopi Kartu Tanda Penduduk (KTP)</li>
            <li>Fotokopi Kartu Keluarga (KK)</li>
            <li>Pas Foto terbaru ukuran 3x4 berwarna</li>
        </ol>

        <p class="mt-3">Demikian surat permohonan ini kami sampaikan, atas perhatian dan persetujuannya diucapkan terima kasih.</p>

        {{-- TTD --}}
        <div class="ttd clearfix">
            <div class="kanan text-center">
                <p class="mb-1">Dumai, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                <p class="mb-4">Pemohon,</p>
                <div style="height: 50px;"></div>
                <p class="mb-0 fw-bold text-decoration-underline">( {{ $p->nama ?? '...................................' }} )</p>
            </div>
        </div>
        <div style="clear: both;"></div>
    </div>
</div>

