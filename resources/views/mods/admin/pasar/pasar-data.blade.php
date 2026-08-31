<div>
    <!-- start page title -->
    <div class="row mb-2">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Data Pasar</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Master Data Pasar</a></li>
                        <li class="breadcrumb-item active">Data Pasar</li>
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
                            <h4 class="card-title">Manajemen Data Pasar</h4>
                        </div>
                        <div class="col-auto ms-auto">
                            <a href="{{ route('admin.pasar.create') }}" class="btn btn-primary" wire:navigate>
                                <i class="iconoir-plus-circle me-1"></i> Tambah Data Pasar
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body" wire:ignore>
                    <div class="table-responsive">
                        <table id="myTable" class="table table-bordered table-striped w-100 align-middle">
                            <thead>
                                <tr>
                                    <th style="width: 20px" class="text-center">Check</th>
                                    <th style="width: 50px" class="text-center">Aksi</th>
                                    <th style="width: 40px" class="text-center">No</th>
                                    <th>Nama Pasar</th>
                                    <th>Alamat</th>
                                    <th class="text-center" style="width: 100px">Total Kios</th>
                                    <th class="text-center" style="width: 100px">Total Los</th>
                                    <th class="text-center" style="width: 120px">Total Pelataran</th>
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
                                            placeholder="Cari Nama">
                                    </th>
                                    <th class="text-center">
                                        <input type="text"
                                            class="form-control form-control-sm text-center search-col-dt"
                                            placeholder="Cari Alamat">
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
    <livewire:modal-delete />
    {{-- ini ngehook ke dalam atc agar kebaca script datatables nya --}}
    @include('mods.admin.pasar.atc.pasar-data-atc')
</div>
