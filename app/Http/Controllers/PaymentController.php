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
            'balance_due' => 'nullable|date'
        ]);

            $last_date = Carbon::now();

        // Check how many months the shop owner want's to pay for.
        if($request->duration === "3"){
            $nxt = Carbon::now()->addMonths(3);
        }elseif($request->duration === "6"){
            $nxt = Carbon::now()->addMonths(6);
        }elseif($request->duration === "12"){
            $nxt =  Carbon::now()->addMonths(12);

        }elseif($request->duration === "24"){
            $nxt = Carbon::now()->addMonths(24);
        }else{
            return back()->with(['error' => 'There is a problem with this request']);
        }


        $checkShop = Shop::where('id', $request->id)->first();
        if($checkShop !== null) {
            if ($checkShop->next_payment !== null) {
                $nxt = $checkShop->next_payment->addMonths((int)$request->duration);
            } else {
                $nxt = Carbon::now()->addMonths((int)$request->duration);
            }
        }else{
            return back()->with('error', 'Could not retrieve the shop. Please try again');
        }


        $lastPayment = Payment::where('shop_id', $request->id)->orderBy('id', 'desc')->first();
        $balance_brought_forward = 0;
        if($lastPayment == null){
            $balance_brought_forward = $request->balance;
        }else{
            $balance_brought_forward = (int)$lastPayment->bal_brought_fwd + (int)$request->balance;
        }


       $payment = Payment::create([
            'shop_id' => $request->id,
            'amount' => $request->amount,
            'paid' => $request->paid,
            'duration' => $request->duration,
            'last_payment' => $last_date,
            'balance' => $request->balance,
            'bal_brought_fwd' => $balance_brought_forward,
            'next_bal_payment' => $request->balance_due !== null ? Carbon::create($request->balance_due): NULL,
            'next_payment' => $nxt->copy()->subDay(),
        ]);
        // Update the shop table with latest payment
        $shop = Shop::where('id', $request->id)->update(['last_payment' => $last_date,
            'next_payment' => $nxt,
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
        if((int)$lastPayment->balance < (int)$request->amount){
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

        $payment->delete();

        return back()->with('success', 'Payment deleted successfully');
    }
}
