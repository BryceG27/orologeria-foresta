<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\PaymentOrderStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Orders/Index', [
            'brands' => Brand::orderBy('name')->get(),
            'orders' => Order::with(['customer' => function($query) {
                                    $query->select('id', 'name', 'surname', DB::raw('CONCAT(name, " ", surname) as description'));
                                }, 'status', 'payment_status', 'brand'])
                                ->orderBy('id', 'desc')
                                ->get(),
            'statuses' => OrderStatus::all(),
            'payment_statuses' => PaymentOrderStatus::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Orders/Create', [
            'brands' => Brand::orderBy('name')->get(),
            'customers' => Customer::get_customers()->where('is_company', false)->get(),
            'statuses' => OrderStatus::all(),
            'payment_order_statuses' => PaymentOrderStatus::all(),
            'order' => new Order(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = Order::validate($request);

        if(isset($data['customer']['name'])) {
            $customer = Customer::where(DB::raw('LOWER(name)'), strtolower($data['customer']['name']))
                                ->where(DB::raw('LOWER(surname)'), strtolower($data['customer']['surname']))
                                ->first();

            if(!$customer) {
                $customer = Customer::create([
                    'name' => $data['customer']['name'],
                    'surname' => $data['customer']['surname'],
                    'email' => $data['customer']['email'] ?? null,
                    'phone' => $data['customer']['phone'] ?? null,
                ]);
            }
        } else {
            $customer = Customer::find($data['customer_id']);
        }

        dd($data);

        $data['order_date'] = Carbon::create($data['order_date'])->setTimezone('Europe/Rome');

        $customer->orders()->create($data);
        
        return redirect()->route('orders.index')->with('success', 'Ordine creato correttamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        return Inertia::render('Orders/Edit', [
            'brands' => Brand::orderBy('name')->get(),
            'customers' => Customer::get_customers()->where('is_company', false)->get(),
            'statuses' => OrderStatus::all(),
            'payment_order_statuses' => PaymentOrderStatus::all(),
            'order' => $order
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $data = Order::validate($request);

        $data['order_date'] = Carbon::create($data['order_date'])->setTimezone('Europe/Rome');

        $order->update($data);

        return redirect()->route('orders.index')->with('success', 'Ordine aggiornato correttamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index');
    }
}
