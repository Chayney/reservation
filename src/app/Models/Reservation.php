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
        'book_time',
        'person'
    ];

    protected $casts = [
        'book_time' => 'datetime:H:i'
    ];

    public function reserve_user()
    {
        return $this->belongsTo(User::class);
    }

    public function reserve_shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }
}
