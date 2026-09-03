<?php

namespace App\Livewire\Admin\Los;

use App\Repositories\LosRepo;
use Livewire\Component;

class LosCreate extends Component
{
    public $form = [];

    public function mount()
    {
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->form = [
            'nomor_los' => '',
            'ukuran_los' => '',
            'harga_sewa' => '',
            'satuan_retribusi' => '',
            'status_los' => '',
            'lokasi_los' => '',
            'pasar_id' => '',
        ];
    }

    public function rules()
    {
        return [
            'form.nomor_los' => 'required|unique:data_los,nomor_los',
            'form.ukuran_los' => 'nullable',
            'form.harga_sewa' => 'nullable|numeric',
            'form.satuan_retribusi' => 'required|in:hari,bulan,tahun',
            'form.status_los' => 'required|in:tersedia,terisi,pengajuan',
            'form.lokasi_los' => 'nullable',
            'form.pasar_id' => 'required|exists:data_pasars,id',
        ];
    }

    public function messages()
    {
        return [
            'form.nomor_los.required' => 'Mohon Masukkan Nomor Los',
            'form.nomor_los.unique' => 'Nomor Los sudah digunakan, gunakan nomor lain',
            'form.harga_sewa.numeric' => 'Harga Sewa harus berupa angka',
            'form.satuan_retribusi.required' => 'Mohon Pilih Satuan Retribusi',
            'form.satuan_retribusi.in' => 'Pilihan Satuan Retribusi tidak valid',
            'form.status_los.required' => 'Mohon Pilih Status Los',
            'form.status_los.in' => 'Pilihan Status Los tidak valid',
            'form.pasar_id.required' => 'Mohon Pilih Pasar',
            'form.pasar_id.exists' => 'Pasar yang dipilih tidak valid',
        ];
    }

    public $validationAttributes = [
        'form.nomor_los' => 'Nomor Los',
        'form.ukuran_los' => 'Ukuran Los',
        'form.harga_sewa' => 'Harga Sewa',
        'form.satuan_retribusi' => 'Satuan Retribusi',
        'form.status_los' => 'Status Los',
        'form.lokasi_los' => 'Lokasi Los',
        'form.pasar_id' => 'Pasar',
    ];

    public function formSubmit()
    {
        $this->validate();

        $payload = [
            'nomor_los' => $this->form['nomor_los'],
            'ukuran_los' => $this->form['ukuran_los'] ?: null,
            'harga_sewa' => $this->form['harga_sewa'] ?: null,
            'satuan_retribusi' => $this->form['satuan_retribusi'],
            'status_los' => $this->form['status_los'],
            'lokasi_los' => $this->form['lokasi_los'] ?: null,
            'pasar_id' => $this->form['pasar_id'],
        ];

        $process = LosRepo::create($payload);

        if ($process) {
            $this->dispatch('alert-show', data: [
                'type' => 'primary',
                'title' => 'Berhasil',
                'message' => 'Data Los Berhasil disimpan',
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
        return view('mods.admin.los.los-create', [
            'pasars' => LosRepo::getPasars(),
        ]);
    }
}
