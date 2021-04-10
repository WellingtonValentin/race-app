<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class RunnerRequest extends FormRequest
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
     * @param Request $request
     * @return array
     */
    public function rules(Request $request)
    {
        return [
            'name' => 'required',
            'document' => sprintf(
                'required|cpf|unique:runners,document,%s,id',
                isset($request->id) ? $request->id : 'null'
            ),
            'birth_date' => 'required|date_format:d/m/Y|before:' . Carbon::now() . '|before:18 years ago',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nome é obrigatório.',
            'document.required' => 'CPF é obrigatório.',
            'document.cpf' => 'CPF inválido.',
            'document.unique' => 'CPF já cadastrado.',
            'birth_date.required' => 'Data de Nascimento é obrigatória.',
            'birth_date.date_format' => 'Formato de Data de Nascimento inválido (d/m/y).',
            'birth_date.before' => 'Proibido cadastro de menores de idade.',
        ];
    }
}
