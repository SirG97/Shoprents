<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plaza extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'address',
    ];

    public function shops()
    {
        return $this->hasMany(Shop::class);
    }
}
