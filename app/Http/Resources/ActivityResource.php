<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
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
            'user_id' => $this->user_id,
            'user_uuid' => $this->user_uuid,
            'user_username' => $this->user_username,
            'subject_id' => $this->subject_id,
            'subject_uuid' => $this->subject_uuid,
            'subject_type' => $this->subject_type,
            'type' => $this->type,
            'before' => $this->before,
            'after' => $this->after,
            'created_at' => $this->created_at,
        ];
    }
}
