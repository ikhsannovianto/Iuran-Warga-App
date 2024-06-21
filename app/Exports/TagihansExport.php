<?php

namespace App\Exports;

use App\Models\Tagihan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TagihansExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Ambil data tagihan dengan relasi warga dan rt
        return Tagihan::with(['warga', 'warga.rt', 'pembayarans'])
            ->get()
            ->map(function ($tagihan) {
                $jumlahTagihan = $tagihan->jumlah_tagihan;
                $totalPembayaran = $tagihan->pembayarans->sum('jumlah_dibayar');
                $belumTerbayar = max(0, $jumlahTagihan - $totalPembayaran);
                $status = ($totalPembayaran >= $jumlahTagihan) ? 'Lunas' : 'Belum Lunas';

                return [
                    'No' => $tagihan->id,
                    'Nama Warga' => $tagihan->warga->nama,
                    'RT' => $tagihan->warga->rt->nama_rt,
                    'Tagihan untuk Bulan' => date('F', mktime(0, 0, 0, $tagihan->bulan, 1)),
                    'Tahun' => $tagihan->tahun,
                    'Jumlah Tagihan' => $jumlahTagihan,
                    'Total Terbayar' => $totalPembayaran,
                    'Belum Terbayar' => $belumTerbayar,
                    'Status' => $status,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Warga',
            'RT',
            'Tagihan untuk Bulan',
            'Tahun',
            'Jumlah Tagihan',
            'Total Terbayar',
            'Belum Terbayar',
            'Status'
        ];
    }
}