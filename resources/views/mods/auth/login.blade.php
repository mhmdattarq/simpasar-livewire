<div>
    <div class="card">
        <div class="card-body p-0 bg-black auth-header-box rounded-top">
            <div class="text-center p-3">
                <h4 class="mt-2 mb-1 fw-bold text-white fs-20">SIM PASAR</h4>
                <p class="text-white-50 fw-medium mb-0 fs-13">Sistem Informasi Manajemen Pasar</p>
            </div>
        </div>
        <div class="card-body pt-0">
            {{-- Alert Error Jika Login Gagal --}}
            @if ($errorMessage)
                <div class="alert alert-danger alert-dismissible fade show mt-3 mb-0" role="alert">
                    <i class="iconoir-warning-circle me-1 align-middle"></i>
                    {{ $errorMessage }}
                </div>
            @endif
            {{-- Form Livewire --}}
            <form class="my-4" wire:submit="authenticate">
                <div class="form-group mb-3">
                    <label class="form-label" for="identifier">Username / NIK</label>
                    <input type="text" class="form-control @error('identifier') is-invalid @enderror" id="identifier"
                        wire:model="identifier" placeholder="Admin: username | Pedagang: NIK" autofocus>
                    @error('identifier')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label class="form-label" for="userpassword">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                        id="userpassword" wire:model="password" placeholder="Masukkan password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group row mt-3">
                    <div class="col-sm-12">
                        <div class="form-check form-switch form-switch-success">
                            <input class="form-check-input" type="checkbox" id="remember" wire:model="remember">
                            <label class="form-check-label" for="remember">Ingat Saya</label>
                        </div>
                    </div>
                </div>
                <div class="form-group mb-0 row">
                    <div class="col-12">
                        <div class="d-grid mt-3">
                            <button class="btn btn-primary" type="submit" wire:loading.attr="disabled">
                                <span wire:loading.remove>Masuk ke Akun <i class="fas fa-sign-in-alt ms-1"></i></span>
                                <span wire:loading>
                                    <span class="spinner-border spinner-border-sm me-1" role="status"></span>
                                    Memproses...
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div><!--end card-body-->
    </div><!--end card-->
</div>
