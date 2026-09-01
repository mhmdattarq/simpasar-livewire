<?php

namespace App\Livewire\Admin\Pasar;

use App\Repositories\PasarRepo;
use Livewire\Attributes\On;
use Livewire\Component;

class PasarData extends Component
{
    public function hookModalDelete($id, $identity)
    {
        $dtHook = [
            'id' => $id,
            'title' => 'Konfirmasi Hapus',
            'msg' => 'Apakah anda yakin menghapus data '.$identity.' ?',
            'dispatch' => 'PasarData-delete',
        ];

        $this->dispatch('modal-delete-setDeleteId', $dtHook);
    }

    #[On('PasarData-delete')]
    public function delete($data)
    {
        $id = is_array($data) ? ($data['id'] ?? null) : $data;
        $process = PasarRepo::delete($id);

        if ($process) {
            $this->dispatch('closeModal', id: 'modalDelete');
            $this->dispatch('alert-show', data: [
                'type' => 'success',
                'title' => 'Berhasil',
                'message' => 'Data Pasar Berhasil dihapus.',
            ]);
            $this->dispatch('reloadDT', data: 'dtTable');
        } else {
            $this->dispatch('alert-show', data: [
                'type' => 'danger',
                'title' => 'Gagal',
                'message' => 'Gagal menghapus data, silahkan hubungi admin.',
            ]);
        }
    }

    public function render()
    {
        return view('mods.admin.pasar.pasar-data');
    }
}
