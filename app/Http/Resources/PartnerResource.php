<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PartnerResource extends JsonResource
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
            'code' => $this->code,
            'name' => $this->name,
            'subject' => strtolower(str_replace('App\\', '', $this->subject_type)),
            'first_name' => $this->subject_type == 'App\Person' ? $this->subject->first_name : '',
            'last_name' => $this->subject_type == 'App\Person' ? $this->subject->last_name : '',
        ];
    }
}
