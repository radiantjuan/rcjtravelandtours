<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookableReviewResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request) {
        return [
            'resource_class' => 'BookableReviewResource',
            'created_at' => $this->created_at,
            'rating' => $this->rating,
            'content' => $this->content
        ];
    }
}
