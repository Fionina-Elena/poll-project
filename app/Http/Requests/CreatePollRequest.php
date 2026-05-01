<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePollRequest extends FormRequest
{
    public function authorize(): bool
    {
        return false;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|min:5|max:100',
            'options' => 'required|array|min:2|max:4',
            'options.*' => 'required|string|min:1|max:50'
        ];
    }

    public function messages(): array
    {
        return [
            'title.min' => 'Название должно быть не менее 5 символов.',
            'options.min' => 'Необходимо минимум 2 варианта ответа.',
            'options.max' => 'Максимум 4 варианта ответа.',
            'options.*.max' => 'Текст варианта не должен превышать 50 символов.',
        ];
    }
}
