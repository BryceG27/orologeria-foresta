<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkingRequest;
use App\Models\Brand;
use App\Models\Customer;
use App\Models\PaymentMethod;
use App\Models\Working;
use App\Models\WorkingStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WorkingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Workings/Index', [
            'workings' => Working::with(['customer', 'brand', 'status'])->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Workings/Create', [
            'working' => new Working([
                'working_status_id' => 1,
                'working_id' => Working::max('working_id') + 1
            ]),
            'brands' => Brand::orderBy('name')->get(),
            'customers' => Customer::get_customers()->get(),
            'working_statuses' => WorkingStatus::all(),
            'payment_methods' => PaymentMethod::all(), 
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWorkingRequest $request)
    {
        dd($request->all());

        if(isset($request->customer_id))
            $customer = Customer::find($request->input('customer_id'));
        else
            $customer = Customer::create($request->input('customer'));

        // If the customer is a company, there could be one or more workings to be created
        if($customer->is_company) {
            foreach ($request->input('workings') as $working => $value) {
                $working_customer = Customer::findOrCreate($request->input('customer'));

                Working::create([
                    'customer_id' => $working_customer->id,
                    'company_id' => $customer->id,
                    'working_status_id' => $working->working_status_id,
                    'brand_id' => $working->brand_id,
                    'reference' => $working->reference,
                    'payment_method_id' => $working->payment_method_id,
                    'notes' => $working->notes,
                    'total_cost' => $working->total_cost,
                    'acceptance_date' => Carbon::create($working->acceptance_date)->timezone('Europe/Rome'),
                    'delivery_date' => $working->delivery_date ? Carbon::create($working->delivery_date)->timezone('Europe/Rome') : null,
                    'working_description' => $working->working_description,
                    'extra_notes' => $working->extra_notes
                ]);
            }
        } else {

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Working $working)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Working $working)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Working $working)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Working $working)
    {
        //
    }
}
