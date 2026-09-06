<?php

namespace App\Livewire\Pedagang\UnggahPermohonan;

use App\Models\DataPermohonan;
use App\Repositories\PermohonanRepo;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Unggah Surat Permohonan - SIM Pasar')]
class UnggahPermohonanData extends Component
{
    public function previewSurat(int $id)
    {
        $permohonan = DataPermohonan::with('pasar')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        $pedagangData = [
            'nama' => $permohonan->nama,
            'jenis_kelamin' => $permohonan->jenis_kelamin,
            'tempat_lahir' => $permohonan->tempat_lahir,
            'tanggal_lahir' => $permohonan->tanggal_lahir,
            'nik' => $permohonan->nik,
            'no_telp' => $permohonan->no_telp,
            'alamat' => $permohonan->alamat,
            'nama_pasar' => $permohonan->pasar?->nama_pasar ?? '-',
            'tipe_tempat' => $permohonan->tipe_tempat,
            'nomor_tempat' => $permohonan->nomor_tempat,
            'lokasi' => $permohonan->lokasi,
            'luas' => $permohonan->luas,
            'jenis_dagangan' => $permohonan->jenis_dagangan,
            'jam_buka' => $permohonan->jam_buka,
            'jam_tutup' => $permohonan->jam_tutup,
        ];

        $this->dispatch('modal-setModalData', data: [
            'modalId' => 'modalPreviewDraft',
            'title' => 'Pratinjau Draf Surat Permohonan',
            'size' => 'modal-xl modal-dialog-scrollable',
            'type' => 'preview',
            'view' => 'templates.components.permohonan',
            'params' => [
                'pedagang' => $pedagangData,
                'isLengkap' => ($permohonan->status === 'lengkap' || $permohonan->status === 'disetujui' || $permohonan->status === 'selesai'),
            ],
            'btnCancelText' => 'Tutup',
            'btnActionText' => 'Tutup',
            'btnActionClass' => 'btn-secondary',
            'btnActionIcon' => 'iconoir-xmark',
            'dispatch' => 'closePreview',
        ]);
    }

    public function render()
    {
        $permohonans = PermohonanRepo::getByUserId(Auth::id());

        return view('mods.pedagang.unggah-permohonan.unggah-permohonan-data', [
            'permohonans' => $permohonans,
        ]);
    }
}
