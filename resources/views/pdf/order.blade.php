@extends('pdf.layout')
@section('title', 'Ordine '.$order->id)
@section('content')
    @php
        $customer = $order->customer;
        $customerName = $customer?->is_company ? $customer->company_name : trim(($customer?->name ?? '').' '.($customer?->surname ?? ''));
        $money = fn ($amount) => $amount !== null ? '€ '.number_format((float) $amount, 2, ',', '.') : '';
    @endphp
    <table class="order-document">
        <tr class="order-heading">
            <td colspan="2" class="email">orologeriaforesta@virgilio.it</td>
            <td class="receipt-label">ORDINE</td>
            <td class="receipt-number">{{ str_pad((string) $order->id, 5, '0', STR_PAD_LEFT) }}</td>
        </tr>
        <tr>
            <td colspan="2"><div class="label">Cliente</div><div class="value">{{ $customerName }}</div></td>
            <td colspan="2"><div class="label">Data ordine</div><div class="value">{{ $order->order_date ? \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') : '' }}</div></td>
        </tr>
        <tr>
            <td colspan="2"><div class="label">Telefono</div><div class="value">{{ $customer?->phone }}</div></td>
            <td colspan="2"><div class="label">Email</div><div class="value">{{ $customer?->email }}</div></td>
        </tr>
        <tr>
            <td colspan="2"><div class="label">Marca</div><div class="value">{{ $order->brand?->name }}</div></td>
            <td colspan="2"><div class="label">Stato ordine</div><div class="value">{{ $order->status?->name }}</div></td>
        </tr>
        <tr>
            <td colspan="4" class="description">
                <div class="label">Descrizione del prodotto ordinato</div>
                <div class="written-text">{{ $order->description }}</div>
                <div class="writing-line"></div>
                <div class="writing-line"></div>
            </td>
        </tr>
        <tr>
            <td colspan="4" class="notes">
                <div class="label">Note</div>
                <div class="written-text">{{ $order->notes }}</div>
                <div class="writing-line"></div>
                <div class="writing-line"></div>
                <div class="writing-line"></div>
            </td>
        </tr>
        <tr>
            <td colspan="2"><div class="label">Stato pagamento</div><div class="value">{{ $order->payment_status?->name }}</div></td>
            <td><div class="label">Acconto</div><div class="value">{{ $money($order->downpayment) }}</div></td>
            <td><div class="label">Totale</div><div class="value">{{ $money($order->total) }}</div></td>
        </tr>
    </table>
@endsection
