<?php
namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            "category_id" => "required|exists:categories,id",
            "name"        => "required|string|min:3|max:255",
            "description" => "nullable|string",
            "price"       => "required|numeric|min:0",
            "image_url"   => "nullable|string|max:255",
        ];
    }
    public function messages(): array
    {
        return [
            // Category ID Validation
            "category_id.required" => "Category ID ကို မဖြစ်မနေ ထည့်ပေးရပါမည်။",
            "category_id.exists"   => "ထည့်သွင်းထားသော Category ID သည် Categories ထဲတွင် မရှိပါ။",

            // Name Validation
            "name.required"        => "Product အမည်ကို မဖြစ်မနေ ထည့်ပေးရပါမည်။",
            "name.string"          => "Product အမည်သည် စာသားဖြစ်ရပါမည်။",
            "name.min"             => "Product အမည်သည် အနည်းဆုံး စာလုံး ၃ လုံး ရှိရပါမည်။",
            "name.max"             => "Product အမည်သည် အများဆုံး စာလုံး ၂၅၅ လုံးသာ ရှိရပါမည်။",

            // Description Validation
            "description.string"   => "Product ဖော်ပြချက်သည် စာသားဖြစ်ရပါမည်။",

            // Price Validation
            "price.required"       => "Product ဈေးနှုန်းကို မဖြစ်မနေ ထည့်ပေးရပါမည်။",
            "price.numeric"        => "Product ဈေးနှုန်းသည် ကိန်းဂဏန်းဖြစ်ရပါမည်။",
            "price.min"            => "Product ဈေးနှုန်းသည် ၀ ထက်ငယ်၍ မရပါ။",

            // Image URL Validation
            "image_url.string"     => "Product ပုံ URL သည် စာသားဖြစ်ရပါမည်။",
            "image_url.max"        => "Product ပုံ URL သည် အများဆုံး စာလုံး ၂၅၅ လုံးသာ ရှိရပါမည်။",
        ];
    }
}
