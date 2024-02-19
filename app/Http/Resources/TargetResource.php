<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TargetResource extends JsonResource
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
            "types"=>"targets",
            "attributes"=>[
                "cost"=>$this->cost,
                "date"=>$this->date,
                "added_by"=>$this->added_by,
            ],
        ];
    }
}
