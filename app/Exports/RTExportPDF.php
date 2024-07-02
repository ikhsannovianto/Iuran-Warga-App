<?php

namespace App\Exports;

use App\Models\RT;
use Illuminate\Support\Facades\View;
use Mpdf\Mpdf;

class RTExportPdf
{
    public function exportPdf()
    {
        $rts = RT::all();

        $data = [
            'rts' => $rts,
        ];

        $html = View::make('exports.rts_pdf', $data)->render();

        $mpdf = new Mpdf([
            'tempDir' => storage_path('temp'),
            'format' => 'A4-L',
            'orientation' => 'L',
        ]);

        $mpdf->WriteHTML($html);

        $mpdf->Output('rts.pdf', 'D');
    }
}
