<?php

namespace App\Http\Requests;

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
            'name' => ['string', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)->where(function ($query) {
                return $query->whereNot('email_verified_at', null)
                             ->whereNull('deleted_at');
            })],
            'nickname' => ['string', 'max:255'],
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'zip_code' => ['string', 'max:8'],
            'state' => ['string', 'max:255'],
            'city' => ['string', 'max:255'],
            'address' => ['string', 'max:255'],
            'tel' => ['string', 'max:255'],
        ];
    }
}
