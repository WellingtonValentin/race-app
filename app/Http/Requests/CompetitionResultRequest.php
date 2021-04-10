<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompetitionResultRequest extends FormRequest
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
            'runner_start_time' => 'required|date_format:H:i:s',
            'runner_end_time' => 'required|date_format:H:i:s||after:runner_start_time',
            'runner' => 'required|exists:runners,id',
            'competition' => 'required|exists:competitions,id',
        ];
    }

    public function messages()
    {
        return [
            'runner_start_time.required' => 'Tempo de início do Corredor é obrigatório.',
            'runner_start_time.date_format' => 'Tempo de início do Corredor inválido.',
            'runner_end_time.required' => 'Tempo de chegada do Corredor é obrigatório.',
            'runner_end_time.date_format' => 'Tempo de chegada do Corredor inválido.',
            'runner_end_time.after' => 'Tempo de chegada deve ser maior que o tempo de início.',
            'runner.required' => 'Corredor é obrigatório.',
            'competition.required' => 'Prova é obrigatória.',
            'runner.exists' => 'Corredor informado não existe.',
            'competition.exists' => 'Prova informada não existe.',
        ];
    }
}
