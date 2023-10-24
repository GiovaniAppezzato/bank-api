<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name'     => ['string','required'],
            'email'    => ['string','required',Rule::unique('users')->ignore($this->user()->id)], /* TODO: Fishy syntax */
            'cpf'      => ['string','required','max:11'],
            'birth'    => ['date','required'],
            'sex'      => ['required','string',Rule::in(['M', 'F'])],
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator): void
    {
        $response = new JsonResponse([
            'success' => false,
            'errors' => $validator->errors(),
        ], 422);

        throw new HttpResponseException($response);
    }
}
