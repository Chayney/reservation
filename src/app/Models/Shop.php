<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'area_id',
        'genre_id',
        'shop',
        'shop_detail',
        'shop_image'
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favorite()
    {
        return $this->hasMany(Favorite::class);
    }

    public function scopeAreaSearch($query, $area_id)
    {
        if (!empty($area_id)) {
            $query->where('area_id', $area_id);
        }
    }

    public function scopeGenreSearch($query, $genre_id)
    {
        if (!empty($genre_id)) {
            $query->where('genre_id', $genre_id);
        }
    }

    public function scopeKeywordSearch($query, $keyword)
    {
        $query->join('areas', function ($query) use ($keyword) {
            $query->on('shops.area_id', '=', 'areas.id');
        })->join('genres', function ($query) use ($keyword) {
            $query->on('shops.genre_id', '=', 'genres.id');
        })->get();
        
        if (!empty($keyword)) {
            $query->where(function ($query) use ($keyword) {
              $query->where("shop", "like", "%" . $keyword . "%")
                ->orWhere("areas.name", "like", "%" . $keyword . "%")
                ->orWhere("genres.name", "like", "%" . $keyword . "%");
            });
        }
    }

    public function favoritemarked()
    {
        $id = Auth::id();
        $favoritemarkers = array();
        foreach ($this->favorite as $favoritemark) {
            array_push($favoritemarkers, $favoritemark->user_id);
        }

        if (in_array($id, $favoritemarkers)) {
            return true;
        } else {
            return false;
        }
    }
}
