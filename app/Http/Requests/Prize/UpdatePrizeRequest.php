<?php

namespace App\Http\Requests\Prize;

use App\Enums\Prize\PrizeType;
use App\Traits\RequestJSONError;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePrizeRequest extends FormRequest
{
    use RequestJSONError;
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
            'name' => [
                'required',
                'string',
                Rule::unique('prizes', 'name')
                    ->where('type', $this->input('type'))
                    ->ignore($this->prize)
            ],
            'type' => [Rule::enum(PrizeType::class)],
            'active' => ['boolean']
        ];
    }
}
