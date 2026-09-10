<?php

namespace App\Http\Controllers;

use App\Models\DataPermohonan;
use App\Models\User;
use App\Repositories\PermohonanRepo;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermohonanController extends Controller
{
    /**
     * Download Draf / Surat Permohonan dalam format PDF
     */
    public function downloadDraft(Request $request, int $id)
    {
        /** @var User $user */
        $user = Auth::user();

        $permohonan = DataPermohonan::with('pasar')
            ->when(! $user->isAdmin(), fn ($q) => $q->where('user_id', $user->id))
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

        $html = view('templates.pdf.surat-permohonan', [
            'pedagang' => $pedagangData,
            'isLengkap' => ($permohonan->status === 'lengkap' || $permohonan->status === 'disetujui' || $permohonan->status === 'verifikasi' || $permohonan->status === 'selesai'),
        ])->render();

        $options = new Options;
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Times-Roman');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'Draf_Surat_Permohonan_'.preg_replace('/[^A-Za-z0-9_\-]/', '_', $permohonan->nama).'.pdf';

        return response()->streamDownload(
            fn () => print ($dompdf->output()),
            $filename,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="'.$filename.'"',
            ]
        );
    }

    /**
     * Download Surat Pemberitahuan dalam format PDF
     */
    public function downloadPemberitahuan(Request $request, int $id)
    {
        /** @var User $user */
        $user = Auth::user();

        $permohonan = DataPermohonan::with('pasar')
            ->when(! $user->isAdmin(), fn ($q) => $q->where('user_id', $user->id))
            ->findOrFail($id);

        $logoPath = public_path('backend/assets/images/logo_kota_dumai.png');
        $ceklistPath = public_path('backend/assets/images/ceklist.png');
        $ceklistKosongPath = public_path('backend/assets/images/ceklist_kosong.png');

        $data = [
            'permohonan' => $permohonan,
            'tanggal_permohonan' => Carbon::parse($permohonan->created_at)->locale('id')->translatedFormat('d F Y'),
            'tanggal' => now()->locale('id')->translatedFormat('d F Y'),
            'logo_src' => file_exists($logoPath) ? 'data:image/png;base64,'.base64_encode(file_get_contents($logoPath)) : '',
            'ceklist_src' => file_exists($ceklistPath) ? 'data:image/png;base64,'.base64_encode(file_get_contents($ceklistPath)) : '',
            'ceklist_kosong_src' => file_exists($ceklistKosongPath) ? 'data:image/png;base64,'.base64_encode(file_get_contents($ceklistKosongPath)) : '',
        ];

        $html = view('templates.pdf.surat-pemberitahuan', $data)->render();

        $options = new Options;
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('chroot', [public_path(), base_path()]);
        $options->set('defaultFont', 'Times-Roman');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'Surat_Pemberitahuan_'.preg_replace('/[^A-Za-z0-9_\-]/', '_', $permohonan->nama).'.pdf';

        return response()->streamDownload(
            fn () => print ($dompdf->output()),
            $filename,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="'.$filename.'"',
            ]
        );
    }

    /**
     * Download Surat Pernyataan dalam format PDF
     */
    public function downloadPernyataan(Request $request, int $id)
    {
        /** @var User $user */
        $user = Auth::user();

        $permohonan = DataPermohonan::with('pasar')
            ->when(! $user->isAdmin(), fn ($q) => $q->where('user_id', $user->id))
            ->findOrFail($id);

        $tempatData = PermohonanRepo::getTempatDataByNik($permohonan->nik);

        if ($tempatData['kios']['count'] === 0 && $tempatData['los']['total'] == 0 && $tempatData['pelataran']['total'] == 0) {
            $namaPasar = $permohonan->pasar?->nama_pasar ?? '-';
            if ($permohonan->tipe_tempat === 'kios') {
                $tempatData['kios']['count'] = 1;
                $tempatData['kios']['locations'] = "{$permohonan->nomor_tempat}, {$permohonan->lokasi}, {$namaPasar}";
            } elseif ($permohonan->tipe_tempat === 'los') {
                $tempatData['los']['total'] = (float) $permohonan->luas;
                $tempatData['los']['locations'] = "{$permohonan->nomor_tempat}, {$permohonan->lokasi}, {$namaPasar}";
            } elseif ($permohonan->tipe_tempat === 'pelataran') {
                $tempatData['pelataran']['total'] = (float) $permohonan->luas;
                $tempatData['pelataran']['locations'] = "{$permohonan->nomor_tempat}, {$permohonan->lokasi}, {$namaPasar}";
            }
        }

        $data = [
            'permohonan' => $permohonan,
            'tanggal' => now()->locale('id')->translatedFormat('d F Y'),
            'kios' => $tempatData['kios'],
            'los' => $tempatData['los'],
            'pelataran' => $tempatData['pelataran'],
        ];

        $html = view('templates.pdf.surat-pernyataan', $data)->render();

        $options = new Options;
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Times-Roman');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'Surat_Pernyataan_'.preg_replace('/[^A-Za-z0-9_\-]/', '_', $permohonan->nama).'.pdf';

        return response()->streamDownload(
            fn () => print ($dompdf->output()),
            $filename,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="'.$filename.'"',
            ]
        );
    }
}
