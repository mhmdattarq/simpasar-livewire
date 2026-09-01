<div>
    <div class="row mb-2">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Edit Data Pasar</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Master Data Pasar</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.pasar.data') }}">Data Pasar</a></li>
                        <li class="breadcrumb-item active">Edit Data Pasar</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-auto">
                    <h4 class="card-title">Edit Data Pasar</h4>
                </div><!--end col-->
                <div class="col-auto ms-auto">
                    <a href="{{ route('admin.pasar.data') }}" class="btn btn-danger" wire:navigate>Kembali</a>
                </div><!--end col-->
            </div> <!--end row-->
        </div><!--end card-header-->
        <div class="card-body pt-0">
            <form wire:submit="formSubmit">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-2 row">
                            <label for="nama_pasar" class="col-sm-3 col-form-label">Nama Pasar</label>
                            <div class="col-sm-9">
                                <input type="text"
                                    class="form-control @error('form.nama_pasar') {{ 'is-invalid' }} @enderror"
                                    placeholder="Masukkan Nama Pasar" wire:model="form.nama_pasar">
                                <div class="invalid-feedback">
                                    @error('form.nama_pasar')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-2 row">
                            <label for="alamat_pasar" class="col-sm-3 col-form-label">Alamat</label>
                            <div class="col-sm-9">
                                <textarea class="form-control @error('form.alamat_pasar') {{ 'is-invalid' }} @enderror" rows="3"
                                    placeholder="Masukkan Alamat Pasar" wire:model="form.alamat_pasar"></textarea>
                                <div class="invalid-feedback">
                                    @error('form.alamat_pasar')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-2 row">
                            <label for="total_kios" class="col-sm-3 col-form-label">Total Kios</label>
                            <div class="col-sm-9">
                                <input type="number"
                                    class="form-control @error('form.total_kios') {{ 'is-invalid' }} @enderror"
                                    placeholder="Masukkan Total Kios Pasar" wire:model="form.total_kios">
                                <div class="invalid-feedback">
                                    @error('form.total_kios')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-2 row">
                            <label for="total_los" class="col-sm-3 col-form-label">Total Los</label>
                            <div class="col-sm-9">
                                <input type="number"
                                    class="form-control @error('form.total_los') {{ 'is-invalid' }} @enderror"
                                    placeholder="Masukkan Total Pelataran Los" wire:model="form.total_los">
                                <div class="invalid-feedback">
                                    @error('form.total_los')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-2 row">
                            <label for="total_pelataran" class="col-sm-3 col-form-label">Total Pelataran</label>
                            <div class="col-sm-9">
                                <input type="number"
                                    class="form-control @error('form.total_pelataran') {{ 'is-invalid' }} @enderror"
                                    placeholder="Masukkan Total Pelataran Pasar" wire:model="form.total_pelataran">
                                <div class="invalid-feedback">
                                    @error('form.total_pelataran')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->
                    <div class="col-lg-6">
                        <div class="mb-2 row">
                            <label class="col-sm-3 col-form-label">Tampak Depan</label>
                            <div class="col-sm-9">
                                @if ($foto_depan_old)
                                    <div class="mb-1">
                                        <img src="{{ asset('storage/' . $foto_depan_old) }}"
                                            class="rounded img-thumbnail" style="max-height: 70px;" alt="Foto Depan">
                                        <small class="text-muted d-block">Foto saat ini</small>
                                    </div>
                                @endif
                                <input type="file"
                                    class="form-control @error('form.tampak_depan_pasar') {{ 'is-invalid' }} @enderror"
                                    accept="image/jpg, image/png, image/jpeg, image/webp"
                                    wire:model="form.tampak_depan_pasar">
                                <div class="invalid-feedback">
                                    @error('form.tampak_depan_pasar')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-2 row">
                            <label class="col-sm-3 col-form-label">Tampak Dalam</label>
                            <div class="col-sm-9">
                                @if ($foto_dalam_old)
                                    <div class="mb-1">
                                        <img src="{{ asset('storage/' . $foto_dalam_old) }}"
                                            class="rounded img-thumbnail" style="max-height: 70px;" alt="Foto Dalam">
                                        <small class="text-muted d-block">Foto saat ini</small>
                                    </div>
                                @endif
                                <input type="file"
                                    class="form-control @error('form.tampak_dalam_pasar') {{ 'is-invalid' }} @enderror"
                                    accept="image/jpg, image/png, image/jpeg, image/webp"
                                    wire:model="form.tampak_dalam_pasar">
                                <div class="invalid-feedback">
                                    @error('form.tampak_dalam_pasar')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-2 row">
                            <label class="col-sm-3 col-form-label">Tampak Belakang</label>
                            <div class="col-sm-9">
                                @if ($foto_belakang_old)
                                    <div class="mb-1">
                                        <img src="{{ asset('storage/' . $foto_belakang_old) }}"
                                            class="rounded img-thumbnail" style="max-height: 70px;"
                                            alt="Foto Belakang">
                                        <small class="text-muted d-block">Foto saat ini</small>
                                    </div>
                                @endif
                                <input type="file"
                                    class="form-control @error('form.tampak_belakang_pasar') {{ 'is-invalid' }} @enderror"
                                    accept="image/jpg, image/png, image/jpeg, image/webp"
                                    wire:model="form.tampak_belakang_pasar">
                                <div class="invalid-feedback">
                                    @error('form.tampak_belakang_pasar')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-2 row">
                            <label for="embed_pasar" class="col-sm-3 col-form-label">Lokasi Peta</label>
                            <div class="col-sm-9">
                                <textarea class="form-control @error('form.embed_pasar') {{ 'is-invalid' }} @enderror" rows="2"
                                    placeholder="Masukkan Embed Peta Pasar" wire:model="form.embed_pasar"></textarea>
                                <div class="invalid-feedback">
                                    @error('form.embed_pasar')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
                    </div>
                </div> <!--end row-->
            </form>
        </div><!--end card-body-->
    </div><!--end card-->
</div>
