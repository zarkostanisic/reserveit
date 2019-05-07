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
        $dir = config('site.upload.images.users.show');

        return [
            'id' => $this->id,
            'name' => $this->name,
            'photo' => [
                'orig' => $this->photo ? asset($dir . $this->photo) : '',
                'small' => $this->photo ? asset($dir . thumbnail($this->photo, 'small')) : ''
            ],
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
