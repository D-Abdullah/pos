<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            "id" =>(string)$this->id,
            "types"=>"supplier",
            "attributes"=>[
                "added_by"=>$this->added_by,
                "name"=>$this->name,
                "email"=>$this->email,
                "phone"=>$this->phone,
                "address"=>$this->address,
                "payment_type"=>$this->payment_type,
                "is_active"=>$this->is_active,
                "created_at"=>$this->created_at,
                "updated_at"=>$this->updated_at,
            ],

        ];
    }
}
