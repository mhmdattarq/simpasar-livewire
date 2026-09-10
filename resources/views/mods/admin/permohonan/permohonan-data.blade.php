<div>
    <!-- start page title -->
    <div class="row mb-2">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Data Permohonan Pedagang</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" wire:navigate>Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">Master Data Pedagang</li>
                        <li class="breadcrumb-item active">Data Permohonan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-bottom">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <h4 class="card-title mb-0">Manajemen Pengajuan Permohonan Pedagang</h4>
                            <p class="text-muted mb-0 fs-13">Review berkas persyaratan, persetujuan tempat, dan
                                verifikasi akhir pedagang pasar.</p>
                        </div>
                    </div>
                </div>

                <div class="card-body" wire:ignore>
                    <div class="table-responsive">
                        <table id="tablePermohonan" class="table table-bordered table-striped w-100 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 40px" class="text-center">No</th>
                                    <th style="width: 110px">Tanggal</th>
                                    <th>Nama Pemohon</th>
                                    <th>Pasar & Objek Unit</th>
                                    <th class="text-center" style="width: 140px">Status</th>
                                    <th>Keterangan</th>
                                    <th class="text-center" style="width: 150px">Aksi</th>
                                </tr>
                            </thead>
                            <thead id="header-filter">
                                <tr>
                                    <th class="text-center"></th>
                                    <th class="text-center"></th>
                                    <th class="text-center">
                                        <input type="text" class="form-control form-control-sm search-col-dt"
                                            placeholder="Cari Nama / NIK">
                                    </th>
                                    <th class="text-center">
                                        <input type="text" class="form-control form-control-sm search-col-dt"
                                            placeholder="Cari Pasar / Unit">
                                    </th>
                                    <th class="text-center"></th>
                                    <th class="text-center"></th>
                                    <th class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Review Permohonan & Berkas Persyaratan -->
    <div class="modal fade" id="modalReviewPermohonan" tabindex="-1" aria-labelledby="modalReviewPermohonanTitle"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-fullscreen-lg-down modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title m-0" id="modalReviewPermohonanTitle">
                        <i class="fas fa-file-alt me-2"></i> Review Berkas Permohonan:
                        {{ $selectedPermohonan->nama ?? '-' }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body p-3">
                    @if ($selectedPermohonan)
                        <div class="row g-3">
                            <!-- Sisi Kiri: Viewer Berkas Aktif -->
                            <div class="col-lg-7">
                                <div class="card h-100 border">
                                    <div
                                        class="card-header bg-light d-flex align-items-center justify-content-between py-2">
                                        <div class="fw-semibold text-dark fs-14">
                                            <i class="fas fa-eye me-1 text-primary"></i> Pratinjau:
                                            {{ $activeDocTitle }}
                                        </div>
                                        @if ($activeDocUrl)
                                            <a href="{{ $activeDocUrl }}" target="_blank"
                                                class="btn btn-outline-primary btn-sm py-1">
                                                <i class="fas fa-external-link-alt me-1"></i> Buka Penuh
                                            </a>
                                        @endif
                                    </div>
                                    <div class="card-body p-2 d-flex flex-column align-items-center justify-content-center bg-secondary-subtle"
                                        style="min-height: 520px;">
                                        @if ($activeDocUrl)
                                            @php
                                                $ext = strtolower(pathinfo($activeDocUrl, PATHINFO_EXTENSION));
                                            @endphp
                                            @if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp']))
                                                <img src="{{ $activeDocUrl }}" alt="Preview Berkas"
                                                    class="img-fluid rounded shadow-sm"
                                                    style="max-height: 520px; object-fit: contain;">
                                            @else
                                                <iframe src="{{ $activeDocUrl }}" width="100%" height="520px"
                                                    style="border: none; border-radius: 4px;"
                                                    class="shadow-sm"></iframe>
                                            @endif
                                        @else
                                            <div class="text-center text-muted p-5">
                                                <i class="fas fa-file-excel fs-1 mb-2"></i>
                                                <h6>Berkas Belum Diunggah</h6>
                                                <p class="fs-13 mb-0">Pemohon belum mengunggah dokumen ini.</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Sisi Kanan: Detail & Daftar Dokumen Pendukung -->
                            <div class="col-lg-5">
                                <div class="card border mb-3">
                                    <div class="card-header bg-light py-2">
                                        <h6 class="mb-0 fs-14 fw-bold"><i class="fas fa-user me-1 text-primary"></i>
                                            Informasi Pemohon & Tempat</h6>
                                    </div>
                                    <div class="card-body p-3 fs-13">
                                        <table class="table table-sm table-borderless mb-0">
                                            <tr>
                                                <td style="width: 110px;" class="text-muted">NIK</td>
                                                <td style="width: 10px;">:</td>
                                                <td class="fw-semibold">{{ $selectedPermohonan->nik }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Nama Lengkap</td>
                                                <td>:</td>
                                                <td class="fw-bold">{{ $selectedPermohonan->nama }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Pasar</td>
                                                <td>:</td>
                                                <td class="fw-semibold">
                                                    {{ $selectedPermohonan->pasar?->nama_pasar ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Tempat / Objek</td>
                                                <td>:</td>
                                                <td>
                                                    <span class="badge bg-primary-subtle text-primary">
                                                        {{ ucfirst($selectedPermohonan->tipe_tempat) }} No.
                                                        {{ $selectedPermohonan->nomor_tempat }}
                                                    </span>
                                                    @if ($selectedPermohonan->lokasi)
                                                        <small
                                                            class="text-muted">({{ $selectedPermohonan->lokasi }})</small>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Komoditas</td>
                                                <td>:</td>
                                                <td>{{ $selectedPermohonan->jenis_dagangan ?? '-' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="card border">
                                    <div class="card-header bg-light py-2">
                                        <h6 class="mb-0 fs-14 fw-bold"><i
                                                class="fas fa-folder me-1 text-primary"></i> Berkas Dokumen
                                            Persyaratan</h6>
                                    </div>
                                    <div class="list-group list-group-flush fs-13">
                                        @foreach ($reviewBerkas as $key => $doc)
                                            <div
                                                class="list-group-item d-flex align-items-center justify-content-between p-2 {{ $activeDocTitle === $doc['label'] ? 'bg-primary-subtle' : '' }}">
                                                <div>
                                                    <div class="fw-semibold">{{ $doc['label'] }}</div>
                                                    @if ($doc['url'])
                                                        <span
                                                            class="badge bg-success-subtle text-success fs-11">Tersedia</span>
                                                    @else
                                                        <span class="badge bg-danger-subtle text-danger fs-11">Belum
                                                             Ada</span>
                                                    @endif
                                                </div>
                                                @if ($doc['url'])
                                                    <button type="button" class="btn btn-sm btn-primary py-1 px-2"
                                                        wire:click="selectPreviewDoc('{{ $key }}')">
                                                        <i class="fas fa-eye me-1"></i> Lihat
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-sm btn-secondary py-1 px-2"
                                                        disabled>
                                                        -
                                                    </button>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Persetujuan Permohonan -->
    <div class="modal fade" id="modalApprovePermohonan" tabindex="-1" aria-labelledby="modalApproveTitle"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title m-0" id="modalApproveTitle">
                        <i class="fas fa-check-circle me-1 text-success"></i> Keputusan Persetujuan:
                        {{ $approveNama }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Keputusan Permohonan :</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="approveStatus"
                                    id="statusApproved" value="approved" wire:model.live="approveStatus">
                                <label class="form-check-label fw-semibold text-success" for="statusApproved">
                                    <i class="fas fa-check me-1"></i> DIKABULKAN
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="approveStatus"
                                    id="statusRejected" value="rejected" wire:model.live="approveStatus">
                                <label class="form-check-label fw-semibold text-danger" for="statusRejected">
                                    <i class="fas fa-times me-1"></i> TIDAK DIKABULKAN
                                </label>
                            </div>
                        </div>
                    </div>

                    @if ($approveStatus === 'rejected')
                        <div class="mb-3">
                            <label class="form-label fw-bold">Alasan Penolakan : <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control @error('rejectReason') is-invalid @enderror" rows="3"
                                placeholder="Masukkan alasan kenapa permohonan ini ditolak..." wire:model="rejectReason"></textarea>
                            @error('rejectReason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    @else
                        <div class="alert alert-success border-0 py-2 fs-13 mb-0">
                            <i class="fas fa-info-circle me-1"></i> Jika dikabulkan, status permohonan akan menjadi
                            <strong>"Disetujui, Belum Terverifikasi"</strong> dan pedagang dapat mengunduh surat
                            pemberitahuan & pernyataan.
                        </div>
                    @endif
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="button"
                        class="btn {{ $approveStatus === 'approved' ? 'btn-success' : 'btn-danger' }} btn-sm"
                        wire:click="saveApprove">
                        <i class="fas fa-save me-1"></i> Simpan Keputusan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Verifikasi Universal -->
    <livewire:modal modal-id="modalVerifyPermohonan" />

    {{-- Script Datatables & Action Handler --}}
    @include('mods.admin.permohonan.atc.permohonan-data-atc')
</div>
