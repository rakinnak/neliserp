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
            'company_uuid' => $this->company_uuid,
            'company_code' => $this->company_code,
            'company_name' => $this->company_name,
            'issued_at' => str_replace(' 00:00:00', '', $this->issued_at),
            'doc_item' => DocItemResource::collection($this->doc_item),
        ];
    }
}
