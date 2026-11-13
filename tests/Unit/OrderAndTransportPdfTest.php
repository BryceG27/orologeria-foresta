<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\TransportDocumentController;
use App\Models\Brand;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\PaymentOrderStatus;
use App\Models\TransportDocument;
use App\Models\Working;
use App\Models\Workshop;
use Barryvdh\DomPDF\Facade\Pdf;

uses(Tests\TestCase::class);

function orderPdfFixture(bool $withDetails): Order
{
    $order = new Order();
    $order->setRawAttributes([
        'id' => 42, 'order_date' => $withDetails ? '2026-11-13' : null,
        'description' => $withDetails ? 'Cinturino in pelle <blu>' : null,
        'notes' => $withDetails ? 'Contattare il cliente prima della consegna.' : null,
        'downpayment' => $withDetails ? '25.00' : null, 'total' => $withDetails ? '80.50' : null,
    ]);
    $order->setRelation('customer', $withDetails ? new Customer(['name' => 'Mario', 'surname' => 'Rossi', 'phone' => '091123456', 'email' => 'mario@example.com']) : null);
    $order->setRelation('brand', $withDetails ? new Brand(['name' => 'Liu Jo']) : null);
    foreach (['status' => OrderStatus::class, 'payment_status' => PaymentOrderStatus::class] as $relation => $modelClass) {
        $model = new $modelClass();
        $model->setRawAttributes(['name' => $relation === 'status' ? 'In corso' : 'Acconto versato']);
        $order->setRelation($relation, $withDetails ? $model : null);
    }

    return $order;
}

function transportPdfFixture(int $count): TransportDocument
{
    $document = new TransportDocument();
    $document->setRawAttributes(['id' => 7, 'document_id' => 123, 'date' => '2026-11-13', 'notes' => 'Verificare le chiusure.']);
    $document->setRelation('workshop', $count ? new Workshop(['name' => 'Laboratorio Test', 'address' => 'Via Roma 10, Palermo', 'phone' => '091123456', 'email' => 'officina@example.com']) : null);
    $workings = collect();
    for ($i = 1; $i <= $count; $i++) {
        $working = new Working(['working_id' => 8000 + $i, 'reference' => 'REF-'.$i, 'working_description' => 'Revisione movimento e verifica chiusura']);
        $working->setRelation('customer', $i % 2 ? new Customer(['name' => 'Mario', 'surname' => 'Rossi']) : null);
        $working->setRelation('brand', $i % 2 ? new Brand(['name' => 'Liu Jo']) : null);
        $workings->push($working);
    }
    $document->setRelation('workings', $workings);

    return $document;
}

it('renders an order on one A5 page with optional data', function (bool $withDetails) {
    $order = orderPdfFixture($withDetails);
    $pdf = Pdf::loadView('pdf.order', compact('order'))->setPaper('a5', 'portrait');
    expect($pdf->output())->toStartWith('%PDF-');
    $canvas = $pdf->getDomPDF()->getCanvas();
    expect($canvas->get_page_count())->toBe(1)
        ->and(abs($canvas->get_width() - 419.53))->toBeLessThan(1)
        ->and(abs($canvas->get_height() - 595.28))->toBeLessThan(1);
    if ($withDetails) {
        expect(view('pdf.order', compact('order'))->render())->toContain('€ 25,00', '€ 80,50', 'Cinturino in pelle &lt;blu&gt;');
    }
})->with([true, false]);

it('renders small transport documents on one A5 page', function (int $count) {
    $transportDocument = transportPdfFixture($count);
    $pdf = Pdf::loadView('pdf.transport-document', compact('transportDocument'))->setPaper('a5', 'portrait');
    expect($pdf->output())->toStartWith('%PDF-');
    $canvas = $pdf->getDomPDF()->getCanvas();
    expect($canvas->get_page_count())->toBe(1)
        ->and(abs($canvas->get_width() - 419.53))->toBeLessThan(1)
        ->and(abs($canvas->get_height() - 595.28))->toBeLessThan(1);
})->with([0, 3]);

it('paginates long transport documents while retaining the last working', function () {
    $transportDocument = transportPdfFixture(60);
    $pdf = Pdf::loadView('pdf.transport-document', compact('transportDocument'))->setPaper('a5', 'portrait');
    $pdf->output();
    expect($pdf->getDomPDF()->getCanvas()->get_page_count())->toBeGreaterThan(1);
    expect(view('pdf.transport-document', compact('transportDocument'))->render())->toContain('8060', 'REF-60');
});

it('serves orders and transport documents as inline PDFs', function () {
    $responses = [
        [(new OrderController())->show(orderPdfFixture(true)), 'ordine-42.pdf'],
        [(new TransportDocumentController())->show(transportPdfFixture(3)), 'ddt-7.pdf'],
    ];
    foreach ($responses as [$response, $filename]) {
        expect($response->headers->get('Content-Type'))->toBe('application/pdf')
            ->and($response->headers->get('Content-Disposition'))->toContain('inline;', $filename)
            ->and($response->getContent())->toStartWith('%PDF-');
    }
});
