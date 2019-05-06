<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'logo' => $this->logo ? $this->logoPath : '',
            'address' => $this->address,
            'phone' => $this->phone,
            'category' => $this->category['name'],
            'category_id' => $this->category_id,
            'city_id' => $this->city_id,
            'quarter_id' => $this->quarter_id,
            'city' => $this->city['name'],
            'quarter' => $this->quarter['name'],
            'deleted' => $this->trashed()
        ];
    }
}
