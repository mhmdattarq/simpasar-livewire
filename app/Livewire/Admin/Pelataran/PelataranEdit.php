<?php

namespace App\Livewire\Admin\Pelataran;

use App\Repositories\PelataranRepo;
use Livewire\Component;

class PelataranEdit extends Component
{
    public $id;

    public $form = [];

    public function mount($id)
    {
        $this->id = $id;
        $pelataran = PelataranRepo::getById($id);

        $this->form = [
            'nomor_pelataran' => $pelataran->nomor_pelataran,
            'ukuran_pelataran' => $pelataran->ukuran_pelataran,
            'harga_sewa' => $pelataran->harga_sewa,
            'satuan_retribusi' => $pelataran->satuan_retribusi,
            'status_pelataran' => $pelataran->status_pelataran,
            'lokasi_pelataran' => $pelataran->lokasi_pelataran,
            'pasar_id' => $pelataran->pasar_id,
        ];
    }

    public function formSubmit()
    {
        $this->validate();

        $payload = [
            'nomor_pelataran' => $this->form['nomor_pelataran'],
            'ukuran_pelataran' => $this->form['ukuran_pelataran'] ?: null,
            'harga_sewa' => $this->form['harga_sewa'] ?: null,
            'satuan_retribusi' => $this->form['satuan_retribusi'],
            'status_pelataran' => $this->form['status_pelataran'],
            'lokasi_pelataran' => $this->form['lokasi_pelataran'] ?: null,
            'pasar_id' => $this->form['pasar_id'],
        ];

        $process = PelataranRepo::update($this->id, $payload);

        if ($process) {
            session()->flash('alert-show', [
                'type' => 'success',
                'title' => 'Berhasil',
                'message' => 'Data Pelataran Berhasil diperbarui',
            ]);

            return $this->redirectRoute('admin.pelataran.data', navigate: true);
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
            'form.nomor_pelataran' => 'required|unique:data_pelatarans,nomor_pelataran,'.$this->id,
            'form.ukuran_pelataran' => 'nullable',
            'form.harga_sewa' => 'nullable|numeric',
            'form.satuan_retribusi' => 'required|in:hari,bulan,tahun',
            'form.status_pelataran' => 'required|in:tetap,tidaktetap,insidentil',
            'form.lokasi_pelataran' => 'nullable',
            'form.pasar_id' => 'required|exists:data_pasars,id',
        ];
    }

    public function messages()
    {
        return [
            'form.nomor_pelataran.required' => 'Mohon Masukkan Nomor/Kode Pelataran',
            'form.nomor_pelataran.unique' => 'Nomor Pelataran sudah digunakan, gunakan nomor lain',
            'form.harga_sewa.numeric' => 'Harga Sewa harus berupa angka',
            'form.satuan_retribusi.required' => 'Mohon Pilih Satuan Retribusi',
            'form.satuan_retribusi.in' => 'Pilihan Satuan Retribusi tidak valid',
            'form.status_pelataran.required' => 'Mohon Pilih Status Pelataran',
            'form.status_pelataran.in' => 'Pilihan Status Pelataran tidak valid',
            'form.pasar_id.required' => 'Mohon Pilih Pasar',
            'form.pasar_id.exists' => 'Pasar yang dipilih tidak valid',
        ];
    }

    public $validationAttributes = [
        'form.nomor_pelataran' => 'Nomor Pelataran',
        'form.ukuran_pelataran' => 'Ukuran Pelataran',
        'form.harga_sewa' => 'Harga Sewa',
        'form.satuan_retribusi' => 'Satuan Retribusi',
        'form.status_pelataran' => 'Status Pelataran',
        'form.lokasi_pelataran' => 'Lokasi Pelataran',
        'form.pasar_id' => 'Pasar',
    ];

    public function render()
    {
        return view('mods.admin.pelataran.pelataran-edit', [
            'pasars' => PelataranRepo::getPasars(),
        ]);
    }
}
