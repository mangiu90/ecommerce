<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cost',
        'province_id',
    ];


    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
