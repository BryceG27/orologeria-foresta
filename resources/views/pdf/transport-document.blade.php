@extends('pdf.layout')
@section('title', 'Documento di trasporto '.$transportDocument->document_id)
@section('content')
    <div class="document-title">DOCUMENTO DI TRASPORTO</div>
    <table class="receipt-heading">
        <tr>
            <td class="email">orologeriaforesta@virgilio.it</td>
            <td class="receipt-label">DDT</td>
            <td class="receipt-number">{{ str_pad((string) $transportDocument->document_id, 5, '0', STR_PAD_LEFT) }}</td>
        </tr>
    </table>
    <table class="details">
        <tr>
            <td><div class="label">Destinatario / Officina</div><div class="value">{{ $transportDocument->workshop?->name }}</div></td>
            <td><div class="label">Data</div><div class="value">{{ $transportDocument->date ? \Carbon\Carbon::parse($transportDocument->date)->format('d/m/Y') : '' }}</div></td>
        </tr>
        <tr><td colspan="2"><div class="label">Indirizzo destinatario</div><div class="value">{{ $transportDocument->workshop?->address }}</div></td></tr>
        <tr>
            <td><div class="label">Telefono</div><div class="value">{{ $transportDocument->workshop?->phone }}</div></td>
            <td><div class="label">Email</div><div class="value">{{ $transportDocument->workshop?->email }}</div></td>
        </tr>
    </table>
    <table class="working-list">
        <thead>
            <tr>
                <th style="width: 12%">N° lav.</th>
                <th style="width: 25%">Cliente</th>
                <th style="width: 20%">Marca</th>
                <th>Referenza / Descrizione</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transportDocument->workings as $working)
                @php
                    $customer = $working->customer;
                    $customerName = $customer?->is_company ? $customer->company_name : trim(($customer?->name ?? '').' '.($customer?->surname ?? ''));
                @endphp
                <tr>
                    <td>{{ $working->working_id }}</td>
                    <td>{{ $customerName }}</td>
                    <td>{{ $working->brand?->name }}</td>
                    <td><strong>{{ $working->reference }}</strong><div class="item-description">{{ $working->working_description }}</div></td>
                </tr>
            @empty
                <tr><td colspan="4">Nessuna lavorazione associata.</td></tr>
            @endforelse
        </tbody>
    </table>
    <section class="text-box">
        <div class="label">Totale lavorazioni</div>
        <div class="value">{{ $transportDocument->workings->count() }}</div>
    </section>
    <section class="text-box notes">
        <div class="label">Note</div>
        <div class="written-text">{{ $transportDocument->notes }}</div>
        <div class="writing-line"></div>
        <div class="writing-line"></div>
    </section>
    <table class="payment signatures">
        <tr>
            <td><div class="label">Firma del mittente</div><div class="writing-line"></div></td>
            <td><div class="label">Firma del destinatario</div><div class="writing-line"></div></td>
        </tr>
    </table>
@endsection
