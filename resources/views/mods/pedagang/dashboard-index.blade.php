<div>
    <!-- Header Welcome Card -->
    <div class="row">
        <div class="col-12">
            <div class="card bg-success text-white mb-4">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <h3 class="fw-bold mb-1">Selamat Datang, {{ auth()->user()->name ?? 'Pedagang' }}! 👋</h3>
                            <p class="mb-0 opacity-75 fs-14">NIK: <strong>{{ auth()->user()->nik ?? '-' }}</strong> | Status: <strong>Pedagang Pasar Aktif</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Informasi Kios & Status Retribusi Pedagang -->
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="row d-flex justify-content-center border-dashed-bottom pb-3">
                        <div class="col-9">
                            <p class="text-dark mb-0 fw-semibold fs-14">Kios / Lapak Anda</p>
                            <h3 class="mt-2 mb-0 fw-bold">Blok A - No. 12</h3>
                        </div>
                        <div class="col-3 align-self-center">
                            <div class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                <i class="iconoir-shop h1 align-self-center mb-0 text-success"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mb-0 text-truncate text-muted mt-3">Pasar Induk Utama</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="row d-flex justify-content-center border-dashed-bottom pb-3">
                        <div class="col-9">
                            <p class="text-dark mb-0 fw-semibold fs-14">Status Retribusi Bulan Ini</p>
                            <h3 class="mt-2 mb-0 fw-bold text-success">LUNAS</h3>
                        </div>
                        <div class="col-3 align-self-center">
                            <div class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                <i class="iconoir-check-circle h1 align-self-center mb-0 text-success"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mb-0 text-truncate text-muted mt-3">Terakhir dibayar: 28 Agustus 2026</p>
                </div>
            </div>
        </div>
    </div>
</div>
