<?php

namespace App\Exports;

use App\Models\Warga;
use Illuminate\Support\Facades\View;
use Mpdf\Mpdf;

class WargaExportPDF
{
    public function exportPdf()
    {
        $wargas = Warga::with('rt')->get();

        $html = view('exports.warga_pdf', compact('wargas'))->render();

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        $timestamp = now()->format('Y-m-d_H-i-s');
        $filename = "daftar_warga_{$timestamp}.pdf";

        return $mpdf->Output($filename, 'D');
    }
}
