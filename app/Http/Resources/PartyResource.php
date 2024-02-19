<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PartyResource extends JsonResource
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
            "types"=>"parties",
            'attributes'=>[
                "client_id"=>$this->client_id,
                "name"=>$this->name,
                "address"=>$this->address,
                "date"=>$this->date,
                "status"=>$this->status,
                "added_by"=>$this->added_by,
                "created_at"=>$this->created_at,
                "updated_at"=>$this->updated_at
            ],
        ];
    }
}
