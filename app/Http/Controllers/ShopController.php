<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Plaza;
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
        $shops = Shop::with(['plaza'])->orderBy('id', 'desc')->paginate(100);
        return view('shops',['shops' => $shops]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $plazas = Plaza::all();
        return view('newshop', ['plazas' => $plazas]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $request->validate([
            'phone' => 'nullable|numeric',
            'name' => 'string',
            'number' => 'required|string',
            'vacant' => 'boolean',
        ]);

        $shop = Shop::create([
            'plaza_id' => $request->plaza,
            'name' => $request->name,
            'phone' => $request->phone,
            'shop_number' => $request->number,
            'vacant_status' => $request->vacant == "1" ? True : False,
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
        $plazas = Plaza::all();

        return view('shop',['shop' => $shop, 'payments' => $payments, 'plazas' => $plazas]);
    }

    public function expired(){
        $shops = Shop::where('next_payment', '<', Carbon::now())->orderBy('id', 'desc')->paginate(100);
        return view('expiredshops',['shops' => $shops]);
    }
    public function almostDue(){
//        $shops = Shop::where('next_payment', '<', Carbon::now()->subMonth())->orderBy('id', 'desc')->paginate(100);
        $shops = Shop::where([['next_payment', '<', Carbon::now()->addMonth()],
                                ['next_payment', '>', Carbon::now()]])


            ->paginate(15);
        return view('almostexpired',['shops' => $shops]);
    }

    public function balance(){
//        $shops = Shop::where('next_balpayment', '<', Carbon::now()->subMonth())->orderBy('id', 'desc')->paginate(100);
//        $shops = Shop::where([['next_bal_payment', '<', Carbon::now()->addDays(7)],
//            ['next_bal_payment', '>', Carbon::now()]])
//            ->paginate(15);
        $shops = Shop::paginate(15);

        return view('balance',['shops' => $shops]);
    }

    public function markAsVacant(Request $request){
        $request->validate([
           'id' => 'required'
        ]);
        Shop::where('id', $request->id)->update(['vacant_status' => 1]);

        return back()->with(['success' => 'Shop marked as vacant successfully']);
    }

    public function markAsOccupied(Request $request){

        $request->validate([
            'id' => 'required',
            'name' => 'nullable|string',
            'phone' => 'nullable|numeric',
            'number' => 'nullable|string',
            'vacant' => 'boolean',
        ]);



        $shop = Shop::where('id',$request->id)->update([
            'plaza_id' => $request->plaza,
            'name' => $request->name,
            'phone' => $request->phone,
            'shop_number' => $request->number,
            'vacant_status' => $request->vacant == "1" ? True : False
        ]);
//
//        $shop->vacant_status = $request->vacant == "1" ? True : False;
//
//        $shop->save();

        return back()->with('success', 'Shop updated successfully');
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
    public function delete(Shop $shop)
    {
        if(!$shop or $shop == null){
            return back()->with('error', 'An error occurred while deleting this shop, please try again');
        }

        Payment::where('shop_id', $shop->id)->delete();

        $shop->delete();

        return back()->with('success', 'Shop deleted successfully');
    }
}
