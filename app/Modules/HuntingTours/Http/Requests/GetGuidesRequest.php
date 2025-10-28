<?php

namespace App\Modules\HuntingTours\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetGuidesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'min_experience' => ['nullable', 'integer', 'min:1', 'max:10'],
        ];
    }
}
