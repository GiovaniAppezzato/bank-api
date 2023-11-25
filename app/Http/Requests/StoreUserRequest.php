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
<<<<<<< HEAD
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
=======
            'user.name'            => ['string','required'],
            'user.email'           => ['string','required','unique:user,email'],
            'user.cpf'             => ['string','required','max:11'],
            'user.password'        => ['string','required','min:6'],
            'user.birth'           => ['date','required'],
            'user.sex'             => ['required','string',Rule::in(['M', 'F'])],
            'user.photo'           => ['string','nullable', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
            'address.city'         => ['string','required'],
            'address.neighborhood' => ['string','required'],
            'address.street'       => ['string','required'],
            'address.number'       => ['string','required'],
            'address.complement'   => ['string','required'],
            'address.zip_code'     => ['string','required','min:9','max:9'],
>>>>>>> e96c6baac0a5762b724c74462ff2c0998d8d060a
        ];
    }
}
