<?php

namespace App\Http\Json;

use App\Models\Slug;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $slug = Slug::of('code', $this->id);
        return [
            'id'         => $this->id,
            'slug'       => $slug ?? $this->id,
            'name'       => $this->name,
            'user_id'    => $this->user_id,
            'user_name'  => $this->user ? $this->user->name : null,
            'sold'       => $this->sold,
            'price'      => $this->price - ($this->price * $this->ck / 100),
            'images'     => img_url($this->images, '/assets/media/svg/files/doc.svg'),
            'category'   => $this->category ?? 'website',
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
