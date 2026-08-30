<div>
    <div class="row mb-2">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Tambah Data Pasar</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Master Data Pasar</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Data Pasar</a></li>
                        <li class="breadcrumb-item active">Tambah Data Pasar</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-auto">
                    <h4 class="card-title">Tambah Data Pasar</h4>
                </div><!--end col-->
                <div class="col-auto ms-auto">
                    <a href="{{ route('admin.pasar.data') }}" class="btn btn-danger">Kembali</a>
                </div><!--end col-->
            </div> <!--end row-->
        </div><!--end card-header-->
        <div class="card-body pt-0">
            <form wire:submit="formSubmit">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-2 row">
                            <label for="nama_pasar" class="col-sm-2 col-form-label">Nama Pasar</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Masukkan Nama Pasar"
                                    wire:model="form.nama_pasar">
                            </div>
                        </div>
                        <div class="mb-2 row">
                            <label for="alamat_pasar" class="col-sm-2 col-form-label">Alamat</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="3" placeholder="Masukkan Alamat Pasar" wire:model="form.alamat_pasar"></textarea>
                            </div>
                        </div>
                        <div class="mb-2 row">
                            <label for="total_kios" class="col-sm-2 col-form-label">Total Kios</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" placeholder="Masukkan Total Kios Pasar"
                                    wire:model="form.total_kios">
                            </div>
                        </div>
                        <div class="mb-2 row">
                            <label for="total_los" class="col-sm-2 col-form-label">Total Los</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" placeholder="Masukkan Total Pelataran Los"
                                    wire:model="form.total_los">
                            </div>
                        </div>
                        <div class="mb-2 row">
                            <label for="total_pelataran" class="col-sm-2 col-form-label">Total Pelataran</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" placeholder="Masukkan Total Pelataran Pasar"
                                    wire:model="form.nama_pelataran">
                            </div>
                        </div>
                    </div><!--end col-->
                    <div class="col-lg-6">
                        <div class="mb-1 row">
                            <label for="total_pelataran" class="col-sm-2 col-form-label">Tampak Depan Pasar</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" wire:model="form.tampak_depan_pasar">
                            </div>
                        </div>
                        <div class="mb-1 row">
                            <label for="total_pelataran" class="col-sm-2 col-form-label">Tampak Dalam Pasar</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" wire:model="form.tampak_dalam_pasar">
                            </div>
                        </div>
                        <div class="mb-1 row">
                            <label for="total_pelataran" class="col-sm-2 col-form-label">Tampak Belakang Pasar</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" wire:model="form.tampak_belakang_pasar">
                            </div>
                        </div>
                        <div class="mb-1 row">
                            <label for="embed_pasar" class="col-sm-2 col-form-label">Lokasi Peta Pasar</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="2" placeholder="Masukkan Embed Peta Pasar" wire:model="form.embed_pasar"></textarea>
                            </div>
                        </div>
                    </div><!--end col-->
                    <div class="mt-1">
                        <button type="submit" class="btn btn-primary w-100">Simpan</button>
                    </div>
                </div> <!--end row-->
            </form>
        </div><!--end card-body-->
    </div><!--end card-->
</div>
