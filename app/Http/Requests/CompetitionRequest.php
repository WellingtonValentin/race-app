<?php

namespace App\Http\Requests;

use App\Enums\CompetitionEnum;
use Illuminate\Foundation\Http\FormRequest;

class CompetitionRequest extends FormRequest
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
            'type' => 'required|in:' . implode(',', CompetitionEnum::getAllValues()),
            'date' => 'required|date_format:d/m/Y',
        ];
    }

    public function messages()
    {
        return [
            'type.required' => 'Tipo é obrigatório.',
            'type.in' => 'Tipo de prova inválido ' . implode(', ', CompetitionEnum::getAllValues()),
            'date.required' => 'Data é obrigatória.',
            'date.date_format' => 'Formato de Data inválido (d/m/y).',
        ];
    }
}
