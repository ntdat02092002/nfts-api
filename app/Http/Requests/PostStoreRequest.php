<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        if(request()->isMethod('post')) {
            return [
                'name' => 'required|string|max:258',
                'description' => 'required|string'
            ];
        } else {
            return [
                'name' => 'required|string|max:258',
                'description' => 'required|string'
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
        if(request()->isMethod('post')) {
            return [
                'name.required' => 'Name is required!',
                'description.required' => 'Descritpion is required!'
            ];
        } else {
            return [
                'name.required' => 'Name is required!',
                'description.required' => 'Descritpion is required!'
            ];   
        }
    }
}
