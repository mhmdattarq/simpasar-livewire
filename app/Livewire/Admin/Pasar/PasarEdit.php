<?php

namespace App\Livewire\Admin\Pasar;

use App\Repositories\PasarRepo;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Edit Data Pasar - SIM Pasar')]
class PasarEdit extends Component
{
    use WithFileUploads;

    public $id;

    public $form = [];

    public $foto_depan_old;

    public $foto_dalam_old;

    public $foto_belakang_old;

    public function mount($id)
    {
        $this->id = $id;
        $pasar = PasarRepo::getById($id);

        $this->foto_depan_old = $pasar->foto_depan;
        $this->foto_dalam_old = $pasar->foto_dalam;
        $this->foto_belakang_old = $pasar->foto_belakang;

        $this->form = [
            'nama_pasar' => $pasar->nama_pasar,
            'alamat_pasar' => $pasar->alamat_pasar,
            'total_kios' => $pasar->total_kios,
            'total_los' => $pasar->total_los,
            'total_pelataran' => $pasar->total_pelataran,
            'tampak_depan_pasar' => null,
            'tampak_dalam_pasar' => null,
            'tampak_belakang_pasar' => null,
            'embed_pasar' => $pasar->lokasi_peta,
        ];
    }

    public function formSubmit()
    {
        $this->validate();

        // 1. Simpan file foto jika user mengunggah foto baru, jika tidak pakai foto lama
        $fotoDepan = $this->form['tampak_depan_pasar']
            ? $this->form['tampak_depan_pasar']->store('pasar', 'public')
            : $this->foto_depan_old;

        $fotoDalam = $this->form['tampak_dalam_pasar']
            ? $this->form['tampak_dalam_pasar']->store('pasar', 'public')
            : $this->foto_dalam_old;

        $fotoBelakang = $this->form['tampak_belakang_pasar']
            ? $this->form['tampak_belakang_pasar']->store('pasar', 'public')
            : $this->foto_belakang_old;

        // 2. Susun payload data
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

        // 3. Update ke Repository
        $process = PasarRepo::update($this->id, $payload);

        if ($process) {
            session()->flash('alert-show', [
                'type' => 'success',
                'title' => 'Berhasil',
                'message' => 'Data Pasar Berhasil diperbarui',
            ]);

            return $this->redirectRoute('admin.pasar.data', navigate: true);
        } else {
            $this->dispatch('alert-show', data: [
                'type' => 'error',
                'title' => 'Gagal',
                'message' => 'Terjadi Kesalahan saat memperbarui data',
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
            'form.tampak_depan_pasar' => 'nullable|image|max:5000',
            'form.tampak_dalam_pasar' => 'nullable|image|max:5000',
            'form.tampak_belakang_pasar' => 'nullable|image|max:5000',
            'form.embed_pasar' => 'required',
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
            'form.embed_pasar' => 'Mohon Masukkan Embed Lokasi Peta Pasar',
        ];
    }

    public function render()
    {
        return view('mods.admin.pasar.pasar-edit');
    }
}
