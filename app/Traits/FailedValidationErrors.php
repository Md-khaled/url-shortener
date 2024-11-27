<?php

namespace App\Traits;

use App\Responses\JSResponse;
use Illuminate\Contracts\Validation\Validator;

trait FailedValidationErrors
{
    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        if ($this->expectsJson()) {
            JSResponse::validationError($validator->errors());
        }
        parent::failedValidation($validator);
    }
}
