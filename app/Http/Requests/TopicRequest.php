<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TopicRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        if(request() ->isMethod('post')) {
            return [
                'name' => 'required|string|max:258',
                'image' => 'required|string'
            ];
        }
        else {
            return [
                'name' => 'required|string|max:258',
                'image' => 'required|string'
            ];
        }
    }

    /**
     * Custom message for validation
     * 
     * @return array
     */
    public function messages() 
    {
        if(request() ->isMethod('post')) {
            return [
                'name.required' => 'Nhập tên đi đã :D',
                'image.required' => 'Ảnh chưa được chọn'
            ];
        }
        else {
            return [
                'name.required' => 'Name is required!'
            ];
        }
    } 
}
