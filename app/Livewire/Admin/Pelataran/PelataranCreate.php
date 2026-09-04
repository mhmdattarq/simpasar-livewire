<?php

namespace App\Livewire\Admin\Pelataran;

use App\Repositories\PelataranRepo;
use Livewire\Component;

class PelataranCreate extends Component
{
    public $form = [];

    public function mount()
    {
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->form = [
            'nomor_pelataran' => '',
            'ukuran_pelataran' => '',
            'harga_sewa' => '',
            'satuan_retribusi' => '',
            'status_pelataran' => '',
            'lokasi_pelataran' => '',
            'pasar_id' => '',
        ];
    }

    public function rules()
    {
        return [
            'form.nomor_pelataran' => 'required|unique:data_pelatarans,nomor_pelataran',
            'form.ukuran_pelataran' => 'required',
            'form.harga_sewa' => 'required|numeric',
            'form.satuan_retribusi' => 'required|in:hari,bulan,tahun',
            'form.status_pelataran' => 'required|in:tetap,tidaktetap,insidentil',
            'form.lokasi_pelataran' => 'required',
            'form.pasar_id' => 'required|exists:data_pasars,id',
        ];
    }

    public function messages()
    {
        return [
            'form.nomor_pelataran.required' => 'Mohon Masukkan Nomor Pelataran',
            'form.nomor_pelataran.unique' => 'Nomor Pelataran sudah digunakan, gunakan nomor lain',
            'form.ukuran_pelataran.required' => 'Mohon Masukkan Ukuran Pelataran',
            'form.harga_sewa.required' => 'Mohon Masukkan Harga Sewa Pelataran',
            'form.harga_sewa.numeric' => 'Harga Sewa harus berupa angka',
            'form.satuan_retribusi.required' => 'Mohon Pilih Satuan Retribusi Pelataran',
            'form.satuan_retribusi.in' => 'Pilihan Satuan Retribusi tidak valid',
            'form.status_pelataran.required' => 'Mohon Pilih Status Pelataran',
            'form.status_pelataran.in' => 'Pilihan Status Pelataran tidak valid',
            'form.lokasi_pelataran.required' => 'Mohon Masukkan Lokasi Pelataran',
            'form.pasar_id.required' => 'Mohon Pilih Pasar Untuk Pelataran',
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

        $process = PelataranRepo::create($payload);

        if ($process) {
            $this->dispatch('alert-show', data: [
                'type' => 'primary',
                'title' => 'Berhasil',
                'message' => 'Data Pelataran Berhasil disimpan',
            ]);
            $this->resetForm();
        } else {
            $this->dispatch('alert-show', data: [
                'type' => 'danger',
                'title' => 'Gagal',
                'message' => 'Terjadi Kesalahan saat menyimpan data',
            ]);
        }
    }

    public function render()
    {
        return view('mods.admin.pelataran.pelataran-create', [
            'pasars' => PelataranRepo::getPasars(),
        ]);
    }
}
