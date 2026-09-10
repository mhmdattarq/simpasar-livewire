<div>
    <!-- Header Welcome Card -->
    <div class="row">
        <div class="col-12">
            <div class="card bg-primary text-white mb-4 shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <h3 class="fw-bold mb-1">Selamat Datang, {{ auth()->user()->name ?? 'Administrator' }}! 👋</h3>
                            <p class="mb-0 opacity-75 fs-14">
                                Anda login sebagai <strong>Administrator SIM Pasar</strong>. Pantau ketersediaan unit usaha dan kelola data operasional pasar Kota Dumai melalui dashboard ini.
                            </p>
                        </div>
                        <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                            <span class="badge bg-white text-primary px-3 py-2 fs-13 fw-semibold shadow-sm">
                                <i class="fas fa-calendar-alt me-1"></i> {{ now()->locale('id')->translatedFormat('l, d F Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Akses Cepat Modul Sidebar -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 class="fw-bold text-dark mb-0">
                    <i class="fas fa-th-large text-primary me-2"></i>Akses Cepat Modul
                </h5>
                <span class="text-muted fs-13">Pintas langsung ke master data & pengelolaan</span>
            </div>
            <div class="row g-3">
                <!-- Modul Pasar -->
                <div class="col-sm-6 col-md-4 col-lg">
                    <a href="{{ route('admin.pasar.data') }}" wire:navigate class="card text-decoration-none h-100 shadow-sm border hover-elevate transition-all">
                        <div class="card-body p-3 text-center">
                            <div class="d-inline-flex justify-content-center align-items-center thumb-md bg-light rounded-circle mb-2">
                                <i class="fas fa-store fs-4 text-primary"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-1 fs-14">Data Pasar</h6>
                            <p class="text-muted fs-12 mb-0">{{ $totalPasar }} Pasar Terdaftar</p>
                        </div>
                    </a>
                </div>

                <!-- Modul Kios -->
                <div class="col-sm-6 col-md-4 col-lg">
                    <a href="{{ route('admin.kios.data') }}" wire:navigate class="card text-decoration-none h-100 shadow-sm border hover-elevate transition-all">
                        <div class="card-body p-3 text-center">
                            <div class="d-inline-flex justify-content-center align-items-center thumb-md bg-light rounded-circle mb-2">
                                <i class="fas fa-store-alt fs-4 text-success"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-1 fs-14">Data Kios</h6>
                            <p class="text-muted fs-12 mb-0">{{ $kios['total'] }} Unit Kios</p>
                        </div>
                    </a>
                </div>

                <!-- Modul Los -->
                <div class="col-sm-6 col-md-4 col-lg">
                    <a href="{{ route('admin.los.data') }}" wire:navigate class="card text-decoration-none h-100 shadow-sm border hover-elevate transition-all">
                        <div class="card-body p-3 text-center">
                            <div class="d-inline-flex justify-content-center align-items-center thumb-md bg-light rounded-circle mb-2">
                                <i class="fas fa-table fs-4 text-warning"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-1 fs-14">Data Los</h6>
                            <p class="text-muted fs-12 mb-0">{{ $los['total'] }} Unit Los</p>
                        </div>
                    </a>
                </div>

                <!-- Modul Pelataran -->
                <div class="col-sm-6 col-md-4 col-lg">
                    <a href="{{ route('admin.pelataran.data') }}" wire:navigate class="card text-decoration-none h-100 shadow-sm border hover-elevate transition-all">
                        <div class="card-body p-3 text-center">
                            <div class="d-inline-flex justify-content-center align-items-center thumb-md bg-light rounded-circle mb-2">
                                <i class="fas fa-umbrella fs-4 text-info"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-1 fs-14">Data Pelataran</h6>
                            <p class="text-muted fs-12 mb-0">{{ $pelataran['total'] }} Lapak Pelataran</p>
                        </div>
                    </a>
                </div>

                <!-- Modul Permohonan -->
                <div class="col-sm-6 col-md-4 col-lg">
                    <a href="{{ route('admin.permohonan.data') }}" wire:navigate class="card text-decoration-none h-100 shadow-sm border hover-elevate transition-all">
                        <div class="card-body p-3 text-center position-relative">
                            @if ($permohonanPerluReview > 0 || $permohonanPerluVerifikasi > 0)
                                <span class="position-absolute top-0 end-0 translate-middle-y badge rounded-pill bg-danger me-2 mt-2" title="Perlu Tindakan">
                                    {{ $permohonanPerluReview + $permohonanPerluVerifikasi }}
                                </span>
                            @endif
                            <div class="d-inline-flex justify-content-center align-items-center thumb-md bg-light rounded-circle mb-2">
                                <i class="fas fa-clipboard-check fs-4 text-danger"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-1 fs-14">Data Permohonan</h6>
                            <p class="text-muted fs-12 mb-0">{{ $totalPermohonan }} Pengajuan</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Ringkasan Statistik Utama -->
    <div class="row g-3 mb-4">
        <!-- 1. Total Pasar -->
        <div class="col-sm-6 col-xl-3">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <div class="row d-flex justify-content-center border-dashed-bottom pb-3">
                        <div class="col-9">
                            <p class="text-muted mb-0 fw-semibold fs-13 text-uppercase">Total Pasar</p>
                            <h3 class="mt-2 mb-0 fw-bold text-dark">{{ $totalPasar }} <span class="fs-14 fw-normal text-muted">Pasar</span></h3>
                        </div>
                        <div class="col-3 align-self-center text-end">
                            <div class="d-inline-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle">
                                <i class="fas fa-store fs-2 text-success"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mb-0 text-truncate text-muted mt-3 fs-13">
                        <span class="text-success fw-semibold"><i class="fas fa-check-circle me-1"></i>Aktif</span> Beroperasi di Kota Dumai
                    </p>
                </div>
            </div>
        </div>

        <!-- 2. Total Pedagang -->
        <div class="col-sm-6 col-xl-3">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <div class="row d-flex justify-content-center border-dashed-bottom pb-3">
                        <div class="col-9">
                            <p class="text-muted mb-0 fw-semibold fs-13 text-uppercase">Total Pedagang</p>
                            <h3 class="mt-2 mb-0 fw-bold text-dark">{{ $totalPedagang }} <span class="fs-14 fw-normal text-muted">Orang</span></h3>
                        </div>
                        <div class="col-3 align-self-center text-end">
                            <div class="d-inline-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle">
                                <i class="fas fa-users fs-2 text-info"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mb-0 text-truncate text-muted mt-3 fs-13">
                        <span class="text-info fw-semibold"><i class="fas fa-id-card me-1"></i>Terdaftar</span> Akun di Sistem
                    </p>
                </div>
            </div>
        </div>

        <!-- 3. Total Keseluruhan Tempat Usaha -->
        <div class="col-sm-6 col-xl-3">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <div class="row d-flex justify-content-center border-dashed-bottom pb-3">
                        <div class="col-9">
                            <p class="text-muted mb-0 fw-semibold fs-13 text-uppercase">Tempat Usaha</p>
                            <h3 class="mt-2 mb-0 fw-bold text-dark">{{ number_format($totalTempat, 0, ',', '.') }} <span class="fs-14 fw-normal text-muted">Unit</span></h3>
                        </div>
                        <div class="col-3 align-self-center text-end">
                            <div class="d-inline-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle">
                                <i class="fas fa-cubes fs-2 text-warning"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mb-0 text-truncate text-muted mt-3 fs-13">
                        <span class="text-primary fw-semibold"><i class="fas fa-door-closed me-1"></i>{{ $totalTerisi }} Terisi</span> ({{ $totalTempat > 0 ? round(($totalTerisi / $totalTempat) * 100) : 0 }}% Keterisian)
                    </p>
                </div>
            </div>
        </div>

        <!-- 4. Total Permohonan -->
        <div class="col-sm-6 col-xl-3">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <div class="row d-flex justify-content-center border-dashed-bottom pb-3">
                        <div class="col-9">
                            <p class="text-muted mb-0 fw-semibold fs-13 text-uppercase">Permohonan</p>
                            <h3 class="mt-2 mb-0 fw-bold text-dark">{{ $totalPermohonan }} <span class="fs-14 fw-normal text-muted">Berkas</span></h3>
                        </div>
                        <div class="col-3 align-self-center text-end">
                            <div class="d-inline-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle">
                                <i class="fas fa-clipboard-list fs-2 text-danger"></i>
                            </div>
                        </div>
                    </div>
                    @if ($permohonanPerluReview > 0 || $permohonanPerluVerifikasi > 0)
                        <p class="mb-0 text-truncate text-muted mt-3 fs-13">
                            <span class="text-danger fw-semibold"><i class="fas fa-clock me-1"></i>{{ $permohonanPerluReview + $permohonanPerluVerifikasi }} Berkas</span> Perlu Tindakan
                        </p>
                    @else
                        <p class="mb-0 text-truncate text-muted mt-3 fs-13">
                            <span class="text-success fw-semibold"><i class="fas fa-check-circle me-1"></i>Semua</span> Berkas Terproses
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Rincian Ketersediaan Tempat Usaha: Kios, Los, dan Pelataran -->
    <div class="row mb-2">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 class="fw-bold text-dark mb-0">
                    <i class="fas fa-chart-pie text-primary me-2"></i>Status Ketersediaan Tempat Usaha
                </h5>
                <span class="text-muted fs-13">Monitoring unit Terisi, Sedang Pengajuan, dan Kosong (Tersedia)</span>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <!-- 1. KARTU DATA KIOS -->
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-bottom py-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="thumb-md bg-light rounded-circle d-flex align-items-center justify-content-center me-2">
                                <i class="fas fa-store-alt text-success fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0 text-dark">Data Kios</h6>
                                <small class="text-muted">Total: <strong>{{ $kios['total'] }}</strong> Unit Kios</small>
                            </div>
                        </div>
                        <span class="badge bg-success-subtle text-success fs-12 px-2 py-1">
                            {{ $kios['persen_terisi'] }}% Terisi
                        </span>
                    </div>
                </div>
                <div class="card-body p-3">
                    <!-- Progress Bar -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between fs-12 text-muted mb-1">
                            <span>Tingkat Keterisian</span>
                            <span>{{ $kios['terisi'] }} / {{ $kios['total'] }} Unit</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $kios['persen_terisi'] }}%" aria-valuenow="{{ $kios['persen_terisi'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <!-- 3 Kotak Status -->
                    <div class="row g-2 text-center">
                        <div class="col-4">
                            <div class="border rounded p-2 bg-light">
                                <i class="fas fa-check-circle text-success fs-5 mb-1 d-block"></i>
                                <span class="d-block fs-11 text-muted fw-semibold">TERISI</span>
                                <h5 class="fw-bold text-success mb-0">{{ $kios['terisi'] }}</h5>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="border rounded p-2 bg-light">
                                <i class="fas fa-hourglass-half text-warning fs-5 mb-1 d-block"></i>
                                <span class="d-block fs-11 text-muted fw-semibold">PENGAJUAN</span>
                                <h5 class="fw-bold text-warning mb-0">{{ $kios['pengajuan'] }}</h5>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="border rounded p-2 bg-light">
                                <i class="fas fa-door-open text-primary fs-5 mb-1 d-block"></i>
                                <span class="d-block fs-11 text-muted fw-semibold">KOSONG</span>
                                <h5 class="fw-bold text-primary mb-0">{{ $kios['kosong'] }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top py-2 text-center">
                    <a href="{{ route('admin.kios.data') }}" wire:navigate class="btn btn-sm btn-outline-success w-100">
                        <i class="fas fa-external-link-alt me-1"></i> Kelola Data Kios
                    </a>
                </div>
            </div>
        </div>

        <!-- 2. KARTU DATA LOS -->
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-bottom py-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="thumb-md bg-light rounded-circle d-flex align-items-center justify-content-center me-2">
                                <i class="fas fa-table text-warning fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0 text-dark">Data Los</h6>
                                <small class="text-muted">Total: <strong>{{ $los['total'] }}</strong> Unit Los</small>
                            </div>
                        </div>
                        <span class="badge bg-warning-subtle text-warning fs-12 px-2 py-1">
                            {{ $los['persen_terisi'] }}% Terisi
                        </span>
                    </div>
                </div>
                <div class="card-body p-3">
                    <!-- Progress Bar -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between fs-12 text-muted mb-1">
                            <span>Tingkat Keterisian</span>
                            <span>{{ $los['terisi'] }} / {{ $los['total'] }} Unit</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $los['persen_terisi'] }}%" aria-valuenow="{{ $los['persen_terisi'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <!-- 3 Kotak Status -->
                    <div class="row g-2 text-center">
                        <div class="col-4">
                            <div class="border rounded p-2 bg-light">
                                <i class="fas fa-check-circle text-success fs-5 mb-1 d-block"></i>
                                <span class="d-block fs-11 text-muted fw-semibold">TERISI</span>
                                <h5 class="fw-bold text-success mb-0">{{ $los['terisi'] }}</h5>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="border rounded p-2 bg-light">
                                <i class="fas fa-hourglass-half text-warning fs-5 mb-1 d-block"></i>
                                <span class="d-block fs-11 text-muted fw-semibold">PENGAJUAN</span>
                                <h5 class="fw-bold text-warning mb-0">{{ $los['pengajuan'] }}</h5>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="border rounded p-2 bg-light">
                                <i class="fas fa-door-open text-primary fs-5 mb-1 d-block"></i>
                                <span class="d-block fs-11 text-muted fw-semibold">KOSONG</span>
                                <h5 class="fw-bold text-primary mb-0">{{ $los['kosong'] }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top py-2 text-center">
                    <a href="{{ route('admin.los.data') }}" wire:navigate class="btn btn-sm btn-outline-warning w-100">
                        <i class="fas fa-external-link-alt me-1"></i> Kelola Data Los
                    </a>
                </div>
            </div>
        </div>

        <!-- 3. KARTU DATA PELATARAN -->
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-bottom py-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="thumb-md bg-light rounded-circle d-flex align-items-center justify-content-center me-2">
                                <i class="fas fa-umbrella text-info fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0 text-dark">Data Pelataran</h6>
                                <small class="text-muted">Total: <strong>{{ $pelataran['total'] }}</strong> Lapak</small>
                            </div>
                        </div>
                        <span class="badge bg-info-subtle text-info fs-12 px-2 py-1">
                            {{ $pelataran['persen_terisi'] }}% Terisi
                        </span>
                    </div>
                </div>
                <div class="card-body p-3">
                    <!-- Progress Bar -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between fs-12 text-muted mb-1">
                            <span>Tingkat Keterisian</span>
                            <span>{{ $pelataran['terisi'] }} / {{ $pelataran['total'] }} Lapak</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-info" role="progressbar" style="width: {{ $pelataran['persen_terisi'] }}%" aria-valuenow="{{ $pelataran['persen_terisi'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <!-- 3 Kotak Status -->
                    <div class="row g-2 text-center">
                        <div class="col-4">
                            <div class="border rounded p-2 bg-light">
                                <i class="fas fa-check-circle text-success fs-5 mb-1 d-block"></i>
                                <span class="d-block fs-11 text-muted fw-semibold">TERISI</span>
                                <h5 class="fw-bold text-success mb-0">{{ $pelataran['terisi'] }}</h5>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="border rounded p-2 bg-light">
                                <i class="fas fa-hourglass-half text-warning fs-5 mb-1 d-block"></i>
                                <span class="d-block fs-11 text-muted fw-semibold">PENGAJUAN</span>
                                <h5 class="fw-bold text-warning mb-0">{{ $pelataran['pengajuan'] }}</h5>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="border rounded p-2 bg-light">
                                <i class="fas fa-door-open text-primary fs-5 mb-1 d-block"></i>
                                <span class="d-block fs-11 text-muted fw-semibold">KOSONG</span>
                                <h5 class="fw-bold text-primary mb-0">{{ $pelataran['kosong'] }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top py-2 text-center">
                    <a href="{{ route('admin.pelataran.data') }}" wire:navigate class="btn btn-sm btn-outline-info w-100">
                        <i class="fas fa-external-link-alt me-1"></i> Kelola Data Pelataran
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
