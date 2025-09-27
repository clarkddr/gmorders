<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreMaxminRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code' => ['required','string'],
            'pack_quantity' => ['required','integer','gt:0'],
            'subcategoryid'    => ['required','integer'],
            'supplierid'    => ['required','integer'],
            'colorid'    => ['required','integer'],
            'branches'        => ['required','array'],
            'branches.*.min'  => ['nullable','numeric','gte:0'],
            'branches.*.max'  => ['nullable','numeric','gte:0'],
        ];
    }

    public function messages(): array {
        return [
            'branches.*.min.numeric' => 'El mínimo debe ser un número.',
            'branches.*.max.numeric' => 'El máximo debe ser un número.',
            'branches.*.min.gte'     => 'El mínimo no puede ser negativo.',
            'branches.*.max.gte'     => 'El máximo no puede ser negativo.',
        ];
    }

    protected function withValidator(Validator $validator){
        $validator->after(function ($validator) {
            foreach($this->input('branches',[]) as $branch => $row){
                $min = $row['min'] ?? null;
                $max = $row['max'] ?? null;

                if( ($min === null && $max !== null) || ($min !== null && $max === null) ){
                    $faltante = $min === null ? 'min' : 'max';
                    $validator->errors()->add("branches.{$branch}.{$faltante}", "El campo {$faltante} es requerido");
                }

                if ($min !== null && $max !== null && $max <= $min) {
                    $validator->errors()->add("branches.{$branch}.max", 'El máximo debe ser mayor que el mínimo.');
                }
            }

        });
    }
}
