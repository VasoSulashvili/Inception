<?php

namespace App\Http\Requests\Prize;

use App\Traits\RequestJSONError;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePriceGroupRequest extends FormRequest
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
            'group_id' => ['required', 'integer'],
            'prize_id' => [
                'required',
                'integer',
                Rule::unique('group_prize', 'prize_id')
                    ->where('group_id', $this->input('group_id'))],
            'number' => ['required', 'integer', 'max:1000000'],
        ];
    }


}
