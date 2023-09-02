<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TripSeatRequest extends FormRequest
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
            'seat_id'=>'required|numeric|in:'.implode(',',$this->trip->seats->pluck('id')->toArray()),
            'start_station'=>'required|numeric|in:'.implode(',',$this->trip->start_station),
            'end_station'=>'required|numeric|in:'.implode(',',$this->trip->end_station),

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
            'message' => 'Invalid data send',
            'details' => $errors->messages(),
        ], 422);
        throw new HttpResponseException($response);
    }
}
