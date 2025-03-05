<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->isMethod('post')) {
            return [
                'rating' => 'required',
                'comment' => 'required|max:400',
                'image_url' => 'required|file|mimes:jpeg,png'
            ];
        } else {
            return [
                'rating' => 'required',
                'comment' => 'nullable|max:400',
                'image_url' => 'nullable|file|mimes:jpeg,png'
            ];
        }
    }

    public function messages()
    {
        return [
            'rating.required' => '評価を指定してください。',
            'comment.required' => 'コメントを入力してください。',
            'comment.max' => 'コメントは400文字以内で入力してください。',
            'image_url.required' => '画像を追加してください。',
            'image_url.file' => '有効なファイルをアップロードしてください',
            'image_url.mimes' => 'アップロード可能なファイル形式は、jpeg,png のみです'
        ];
    }
}
