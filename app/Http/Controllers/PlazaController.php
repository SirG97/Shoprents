<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Plaza;
use App\Models\Shop;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PlazaController extends Controller
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
        $plazas = Plaza::withCount('shops')->paginate(25);

        return view('plazas',['plazas' => $plazas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('newplaza');

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
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function show(Plaza $plaza){
        $shops = Shop::where('plaza_id', $plaza->id)->orderBy('id', 'desc')->paginate(100);

        return view('plaza', ['plaza' => $plaza, 'shops' => $shops, ]);
    }

    public function expired(){
        $shops = Shop::where('next_payment', '<', Carbon::now())->orderBy('id', 'desc')->paginate(100);
        return view('expiredshops',['shops' => $shops]);
    }
    public function almostDue(){
//        $shops = Shop::where('next_payment', '<', Carbon::now()->subMonth())->orderBy('id', 'desc')->paginate(100);
        $shops = Shop::where([['next_payment', '<', Carbon::now()->addMonth()],
            ['next_payment', '>', Carbon::now()->subMonth()]])


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
     * @param  \App\Models\Shop  $plaza
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shop $shop)
    {
        //
    }
}
