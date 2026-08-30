<?php

namespace App\Livewire\Admin\Pasar;

use App\Repositories\PasarRepo;
use Livewire\Component;

class PasarCreate extends Component
{
    public $form = [];
    public function formSubmit()
    {
        $this->validate();
        $process = PasarRepo::create($this->form);
        if ($process) {
            $this->dispatch(
                'alert-show',
                type: "success",
                msg: "Data Pasar " . $this->form['nama_kecamatan'] . " berhasil disimpan.",
            );
            $this->reset('form');
        } else {
            $this->dispatch(
                'alert-show',
                type: "danger",
                msg: "Proses input data baru gagal, periksa kembali",
            );
        }
    }
    public function render()
    {
        return view('mods.admin.pasar.pasar-create');
    }
}
