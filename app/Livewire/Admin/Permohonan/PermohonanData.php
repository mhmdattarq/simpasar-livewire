<?php

namespace App\Livewire\Admin\Permohonan;

use App\Models\DataPermohonan;
use App\Repositories\PermohonanRepo;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Data Permohonan Pedagang - SIM Pasar')]
class PermohonanData extends Component
{
    public ?DataPermohonan $selectedPermohonan = null;

    public array $reviewBerkas = [];

    public ?string $activeDocUrl = null;

    public string $activeDocTitle = '';

    // Approval state
    public ?int $approveId = null;

    public string $approveNama = '';

    public string $approveStatus = 'approved';

    public string $rejectReason = '';

    public function reviewPermohonan(int $id): void
    {
        $this->selectedPermohonan = DataPermohonan::with('pasar')->findOrFail($id);

        $this->reviewBerkas = [
            'permohonan' => [
                'label' => 'Surat Permohonan Bertandatangan',
                'path' => $this->selectedPermohonan->dokumen_path,
                'url' => $this->selectedPermohonan->dokumen_path ? asset('storage/'.$this->selectedPermohonan->dokumen_path) : null,
            ],
            'nib' => [
                'label' => 'Nomor Induk Berusaha (NIB)',
                'path' => $this->selectedPermohonan->nib,
                'url' => $this->selectedPermohonan->nib ? asset('storage/'.$this->selectedPermohonan->nib) : null,
            ],
            'npwp' => [
                'label' => 'Fotokopi NPWP',
                'path' => $this->selectedPermohonan->npwp,
                'url' => $this->selectedPermohonan->npwp ? asset('storage/'.$this->selectedPermohonan->npwp) : null,
            ],
            'ktp' => [
                'label' => 'Fotokopi KTP',
                'path' => $this->selectedPermohonan->ktp,
                'url' => $this->selectedPermohonan->ktp ? asset('storage/'.$this->selectedPermohonan->ktp) : null,
            ],
            'kk' => [
                'label' => 'Fotokopi Kartu Keluarga (KK)',
                'path' => $this->selectedPermohonan->kk,
                'url' => $this->selectedPermohonan->kk ? asset('storage/'.$this->selectedPermohonan->kk) : null,
            ],
            'foto' => [
                'label' => 'Pas Foto Berwarna',
                'path' => $this->selectedPermohonan->foto,
                'url' => $this->selectedPermohonan->foto ? asset('storage/'.$this->selectedPermohonan->foto) : null,
            ],
            'pernyataan' => [
                'label' => 'Surat Pernyataan Bertandatangan',
                'path' => $this->selectedPermohonan->dokumen_path_pernyataan,
                'url' => $this->selectedPermohonan->dokumen_path_pernyataan ? asset('storage/'.$this->selectedPermohonan->dokumen_path_pernyataan) : null,
            ],
        ];

        // Default pratinjau pertama: surat permohonan bertandatangan jika ada, atau berkas pertama yang ada
        $this->activeDocUrl = $this->reviewBerkas['permohonan']['url']
            ?? $this->reviewBerkas['ktp']['url']
            ?? null;
        $this->activeDocTitle = $this->reviewBerkas['permohonan']['url']
            ? 'Surat Permohonan Bertandatangan'
            : 'Dokumen Persyaratan';

        $this->dispatch('showModal', id: 'modalReviewPermohonan');
    }

    public function selectPreviewDoc(string $key): void
    {
        if (isset($this->reviewBerkas[$key]) && $this->reviewBerkas[$key]['url']) {
            $this->activeDocUrl = $this->reviewBerkas[$key]['url'];
            $this->activeDocTitle = $this->reviewBerkas[$key]['label'];
        }
    }

    public function openApproveModal(int $id): void
    {
        $permohonan = DataPermohonan::findOrFail($id);
        $this->approveId = $id;
        $this->approveNama = $permohonan->nama;
        $this->approveStatus = 'approved';
        $this->rejectReason = '';

        $this->dispatch('showModal', id: 'modalApprovePermohonan');
    }

    public function saveApprove(): void
    {
        if ($this->approveStatus === 'rejected') {
            $this->validate([
                'rejectReason' => 'required|min:5',
            ], [
                'rejectReason.required' => 'Mohon isi alasan penolakan permohonan.',
                'rejectReason.min' => 'Alasan penolakan minimal 5 karakter.',
            ]);
        }

        $success = PermohonanRepo::approve(
            $this->approveId,
            $this->approveStatus,
            $this->approveStatus === 'rejected' ? $this->rejectReason : null
        );

        if ($success) {
            $this->dispatch('closeModal', id: 'modalApprovePermohonan');
            $this->dispatch('alert-show', data: [
                'type' => $this->approveStatus === 'approved' ? 'success' : 'warning',
                'title' => 'Persetujuan Disimpan',
                'message' => $this->approveStatus === 'approved'
                    ? "Permohonan dari {$this->approveNama} telah disetujui (Belum Terverifikasi)."
                    : "Permohonan dari {$this->approveNama} telah ditolak.",
            ]);
            $this->dispatch('reloadDT', data: 'tablePermohonan');
        } else {
            $this->dispatch('alert-show', data: [
                'type' => 'danger',
                'title' => 'Gagal',
                'message' => 'Terjadi kesalahan saat menyimpan keputusan permohonan.',
            ]);
        }
    }

    public function verifyPermohonan(int $id): void
    {
        $permohonan = DataPermohonan::findOrFail($id);
        $success = PermohonanRepo::verify($id);

        if ($success) {
            $this->dispatch('alert-show', data: [
                'type' => 'success',
                'title' => 'Berhasil Diverifikasi',
                'message' => "Permohonan dari {$permohonan->nama} berhasil diverifikasi. Status permohonan selesai dan tempat pasar telah terisi.",
            ]);
            $this->dispatch('reloadDT', data: 'tablePermohonan');
        } else {
            $this->dispatch('alert-show', data: [
                'type' => 'danger',
                'title' => 'Gagal',
                'message' => 'Terjadi kesalahan saat memverifikasi permohonan.',
            ]);
        }
    }

    public function render()
    {
        return view('mods.admin.permohonan.permohonan-data');
    }
}
