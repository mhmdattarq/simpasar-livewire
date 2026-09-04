<?php

namespace App\Livewire\Admin\Pelataran;

use App\Repositories\PelataranRepo;
use Livewire\Attributes\On;
use Livewire\Component;

class PelataranDelete extends Component
{
    #[On('PelataranDelete-delete')]
    public function delete($data)
    {
        $process = PelataranRepo::delete($data['id']);
        if ($process) {
            $this->dispatch('reloadDT', data: 'dtTable');
            $this->dispatch('closeModal', id: 'modalDelete');
            $this->dispatch('alert-show', data: [
                'type' => 'success',
                'title' => 'Berhasil',
                'message' => 'Data baru berhasil di hapus.',
            ]);
        } else {
            $this->dispatch(
                'alert-show',
                type: 'danger',
                title: 'Gagal',
                msg: 'Gagal menghapus data, silahkan hubungi admin.',
            );
        }
    }

    public function render()
    {
        return '<div></div>';
    }
}
