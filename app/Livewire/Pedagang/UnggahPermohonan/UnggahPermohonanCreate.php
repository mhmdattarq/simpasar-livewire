<?php

namespace App\Livewire\Pedagang\UnggahPermohonan;

use App\Models\DataPermohonan;
use App\Repositories\PermohonanRepo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Unggah Surat Permohonan - SIM Pasar')]
class UnggahPermohonanCreate extends Component
{
    use WithFileUploads;

    public ?int $permohonan_id = null;

    public ?DataPermohonan $permohonan = null;

    public $signed_document = null;

    public function mount(?int $id = null)
    {
        $userId = Auth::id();

        if ($id) {
            $this->permohonan = DataPermohonan::with('pasar')
                ->where('user_id', $userId)
                ->find($id);
        } else {
            // Ambil permohonan status draft terbaru milik user
            $this->permohonan = DataPermohonan::with('pasar')
                ->where('user_id', $userId)
                ->where('status', 'draft')
                ->latest()
                ->first();

            // Jika tidak ada draft, ambil permohonan terakhir
            if (! $this->permohonan) {
                $this->permohonan = DataPermohonan::with('pasar')
                    ->where('user_id', $userId)
                    ->latest()
                    ->first();
            }
        }

        if (! $this->permohonan) {
            session()->flash('alert-show', [
                'type' => 'warning',
                'title' => 'Belum Ada Permohonan',
                'message' => 'Silakan ajukan permohonan tempat pasar terlebih dahulu.',
            ]);

            return $this->redirectRoute('pedagang.ajukan_permohonan.create', navigate: true);
        }

        $this->permohonan_id = $this->permohonan->id;
    }

    public function previewSurat()
    {
        if (! $this->permohonan) {
            return;
        }

        $pedagangData = [
            'nama' => $this->permohonan->nama,
            'jenis_kelamin' => $this->permohonan->jenis_kelamin,
            'tempat_lahir' => $this->permohonan->tempat_lahir,
            'tanggal_lahir' => $this->permohonan->tanggal_lahir,
            'nik' => $this->permohonan->nik,
            'no_telp' => $this->permohonan->no_telp,
            'alamat' => $this->permohonan->alamat,
            'nama_pasar' => $this->permohonan->pasar?->nama_pasar ?? '-',
            'tipe_tempat' => $this->permohonan->tipe_tempat,
            'nomor_tempat' => $this->permohonan->nomor_tempat,
            'lokasi' => $this->permohonan->lokasi,
            'luas' => $this->permohonan->luas,
            'jenis_dagangan' => $this->permohonan->jenis_dagangan,
            'jam_buka' => $this->permohonan->jam_buka,
            'jam_tutup' => $this->permohonan->jam_tutup,
        ];

        $this->dispatch('modal-setModalData', data: [
            'modalId' => 'modalPreviewDraft',
            'title' => 'Pratinjau Draf Surat Permohonan',
            'size' => 'modal-xl modal-dialog-scrollable',
            'type' => 'preview',
            'view' => 'templates.components.permohonan',
            'params' => [
                'pedagang' => $pedagangData,
                'isLengkap' => ($this->permohonan->status === 'lengkap'),
            ],
            'btnCancelText' => 'Tutup',
            'btnActionText' => 'Tutup',
            'btnActionClass' => 'btn-secondary',
            'btnActionIcon' => 'iconoir-xmark',
            'dispatch' => 'closePreview',
        ]);
    }

    public function rules(): array
    {
        return [
            'signed_document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'signed_document.required' => 'Pilih berkas surat permohonan yang telah Anda tanda tangani.',
            'signed_document.file' => 'Berkas yang diunggah harus berupa file yang valid.',
            'signed_document.mimes' => 'Format berkas harus berupa PDF, JPG, JPEG, atau PNG.',
            'signed_document.max' => 'Ukuran berkas maksimal 5 MB.',
        ];
    }

    public function formSubmit()
    {
        $this->validate();

        try {
            $filePath = $this->signed_document->store('permohonan/signed', 'public');

            $updated = PermohonanRepo::uploadSignedDocument($this->permohonan_id, $filePath);

            if ($updated) {
                session()->flash('alert-show', [
                    'type' => 'success',
                    'title' => 'Berhasil Diunggah',
                    'message' => 'Surat permohonan bertandatangan berhasil diunggah. Status permohonan Anda kini telah Lengkap.',
                ]);

                return $this->redirectRoute('pedagang.permohonan.unggah', navigate: true);
            }

            $this->dispatch('alert-show', data: [
                'type' => 'danger',
                'title' => 'Gagal',
                'message' => 'Terjadi kesalahan saat menyimpan berkas permohonan.',
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal mengunggah surat bertandatangan', ['error' => $e->getMessage()]);

            $this->dispatch('alert-show', data: [
                'type' => 'danger',
                'title' => 'Gagal',
                'message' => 'Terjadi kesalahan sistem: '.$e->getMessage(),
            ]);
        }
    }

    public function render()
    {
        return view('mods.pedagang.unggah-permohonan.unggah-permohonan-create');
    }
}
