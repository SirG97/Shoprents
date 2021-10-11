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
        'shop_id', 'amount', 'duration', 'last_payment', 'next_payment', 'balance', 'balance_due_by', 'payment_type'
    ];

    public function shop(){
        return $this->belongsTo(Shop::class);
    }
}
