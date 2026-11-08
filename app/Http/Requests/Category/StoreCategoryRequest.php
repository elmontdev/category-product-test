<?php
namespace App\Http\Requests\Category;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            "name"        => "required|string|min:3|max:255|unique:categories,name",
            "description" => "required|string",
        ];
    }

    public function messages(): array
    {
        return [
            // Name Validation
            "name.required"        => "Category အမည်ကို မဖြစ်မနေ ဖြည့်သွင်းပေးပါ။",
            "name.string"          => "Category အမည်သည် စာသားဖြစ်ရပါမည်။",
            "name.min"             => "Category အမည်သည် အနည်းဆုံး စာလုံး ၃ လုံး ရှိရပါမည်။",
            "name.max"             => "Category အမည်သည် အများဆုံး စာလုံး ၂၅၅ လုံးသာ ရှိရပါမည်။",
            "name.unique"          => "ဤ Category အမည်သည် အသုံးပြုပြီးသား ဖြစ်နေပါသည်။",

            // Description Validation
            "description.required" => "ဖော်ပြချက်ကို မဖြစ်မနေ ဖြည့်သွင်းပေးပါ။",
            "description.string"   => "ဖော်ပြချက်သည် စာသားဖြစ်ရပါမည်။",
        ];
    }
}
