<?php

namespace App\Livewire\Pedagang\UnggahPermohonan;

use App\Models\DataPermohonan;
use App\Repositories\PermohonanRepo;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Unggah Surat Permohonan - SIM Pasar')]
class UnggahPermohonanData extends Component
{
    use WithFileUploads;

    public ?int $uploadPernyataanId = null;

    public $signedPernyataan = null;

    public function previewSurat(int $id): void
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
                'isLengkap' => ($permohonan->status === 'lengkap' || $permohonan->status === 'disetujui' || $permohonan->status === 'verifikasi' || $permohonan->status === 'selesai'),
            ],
            'btnCancelText' => 'Tutup',
            'showActionBtn' => true,
            'btnActionText' => 'Download PDF',
            'btnActionClass' => 'btn-primary',
            'btnActionIcon' => 'fas fa-download',
            'btnActionUrl' => route('pedagang.permohonan.download', $permohonan->id),
        ]);
    }

    public function openUploadPernyataanModal(int $id): void
    {
        $this->uploadPernyataanId = $id;
        $this->signedPernyataan = null;
        $this->dispatch('showModal', id: 'modalUploadPernyataan');
    }

    public function saveUploadPernyataan(): void
    {
        $this->validate([
            'signedPernyataan' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'signedPernyataan.required' => 'Pilih berkas surat pernyataan yang telah Anda tanda tangani.',
            'signedPernyataan.file' => 'Berkas harus berupa file yang valid.',
            'signedPernyataan.mimes' => 'Format berkas harus berupa PDF, JPG, JPEG, atau PNG.',
            'signedPernyataan.max' => 'Ukuran berkas maksimal 5 MB.',
        ]);

        $filePath = $this->signedPernyataan->store('permohonan/pernyataan', 'public');
        $success = PermohonanRepo::uploadPernyataan($this->uploadPernyataanId, $filePath);

        if ($success) {
            $this->dispatch('permohonan-updated');
            $this->dispatch('closeModal', id: 'modalUploadPernyataan');
            $this->dispatch('alert-show', data: [
                'type' => 'success',
                'title' => 'Surat Pernyataan Berhasil Diunggah',
                'message' => 'Surat pernyataan Anda telah berhasil dikirim. Silakan menunggu proses verifikasi akhir oleh Admin.',
            ]);
            $this->reset(['uploadPernyataanId', 'signedPernyataan']);
        } else {
            $this->dispatch('alert-show', data: [
                'type' => 'danger',
                'title' => 'Gagal',
                'message' => 'Terjadi kesalahan saat mengunggah surat pernyataan.',
            ]);
        }
    }

    public function render()
    {
        $permohonans = PermohonanRepo::getByUserId(Auth::id());

        return view('mods.pedagang.unggah-permohonan.unggah-permohonan-data', [
            'permohonans' => $permohonans,
        ]);
    }
}
