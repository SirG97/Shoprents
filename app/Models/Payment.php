<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'shop_id', 'amount', 'duration', 'last_payment', 'next_payment', 'balance','bal_brought_fwd', 'next_bal_payment', 'last_bal_payment', 'payment_type'
    ];

    public function shop(){
        return $this->belongsTo(Shop::class);
    }

    public function getLastPaymentAttribute($value)
    {
        if($value !== null or !empty($value)){
            return Carbon::create($value);
        }

    }

    public function getNextPaymentAttribute($value)
    {
        if($value !== null or !empty($value)){
            return Carbon::create($value);
        }
    }

    public function getLastBalPaymentAttribute($value)
    {
        if($value !== null or !empty($value)){
            return Carbon::create($value);
        }
    }

    public function getNextBalPaymentAttribute($value)
    {
        if($value !== null or !empty($value)){
            return Carbon::create($value);
        }
    }
}
