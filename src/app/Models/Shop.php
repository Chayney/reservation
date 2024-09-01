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
        'area',
        'genre',
        'shop_detail',
        'shop_image'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
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
            $query->where('area', $area);
        }
    }

    public function scopeGenreSearch($query, $genre)
    {
        if (!empty($genre)) {
            $query->where('genre', $genre);
        }
    }

    public function scopeKeywordSearch($query, $keyword)
    {
        if (!empty($keyword)) {
            $query->where(function ($query) use ($keyword) {
              $query->where("shop", "like", "%" . $keyword . "%")
                ->orWhere("area", "like", "%" . $keyword . "%")
                ->orWhere("genre", "like", "%" . $keyword . "%");
            });
        }
    }

    public function favoritemarked()
    {
        $id = Auth::id();
        $favoritemarkers = array(); //配列を用意
        foreach ($this->favorites as $favoritemark) { //配列に要素を追加
            array_push($favoritemarkers, $favoritemark->user_id); //第一引数が配列の箱
        }
        
        if (in_array($id, $favoritemarkers)) { //配列の中に探したい値(第一引数)があるかみる
            return true;
        } else {
            return false;
        }
    }
}
