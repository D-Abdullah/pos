<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => (string) $this->id,
            "types"=>"departments",
            "attributes"=>[
                "added_by"=>$this->added_by,
                "name"=>$this->name,
                "description"=>$this->description,
                "is_active"=>$this->is_active,
                "created_at"=>$this->created_at,
                "updated_at"=>$this->updated_at,
            ]
        ];
    }
}
