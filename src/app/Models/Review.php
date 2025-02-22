<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'shop_id', 
        'rating', 
        'comment',
        'image_url'
    ];

    public function reviewUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reviewShop()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
