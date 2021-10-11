<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'address', 'status', 'phone', 'last_payment','next_payment', 'plaza_id', 'vacant_status', 'shop_number', 'next_bal_payment', 'last_bal_payment', 'is_owing_bal'
    ];

    public function payments(){
        return $this->hasMany(Payment::class);
    }

    public function getLastPaymentAttribute($value)
    {
        if($value !== null or !empty($value)){
            return Carbon::create($value);
        }
    }

    public function plaza(){
        return $this->belongsTo(Plaza::class);
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
