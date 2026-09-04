<div>
    <div class="col-12 col-md-10 col-lg-8 col-xl-7 mx-auto">
        <div class="card shadow-sm border-0">
            <div class="card-body p-0 bg-black auth-header-box rounded-top">
                <div class="text-center p-3">
                    <h4 class="mt-2 mb-1 fw-bold text-white fs-20">SIM PASAR</h4>
                    <p class="text-white-50 fw-medium mb-0 fs-13">Pendaftaran Akun Pedagang Baru</p>
                </div>
            </div>
            <div class="card-body pt-3 pb-4">
                {{-- Alert Info Petunjuk Pendaftaran --}}
                <div class="alert alert-primary mb-3 py-2 px-3 fs-13" role="alert">
                    <div class="d-flex align-items-center mb-1">
                        <i class="iconoir-info-circle me-2 fs-16 text-primary"></i>
                        <span class="fw-semibold">Petunjuk Pendaftaran Pedagang:</span>
                    </div>
                    <ul class="mb-0 ps-3 text-muted" style="font-size: 12.5px;">
                        <li>Lengkapi data diri Anda sesuai identitas resmi KTP.</li>
                        <li><strong>NIK</strong> akan digunakan sebagai identitas utama untuk masuk ke aplikasi.</li>
                        <li>Pastikan nomor handphone aktif dan simpan password Anda dengan baik.</li>
                    </ul>
                </div>

                {{-- Alert Error Umum Jika Registrasi Gagal --}}
                @if ($errorMessage)
                    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                        <i class="iconoir-warning-circle me-1 align-middle fs-16"></i>
                        {{ $errorMessage }}
                    </div>
                @endif

                {{-- Form Registrasi Livewire --}}
                <form wire:submit="registerSubmit">
                    <div class="row">
                        {{-- Kolom Kiri --}}
                        <div class="col-md-6">
                            {{-- NIK --}}
                            <div class="mb-3">
                                <label for="nik" class="form-label fs-13">
                                    NIK (Nomor KTP) <span class="text-danger">*</span>
                                </label>
                                <input type="text" id="nik" maxlength="16"
                                    class="form-control @error('nik') is-invalid @enderror"
                                    placeholder="Masukkan 16 digit NIK..." wire:model="nik" autofocus>
                                @error('nik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Nama Lengkap --}}
                            <div class="mb-3">
                                <label for="nama" class="form-label fs-13">
                                    Nama Lengkap <span class="text-danger">*</span>
                                </label>
                                <input type="text" id="nama"
                                    class="form-control @error('nama') is-invalid @enderror"
                                    placeholder="Masukkan nama lengkap..." wire:model="nama">
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tempat Lahir --}}
                            <div class="mb-3">
                                <label for="tempat_lahir" class="form-label fs-13">
                                    Tempat Lahir <span class="text-danger">*</span>
                                </label>
                                <input type="text" id="tempat_lahir"
                                    class="form-control @error('tempat_lahir') is-invalid @enderror"
                                    placeholder="Contoh: Dumai..." wire:model="tempat_lahir">
                                @error('tempat_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tanggal Lahir --}}
                            <div class="mb-3">
                                <label for="tanggal_lahir" class="form-label fs-13">
                                    Tanggal Lahir <span class="text-danger">*</span>
                                </label>
                                <input type="date" id="tanggal_lahir"
                                    class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                    wire:model="tanggal_lahir">
                                @error('tanggal_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Kolom Kanan --}}
                        <div class="col-md-6">
                            {{-- Jenis Kelamin --}}
                            <div class="mb-3">
                                <label for="jenis_kelamin" class="form-label fs-13">
                                    Jenis Kelamin <span class="text-danger">*</span>
                                </label>
                                <select id="jenis_kelamin"
                                    class="form-select @error('jenis_kelamin') is-invalid @enderror"
                                    wire:model="jenis_kelamin">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L">Laki-Laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Nomor Handphone --}}
                            <div class="mb-3">
                                <label for="no_telp" class="form-label fs-13">
                                    Nomor Handphone / WA <span class="text-danger">*</span>
                                </label>
                                <input type="text" id="no_telp"
                                    class="form-control @error('no_telp') is-invalid @enderror"
                                    placeholder="Contoh: 081234567890..." wire:model="no_telp">
                                @error('no_telp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="mb-3">
                                <label for="password" class="form-label fs-13">
                                    Password <span class="text-danger">*</span>
                                </label>
                                <input type="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Minimal 6 karakter..." wire:model="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Konfirmasi Password --}}
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label fs-13">
                                    Konfirmasi Password <span class="text-danger">*</span>
                                </label>
                                <input type="password" id="password_confirmation"
                                    class="form-control"
                                    placeholder="Ulangi password..." wire:model="password_confirmation">
                            </div>
                        </div>

                        {{-- Baris Penuh: Alamat Lengkap --}}
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="alamat" class="form-label fs-13">
                                    Alamat Lengkap <span class="text-danger">*</span>
                                </label>
                                <textarea id="alamat" rows="2"
                                    class="form-control @error('alamat') is-invalid @enderror"
                                    placeholder="Masukkan alamat lengkap sesuai KTP..." wire:model="alamat"></textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Tombol Submit --}}
                        <div class="col-12">
                            <div class="d-grid mt-2">
                                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                    <span wire:loading.remove>
                                        <i class="iconoir-user-badge-check me-1 align-middle fs-16"></i> Daftar Akun Pedagang
                                    </span>
                                    <span wire:loading>
                                        <span class="spinner-border spinner-border-sm me-1" role="status"></span>
                                        Mendaftarkan akun...
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="text-center mt-3 pt-2 border-top">
                    <p class="text-muted mb-0 fs-13">
                        Sudah memiliki akun?
                        <a href="{{ route('login') }}" class="text-primary fw-semibold" wire:navigate>Masuk ke Akun</a>
                    </p>
                </div>
            </div><!--end card-body-->
        </div><!--end card-->
    </div>
</div>
