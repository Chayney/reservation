<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shop_id',
        'date',
        'time',
        'person'
    ];

    protected $casts = [
        'time' => 'datetime:H:i'
    ];

    public function reserve_user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reserve_shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }
}
