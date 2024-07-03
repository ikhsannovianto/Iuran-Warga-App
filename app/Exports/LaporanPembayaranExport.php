<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LaporanPembayaranExport implements WithMultipleSheets
{
    protected $totalPendapatan;
    protected $pendapatanPerBulan;
    protected $pembayaranPerMetode;
    protected $totalPembayaranPerRT;

    public function __construct($totalPendapatan, $pendapatanPerBulan, $pembayaranPerMetode, $totalPembayaranPerRT)
    {
        $this->totalPendapatan = $totalPendapatan;
        $this->pendapatanPerBulan = $pendapatanPerBulan;
        $this->pembayaranPerMetode = $pembayaranPerMetode;
        $this->totalPembayaranPerRT = $totalPembayaranPerRT;
    }

    public function sheets(): array
    {
        return [
            new TotalPendapatanSheet($this->totalPendapatan),
            new PendapatanPerMetodeSheet($this->pembayaranPerMetode),
            new PendapatanPerBulanSheet($this->pendapatanPerBulan),
            new PendapatanPerRTSheet($this->totalPembayaranPerRT),
        ];
    }
}
