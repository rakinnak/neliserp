<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DocItemResource extends JsonResource
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
            'uuid' => $this->uuid,
            'ref_id' => $this->ref_id,
            'line_number' => $this->line_number,
            'item_uuid' => $this->item_uuid,
            'item_code' => $this->item_code,
            'item_name' => $this->item_name,
            'quantity' => $this->quantity,
            'pending_quantity' => $this->pending_quantity,
            'unit_price' => $this->unit_price,
            'creating' => false,    // TODO: temp assign, should be definied in Vue
            'editing' => false,     // TODO: temp assign, should be definied in Vue
            'deleting' => false,    // TODO: temp assign, should be definied in Vue
            'deleted' => false,     // TODO: temp assign, should be definied in Vue
            'errors' => []
        ];
    }
}
