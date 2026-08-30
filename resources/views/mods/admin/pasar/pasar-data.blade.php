<div>
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
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-auto">
                    <h4 class="card-title">Data Pasar</h4>
                </div><!--end col-->
                <div class="col-auto ms-auto">
                    <a href="{{ route('admin.pasar.create') }}" class="btn btn-primary">Tambah Data Pasar</a>
                </div><!--end col-->
            </div> <!--end row-->
        </div><!--end card-header-->
        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table datatable" id="datatable_1">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Pasar</th>
                            <th>Alamat</th>
                            <th>Total Kios</th>
                            <th>Total Los</th>
                            <th>Total Pelataran</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div><!--end card-body-->
    </div><!--end card-->
    @include('mods.admin.pasar.atc.pasar-data-atc')
</div>
