<?php

namespace App\Models;

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
}
