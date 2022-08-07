<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookableIndexResource extends JsonResource
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
            'resource_class' => 'BookableIndexResource',
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description
        ];
    }
}
