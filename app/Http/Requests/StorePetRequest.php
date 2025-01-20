<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\PetStatus;

class StorePetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $statusValues = implode(',', PetStatus::values());

        return [
            'name'   => 'required|string|max:255',
            'status' => 'required|string|in:' . $statusValues
        ];
    }
}
