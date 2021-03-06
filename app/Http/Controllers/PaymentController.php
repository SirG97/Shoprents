<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Shop;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
            'paid' => 'required|numeric',
            'duration' => 'required|numeric',
            'balance' => 'nullable|numeric',
            'date' => 'nullable|date',
            'balance_due' => 'nullable|date'
        ]);
        // Check if a last date was provided so we can work with it or else, we assume the payment date is today
        if($request->date !== null){
            $date = Carbon::create($request->date);
            $last_date = Carbon::create($request->date);

        }else{
            $last_date = Carbon::today();
        }

        // Check how many months is being paid for and set the next date of payment with it
        if($request->duration === "3"){
            $nxt = $request->date !== null ? $date->addMonths(3) : Carbon::today()->addMonths(3);
        }elseif($request->duration === "6"){
            $nxt = $request->date !== null ? $date->addMonths(6) : Carbon::today()->addMonths(6);
        }elseif($request->duration === "12"){
            $nxt = $request->date !== null ? $date->addMonths(12) : Carbon::today()->addMonths(12);

        }elseif($request->duration === "24"){
            $nxt = $request->date !== null ? $date->addMonths(24) : Carbon::today()->addMonths(24);
        }else{
            return back()->with(['error' => 'There is a problem with this request']);
        }

        // Get the shop whoose payment is about to be made
        $checkShop = Shop::where('id', $request->id)->first();
        if($checkShop !== null) {
            if ($checkShop->next_payment !== null) {
                if($request->date !== null){
//                    if(Carbon::parse($request->date) > Carbon::parse($checkShop->next_payment)){
                        $nxt = Carbon::parse($request->date)->addMonths((int)$request->duration);
//                        dd('Request date is bigger');
//                    }else{
////                        dd('Request date is smaller');
//                        $nxt = Carbon::parse($checkShop->next_payment)->addMonths((int)$request->duration);
//                    }

//                    dd($checkShop->next_payment, $nxt);
                }else{
                    $nxt = Carbon::today()->addMonths((int)$request->duration);
                }
            }
        }


        $lastPayment = Payment::where('shop_id', $request->id)->orderBy('id', 'desc')->first();
        $balance_brought_forward = 0;
        if($lastPayment == null){
            $balance_brought_forward = $request->balance;
        }else{
            $balance_brought_forward = (int)$lastPayment->bal_brought_fwd + (int)$request->balance;
        }

        $nxt_pay = $nxt->copy()->subDay();
       $payment = Payment::create([
            'shop_id' => $request->id,
            'amount' => $request->amount,
            'paid' => $request->paid,
            'duration' => $request->duration,
            'last_payment' => $last_date,
            'balance' => $request->balance,
            'bal_brought_fwd' => $balance_brought_forward,
            'next_bal_payment' => $request->balance_due !== null ? Carbon::create($request->balance_due): NULL,
            'next_payment' => $nxt_pay,
//            'next_payment' => $nxt->copy()->subDay(),
        ]);
        // Update the shop table with latest payment
        $shop = Shop::where('id', $request->id)->update(['last_payment' => $last_date,
            'next_payment' => $nxt_pay,
//            'next_payment' => $nxt->copy()->subDay(),
            'is_owing_bal' => $balance_brought_forward == 0 ? false : true,
            'next_bal_payment' => $request->balance_due !== null ? Carbon::create($request->balance_due): NULL,
            ]);
//        dd($payment, $shop);
        return back()->with(['success' => 'Rent paid successfully']);
    }

    public function payBalance(Request $request){
        $lastPayment = Payment::where([['shop_id', '=', $request->id]])->orderBy('id', 'desc')->first();

        if($lastPayment == null){
            return back()->with('error', 'Could not retrieve last payment with owned balance');
        }

        if($lastPayment->bal_brought_fwd < 1){
            return back()->with('error', 'You have no balance to be paid');
        }
        if($request->amount > $lastPayment->bal_brought_fwd ){
            return back()->with('error', 'The amount about to be deposited is more than the balance. Pay off balance and make a new payment');
        }

        $request->validate([
            'id' => 'required|numeric',
            'amount' => 'required|numeric',
            'balance_due_by' =>  'nullable|date',

        ]);



        $last_date =  Carbon::now();
        $nxt = $request->balance_due_by !== null ? Carbon::create($request->balance_due_by): NULL;
        $payment = Payment::create([
            'shop_id' => $request->id,
            'paid' => $request->amount,
//            '' => $request->amount,
            'duration' => 0,
            'last_bal_payment' => $last_date,
            'balance' => 0,
            'bal_brought_fwd' => (int)$lastPayment->bal_brought_fwd - (int)$request->amount,
            'next_bal_payment' => $nxt,
        ]);
        // Check if the whole balance has been paid so as to set the balance owed flag to false
        if((int)$lastPayment->bal_brought_fwd <= (int)$request->amount){
            $balance_status = false;
        }else{
            $balance_status = true;
        }
        // Update the shop
        $shop = Shop::where('id', $request->id)->update(['last_bal_payment' => $last_date,
            'next_bal_payment' => $nxt, 'is_owing_bal' => $balance_status]);
//        dd($payment, $shop);
        return back()->with(['success' => 'Balance paid successfully']);

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
    public function delete(Payment $payment)
    {

        if(!$payment or $payment == null){
            return back()->with('error', 'An error occurred while deleting this payment, please try again');
        }
        //Get the shop whose payment is about to be delivered
        $del_id = $payment->shop_id;
        $shop =  Shop::where('id', $payment->shop_id)->first();
        //Delete the payment
        $payment->delete();
        //Get the last payment of this shop
        $lastPayment = Payment::where([['shop_id', '=', $shop->id],['duration', '!=', 0]])->orderBy('id', 'desc')->first();
        $lastBalPaid = Payment::where([['shop_id', '=', $shop->id],['duration', '=', 0]])->orderBy('id', 'desc')->first();

//        dd($lastPayment, $lastBalPaid);
        if($lastPayment == null){
            $shop->update([
                'next_payment' => NULL,
                'last_payment' => NULL,
//                'is_owing_bal' =>
            ]);

        }else{
            $shop->update([
                'next_payment' => $lastPayment->next_payment,
                'last_payment' => $lastPayment->last_payment,
                'is_owing_bal' => $lastPayment->bal_brought_fwd > 0 ? true : false,
            ]);
        }

        if($lastBalPaid == null){
            $shop->update([
                'next_bal_payment' => NULL,
                'last_bal_payment' => NULL,
            ]);


        }else{
            $shop->update([
                'next_bal_payment' => $lastBalPaid->next_bal_payment,
                'last_bal_payment' => $lastBalPaid->last_bal_payment,
                'is_owing_bal' => $lastBalPaid->bal_brought_fwd > 0 ? true : false,
            ]);
        }


        return back()->with('success', 'Payment deleted successfully');
    }
}
