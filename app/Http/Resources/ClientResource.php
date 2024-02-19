<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>(string)$this->id,
            "types"=>"clients",
            "attributes"=>[
                "name"=>$this->name,
                "phone"=>$this->phone,
                "added_by"=>$this->added_by,
                "is_active"=>$this->is_active,
                "created_at"=>$this->created_at,
                "updated_at"=>$this->updated_at,
            ]
        ];
    }
}
