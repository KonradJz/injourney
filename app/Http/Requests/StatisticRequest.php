<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StatisticRequest extends FormRequest
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
        return [
            'users_count' => ['integer'],
            'posts_count' => ['integer'],
            'latest_user_id' => ['integer'],
            'latest_user_email' => ['string'],
            'latest_user_created_at' => ['string'],
            'latest_post_title' => ['string'],
            'latest_post_id' => ['integer'],
            'latest_post_created_at' => ['string']
        ];
    }
}
