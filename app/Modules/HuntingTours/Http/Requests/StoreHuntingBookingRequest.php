<?php

namespace App\Modules\HuntingTours\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreHuntingBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tour_name' => ['required', 'string', 'max:255'],
            'hunter_name' => ['required', 'string', 'max:255'],
            'guide_id' => ['required', 'integer', Rule::exists('hunting_guides', 'id')->where('is_active', true)],
            'date' => ['required', 'date', 'after_or_equal:today'],
            'participants_count' => ['required', 'integer', 'min:1', 'max:10'],
        ];
    }

    public function messages(): array
    {
        return [
            'guide_id.exists' => 'Выбранный гид недоступен или неактивен',
            'date.after_or_equal' => 'Дата бронирования не может быть в прошлом',
            'participants_count.max' => 'Максимальное количество участников — 10 человек',
        ];
    }
}
