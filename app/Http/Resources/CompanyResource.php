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
            'logo' => $this->logoPath,
            'city_id' => $this->city_id,
            'quarter_id' => $this->quarter_id,
            'city' => $this->city['name'],
            'quarter' => $this->quarter['name'],
            'deleted' => $this->trashed()
        ];
    }
}
