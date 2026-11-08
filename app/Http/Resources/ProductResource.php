<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "category_name" => $this->category?->name,
            "id"            => $this->id,
            "category_id"   => $this->category_id,
            "name"          => $this->name,
            "description"   => $this->description,
            "price"         => $this->price,
            "image_url"     => $this->image_url,
            "created_at"    => $this->created_at,
            "updated_at"    => $this->updated_at,
        ];
    }
}
// protected $fillable = ["category_id", "name", "description", "price", "image_url"];
