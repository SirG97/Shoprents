<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Shop;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ShopController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $shops = Shop::orderBy('id', 'desc')->paginate(100);
        return view('shops',['shops' => $shops]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('newshop');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required',
//            'duration' => Rule::requiredIf($request->amount !== null),
//            'amount' => 'numeric|' . Rule::requiredIf($request->duration !== null),

        ]);

        $shop = Shop::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);
        return redirect('/shop/'. $shop->id)->with(['success' => 'Shop created successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function show(Shop $shop){

        $payments = Payment::where('shop_id', $shop->id)->orderBy('id', 'desc')->paginate(100);
//dd($shop, $payments);

        return view('shop',['shop' => $shop, 'payments' => $payments]);
    }

    public function expired(){
        $shops = Shop::where('next_payment', '<', Carbon::now())->orderBy('id', 'desc')->paginate(100);
        return view('expiredshops',['shops' => $shops]);
    }
    public function almostDue(){
//        $shops = Shop::where('next_payment', '<', Carbon::now()->subMonth())->orderBy('id', 'desc')->paginate(100);
        $shops = Shop::where([['next_payment', '<', Carbon::now()->addMonth()],
                                ['next_payment', '>', Carbon::now()->subMonth()],])


            ->paginate(15);
        return view('almostexpired',['shops' => $shops]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function edit(Shop $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shop $shop)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shop $shop)
    {
        //
    }
}
