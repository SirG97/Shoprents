<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $total = Shop::all()->count();
        $expired = Shop::where([['next_payment', '<', Carbon::now()], ['vacant_status', '=', '0']])->count();
        $expireInOneMonth = Shop::where([['next_payment', '<', Carbon::now()->addMonth()],
            ['next_payment', '>', Carbon::now()]])->count();
//        $revenue = Payment::all()->sum('amount');
        $shops = Shop::where('next_payment', '<', Carbon::now()->addMonth())
            ->orWhere('next_payment', '<', Carbon::now()->subMonth())
            ->orWhere('next_payment', '=', null)
            ->paginate(15);
        $vacant = Shop::where([['vacant_status', '=', '0']])->count();
        return view('home', ['total_shops' => $total,
                                    'expired_shops' => $expired,
                                    'shops' => $shops,
                                    'expire_in_one_month' => $expireInOneMonth,
                                    'vacant' => $vacant,
//                                    'revenue' => number_format($revenue, 2, '.', ',')
            ]
        );
    }
}
