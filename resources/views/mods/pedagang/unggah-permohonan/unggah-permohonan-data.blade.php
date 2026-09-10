@push('css')
    <style>
        .table-responsive {
            min-height: 260px;
        }

        .table .dropdown {
            position: relative;
            display: inline-block;
        }

        .table .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            left: auto;
            z-index: 1060 !important;
        }
    </style>
@endpush

<div>
    <!-- start page title -->
    <div class="row mb-2">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Unggah Surat Permohonan</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('pedagang.dashboard') }}"
                                wire:navigate>Dashboard</a></li>
                        <li class="breadcrumb-item">Layanan Permohonan</li>
                        <li class="breadcrumb-item active">Unggah Surat Permohonan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    {{-- Banner Status Dinamis --}}
    @foreach ($permohonans as $pBanner)
        @if ($pBanner->status === 'disetujui')
            <div class="alert alert-warning border-0 shadow-sm p-3 mb-3">
                <div class="d-flex align-items-start">
                    <i class="fas fa-bell fs-3 text-warning me-3 mt-1"></i>
                    <div>
                        <h6 class="fw-bold mb-1">Permohonan Anda Telah Disetujui (Belum Terverifikasi)</h6>
                        <p class="mb-2 fs-13">Silakan unduh <strong>Surat Pemberitahuan</strong> dan <strong>Surat Pernyataan</strong>. Tanda tangani Surat Pernyataan fisik bermeterai, kemudian unggah pada menu aksi di bawah untuk menyelesaikan verifikasi akhir.</p>
                        <button type="button" class="btn btn-warning btn-sm" wire:click="openUploadPernyataanModal({{ $pBanner->id }})">
                            <i class="fas fa-upload me-1"></i> Unggah Surat Pernyataan Sekarang
                        </button>
                    </div>
                </div>
            </div>
        @elseif ($pBanner->status === 'verifikasi')
            <div class="alert alert-info border-0 shadow-sm p-3 mb-3">
                <div class="d-flex align-items-center">
                    <i class="fas fa-hourglass-half fs-3 text-info me-3"></i>
                    <div>
                        <h6 class="fw-bold mb-0">Menunggu Verifikasi Akhir oleh Admin</h6>
                        <p class="mb-0 fs-13 text-muted">Surat pernyataan Anda telah berhasil dikirim. Tim Dinas Perdagangan sedang memverifikasi dokumen Anda.</p>
                    </div>
                </div>
            </div>
        @elseif ($pBanner->status === 'selesai')
            <div class="alert alert-success border-0 shadow-sm p-3 mb-3">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle fs-3 text-success me-3"></i>
                    <div>
                        <h6 class="fw-bold mb-0">Permohonan Selesai & Terverifikasi</h6>
                        <p class="mb-0 fs-13 text-muted">Selamat! Anda telah resmi diverifikasi sebagai pedagang pada unit tempat yang telah disetujui.</p>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

    {{-- Banner Petunjuk --}}
    <div class="row mb-3">
        <div class="col-12">
            <div class="alert alert-info border-0 shadow-sm p-3">
                <div class="d-flex align-items-start">
                    <i class="fas fa-info-circle fs-3 text-info me-3 mt-1"></i>
                    <div>
                        <h6 class="fw-bold mb-1">Panduan Penyelesaian Permohonan Menjadi Pedagang</h6>
                        <p class="mb-2 fs-13">Ikuti tahapan alur berikut untuk pengajuan permohonan tempat pasar:</p>
                        <ol class="mb-0 fs-13 ps-3">
                            <li>Klik tombol <strong>"Draf Surat"</strong> untuk melihat pratinjau dan mengunduh berkas surat permohonan.</li>
                            <li>Tanda tangani surat permohonan fisik lalu unggah scan dokumennya (Status berubah menjadi <strong>Lengkap</strong>).</li>
                            <li>Setelah disetujui Admin (Status <strong>Disetujui, Belum Terverifikasi</strong>), unduh Surat Pemberitahuan dan Surat Pernyataan.</li>
                            <li>Tanda tangani Surat Pernyataan fisik lalu klik <strong>"Unggah Surat Pernyataan"</strong> untuk verifikasi akhir.</li>
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
                                <a href="{{ route('pedagang.unggah_permohonan.create') }}"
                                     class="btn btn-primary btn-sm" wire:navigate>
                                     <i class="fas fa-upload me-1"></i> Unggah Surat Bertandatangan
                                 </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    @if ($permohonans->isEmpty())
                        <div class="text-center py-5">
                            <div class="avatar-lg bg-light rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3 text-muted">
                                <i class="fas fa-file-alt fs-1"></i>
                            </div>
                            <h5 class="fw-bold">Belum Ada Permohonan</h5>
                            <p class="text-muted fs-13 mb-3">Anda belum membuat pengajuan surat permohonan tempat pasar.</p>
                            <a href="{{ route('pedagang.ajukan_permohonan.create') }}" class="btn btn-primary btn-sm" wire:navigate>
                                <i class="fas fa-plus-circle me-1"></i> Ajukan Permohonan Sekarang
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
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Berkas Terunggah</th>
                                        <th class="text-center" style="width: 80px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permohonans as $index => $p)
                                        <tr>
                                             <td class="text-center text-muted fs-13">{{ $index + 1 }}</td>
                                            <td>
                                                <div class="fw-semibold">
                                                    {{ \Carbon\Carbon::parse($p->created_at)->translatedFormat('d F Y') }}
                                                </div>
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
                                                <div class="fs-12 text-muted">Jam:
                                                    {{ $p->jam_buka ? \Carbon\Carbon::parse($p->jam_buka)->format('H:i') : '-' }} -
                                                    {{ $p->jam_tutup ? \Carbon\Carbon::parse($p->jam_tutup)->format('H:i') : '-' }}
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                @if ($p->status === 'draft')
                                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1">
                                                        <i class="fas fa-exclamation-circle me-1"></i> Belum Lengkap
                                                    </span>
                                                @elseif ($p->status === 'lengkap')
                                                    <span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1">
                                                        <i class="fas fa-check-circle me-1"></i> Lengkap (Terkirim)
                                                    </span>
                                                @elseif ($p->status === 'disetujui')
                                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                                        <i class="fas fa-check-circle me-1"></i> Disetujui, Belum Terverifikasi
                                                    </span>
                                                @elseif ($p->status === 'verifikasi')
                                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1">
                                                        <i class="fas fa-clipboard-check me-1"></i> Menunggu Verifikasi
                                                    </span>
                                                @elseif ($p->status === 'selesai')
                                                    <span class="badge bg-success border border-success px-2 py-1 text-white">
                                                        <i class="fas fa-check me-1"></i> Selesai
                                                    </span>
                                                @elseif ($p->status === 'ditolak')
                                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">
                                                        <i class="fas fa-times-circle me-1"></i> Ditolak
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary-subtle text-secondary px-2 py-1">{{ ucfirst($p->status) }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex flex-column gap-1 align-items-center">
                                                    @if ($p->dokumen_path)
                                                        <a href="{{ asset('storage/' . $p->dokumen_path) }}" target="_blank" class="btn btn-sm btn-outline-success py-0 px-2 fs-12">
                                                            <i class="fas fa-file-alt me-1"></i> Surat Permohonan
                                                        </a>
                                                    @endif
                                                    @if ($p->dokumen_path_pernyataan)
                                                        <a href="{{ asset('storage/' . $p->dokumen_path_pernyataan) }}" target="_blank" class="btn btn-sm btn-outline-primary py-0 px-2 fs-12">
                                                            <i class="fas fa-check-circle me-1"></i> Surat Pernyataan
                                                        </a>
                                                    @endif
                                                    @if (!$p->dokumen_path && !$p->dokumen_path_pernyataan)
                                                        <span class="text-muted fs-12 fst-italic">Belum Diunggah</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="dropdown">
                                                    <button type="button" class="btn btn-primary dropdown-toggle btn-sm" aria-expanded="false" title="Menu Aksi">
                                                        <i class="fas fa-ellipsis-h"></i>
                                                    </button>
                                                    <div class="dropdown-menu shadow dropdown-menu-end">
                                                        {{-- Draf Surat Permohonan --}}
                                                        <a class="dropdown-item" href="javascript:void(0)" wire:click="previewSurat({{ $p->id }})">
                                                            <i class="fas fa-file-invoice me-2 text-primary"></i> Pratinjau Draf Surat
                                                        </a>

                                                        {{-- Jika status draft: opsi unggah surat bertandatangan --}}
                                                        @if ($p->status === 'draft')
                                                            <a class="dropdown-item" href="{{ route('pedagang.unggah_permohonan.create', ['id' => $p->id]) }}" wire:navigate>
                                                                <i class="fas fa-upload me-2 text-success"></i> Unggah Surat Permohonan
                                                            </a>
                                                        @endif

                                                        {{-- KETIKA STATUS DISETUJUI, VERIFIKASI, ATAU SELESAI: 3 TOMBOL DOWNLOAD SURAT --}}
                                                        @if (in_array($p->status, ['disetujui', 'verifikasi', 'selesai']))
                                                            <div class="dropdown-divider"></div>
                                                            <h6 class="dropdown-header text-uppercase fs-11 text-muted">Unduh Berkas Surat</h6>
                                                            <a class="dropdown-item text-success" href="{{ route('pedagang.permohonan.download', $p->id) }}" target="_blank">
                                                                <i class="fas fa-download me-2"></i> Download Surat Permohonan
                                                            </a>
                                                            <a class="dropdown-item text-success" href="{{ route('pedagang.permohonan.download-pernyataan', $p->id) }}" target="_blank">
                                                                <i class="fas fa-download me-2"></i> Download Surat Pernyataan
                                                            </a>
                                                            <a class="dropdown-item text-success" href="{{ route('pedagang.permohonan.download-pemberitahuan', $p->id) }}" target="_blank">
                                                                <i class="fas fa-download me-2"></i> Download Surat Pemberitahuan
                                                            </a>
                                                        @endif

                                                        {{-- Jika status disetujui: tombol untuk unggah surat pernyataan --}}
                                                        @if ($p->status === 'disetujui')
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item text-warning fw-bold" href="javascript:void(0)" wire:click="openUploadPernyataanModal({{ $p->id }})">
                                                                <i class="fas fa-upload me-2"></i> Unggah Surat Pernyataan
                                                            </a>
                                                        @endif

                                                        {{-- Jika ditolak: tetap bisa download surat pemberitahuan penolakan --}}
                                                        @if ($p->status === 'ditolak')
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item text-danger" href="{{ route('pedagang.permohonan.download-pemberitahuan', $p->id) }}" target="_blank">
                                                                <i class="fas fa-download me-2"></i> Download Surat Pemberitahuan
                                                            </a>
                                                        @endif
                                                    </div>
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

    <!-- Modal Upload Surat Pernyataan Bertandatangan -->
    <div class="modal fade" id="modalUploadPernyataan" tabindex="-1" aria-labelledby="modalUploadPernyataanTitle" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title m-0" id="modalUploadPernyataanTitle">
                        <i class="fas fa-upload me-1"></i> Unggah Surat Pernyataan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="alert alert-warning border-0 py-2 fs-13 mb-3">
                        <i class="fas fa-info-circle me-1"></i>
                        Pastikan Anda telah mengunduh <strong>Surat Pernyataan</strong>, mencetaknya, membubuhkan meterai dan tanda tangan asli, lalu memindai (scan) berkasnya sebelum diunggah.
                    </div>

                    <div class="mb-3">
                        <label for="signedPernyataan" class="form-label fw-bold">Berkas Surat Pernyataan Bertandatangan : <span class="text-danger">*</span></label>
                        <input type="file" id="signedPernyataan" class="form-control @error('signedPernyataan') is-invalid @enderror" wire:model="signedPernyataan" accept="application/pdf,image/jpeg,image/png,image/jpg">
                        <div class="form-text text-muted fs-12">Format: PDF, JPG, JPEG, atau PNG (Maksimal 5 MB).</div>
                        @error('signedPernyataan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <div wire:loading wire:target="signedPernyataan" class="text-primary mt-2 fs-13">
                            <i class="fas fa-spinner fa-spin me-1"></i> Mengunggah berkas...
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success btn-sm" wire:click="saveUploadPernyataan" wire:loading.attr="disabled">
                        <i class="fas fa-paper-plane me-1"></i> Kirim Surat Pernyataan
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Preview Draf Surat --}}
    <livewire:modal modal-id="modalPreviewDraft" />
</div>
