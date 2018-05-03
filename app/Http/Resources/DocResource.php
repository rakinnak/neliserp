<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DocResource extends JsonResource
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
            'name' => $this->name,
            'type' => $this->type,
            'partner_type' => 'App\Company',
            'partner_id' => $this->partner->id,
            'partner_uuid' => $this->partner->uuid,
            'partner_code' => $this->partner->code,
            'partner_name' => $this->partner->name,
            'issued_at' => str_replace(' 00:00:00', '', $this->issued_at),
            'doc_items' => DocItemResource::collection($this->doc_items),
            'moving' => false,
        ];
    }
}
