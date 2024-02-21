<?php

namespace App\Http\Requests\Api\V1\Event;

use App\Http\Requests\Api\V1\Event\CreateEventRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class UpdateEventRequest extends CreateEventRequest
{
    public function rules()
    {
        $rules = parent::rules();

        $rules['start'] = 'sometimes|date_format:Y-m-d\TH:i:sP';
        $rules['end'] = 'sometimes|date_format:Y-m-d\TH:i:sP|after_or_equal:start';
        $rules['recurring_pattern.frequency'] = 'sometimes|in:daily,weekly,monthly,yearly';
        $rules['recurring_pattern.repeat_until'] = 'sometimes|date_format:Y-m-d\TH:i:sP|after_or_equal:end';

        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        $response = new JsonResponse(['errors' => $validator->errors()], 422);
        throw new HttpResponseException($response);
    }
}
