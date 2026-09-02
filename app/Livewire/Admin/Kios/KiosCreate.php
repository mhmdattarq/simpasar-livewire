<?php

namespace App\Livewire\Admin\Kios;

use App\Repositories\KiosRepo;
use Livewire\Component;

class KiosCreate extends Component
{
    public $form = [];

    public function mount()
    {
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->form = [
            'nomor_kios' => '',
            'ukuran_kios' => '',
            'harga_sewa' => '',
            'satuan_retribusi' => '',
            'status_kios' => '',
            'lokasi_kios' => '',
            'pasar_id' => '',
        ];
    }

    public function rules()
    {
        return [
            'form.nomor_kios' => 'required|unique:data_kios,nomor_kios',
            'form.ukuran_kios' => 'required|nullable',
            'form.harga_sewa' => 'required|nullable|numeric',
            'form.satuan_retribusi' => 'required|in:hari,bulan,tahun',
            'form.status_kios' => 'required|in:tersedia,terisi,pengajuan',
            'form.lokasi_kios' => 'required|nullable',
            'form.pasar_id' => 'required|exists:data_pasars,id',
        ];
    }

    public function messages()
    {
        return [
            'form.nomor_kios.required' => 'Mohon Masukkan Nomor Kios',
            'form.nomor_kios.unique' => 'Nomor Kios sudah digunakan, gunakan nomor lain',
            'form.ukuran_kios.required' => 'Mohon Masukkan Ukuran Kios',
            'form.harga_sewa.required' => 'Mohon Masukkan Harga Sewa Kios',
            'form.harga_sewa.numeric' => 'Harga Sewa harus berupa angka',
            'form.satuan_retribusi.required' => 'Mohon Pilih Satuan Retribusi',
            'form.satuan_retribusi.in' => 'Pilihan Satuan Retribusi tidak valid',
            'form.status_kios.required' => 'Mohon Pilih Status Kios',
            'form.status_kios.in' => 'Pilihan Status Kios tidak valid',
            'form.lokasi_kios.required' => 'Mohon Masukkan Lokasi Kios',
            'form.pasar_id.required' => 'Mohon Pilih Pasar',
            'form.pasar_id.exists' => 'Pasar yang dipilih tidak valid',
        ];
    }

    public $validationAttributes = [
        'form.nomor_kios' => 'Nomor Kios',
        'form.ukuran_kios' => 'Ukuran Kios',
        'form.harga_sewa' => 'Harga Sewa',
        'form.satuan_retribusi' => 'Satuan Retribusi',
        'form.status_kios' => 'Status Kios',
        'form.lokasi_kios' => 'Lokasi Kios',
        'form.pasar_id' => 'Pasar',
    ];

    public function formSubmit()
    {
        $this->validate();

        $payload = [
            'nomor_kios' => $this->form['nomor_kios'],
            'ukuran_kios' => $this->form['ukuran_kios'] ?: null,
            'harga_sewa' => $this->form['harga_sewa'] ?: null,
            'satuan_retribusi' => $this->form['satuan_retribusi'],
            'status_kios' => $this->form['status_kios'],
            'lokasi_kios' => $this->form['lokasi_kios'] ?: null,
            'pasar_id' => $this->form['pasar_id'],
        ];

        $process = KiosRepo::create($payload);

        if ($process) {
            $this->dispatch('alert-show', data: [
                'type' => 'primary',
                'title' => 'Berhasil',
                'message' => 'Data Kios Berhasil disimpan',
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
        return view('mods.admin.kios.kios-create', [
            'pasars' => KiosRepo::getPasars(),
        ]);
    }
}
