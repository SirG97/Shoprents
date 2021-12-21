<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Plaza;
use App\Models\Shop;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PlazaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(){
        $plazas = Plaza::withCount('shops')->with(['shops' => function($query){

        }])->paginate(25);

        return view('plazas', ['plazas' => $plazas]);
    }

    /**
     * Show the form for creating a new resource.o
     *
     * @return Response
     */
    public function create()
    {
        return view('newplaza');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'address' => 'required',
//            'duration' => Rule::requiredIf($request->amount !== null),
//            'amount' => 'numeric|' . Rule::requiredIf($request->duration !== null),

        ]);

        $plaza = Plaza::create([
            'name' => $request->name,

            'address' => $request->address,
        ]);
        return redirect('/plazas')->with(['success' => 'Plaza created successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param Plaza $plaza
     * @return Response
     */
    public function show(Plaza $plaza){
        $shops = Shop::where('plaza_id', $plaza->id)->with(['plaza','latestPayment'])->orderBy('shop_number', 'asc')->paginate(100);
        // Paid Shop
        $paid_almost = Shop::where([['plaza_id', '=', $plaza->id],['next_payment', '>', Carbon::now()->addMonth()],['next_payment', '>', Carbon::now()],
            ['vacant_status', '=', '0']])->with(['plaza','payments' => function($query){
                $query->where('next_payment', '>', Carbon::now());
        }])->orderBy('shop_number', 'asc')->paginate(50);
        $amount =  0;
        foreach($paid_almost as $shop){
            foreach ($shop->payments as $payment){
                $amount += (float)$payment->amount;
            }

        }
//        dd($shops[0]['latestPayment']['amount']);
        return view('plaza', ['plaza' => $plaza, 'shops' => $shops, 'amount' => $amount]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Plaza $plaza
     * @return Response
     */
    public function paidPlaza(Plaza $plaza)
    {
        $shops = Shop::where([['plaza_id', '=', $plaza->id],['next_payment', '>', Carbon::now()->addMonth()],
            ['vacant_status', '=', '0']])->with(['plaza','latestPayment'])->orderBy('shop_number', 'asc')->paginate(50);
        $amount =  0;
        foreach($shops as $shop){
            $amount += (float)$shop->latestPayment->amount;
        }
        return view('paidplaza',['shops' => $shops, 'amount' => $amount, 'plaza' => $plaza]);
    }

        public function vacantPlaza(Plaza $plaza){
            $shops = Shop::where([['plaza_id', '=', $plaza->id], ['vacant_status', '=', '1']])->with(['plaza','latestPayment'])->orderBy('shop_number', 'asc')->paginate(50);

            return view('vacant',['shops' => $shops, 'plaza' => $plaza]);
        }

    public function almostDuePlaza(Plaza $plaza){
        $shops = Shop::where([['plaza_id', '=', $plaza->id],['next_payment', '<', Carbon::now()->addMonth()], ['next_payment', '>', Carbon::now()],
            ['vacant_status', '=', '0']])->with(['plaza','latestPayment'])->orderBy('shop_number', 'asc')->paginate(50);
        $amount =  0;
        foreach($shops as $shop){
            $amount += (float)$shop->latestPayment->amount;
        }
        return view('almostdueplaza',['shops' => $shops, 'amount' => $amount, 'plaza' => $plaza]);
    }

    public function expiredPlaza(Plaza $plaza){
        $shops = Shop::where([['plaza_id', '=', $plaza->id],['next_payment', '<', Carbon::now()],
            ['vacant_status', '=', '0']])->with(['plaza','latestPayment'])->orderBy('shop_number', 'asc')->paginate(50);
        $amount =  0;
        foreach($shops as $shop){
            $amount += (float)$shop->latestPayment->amount;
        }
        return view('expiredplaza',['shops' => $shops, 'amount' => $amount, 'plaza' => $plaza]);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shop  $plaza
     * @return Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'address' => 'required',
        ]);

        Plaza::where('id', $request->id)->update([
           'name' => $request->name,
           'address' => $request->address,
        ]);

        return back()->with('success', 'Plaza updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shop  $shop
     * @return Response
     */
    public function destroy(Shop $shop)
    {
        //
    }
}
