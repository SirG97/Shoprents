<?php

namespace App\Models;

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

    public function plaza(){
        return $this->belongsTo(Plaza::class);
    }
}
