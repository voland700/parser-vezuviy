<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileRequest extends FormRequest
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
        return [
            'file' => 'required|mimes:xlsx,xls,csv'
        ];
    }

    public function messages()
    {
        return [
            'file.required' => 'Загрузите файл для импорта данных',
            'file.mimes' => 'Файл для иморта данных должен быть в Excel формате',
        ];
    }



}
