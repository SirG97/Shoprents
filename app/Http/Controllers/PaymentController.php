<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Shop;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::with(['shop'])->paginate(50);
        return view('payments', ['payments' => $payments]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

        $request->validate([
            'id' => 'required|numeric',
            'amount' => 'required|numeric',
            'duration' => 'required|numeric',
        ]);
        if($request->date !== null){
            $date = Carbon::create($request->date);
            $last_date = Carbon::create($request->date);
        }else{
            $last_date = Carbon::now();
        }

        if($request->duration === "3"){
            $nxt = $request->date !== null ? $date->addMonths(3) : Carbon::now()->addMonths(3);
        }elseif($request->duration === "6"){
            $nxt = $request->date !== null ? $date->addMonths(6) : Carbon::now()->addMonths(6);
        }elseif($request->duration === "12"){
            $nxt = $request->date !== null ? $date->addMonths(12) : Carbon::now()->addMonths(12);

        }elseif($request->duration === "24"){
            $nxt = $request->date !== null ? $date->addMonths(24) : Carbon::now()->addMonths(24);
        }else{
            return back()->with(['error' => 'There is a problem with this request']);
        }

        $checkShop = Shop::where('id', $request->id)->first();
        if($checkShop !== null) {
            if ($checkShop->next_payment !== null) {
                if($request->date !== null){
                    $nxt = Carbon::create($checkShop->next_payment)->addMonths((int)$request->duration);
                }else{
                    $nxt = Carbon::now()->addMonths((int)$request->duration);
                }


            }
        }

       $payment = Payment::create([
            'shop_id' => $request->id,
            'amount' => $request->amount,
            'duration' => $request->duration,
            'last_payment' => $last_date,
            'next_payment' => $nxt,
        ]);

        $shop = Shop::where('id', $request->id)->update(['last_payment' => $last_date,
            'next_payment' => $nxt]);
//        dd($payment, $shop);
        return back()->with(['success' => 'Payment noted successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment){

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
