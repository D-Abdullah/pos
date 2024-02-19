<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            "id"=>(string)$this->id,
            "types"=>"purchases",
            "attributes"=>[
                "supplier_id"=>$this->supplier_id,
                "product_id"=>$this->product_id,
                "added_by"=>$this->added_by,
                'quantity'=>$this->quantity,
                "date"=>$this->date,
                "total_price"=>$this->total_price,
                "created_at"=>$this->created_at,
                "updated_at"=>$this->updated_at
            ],
        ];
    }
}
