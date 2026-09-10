<div>
    <!-- start page title -->
    <div class="row mb-2">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Unggah Surat Permohonan</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('pedagang.dashboard') }}" wire:navigate>Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pedagang.permohonan.unggah') }}" wire:navigate>Unggah Surat Permohonan</a></li>
                        <li class="breadcrumb-item active">Formulir Unggah</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-bottom">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-3">
                            <i class="fas fa-upload fs-5"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-0">Formulir Unggah Surat Bertandatangan</h5>
                            <p class="text-muted mb-0 fs-13">Unggah berkas fisik surat permohonan yang telah ditandatangani untuk melengkapi pengajuan Anda.</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    {{-- 1. Ringkasan Permohonan --}}
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center">
                            <span class="badge bg-primary me-2">1</span>
                            <h6 class="mb-0 fw-bold text-dark">Ringkasan Objek Pengajuan</h6>
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm" wire:click="previewSurat">
                            <i class="fas fa-file-invoice me-1"></i> Pratinjau / Cetak Draf Surat
                        </button>
                    </div>

                    <div class="bg-light p-3 rounded mb-4 border">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fs-12 text-muted mb-1">Nama Pemohon</label>
                                <div class="fw-bold fs-14 text-dark">{{ $permohonan->nama ?? '-' }}</div>
                                <small class="text-muted">NIK: {{ $permohonan->nik ?? '-' }}</small>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fs-12 text-muted mb-1">Pasar Tujuan</label>
                                <div class="fw-bold fs-14 text-dark">{{ $permohonan->pasar->nama_pasar ?? '-' }}</div>
                                <small class="text-muted">{{ $permohonan->pasar->alamat_pasar ?? '-' }}</small>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fs-12 text-muted mb-1">Tempat & Unit</label>
                                <div class="fw-bold fs-14 text-dark">
                                    {{ ucfirst($permohonan->tipe_tempat ?? '-') }} Nomor {{ $permohonan->nomor_tempat ?? '-' }}
                                </div>
                                <small class="text-muted">Luas: {{ $permohonan->luas ?? '-' }} m² | {{ $permohonan->lokasi ?? '-' }}</small>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fs-12 text-muted mb-1">Jenis Dagangan</label>
                                <div class="fw-semibold text-dark">{{ $permohonan->jenis_dagangan ?? '-' }}</div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fs-12 text-muted mb-1">Jam Operasional</label>
                                <div class="fw-semibold text-dark">
                                    {{ $permohonan->jam_buka ? \Carbon\Carbon::parse($permohonan->jam_buka)->format('H:i') : '-' }} s.d.
                                    {{ $permohonan->jam_tutup ? \Carbon\Carbon::parse($permohonan->jam_tutup)->format('H:i') : '-' }} WIB
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fs-12 text-muted mb-1">Status Saat Ini</label>
                                <div>
                                    @if (($permohonan->status ?? '') === 'draft')
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1">
                                            <i class="fas fa-exclamation-circle me-1"></i> Belum Lengkap (Draft)
                                        </span>
                                    @elseif (($permohonan->status ?? '') === 'lengkap')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                            <i class="fas fa-check-circle me-1"></i> Lengkap
                                        </span>
                                    @else
                                        <span class="badge bg-info-subtle text-info px-2 py-1">{{ ucfirst($permohonan->status ?? '') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 2. Panduan Pengunggahan --}}
                    <div class="d-flex align-items-center mb-3">
                        <span class="badge bg-primary me-2">2</span>
                        <h6 class="mb-0 fw-bold text-dark">Panduan Pengunggahan Berkas</h6>
                    </div>

                    <div class="alert alert-light border border-info-subtle bg-info-subtle bg-opacity-10 p-3 rounded mb-4">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-info-circle fs-5 text-info me-2 mt-1"></i>
                            <div class="fs-13 text-secondary">
                                <p class="mb-1 fw-bold text-dark">Langkah-langkah sebelum mengunggah:</p>
                                <ul class="mb-0 ps-3">
                                    <li>Cetak lembar draf surat permohonan menggunakan tombol <strong>"Pratinjau / Cetak Draf Surat"</strong> di atas.</li>
                                    <li>Tanda tangani surat secara fisik pada kolom tanda tangan pemohon.</li>
                                    <li>Pindai (scan) atau foto lembar surat yang telah ditandatangani dengan jelas dan pastikan terbaca.</li>
                                    <li>Unggah berkas hasil scan di bawah ini (Format: <strong>PDF, JPG, JPEG, atau PNG</strong>, maksimal <strong>5 MB</strong>).</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- 3. Formulir Unggah --}}
                    <div class="d-flex align-items-center mb-3">
                        <span class="badge bg-primary me-2">3</span>
                        <h6 class="mb-0 fw-bold text-dark">Unggah Dokumen Surat Bertandatangan</h6>
                    </div>

                    <form wire:submit.prevent="formSubmit">
                        <div class="mb-4">
                            <label class="form-label fs-13 fw-semibold">
                                Pilih Berkas Surat Permohonan Bertandatangan <span class="text-danger">*</span>
                            </label>
                            <input type="file" wire:model="signed_document"
                                class="form-control @error('signed_document') is-invalid @enderror"
                                accept=".pdf,.jpg,.jpeg,.png">
                            <div class="form-text fs-12 text-muted">
                                Format yang didukung: PDF, JPG, JPEG, PNG (Ukuran file maksimal: 5MB).
                            </div>
                            @error('signed_document')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            {{-- Indikator upload Livewire --}}
                            <div wire:loading wire:target="signed_document" class="text-primary fs-12 mt-2">
                                <i class="fas fa-spinner fa-spin me-1"></i> Sedang mengunggah berkas, mohon tunggu...
                            </div>
                        </div>

                        @if ($permohonan && $permohonan->dokumen_path)
                            <div class="alert alert-success-subtle border border-success-subtle p-3 rounded mb-4 d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle fs-5 text-success me-2"></i>
                                    <span class="fs-13">Anda sebelumnya sudah mengunggah berkas surat. Mengunggah berkas baru akan mengganti dokumen lama.</span>
                                </div>
                                <a href="{{ asset('storage/' . $permohonan->dokumen_path) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-external-link-alt me-1"></i> Lihat Dokumen Saat Ini
                                </a>
                            </div>
                        @endif

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('pedagang.permohonan.unggah') }}" class="btn btn-secondary" wire:navigate>
                                <i class="fas fa-arrow-left me-1"></i> Batal & Kembali
                            </a>
                            <button type="submit" class="btn btn-primary px-4" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="formSubmit">
                                    <i class="fas fa-upload me-1"></i> Simpan & Unggah Surat
                                </span>
                                <span wire:loading wire:target="formSubmit">
                                    <i class="fas fa-spinner fa-spin me-1"></i> Memproses...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Preview Draf Surat --}}
    <livewire:modal modal-id="modalPreviewDraft" />
</div>
