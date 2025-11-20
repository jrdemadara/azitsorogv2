<?php

namespace App\Http\Controllers;

use App\Models\DraftInvoice;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class InvoicePdfController extends Controller
{
    public function downloadPdf($id)
    {
        $invoice = DraftInvoice::with(['client', 'items'])->findOrFail($id);

        if ($invoice->status !== 'final') {
            abort(403, 'Only final invoices can be exported to PDF.');
        }

        $html = View::make('filament.resources.draft-invoice-resource.pages.print-invoice-pdf', [
            'record' => $invoice,
        ])->render();

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->stream("invoice-{$invoice->si_number}.pdf", [
            'Attachment' => true,
        ]);
    }
}
