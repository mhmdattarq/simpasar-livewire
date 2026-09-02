<?php

namespace App\Livewire\Admin\Kios;

use App\Repositories\KiosRepo;
use Livewire\Component;

class KiosEdit extends Component
{
    public $id;

    public $form = [];

    public function mount($id)
    {
        $this->id = $id;
        $kios = KiosRepo::getById($id);

        $this->form = [
            'nomor_kios' => $kios->nomor_kios,
            'ukuran_kios' => $kios->ukuran_kios,
            'harga_sewa' => $kios->harga_sewa,
            'satuan_retribusi' => $kios->satuan_retribusi,
            'status_kios' => $kios->status_kios,
            'lokasi_kios' => $kios->lokasi_kios,
            'pasar_id' => $kios->pasar_id,
        ];
    }

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

        $process = KiosRepo::update($this->id, $payload);

        if ($process) {
            session()->flash('alert-show', [
                'type' => 'success',
                'title' => 'Berhasil',
                'message' => 'Data Kios Berhasil diperbarui',
            ]);

            return $this->redirectRoute('admin.kios.data', navigate: true);
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
            'form.nomor_kios' => 'required|unique:data_kios,nomor_kios,'.$this->id,
            'form.ukuran_kios' => 'nullable',
            'form.harga_sewa' => 'nullable|numeric',
            'form.satuan_retribusi' => 'required|in:hari,bulan,tahun',
            'form.status_kios' => 'required|in:tersedia,terisi,pengajuan',
            'form.lokasi_kios' => 'nullable',
            'form.pasar_id' => 'required|exists:data_pasars,id',
        ];
    }

    public function messages()
    {
        return [
            'form.nomor_kios.required' => 'Mohon Masukkan Nomor Kios',
            'form.nomor_kios.unique' => 'Nomor Kios sudah digunakan, gunakan nomor lain',
            'form.harga_sewa.numeric' => 'Harga Sewa harus berupa angka',
            'form.satuan_retribusi.required' => 'Mohon Pilih Satuan Retribusi',
            'form.satuan_retribusi.in' => 'Pilihan Satuan Retribusi tidak valid',
            'form.status_kios.required' => 'Mohon Pilih Status Kios',
            'form.status_kios.in' => 'Pilihan Status Kios tidak valid',
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

    public function render()
    {
        return view('mods.admin.kios.kios-edit', [
            'pasars' => KiosRepo::getPasars(),
        ]);
    }
}
