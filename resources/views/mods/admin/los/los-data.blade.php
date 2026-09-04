<div>
    <!-- start page title -->
    <div class="row mb-2">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Data Los</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Master Data Los</a></li>
                        <li class="breadcrumb-item active">Data Los</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <h4 class="card-title">Manajemen Data Los</h4>
                        </div>
                        <div class="col-auto ms-auto">
                            <a href="{{ route('admin.los.create') }}" class="btn btn-primary" wire:navigate>
                                <i class="iconoir-plus-circle me-1"></i> Tambah Data Los
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body" wire:ignore>
                    <div class="table-responsive">
                        <table id="tableLos" class="table table-bordered table-striped w-100 align-middle">
                            <thead>
                                <tr>
                                    <th style="width: 20px" class="text-center">Check</th>
                                    <th style="width: 50px" class="text-center">Aksi</th>
                                    <th style="width: 40px" class="text-center">No</th>
                                    <th>Nomor Los</th>
                                    <th>Ukuran Los</th>
                                    <th class="text-center" style="width: 100px">Harga Sewa/Restribusi</th>
                                    <th class="text-center" style="width: 100px">Satuan Restribusi</th>
                                    <th class="text-center" style="width: 120px">Status Los</th>
                                    <th class="text-center" style="width: 120px">Lokasi Los</th>
                                    <th class="text-center" style="width: 120px">Lokasi Pasar</th>
                                </tr>
                            </thead>
                            <thead id="header-filter">
                                <tr>
                                    <th class="text-center">
                                        <input type="checkbox" class="form-check-input check-data-all">
                                    </th>
                                    <th class="text-center"></th>
                                    <th class="text-center"></th>
                                    <th class="text-center">
                                        <input type="text"
                                            class="form-control form-control-sm text-center search-col-dt"
                                            placeholder="Cari Nomor Los">
                                    </th>
                                    <th class="text-center"></th>
                                    <th class="text-center"></th>
                                    <th class="text-center"></th>
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
    <livewire:modal />
    @include('mods.admin.los.atc.los-data-atc')
</div>
