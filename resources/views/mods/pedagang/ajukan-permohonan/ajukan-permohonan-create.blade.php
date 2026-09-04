<div>
    <!-- start page title -->
    <div class="row mb-2">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Ajukan Permohonan Tempat</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('pedagang.dashboard') }}"
                                wire:navigate>Dashboard</a></li>
                        <li class="breadcrumb-item">Layanan Permohonan</li>
                        <li class="breadcrumb-item active">Ajukan Permohonan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    @if ($hasActivePermohonan)
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info border-0 shadow-sm d-flex align-items-center p-3 mb-4" role="alert">
                    <i class="iconoir-info-circle fs-24 me-3 text-info"></i>
                    <div>
                        <h6 class="alert-heading mb-1 fw-bold">Pengajuan Permohonan Sedang Diproses</h6>
                        <p class="mb-0 fs-13">
                            Anda saat ini memiliki permohonan yang berstatus
                            <span class="badge bg-primary text-uppercase">{{ $activePermohonan->status }}</span>
                            untuk <strong>{{ ucfirst($activePermohonan->tipe_tempat) }}
                                {{ $activePermohonan->nomor_tempat }}</strong>
                            di <strong>{{ $activePermohonan->pasar->nama_pasar ?? '-' }}</strong>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-bottom">
                    <div class="d-flex align-items-center">
                        <div
                            class="avatar-sm bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-3">
                            <i class="iconoir-clipboard-check fs-20"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-0">Formulir Pengajuan Surat Permohonan</h5>
                            <p class="text-muted mb-0 fs-13">Lengkapi data objek dagangan dan unggah berkas persyaratan
                                sesuai ketentuan.</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    {{-- Alert Persyaratan --}}
                    <div
                        class="alert alert-light border border-primary-subtle bg-primary-subtle bg-opacity-10 p-3 rounded mb-4">
                        <h6 class="text-primary fw-bold mb-2">
                            <i class="iconoir-warning-triangle me-1"></i> Perhatian Sebelum Mengajukan:
                        </h6>
                        <p class="mb-2 fs-13 text-muted">Pastikan Anda telah menyiapkan dokumen kelengkapan berikut
                            dalam format PDF / Gambar (JPG/PNG, Maks. 5MB per file):</p>
                        <div class="row fs-13 text-secondary g-2">
                            <div class="col-md-4 col-sm-6"><i class="iconoir-check text-success me-1"></i> Nomor Induk
                                Berusaha (NIB)</div>
                            <div class="col-md-4 col-sm-6"><i class="iconoir-check text-success me-1"></i> Fotokopi NPWP
                            </div>
                            <div class="col-md-4 col-sm-6"><i class="iconoir-check text-success me-1"></i> Fotokopi KTP
                            </div>
                            <div class="col-md-4 col-sm-6"><i class="iconoir-check text-success me-1"></i> Fotokopi
                                Kartu Keluarga (KK)</div>
                            <div class="col-md-4 col-sm-6"><i class="iconoir-check text-success me-1"></i> Pas Foto
                                Berwarna 3x4</div>
                        </div>
                    </div>

                    <form wire:submit.prevent="previewSubmit">
                        {{-- BAGIAN 1: IDENTITAS PEMOHON --}}
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge bg-primary me-2">1</span>
                            <h6 class="mb-0 fw-bold text-dark">Data Identitas Pemohon (Sesuai Pendaftaran)</h6>
                        </div>

                        <div class="bg-light p-3 rounded mb-4 border">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fs-13 text-muted">Nomor Induk Kependudukan (NIK)</label>
                                    <input type="text" class="form-control bg-white" value="{{ $nik }}"
                                        readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fs-13 text-muted">Nama Lengkap</label>
                                    <input type="text" class="form-control bg-white" value="{{ $nama }}"
                                        readonly>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fs-13 text-muted">Tempat Lahir</label>
                                    <input type="text" class="form-control bg-white" value="{{ $tempat_lahir }}"
                                        readonly>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fs-13 text-muted">Tanggal Lahir</label>
                                    <input type="text" class="form-control bg-white" value="{{ $tanggal_lahir }}"
                                        readonly>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fs-13 text-muted">Jenis Kelamin</label>
                                    <input type="text" class="form-control bg-white"
                                        value="{{ $jenis_kelamin === 'L' ? 'Laki-laki' : ($jenis_kelamin === 'P' ? 'Perempuan' : $jenis_kelamin) }}"
                                        readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fs-13 text-muted">Nomor Handphone / WhatsApp</label>
                                    <input type="text" class="form-control bg-white" value="{{ $no_telp }}"
                                        readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fs-13 text-muted">Alamat Domisili</label>
                                    <input type="text" class="form-control bg-white" value="{{ $alamat }}"
                                        readonly>
                                </div>
                            </div>
                        </div>

                        {{-- BAGIAN 2: OBJEK & LOKASI PERMOHONAN --}}
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge bg-primary me-2">2</span>
                            <h6 class="mb-0 fw-bold text-dark">Data Objek & Lokasi Dagangan</h6>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fs-13 fw-semibold">Pilih Pasar <span
                                        class="text-danger">*</span></label>
                                <select wire:model.live="pasar_id"
                                    class="form-select @error('pasar_id') is-invalid @enderror">
                                    <option value="">-- Pilih Pasar Tujuan --</option>
                                    @foreach ($pasars as $pasar)
                                        <option value="{{ $pasar->id }}">{{ $pasar->nama_pasar }}</option>
                                    @endforeach
                                </select>
                                @error('pasar_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fs-13 fw-semibold">Tipe Tempat Dasaran <span
                                        class="text-danger">*</span></label>
                                <select wire:model.live="tipe_tempat"
                                    class="form-select @error('tipe_tempat') is-invalid @enderror"
                                    {{ empty($pasar_id) ? 'disabled' : '' }}>
                                    <option value="">-- Pilih Tipe Tempat --</option>
                                    <option value="kios">Kios</option>
                                    <option value="los">Los</option>
                                    <option value="pelataran">Pelataran</option>
                                </select>
                                @error('tipe_tempat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fs-13 fw-semibold">Pilih Nomor Unit / Tempat <span
                                        class="text-danger">*</span></label>
                                <select wire:model.live="nomor_tempat"
                                    class="form-select @error('nomor_tempat') is-invalid @enderror"
                                    {{ empty($tipe_tempat) ? 'disabled' : '' }}>
                                    <option value="">-- Pilih Unit Tersedia --</option>
                                    @foreach ($units as $u)
                                        @if ($tipe_tempat === 'kios')
                                            <option value="{{ $u->nomor_kios }}">Kios No. {{ $u->nomor_kios }}
                                                ({{ $u->lokasi_kios ?? 'Lantai 1' }}) - {{ $u->ukuran_kios }} m²
                                            </option>
                                        @elseif ($tipe_tempat === 'los')
                                            <option value="{{ $u->nomor_los }}">Los No. {{ $u->nomor_los }}
                                                ({{ $u->lokasi_los ?? 'Zona Pasar' }}) - {{ $u->ukuran_los }} m²
                                            </option>
                                        @elseif ($tipe_tempat === 'pelataran')
                                            <option value="{{ $u->nomor_pelataran }}">Pelataran No.
                                                {{ $u->nomor_pelataran }} ({{ $u->lokasi_pelataran ?? 'Halaman' }}) -
                                                {{ $u->ukuran_pelataran }} m²</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('nomor_tempat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if (!empty($tipe_tempat) && count($units) === 0)
                                    <div class="form-text text-warning"><i class="iconoir-info-circle me-1"></i>Tidak
                                        ada unit {{ $tipe_tempat }} berstatus 'tersedia' di pasar ini.</div>
                                @endif
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fs-13 fw-semibold">Luas Tempat</label>
                                <div class="input-group">
                                    <input type="text" wire:model="luas" class="form-control bg-light"
                                        placeholder="-" readonly>
                                    <span class="input-group-text">m²</span>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fs-13 fw-semibold">Lokasi Unit</label>
                                <input type="text" wire:model="lokasi" class="form-control bg-light"
                                    placeholder="-" readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fs-13 fw-semibold">Jenis Dagangan / Komoditas <span
                                        class="text-danger">*</span></label>
                                <input type="text" wire:model="jenis_dagangan"
                                    class="form-control @error('jenis_dagangan') is-invalid @enderror"
                                    placeholder="Contoh: Sayur-mayur, Pakaian, Sembako, Daging, dll.">
                                @error('jenis_dagangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fs-13 fw-semibold">Jam Buka Operasional <span
                                        class="text-danger">*</span></label>
                                <input type="time" wire:model="jam_buka"
                                    class="form-control @error('jam_buka') is-invalid @enderror">
                                @error('jam_buka')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fs-13 fw-semibold">Jam Tutup Operasional <span
                                        class="text-danger">*</span></label>
                                <input type="time" wire:model="jam_tutup"
                                    class="form-control @error('jam_tutup') is-invalid @enderror">
                                @error('jam_tutup')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- BAGIAN 3: UNGGAH PERSYARATAN --}}
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge bg-primary me-2">3</span>
                            <h6 class="mb-0 fw-bold text-dark">Unggah Dokumen Persyaratan</h6>
                        </div>

                        <div class="row g-3 mb-4">
                            {{-- NIB --}}
                            <div class="col-md-6">
                                <label class="form-label fs-13 fw-semibold">1. Berkas NIB (Nomor Induk Berusaha) <span
                                        class="text-danger">*</span></label>
                                <input type="file" wire:model="nib"
                                    class="form-control @error('nib') is-invalid @enderror"
                                    accept=".pdf,.jpg,.jpeg,.png">
                                <div class="form-text fs-12 text-muted">Format: PDF / JPG / PNG (Maks. 5MB)</div>
                                @error('nib')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div wire:loading wire:target="nib" class="text-primary fs-12 mt-1">
                                    <i class="iconoir-refresh me-1 spin"></i> Mengunggah berkas NIB...
                                </div>
                            </div>

                            {{-- NPWP --}}
                            <div class="col-md-6">
                                <label class="form-label fs-13 fw-semibold">2. Fotokopi NPWP <span
                                        class="text-danger">*</span></label>
                                <input type="file" wire:model="npwp"
                                    class="form-control @error('npwp') is-invalid @enderror"
                                    accept=".pdf,.jpg,.jpeg,.png">
                                <div class="form-text fs-12 text-muted">Format: PDF / JPG / PNG (Maks. 5MB)</div>
                                @error('npwp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div wire:loading wire:target="npwp" class="text-primary fs-12 mt-1">
                                    <i class="iconoir-refresh me-1 spin"></i> Mengunggah berkas NPWP...
                                </div>
                            </div>

                            {{-- KTP --}}
                            <div class="col-md-4">
                                <label class="form-label fs-13 fw-semibold">3. Fotokopi KTP <span
                                        class="text-danger">*</span></label>
                                <input type="file" wire:model="ktp"
                                    class="form-control @error('ktp') is-invalid @enderror"
                                    accept=".pdf,.jpg,.jpeg,.png">
                                <div class="form-text fs-12 text-muted">Format: PDF / JPG / PNG (Maks. 5MB)</div>
                                @error('ktp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div wire:loading wire:target="ktp" class="text-primary fs-12 mt-1">
                                    <i class="iconoir-refresh me-1 spin"></i> Mengunggah KTP...
                                </div>
                            </div>

                            {{-- KK --}}
                            <div class="col-md-4">
                                <label class="form-label fs-13 fw-semibold">4. Fotokopi Kartu Keluarga (KK) <span
                                        class="text-danger">*</span></label>
                                <input type="file" wire:model="kk"
                                    class="form-control @error('kk') is-invalid @enderror"
                                    accept=".pdf,.jpg,.jpeg,.png">
                                <div class="form-text fs-12 text-muted">Format: PDF / JPG / PNG (Maks. 5MB)</div>
                                @error('kk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div wire:loading wire:target="kk" class="text-primary fs-12 mt-1">
                                    <i class="iconoir-refresh me-1 spin"></i> Mengunggah KK...
                                </div>
                            </div>

                            {{-- Pas Foto --}}
                            <div class="col-md-4">
                                <label class="form-label fs-13 fw-semibold">5. Pas Foto Berwarna 3x4 <span
                                        class="text-danger">*</span></label>
                                <input type="file" wire:model="foto"
                                    class="form-control @error('foto') is-invalid @enderror"
                                    accept=".pdf,.jpg,.jpeg,.png">
                                <div class="form-text fs-12 text-muted">Format: PDF / JPG / PNG (Maks. 5MB)</div>
                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div wire:loading wire:target="foto" class="text-primary fs-12 mt-1">
                                    <i class="iconoir-refresh me-1 spin"></i> Mengunggah Pas Foto...
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- TOMBOL SUBMIT / PREVIEW --}}
                        <div class="d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-primary px-4" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="previewSubmit">
                                    <i class="iconoir-page-search me-1"></i> Buat Permohonan & Preview Surat
                                </span>
                                <span wire:loading wire:target="previewSubmit">
                                    <i class="iconoir-refresh me-1 spin"></i> Memeriksa Data...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Universal Modal Component for Preview & Confirmation --}}
    <livewire:modal />
</div>
