<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'photo' => $this->photo ? $this->photoPath : '',
            'email' => $this->email,
            'birthdate' => $this->birthdate,
            'address' => $this->address,
            'phone' => $this->phone,
            'city_id' => $this->city['id'],
            'city' => $this->city['name'] ?? '',
            'role_id' => $this->role->id,
            'role' => $this->role->name ?? '',
            'company_id' => $this->company_id,
            'company' => $this->company->name ?? '',
            'deleted' => $this->trashed(),
            'created_at' => $this->created_at
        ];
    }
}
