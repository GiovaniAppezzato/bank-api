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
            'name'         => ['string','required'],
            'email'        => ['string','required','unique:users,email'],
            'cpf'          => ['string','required','max:15'],
            'password'     => ['string','required','min:6'],
            'birth'        => ['date','required'],
            'sex'          => ['required','string',Rule::in(['M', 'F'])],
            'photo'        => ['nullable'],
            'city'         => ['string','required'],
            'neighborhood' => ['string','required'],
            'street'       => ['string','required'],
            'number'       => ['string','required'],
            'zip_code'     => ['string','required','min:9','max:9'],
            'state'        => ['string','required'],
            'complement'   => ['nullable', 'string'],
        ];
    }
}
