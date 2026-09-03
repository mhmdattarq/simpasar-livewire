<?php

namespace App\Livewire\Admin\Los;

use App\Repositories\LosRepo;
use Livewire\Attributes\On;
use Livewire\Component;

class LosDelete extends Component
{
    #[On('LosDelete-delete')]
    public function delete($data)
    {
        $process = LosRepo::delete($data['id']);
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
