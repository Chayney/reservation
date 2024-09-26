<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop',
        'area_id',
        'genre_id',
        'shop_detail',
        'shop_image'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function reservates()
    {
        return $this->hasMany(Reservation::class);
    }

    public function scopeAreaSearch($query, $area)
    {
        if (!empty($area)) {
            $query->where('area_id', $area);
        }
    }

    public function scopeGenreSearch($query, $genre)
    {
        if (!empty($genre)) {
            $query->where('genre_id', $genre);
        }
    }

    public function scopeKeywordSearch($query, $keyword)
    {
        if (!empty($keyword)) {
            $query->where(function ($query) use ($keyword) {
              $query->where("shop", "like", "%" . $keyword . "%");
            });
        }
    }

    public function favoriteMarked()
    {
        $id = Auth::id();
        $favoriteMarkers = array();
        foreach ($this->favorites as $favoriteMark) {
            array_push($favoriteMarkers, $favoriteMark->user_id);
        }
        
        if (in_array($id, $favoriteMarkers)) {
            return true;
        } else {
            return false;
        }
    }
}
