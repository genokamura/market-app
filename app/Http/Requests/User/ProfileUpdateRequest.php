<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'max:255'],
            'nickname' => ['string', 'max:255', 'regex:/^[a-zA-Z0-9_]+$/u',
            Rule::unique(User::class)->ignore($this->user()->id)->where(function ($query) {
                return $query->whereNull('deleted_at');
            })
            ],
            'email' => ['prohibited'],
            'zip_code' => ['string', 'max:8'],
            'state' => ['string', 'max:255'],
            'city' => ['string', 'max:255'],
            'address' => ['string', 'max:255'],
            'tel' => ['string', 'max:255'],
        ];
    }
}
