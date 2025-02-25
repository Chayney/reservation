<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Shop;
use App\Models\Review;
use League\Csv\Reader;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function show()
    {
        $reviews = Review::with('reviewUser')->paginate(5);
        
        return view('admin.review', compact('reviews'));
    }

    public function edit()
    {
        $reviews = Review::with('reviewUser')->paginate(5);
        
        return view('admin.import');
    }

    public function import(Request $request)
    {
        $csvFile = $request->file('csvFile');
        $csv = Reader::createFromPath($csvFile->getRealPath(), 'r');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();
        $errors = [];
        $rowNumber = 2;
        foreach ($records as $record) {
            $customMsgs = [
                '店舗名.required' => '店舗名は50文字以内で入力してください',
                '地域.required' => '地域は「東京都」「大阪府」「福岡県」のいずれかを入力してください',
                '地域.exists' => '地域は「東京都」「大阪府」「福岡県」のいずれかを入力してください',
                'ジャンル.required' => 'ジャンルは「寿司」「焼肉」「イタリアン」「居酒屋」「ラーメン」のいずれかを入力してください',
                'ジャンル.exists' => 'ジャンルは「寿司」「焼肉」「イタリアン」「居酒屋」「ラーメン」のいずれかを入力してください',
                '店舗概要.required' => '店舗概要は400文字以内で入力してください',
                '画像URL.url' => '画像URLは、URL形式で「jpg」「jpeg」「png」のみアップロード可能です',
                '画像URL.regex' => '画像URLは、URL形式で「jpg」「jpeg」「png」のみアップロード可能です'
            ];
            $validator = Validator::make($record, [
                '店舗名' => 'required|max:50',
                '地域' => 'required|exists:areas,name',
                'ジャンル' => 'required|exists:genres,name',
                '店舗概要' => 'required|max:400',
                '画像URL' => ['required', 'url', 'regex:/\.(jpg|jpeg|png)$/i'],
            ], $customMsgs);
            if ($validator->fails()) {
                foreach ($validator->errors()->messages() as $field => $message) {
                    foreach ($message as $specificError) {
                        $errors[] = "{$specificError}";
                    }
                }
                $rowNumber++;
                continue;
            }
            $area = Area::where('name', $record['地域'])->first();
            $genre = Genre::where('name', $record['ジャンル'])->first();
            Shop::create([
                'shop' => $record['店舗名'],
                'area_id' => $area->id,
                'genre_id' => $genre->id,
                'shop_detail' => $record['店舗概要'],
                'shop_image' => $record['画像URL'],
            ]);
            $rowNumber++;
        }
        if (!empty($errors)) {
            return back()->with('errors', $errors);
        }

        return back()->with('success', 'CSVファイルのインポートが完了しました');
    }
}
