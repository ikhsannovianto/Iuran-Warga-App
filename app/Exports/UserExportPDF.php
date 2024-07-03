<?php

namespace App\Exports;

use App\Models\User;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\View;

class UserExportPdf
{
    public function export()
    {
        $users = User::all();

        $html = View::make('exports.user_pdf', compact('users'))->render();

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('DataUserIuranWargaApps.pdf', 'D');
    }
}
