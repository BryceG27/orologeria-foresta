<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Ricevuta lavorazione {{ $working->working_id }}</title>
    <style>{!! file_get_contents(resource_path('css/pdf.css')) !!}</style>
</head>
<body>
    @php
        $customer = $working->customer;
        $customerName = $customer?->is_company
            ? $customer->company_name
            : trim(($customer?->name ?? '').' '.($customer?->surname ?? ''));
        $formatDate = fn ($date) => $date ? \Carbon\Carbon::parse($date)->timezone('Europe/Rome')->format('d/m/Y') : '';
        $interventions = [
            ['Revisione', 'Sostituzione vetro'],
            ['Pronto intervento', 'Sostituzione bracciale'],
            ['Sostituzione movimento', 'Sostituzione cinturino'],
            ['Sostituzione circuito', 'Sostituzione cassa'],
            ['Sostituzione pila', 'Test d’impermeabilità'],
            ['Sostituzione quadrante', 'Sostituzione guarnizioni'],
            ['Sostituzione sfere', 'Lucidatura'],
            ['Sostituzione corona', 'Sostituzione chiusura'],
            ['Sostituzione corona suoneria', '________________________'],
            ['Sostituzione pulsanti', '________________________'],
        ];
    @endphp

    {{-- Colonna riservata ai loghi dei marchi, da inserire successivamente. --}}
    <aside class="brand-logos"></aside>

    <main>
        @include('pdf.partials.header')

        <table class="receipt-heading">
            <tr>
                <td class="email">orologeriaforesta@virgilio.it</td>
                <td class="receipt-label">RICEVUTA</td>
                <td class="receipt-number">{{ str_pad((string) $working->working_id, 5, '0', STR_PAD_LEFT) }}</td>
            </tr>
        </table>

        <table class="details">
            <colgroup><col style="width: 50%"><col style="width: 16%"><col style="width: 34%"></colgroup>
            <tr>
                <td colspan="2">
                    <div class="label">Il Sig.</div>
                    <div class="value">{{ $customerName }}</div>
                    @if ($working->company)
                        <div class="company">Gioielleria: {{ $working->company->company_name }}</div>
                    @endif
                </td>
                <td><div class="label">In data</div><div class="value">{{ $formatDate($working->acceptance_date) }}</div></td>
            </tr>
            <tr>
                <td><div class="label">Tel.</div><div class="value">{{ $customer?->phone }}</div></td>
                <td class="warranty"><span class="checkbox"></span><div>In Garanzia</div></td>
                <td><div class="label">Ritiro</div><div class="value">{{ $formatDate($working->delivery_date) }}</div></td>
            </tr>
            <tr>
                <td><div class="label">Marca</div><div class="value">{{ $working->brand?->name }}</div></td>
                <td colspan="2"><div class="label">N° Cassa / Referenza</div><div class="value">{{ $working->reference }}</div></td>
            </tr>
        </table>

        <section class="text-box description">
            <div class="label">Descrizione</div>
            <div class="written-text">{{ $working->working_description }}</div>
            <div class="writing-line"></div>
            <div class="writing-line"></div>
        </section>

        <section class="interventions">
            <table>
                @foreach ($interventions as [$left, $right])
                    <tr>
                        <td><span class="checkbox"></span>{{ $left }}</td>
                        <td><span class="checkbox"></span>{{ $right }}</td>
                    </tr>
                @endforeach
            </table>
        </section>

        <section class="text-box notes">
            <div class="label">Note</div>
            <div class="written-text">{{ $working->extra_notes }}</div>
            <div class="writing-line"></div>
            <div class="writing-line"></div>
            <div class="writing-line"></div>
        </section>

        <table class="payment">
            <tr>
                <td><div class="label">Modalità di pagamento</div><div class="value">{{ $working->paymentMethod?->name }}</div></td>
                <td class="total"><div class="label">Totale</div><div class="value">{{ $working->total_cost !== null ? '€ '.number_format((float) $working->total_cost, 2, ',', '.') : '' }}</div></td>
            </tr>
        </table>
    </main>
</body>
</html>
