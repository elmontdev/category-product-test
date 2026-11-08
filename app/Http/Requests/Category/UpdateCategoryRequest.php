<?php
namespace App\Http\Requests\Category;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name"        => "sometimes|string|min:3|max:255|unique:categories,name," . $this->route("category"),
            "description" => "sometimes|string",
        ];
    }

    public function messages(): array
    {
        return [
            // Name Validation
            "name.string"        => "Category အမည်သည် စာသားဖြစ်ရပါမည်။",
            "name.min"           => "Category အမည်သည် အနည်းဆုံး စာလုံး ၃ လုံး ရှိရပါမည်။",
            "name.max"           => "Category အမည်သည် အများဆုံး စာလုံး ၂၅၅ လုံးသာ ရှိရပါမည်။",
            "name.unique"        => "ဤ Category အမည်ကို အခြား Category တစ်ခုတွင် အသုံးပြုပြီးဖြစ်ပါသည်။",

            // Description Validation
            "description.string" => "Category ဖော်ပြချက်သည် စာသားဖြစ်ရပါမည်။",
        ];
    }

}
