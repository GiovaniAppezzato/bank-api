<?php

namespace App\Http\Requests;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
            'user.name'            => ['string','required'],
            'user.email'           => ['string','required','unique:user,email'],
            'user.cpf'             => ['string','required','max:11'],
            'user.password'        => ['string','required','min:6'],
            'user.birth'           => ['date','required'],
            'user.sex'             => ['required','string',Rule::in(['M', 'F'])],
            'user.photo'           => ['string','required'],
            'address.city'         => ['string','required'],
            'address.neighborhood' => ['string','required'],
            'address.street'       => ['string','required'],
            'address.number'       => ['string','required'],
            'address.complement'   => ['string','required'],
            'address.zip_code'     => ['string','required','min:9','max:9'],
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
