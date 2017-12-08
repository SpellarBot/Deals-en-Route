<?php

namespace App\Http\Services;

use URL;
use PDF;
use Illuminate\Support\Facades\Storage;

trait PdfTrait {

    public function generateInvoice($data) {
        view()->share('details', $data);
        $pdf = PDF::loadView('htmltopdfview');
        $filename = time() . '_Invoice.pdf';
        Storage::put('/pdf/' . $filename, $pdf->output());
        return $filename;
    }

}
