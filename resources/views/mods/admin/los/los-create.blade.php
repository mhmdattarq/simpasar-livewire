<div>
    <livewire:toast />
    <div class="row mb-2">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Tambah Data Los</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Master Data Los</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Data Los</a></li>
                        <li class="breadcrumb-item active">Tambah Data Los</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-auto">
                    <h4 class="card-title">Tambah Data Los</h4>
                </div><!--end col-->
                <div class="col-auto ms-auto">
                    <a href="{{ route('admin.los.data') }}" class="btn btn-danger" wire:navigate>Kembali</a>
                </div><!--end col-->
            </div> <!--end row-->
        </div><!--end card-header-->
        <div class="card-body pt-0">
            <form wire:submit="formSubmit">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3 row">
                            <label for="nomor_los" class="col-sm-3 col-form-label">Nomor/Kode Los</label>
                            <div class="col-sm-9">
                                <input type="text" id="nomor_los"
                                    class="form-control @error('form.nomor_los') is-invalid @enderror"
                                    placeholder="Masukkan Nomor/Kode Los" wire:model="form.nomor_los">
                                <div class="invalid-feedback">
                                    @error('form.nomor_los')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ukuran_los" class="col-sm-3 col-form-label">Ukuran Los</label>
                            <div class="col-sm-9">
                                <input type="text" id="ukuran_los"
                                    class="form-control @error('form.ukuran_los') is-invalid @enderror"
                                    placeholder="Contoh: 3 x 4 m" wire:model="form.ukuran_los">
                                <div class="invalid-feedback">
                                    @error('form.ukuran_los')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="harga_sewa" class="col-sm-3 col-form-label">Harga Sewa / Retribusi</label>
                            <div class="col-sm-9">
                                <input type="number" id="harga_sewa"
                                    class="form-control @error('form.harga_sewa') is-invalid @enderror"
                                    placeholder="Masukkan Harga Sewa / Retribusi" wire:model="form.harga_sewa">
                                <div class="invalid-feedback">
                                    @error('form.harga_sewa')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="satuan_retribusi" class="col-sm-3 col-form-label">Satuan Retribusi</label>
                            <div class="col-sm-9">
                                <select id="satuan_retribusi"
                                    class="form-select @error('form.satuan_retribusi') is-invalid @enderror"
                                    wire:model="form.satuan_retribusi">
                                    <option value="">Pilih Satuan Retribusi</option>
                                    <option value="hari">Hari</option>
                                    <option value="bulan">Bulan</option>
                                    <option value="tahun">Tahun</option>
                                </select>
                                <div class="invalid-feedback">
                                    @error('form.satuan_retribusi')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->
                    <div class="col-lg-6">
                        <div class="mb-3 row">
                            <label for="status_los" class="col-sm-3 col-form-label">Status Los</label>
                            <div class="col-sm-9">
                                <select id="status_los"
                                    class="form-select @error('form.status_los') is-invalid @enderror"
                                    wire:model="form.status_los">
                                    <option value="">Pilih Status Los</option>
                                    <option value="tersedia">Tersedia</option>
                                    <option value="terisi">Terisi</option>
                                    <option value="pengajuan">Pengajuan</option>
                                </select>
                                <div class="invalid-feedback">
                                    @error('form.status_los')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="lokasi_los" class="col-sm-3 col-form-label">Lokasi Los</label>
                            <div class="col-sm-9">
                                <input type="text" id="lokasi_los"
                                    class="form-control @error('form.lokasi_los') is-invalid @enderror"
                                    placeholder="Contoh: Blok A No. 12" wire:model="form.lokasi_los">
                                <div class="invalid-feedback">
                                    @error('form.lokasi_los')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="pasar_id" class="col-sm-3 col-form-label">Pasar</label>
                            <div class="col-sm-9">
                                <select id="pasar_id" class="form-select @error('form.pasar_id') is-invalid @enderror"
                                    wire:model="form.pasar_id">
                                    <option value="">Pilih Pasar</option>
                                    @foreach ($pasars as $pasar)
                                        <option value="{{ $pasar->id }}">{{ $pasar->nama_pasar }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    @error('form.pasar_id')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary w-100">Simpan</button>
                    </div>
                </div> <!--end row-->
            </form>
        </div><!--end card-body-->
    </div><!--end card-->
</div>
