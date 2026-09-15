<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreNewsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'         => 'required|string|min:3|max:255',
            'summary'       => 'nullable|string|max:500',
            'content'       => 'required|string|min:10',
            'image_url'     => 'nullable|url|max:2048',
            'is_published'  => 'required|boolean',
            'published_at'  => 'nullable|date',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'        => 'Заголовок имени должен быть обязательным',
            'title.min'             => 'Заголовок должен быть не меньше 3 символов',
            'title.max'             => 'Заголовок должен быть не больше 255 символов',  
            'summary.max'           => 'Текст анонса должен быть не больше 500 символов',
            'content.required'      => 'Детальный текст новости должен быть обязательным',            
            'content.min'           => 'Детальный текст новости должен быть не меньше 10 символов',
            'image_url.url'         => 'Ссылка должна быть в формате url',
            'image_url.max'         => 'Ссылка на изображение не должна превышать длину в 2048',
            'is_published.boolean'  => 'Обязательно указать опубликована ли новость',
            'published_at.date'     => 'Публикация должжна быть в формате даты',
        ];
    }
}
