<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AvailableSeatRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
           'start_station'=>'required|numeric|exists:cities,id',
           'end_station'=>'required|numeric|exists:cities,id',
        ];
    }

    /**
     * @param Validator $validator
     * @return mixed
     */
    public function failedValidation(Validator $validator){
        $errors = $validator->errors(); // Here is your array of errors
        $response = response()->json([
            'status' => false,
            'message' => 'validation error',
            'details' => $errors->messages(),
        ], 422);
        throw new HttpResponseException($response);
    }
}
