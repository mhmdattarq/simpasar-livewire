<?php

namespace App\Livewire\Admin\Pasar;

use App\Repositories\PasarRepo;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Tambah Data Pasar - SIM Pasar')]
class PasarCreate extends Component
{
    use WithFileUploads;

    public $form = [];

    public function mount()
    {
        $this->resetForm();
    }

    public function formSubmit()
    {
        $this->validate();

        // 1. Simpan file foto ke public/storage/pasar dan ambil path string-nya
        $fotoDepan = $this->form['tampak_depan_pasar']->store('pasar', 'public');
        $fotoDalam = $this->form['tampak_dalam_pasar']->store('pasar', 'public');
        $fotoBelakang = $this->form['tampak_belakang_pasar']->store('pasar', 'public');

        // 2. Susun payload data yang sesuai persis dengan kolom tabel data_pasars
        $payload = [
            'nama_pasar' => $this->form['nama_pasar'],
            'alamat_pasar' => $this->form['alamat_pasar'],
            'total_kios' => $this->form['total_kios'],
            'total_los' => $this->form['total_los'],
            'total_pelataran' => $this->form['total_pelataran'],
            'foto_depan' => $fotoDepan,
            'foto_dalam' => $fotoDalam,
            'foto_belakang' => $fotoBelakang,
            'lokasi_peta' => $this->form['embed_pasar'],
        ];

        // 3. Kirim payload ke Repository
        $process = PasarRepo::create($payload);

        if ($process) {
            $this->dispatch('alert-show', data: [
                'type' => 'primary',
                'title' => 'Berhasil',
                'message' => 'Data Pasar Berhasil disimpan',
            ]);
            $this->resetForm();
        } else {
            $this->dispatch('alert-show', data: [
                'type' => 'danger',
                'title' => 'Gagal',
                'message' => 'Terjadi Kesalahan',
            ]);
        }
    }

    public function rules()
    {
        return [
            'form.nama_pasar' => 'required',
            'form.alamat_pasar' => 'required',
            'form.total_kios' => 'required|numeric',
            'form.total_los' => 'required|numeric',
            'form.total_pelataran' => 'required|numeric',
            'form.tampak_depan_pasar' => 'required|image|max:5000',
            'form.tampak_dalam_pasar' => 'required|image|max:5000',
            'form.tampak_belakang_pasar' => 'required|image|max:5000',
            'form.embed_pasar' => 'required',
        ];
    }

    public function resetForm()
    {
        $this->form = [
            'nama_pasar' => '',
            'alamat_pasar' => '',
            'total_kios' => '',
            'total_los' => '',
            'total_pelataran' => '',
            'tampak_depan_pasar' => null,
            'tampak_dalam_pasar' => null,
            'tampak_belakang_pasar' => null,
            'embed_pasar' => '',
        ];
    }

    public function messages()
    {
        return [
            'form.nama_pasar' => 'Mohon Masukkan Nama Pasar',
            'form.alamat_pasar' => 'Mohon Masukkan Alamat Pasar',
            'form.total_kios' => 'Mohon Masukkan Total Kios',
            'form.total_los' => 'Mohon Masukkan Total Los',
            'form.total_pelataran' => 'Mohon Masukkan Total Pelataran',
            'form.tampak_depan_pasar' => 'Mohon Masukkan Gambar Tampak Depan Pasar',
            'form.tampak_dalam_pasar' => 'Mohon Masukkan Gambar Tampak Dalam Pasar',
            'form.tampak_belakang_pasar' => 'Mohon Masukkan Gambar Tampak Belakang Pasar',
            'form.embed_pasar' => 'Mohon Masukkan Embed Lokasi Peta Pasar',
        ];
    }

    public $validationAttributes = [
        'form.nama_pasar' => 'Nama Pasar',
        'form.alamat_pasar' => 'Alamat Pasar',
        'form.total_kios' => 'Total Kios',
        'form.total_los' => 'Total Los',
        'form.total_pelataran' => 'Total Pelataran',
        'form.tampak_depan_pasar' => 'Gambar Tampak Depan Pasar',
        'form.tampak_dalam_pasar' => 'Gambar Tampak Dalam Pasar',
        'form.tampak_belakang_pasar' => 'Gambar Tampak Belakang Pasar',
        'form.embed_pasar' => 'Embed Lokasi Peta Pasar',
    ];

    public function render()
    {
        return view('mods.admin.pasar.pasar-create');
    }
}
