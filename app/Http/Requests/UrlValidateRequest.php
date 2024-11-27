<?php

namespace App\Http\Requests;

use App\Actions\CodeGenerator\ShortCodeGenerator;
use Illuminate\Foundation\Http\FormRequest;
use function App\Helpers\short_code_generator;

class UrlValidateRequest extends FormRequest
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
            'original_url' => [
                'required',
                'url',
                'unique:url_mappings,original_url'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'original_url.required' => 'The original url field is required.',
            'original_url.url' => 'The original url must be a valid URL.',
            'original_url.unique' => 'The original url has already been taken.',
        ];
    }

    protected function passedValidation(): void
    {
        $this->mergeIfMissing([
            $url = 'original_url' => $this->$url,
            'short_code' => short_code_generator(),
        ]);
    }
}
