<div>
    <!-- start page title -->
    <div class="row mb-2">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Unggah Surat Permohonan</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('pedagang.dashboard') }}" wire:navigate>Dashboard</a></li>
                        <li class="breadcrumb-item">Layanan Permohonan</li>
                        <li class="breadcrumb-item active">Unggah Surat Permohonan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    {{-- Banner Petunjuk --}}
    <div class="row mb-3">
        <div class="col-12">
            <div class="alert alert-info border-0 shadow-sm p-3">
                <div class="d-flex align-items-start">
                    <i class="iconoir-info-circle fs-24 text-info me-3 mt-1"></i>
                    <div>
                        <h6 class="fw-bold mb-1">Panduan Penyelesaian Permohonan Menjadi Pedagang</h6>
                        <p class="mb-2 fs-13">Agar permohonan Anda dapat diproses oleh Dinas Perdagangan, pastikan mengikuti langkah-langkah berikut:</p>
                        <ol class="mb-0 fs-13 ps-3">
                            <li>Klik tombol <strong>"Lihat / Cetak Draf"</strong> untuk memeriksa dan mencetak fisik surat permohonan.</li>
                            <li>Bubuhkan tanda tangan asli Anda (Pemohon) pada lembar surat permohonan fisik.</li>
                            <li>Pindai (scan) atau foto lembar surat bertandatangan tersebut dengan jelas (format PDF, JPG, atau PNG).</li>
                            <li>Klik tombol <strong>"Unggah Surat"</strong> untuk mengunggah dokumen dan mengubah status menjadi <strong>Lengkap</strong>.</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-bottom">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <h5 class="card-title mb-0">Daftar Pengajuan Surat Permohonan Anda</h5>
                            <p class="text-muted mb-0 fs-13">Pantau kelengkapan dokumen dan status verifikasi permohonan tempat pasar.</p>
                        </div>
                        <div class="col-auto ms-auto">
                            @php
                                $hasDraft = $permohonans->contains('status', 'draft');
                            @endphp
                            @if ($hasDraft)
                                <a href="{{ route('pedagang.unggah_permohonan.create') }}" class="btn btn-primary btn-sm" wire:navigate>
                                    <i class="iconoir-upload me-1"></i> Unggah Surat Bertandatangan
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    @if ($permohonans->isEmpty())
                        <div class="text-center py-5">
                            <div class="avatar-lg bg-light rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3 text-muted">
                                <i class="iconoir-page-flip fs-36"></i>
                            </div>
                            <h5 class="fw-bold">Belum Ada Permohonan</h5>
                            <p class="text-muted fs-13 mb-3">Anda belum membuat pengajuan surat permohonan tempat pasar.</p>
                            <a href="{{ route('pedagang.ajukan_permohonan.create') }}" class="btn btn-primary btn-sm" wire:navigate>
                                <i class="iconoir-plus-circle me-1"></i> Ajukan Permohonan Sekarang
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 50px;">No</th>
                                        <th>Tanggal Pengajuan</th>
                                        <th>Pasar & Objek Unit</th>
                                        <th>Jenis Komoditas</th>
                                        <th class="text-center">Status Kelengkapan</th>
                                        <th class="text-center">Berkas Bertandatangan</th>
                                        <th class="text-center" style="width: 220px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permohonans as $index => $p)
                                        <tr>
                                            <td class="text-center text-muted fs-13">{{ $index + 1 }}</td>
                                            <td>
                                                <div class="fw-semibold">{{ \Carbon\Carbon::parse($p->created_at)->translatedFormat('d F Y') }}</div>
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($p->created_at)->format('H:i') }} WIB</small>
                                            </td>
                                            <td>
                                                <div class="fw-bold text-dark">{{ $p->pasar->nama_pasar ?? '-' }}</div>
                                                <div class="fs-13 text-muted">
                                                    {{ ucfirst($p->tipe_tempat) }} Nomor <strong>{{ $p->nomor_tempat }}</strong>
                                                    @if ($p->luas)
                                                        ({{ $p->luas }} m²)
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <span class="fs-13">{{ $p->jenis_dagangan ?? '-' }}</span>
                                                <div class="fs-12 text-muted">Jam: {{ $p->jam_buka ? \Carbon\Carbon::parse($p->jam_buka)->format('H:i') : '-' }} - {{ $p->jam_tutup ? \Carbon\Carbon::parse($p->jam_tutup)->format('H:i') : '-' }}</div>
                                            </td>
                                            <td class="text-center">
                                                @if ($p->status === 'draft')
                                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1">
                                                        <i class="iconoir-warning-circle me-1"></i> Belum Lengkap
                                                    </span>
                                                @elseif ($p->status === 'lengkap')
                                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                                        <i class="iconoir-check-circle me-1"></i> Lengkap (Terkirim)
                                                    </span>
                                                @elseif ($p->status === 'disetujui')
                                                    <span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1">
                                                        <i class="iconoir-check-circle me-1"></i> Disetujui
                                                    </span>
                                                @elseif ($p->status === 'ditolak')
                                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">
                                                        <i class="iconoir-xmark-circle me-1"></i> Ditolak
                                                    </span>
                                                @elseif ($p->status === 'selesai')
                                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1">
                                                        <i class="iconoir-check me-1"></i> Selesai
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary-subtle text-secondary px-2 py-1">{{ ucfirst($p->status) }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($p->dokumen_path)
                                                    <a href="{{ asset('storage/' . $p->dokumen_path) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                                        <i class="iconoir-open-new-window me-1"></i> Lihat Berkas
                                                    </a>
                                                @else
                                                    <span class="text-muted fs-12 fst-italic">Belum Diunggah</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-1">
                                                    {{-- Tombol Lihat/Cetak Draf Surat --}}
                                                    <button type="button" class="btn btn-outline-secondary btn-sm" wire:click="previewSurat({{ $p->id }})" title="Lihat dan Cetak Draf Surat">
                                                        <i class="iconoir-page-search me-1"></i> Draf Surat
                                                    </button>

                                                    {{-- Tombol Unggah Surat jika masih draft --}}
                                                    @if ($p->status === 'draft')
                                                        <a href="{{ route('pedagang.unggah_permohonan.create', ['id' => $p->id]) }}" class="btn btn-primary btn-sm" wire:navigate title="Unggah Surat Bertandatangan">
                                                            <i class="iconoir-upload me-1"></i> Unggah
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Preview Draf Surat --}}
    <livewire:modal modal-id="modalPreviewDraft" />
</div>
