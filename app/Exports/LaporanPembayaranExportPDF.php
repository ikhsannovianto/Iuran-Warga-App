<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use PDF;

class LaporanPembayaranExportPDF implements FromView
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('exports.laporan_pembayaran_pdf', [
            'data' => $this->data,
        ]);
    }
}
