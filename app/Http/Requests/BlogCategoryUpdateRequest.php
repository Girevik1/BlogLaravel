<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogCategoryUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //return auth()->check();
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
            'title' => 'required|min:5|max:200',
            'slug' => 'max:200',
            'description' => 'required|string|max:500|min:3',
            'parent_id' => 'required|integer|exists:blog_categories,id',
        ];
    }

//    public function rules()
//    {
//        return [
//            'name' => 'required',
//            'phone' => 'required',
//            'g-recaptcha-response' => 'required|recaptchav3:register,0.5'
//        ];
//    }
//
    public function messages()
    {
        return [
            'description.required' => 'Описание - обязательное поле',
            //'title.required' => 'Имя - обязательное поле',
        ];
    }
}
