<?php

namespace App\Livewire\Admin\Kios;

use App\Repositories\KiosRepo;
use Livewire\Attributes\On;
use Livewire\Component;

class KiosData extends Component
{
    public function hookModalDelete($id, $identity)
    {
        $dtHook = [
            'id' => $id,
            'title' => 'Konfirmasi Hapus',
            'msg' => 'Apakah anda yakin menghapus data kios '.$identity.' ?',
            'dispatch' => 'KiosData-delete',
        ];

        $this->dispatch('modal-delete-setDeleteId', $dtHook);
    }

    #[On('KiosData-delete')]
    public function delete($data)
    {
        $id = is_array($data) ? ($data['id'] ?? null) : $data;
        $process = KiosRepo::delete($id);

        if ($process) {
            $this->dispatch('closeModal', id: 'modalDelete');
            $this->dispatch('alert-show', data: [
                'type' => 'success',
                'title' => 'Berhasil',
                'message' => 'Data Kios Berhasil dihapus.',
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
        return view('mods.admin.kios.kios-data');
    }
}
