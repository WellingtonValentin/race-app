<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RunnerCompetitionRequest extends FormRequest
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
            'runner' => 'required|exists:runners,id',
            'competition' => 'required|exists:competitions,id',
        ];
    }

    public function messages()
    {
        return [
            'runner.required' => 'Corredor é obrigatório.',
            'competition.required' => 'Prova é obrigatória.',
            'runner.exists' => 'Corredor informado não existe.',
            'competition.exists' => 'Prova informada não existe.',
        ];
    }
}
