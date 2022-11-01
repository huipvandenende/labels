<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Spatie\PdfToImage\Exceptions\InvalidFormat;
use Spatie\PdfToImage\Exceptions\PdfDoesNotExist;
use Spatie\PdfToImage\Pdf as PdfToImage;

class LabelService
{
    /**
     * Convert PDF to PNG.
     *
     * @param $order
     * @return void
     * @throws InvalidFormat
     * @throws PdfDoesNotExist
     */
    public static function convertPdfToPng($order): void
    {
        $pdf = new PdfToImage(storage_path('app/labels/' . $order->id . '.pdf'));
        $pdf->setOutputFormat('png');
        $pdf->saveImage(storage_path('app/labels/' . $order->id . '.png'));
    }

    /**
     * Formats a packing slip for the given order.
     *
     * @param $order
     * @return Response
     */
    public static function downloadPackingSlip($order): \Illuminate\Http\Response
    {
        $order = $order->with('orderLines')->find($order->id);
        $image = base64_encode(Storage::get('labels/' . $order->id . '.png'));

        $pdf = Pdf::loadView('pdf.packing_slip', [
            'order' => $order,
            'image' => $image
        ]);

        return $pdf->download('packing_slip.pdf');
    }
}