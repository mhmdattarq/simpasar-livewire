<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\PermohonanRepo;
use Yajra\DataTables\Facades\DataTables;

class PermohonanAdminController extends Controller
{
    public function dataDt()
    {
        $data = PermohonanRepo::getAdminDt();

        return DataTables::of($data)
            ->editColumn('keterangan', function ($row) {
                if (! empty($row->keterangan) && $row->keterangan !== '-') {
                    return $row->keterangan;
                }

                return match ($row->status) {
                    'lengkap' => 'Dokumen Berhasil Terkirim, Silahkan tunggu persetujuan dari Admin!',
                    'disetujui' => 'Surat permohonan telah disetujui, Belum Terverifikasi!',
                    'verifikasi' => 'Surat Pernyataan menjadi pedagang berhasil di unggah, Silahkan tunggu verifikasi dari Admin!',
                    'selesai' => 'Permohonan telah diverifikasi dan selesai',
                    default => $row->keterangan ?? '-',
                };
            })
            ->toJson();
    }
}
