<?php

namespace App\Http\Controllers;

use App\Models\DataPermohonan;
use App\Models\User;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermohonanController extends Controller
{
    /**
     * Download Draf Surat Permohonan dalam format PDF
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
            'isLengkap' => ($permohonan->status === 'lengkap' || $permohonan->status === 'disetujui' || $permohonan->status === 'selesai'),
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
}
