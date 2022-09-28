<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $rule = [
            'title' => 'required|string|max:50',
            'category' => 'required',
            'body' => 'required|string|max:2000',
        ];

        // getNameはroute:listのNameを取得
        $route = $this->route()->getName();
        if (
            // storeとupdateアクションがrouteと一致しているかを判定
            $route === 'meals.store' ||
            ($route === 'meals.update' && $this->file('image'))
        ) {
            $rule['image'] = 'required|file|image|mimes:jpg,png';
        }

        return $rule;
    }
}
