<?php

namespace App\Http\Requests\Api\V1\Event;

use App\Domain\Entities\Basic\Frecuency;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rules\Enum;

class CreateEventRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string',
            'description' => 'nullable|string',
            'start' => 'required|date_format:Y-m-d\TH:i:sP',
            'end' => 'required|date_format:Y-m-d\TH:i:sP|after_or_equal:start',
            'recurring_pattern' => 'nullable|array',
            'recurring_pattern.frequency' => [
                'required_with:recurring_pattern',
                'in:daily,weekly,monthly,yearly'
            ],
            'recurring_pattern.repeat_until' => [
                'required_with:recurring_pattern',
                'date_format:Y-m-d\TH:i:sP',
                'after_or_equal:end'
            ],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = new JsonResponse(['errors' => $validator->errors()], 422);
        throw new HttpResponseException($response);
    }
}
