<div>
    <!-- Header Welcome Card -->
    <div class="row">
        <div class="col-12">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <h3 class="fw-bold mb-1">Selamat Datang, {{ auth()->user()->name ?? 'Administrator' }}! 👋</h3>
                            <p class="mb-0 opacity-75 fs-14">Anda login sebagai <strong>Administrator SIM Pasar</strong>. Kelola data pasar, kios, dan pedagang melalui dashboard ini.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Ringkasan -->
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="row d-flex justify-content-center border-dashed-bottom pb-3">
                        <div class="col-9">
                            <p class="text-dark mb-0 fw-semibold fs-14">Total Pasar</p>
                            <h3 class="mt-2 mb-0 fw-bold">4 Pasar</h3>
                        </div>
                        <div class="col-3 align-self-center">
                            <div class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                <i class="iconoir-shop h1 align-self-center mb-0 text-secondary"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mb-0 text-truncate text-muted mt-3"><span class="text-success">Aktif</span> Beroperasi</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="row d-flex justify-content-center border-dashed-bottom pb-3">
                        <div class="col-9">
                            <p class="text-dark mb-0 fw-semibold fs-14">Total Pedagang</p>
                            <h3 class="mt-2 mb-0 fw-bold">128 Pedagang</h3>
                        </div>
                        <div class="col-3 align-self-center">
                            <div class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                <i class="iconoir-group h1 align-self-center mb-0 text-secondary"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mb-0 text-truncate text-muted mt-3"><span class="text-success">Terdaftar</span> dalam sistem</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="row d-flex justify-content-center border-dashed-bottom pb-3">
                        <div class="col-9">
                            <p class="text-dark mb-0 fw-semibold fs-14">Kios / Lapak</p>
                            <h3 class="mt-2 mb-0 fw-bold">250 Unit</h3>
                        </div>
                        <div class="col-3 align-self-center">
                            <div class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                <i class="iconoir-home-simple h1 align-self-center mb-0 text-secondary"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mb-0 text-truncate text-muted mt-3"><span class="text-primary">85%</span> Terisi</p>
                </div>
            </div>
        </div>
    </div>
</div>
