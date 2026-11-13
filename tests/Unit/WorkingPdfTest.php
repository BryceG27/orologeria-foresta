<?php

use App\Http\Controllers\WorkingController;
use App\Models\Brand;
use App\Models\Customer;
use App\Models\PaymentMethod;
use App\Models\Working;
use Barryvdh\DomPDF\Facade\Pdf;

uses(Tests\TestCase::class);

function workingPdfFixture(bool $withDetails): Working
{
    $working = new Working();
    $working->setRawAttributes([
        'id' => 12,
        'working_id' => 8279,
        'reference' => $withDetails ? 'MLJ336' : null,
        'acceptance_date' => $withDetails ? '2026-11-13 10:00:00' : null,
        'delivery_date' => null,
        'working_description' => $withDetails ? "Bracciale acciaio con pietre\nVerifica chiusura" : null,
        'extra_notes' => $withDetails ? 'Chiusura rotta <da verificare>' : null,
        'total_cost' => $withDetails ? '125.50' : null,
    ]);
    $working->setRelation('customer', $withDetails ? new Customer(['name' => 'Mario', 'surname' => 'Rossi', 'phone' => '091123456']) : null);
    $working->setRelation('company', $withDetails ? new Customer(['is_company' => true, 'company_name' => 'Gioielleria Test']) : null);
    $working->setRelation('brand', $withDetails ? new Brand(['name' => 'Liu Jo']) : null);
    $payment = new PaymentMethod();
    $payment->setRawAttributes(['name' => 'Contanti']);
    $working->setRelation('paymentMethod', $withDetails ? $payment : null);

    return $working;
}

it('renders the receipt on one portrait A5 page', function (bool $withDetails) {
    $pdf = Pdf::loadView('pdf.working', ['working' => workingPdfFixture($withDetails)])
        ->setPaper('a5', 'portrait');

    expect($pdf->output())->toStartWith('%PDF-');
    $canvas = $pdf->getDomPDF()->getCanvas();
    expect($canvas->get_page_count())->toBe(1)
        ->and(abs($canvas->get_width() - 419.53))->toBeLessThan(1)
        ->and(abs($canvas->get_height() - 595.28))->toBeLessThan(1);
})->with([true, false]);

it('opens the working receipt as an inline PDF', function () {
    $response = (new WorkingController())->show(workingPdfFixture(true));

    expect($response->headers->get('Content-Type'))->toBe('application/pdf')
        ->and($response->headers->get('Content-Disposition'))->toContain('inline;', 'lavorazione-12.pdf')
        ->and($response->getContent())->toStartWith('%PDF-');
});
