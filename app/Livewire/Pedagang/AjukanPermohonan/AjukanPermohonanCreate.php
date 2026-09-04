<?php

namespace App\Livewire\Pedagang\AjukanPermohonan;

use App\Models\DataKios;
use App\Models\DataLos;
use App\Models\DataPasar;
use App\Models\DataPelataran;
use App\Models\DataPermohonan;
use App\Repositories\PermohonanRepo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Ajukan Permohonan Pedagang - SIM Pasar')]
class AjukanPermohonanCreate extends Component
{
    use WithFileUploads;

    // Data Identitas Pedagang (Read-only)
    public string $nik = '';

    public string $nama = '';

    public string $tempat_lahir = '';

    public string $tanggal_lahir = '';

    public string $jenis_kelamin = '';

    public string $no_telp = '';

    public string $alamat = '';

    // Data Form Permohonan Tempat
    public $pasar_id = '';

    public string $tipe_tempat = '';

    public string $nomor_tempat = '';

    public string $lokasi = '';

    public string $luas = '';

    public string $jenis_dagangan = '';

    public string $jam_buka = '';

    public string $jam_tutup = '';

    // Dokumen Persyaratan
    public $nib = null;

    public $npwp = null;

    public $ktp = null;

    public $kk = null;

    public $foto = null;

    // Status Pengajuan Aktif
    public bool $hasActivePermohonan = false;

    public ?DataPermohonan $activePermohonan = null;

    public function mount()
    {
        $user = Auth::user();
        if ($user) {
            $pedagang = $user->pedagang;
            $this->nik = $user->nik ?? ($pedagang->nik ?? '');
            $this->nama = $pedagang->nama ?? ($user->name ?? '');
            $this->tempat_lahir = $pedagang->tempat_lahir ?? '';
            $this->tanggal_lahir = $pedagang->tanggal_lahir ?? '';
            $this->jenis_kelamin = $pedagang->jenis_kelamin ?? '';
            $this->no_telp = $pedagang->no_telp ?? '';
            $this->alamat = $pedagang->alamat ?? '';

            // Cek apakah ada permohonan yang sedang berjalan
            $this->activePermohonan = DataPermohonan::where('user_id', $user->id)
                ->whereIn('status', ['draft', 'lengkap', 'disetujui'])
                ->latest()
                ->first();

            if ($this->activePermohonan) {
                $this->hasActivePermohonan = true;
            }
        }
    }

    public function getPasarsProperty()
    {
        return PermohonanRepo::getPasars();
    }

    public function getUnitsProperty()
    {
        if (! $this->pasar_id || ! $this->tipe_tempat) {
            return collect();
        }

        return PermohonanRepo::getAvailableUnits($this->pasar_id, $this->tipe_tempat);
    }

    public function updatedPasarId()
    {
        $this->nomor_tempat = '';
        $this->lokasi = '';
        $this->luas = '';
    }

    public function updatedTipeTempat()
    {
        $this->nomor_tempat = '';
        $this->lokasi = '';
        $this->luas = '';
    }

    public function updatedNomorTempat($value)
    {
        if (empty($value) || empty($this->pasar_id) || empty($this->tipe_tempat)) {
            $this->luas = '';
            $this->lokasi = '';

            return;
        }

        if ($this->tipe_tempat === 'kios') {
            $unit = DataKios::where('pasar_id', $this->pasar_id)
                ->where('nomor_kios', $value)
                ->first();
            if ($unit) {
                $this->luas = (string) $unit->ukuran_kios;
                $this->lokasi = (string) $unit->lokasi_kios;
            }
        } elseif ($this->tipe_tempat === 'los') {
            $unit = DataLos::where('pasar_id', $this->pasar_id)
                ->where('nomor_los', $value)
                ->first();
            if ($unit) {
                $this->luas = (string) $unit->ukuran_los;
                $this->lokasi = (string) $unit->lokasi_los;
            }
        } elseif ($this->tipe_tempat === 'pelataran') {
            $unit = DataPelataran::where('pasar_id', $this->pasar_id)
                ->where('nomor_pelataran', $value)
                ->first();
            if ($unit) {
                $this->luas = (string) $unit->ukuran_pelataran;
                $this->lokasi = (string) $unit->lokasi_pelataran;
            }
        }
    }

    public function rules(): array
    {
        return [
            'pasar_id' => 'required|exists:data_pasars,id',
            'tipe_tempat' => 'required|in:kios,los,pelataran',
            'nomor_tempat' => 'required|string',
            'jenis_dagangan' => 'required|string|max:255',
            'jam_buka' => 'required',
            'jam_tutup' => 'required',
            'nib' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'npwp' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'ktp' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'kk' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'foto' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'pasar_id.required' => 'Pilih pasar tujuan permohonan.',
            'pasar_id.exists' => 'Pasar yang dipilih tidak valid.',
            'tipe_tempat.required' => 'Pilih tipe tempat (Kios, Los, atau Pelataran).',
            'tipe_tempat.in' => 'Tipe tempat tidak valid.',
            'nomor_tempat.required' => 'Pilih nomor tempat / unit yang tersedia.',
            'jenis_dagangan.required' => 'Jenis dagangan / komoditas wajib diisi.',
            'jam_buka.required' => 'Jam operasional buka wajib diisi.',
            'jam_tutup.required' => 'Jam operasional tutup wajib diisi.',
            'nib.required' => 'Berkas NIB wajib diunggah.',
            'nib.mimes' => 'Format berkas NIB harus berupa PDF, JPG, JPEG, atau PNG.',
            'nib.max' => 'Ukuran berkas NIB maksimal 5 MB.',
            'npwp.required' => 'Berkas NPWP wajib diunggah.',
            'npwp.mimes' => 'Format berkas NPWP harus berupa PDF, JPG, JPEG, atau PNG.',
            'npwp.max' => 'Ukuran berkas NPWP maksimal 5 MB.',
            'ktp.required' => 'Berkas KTP wajib diunggah.',
            'ktp.mimes' => 'Format berkas KTP harus berupa PDF, JPG, JPEG, atau PNG.',
            'ktp.max' => 'Ukuran berkas KTP maksimal 5 MB.',
            'kk.required' => 'Berkas KK wajib diunggah.',
            'kk.mimes' => 'Format berkas KK harus berupa PDF, JPG, JPEG, atau PNG.',
            'kk.max' => 'Ukuran berkas KK maksimal 5 MB.',
            'foto.required' => 'Pas foto berwarna terbaru wajib diunggah.',
            'foto.mimes' => 'Format pas foto harus berupa PDF, JPG, JPEG, atau PNG.',
            'foto.max' => 'Ukuran pas foto maksimal 5 MB.',
        ];
    }

    public function previewSubmit()
    {
        $this->validate();

        $pasar = DataPasar::find($this->pasar_id);

        $pedagangData = [
            'nama' => $this->nama,
            'jenis_kelamin' => $this->jenis_kelamin,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir,
            'nik' => $this->nik,
            'no_telp' => $this->no_telp,
            'alamat' => $this->alamat,
            'nama_pasar' => $pasar?->nama_pasar ?? '-',
            'tipe_tempat' => $this->tipe_tempat,
            'nomor_tempat' => $this->nomor_tempat,
            'lokasi' => $this->lokasi,
            'luas' => $this->luas,
            'jenis_dagangan' => $this->jenis_dagangan,
            'jam_buka' => $this->jam_buka,
            'jam_tutup' => $this->jam_tutup,
        ];

        $this->dispatch('modal-setModalData', data: [
            'modalId' => 'modalPreviewPermohonan',
            'title' => 'Preview Draft Surat Permohonan',
            'size' => 'modal-xl modal-dialog-scrollable',
            'type' => 'preview',
            'view' => 'templates.components.permohonan',
            'params' => ['pedagang' => $pedagangData, 'isLengkap' => false],
            'btnCancelText' => 'Kembali',
            'btnActionText' => 'Ajukan Surat',
            'btnActionClass' => 'btn-success',
            'btnActionIcon' => 'iconoir-send',
            'dispatch' => 'AjukanPermohonanCreate-confirm',
        ]);

        $this->dispatch('showModal', id: 'modalPreviewPermohonan');
    }

    #[On('AjukanPermohonanCreate-confirm')]
    public function confirmSubmit()
    {
        $this->validate();

        try {
            // Upload berkas persyaratan
            $nibPath = $this->nib ? $this->nib->store('permohonan/nib', 'public') : null;
            $npwpPath = $this->npwp ? $this->npwp->store('permohonan/npwp', 'public') : null;
            $ktpPath = $this->ktp ? $this->ktp->store('permohonan/ktp', 'public') : null;
            $kkPath = $this->kk ? $this->kk->store('permohonan/kk', 'public') : null;
            $fotoPath = $this->foto ? $this->foto->store('permohonan/foto', 'public') : null;

            $payload = [
                'user_id' => Auth::id(),
                'nik' => $this->nik,
                'nama' => $this->nama,
                'tempat_lahir' => $this->tempat_lahir,
                'tanggal_lahir' => $this->tanggal_lahir,
                'jenis_kelamin' => $this->jenis_kelamin,
                'no_telp' => $this->no_telp,
                'alamat' => $this->alamat,
                'pasar_id' => $this->pasar_id,
                'tipe_tempat' => $this->tipe_tempat,
                'nomor_tempat' => $this->nomor_tempat,
                'lokasi' => $this->lokasi,
                'luas' => $this->luas,
                'jenis_dagangan' => $this->jenis_dagangan,
                'jam_buka' => $this->jam_buka,
                'jam_tutup' => $this->jam_tutup,
                'nib' => $nibPath,
                'npwp' => $npwpPath,
                'ktp' => $ktpPath,
                'kk' => $kkPath,
                'foto' => $fotoPath,
                'status' => 'draft',
            ];

            $permohonan = PermohonanRepo::create($payload);

            $this->dispatch('closeModal', id: 'modalPreviewPermohonan');

            if ($permohonan) {
                session()->flash('alert-show', [
                    'type' => 'success',
                    'title' => 'Permohonan Berhasil Diajukan',
                    'message' => 'Surat permohonan Anda berhasil dibuat dan diajukan.',
                ]);

                return $this->redirectRoute('pedagang.dashboard', navigate: true);
            } else {
                $this->dispatch('alert-show', data: [
                    'type' => 'danger',
                    'title' => 'Gagal Mengajukan Permohonan',
                    'message' => 'Terjadi kesalahan saat menyimpan data permohonan.',
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error saat submit permohonan', ['error' => $e->getMessage()]);
            $this->dispatch('alert-show', data: [
                'type' => 'danger',
                'title' => 'Gagal',
                'message' => 'Terjadi kesalahan sistem: '.$e->getMessage(),
            ]);
        }
    }

    public function render()
    {
        return view('mods.pedagang.ajukan-permohonan.ajukan-permohonan-create', [
            'pasars' => $this->pasars,
            'units' => $this->units,
        ]);
    }
}
