<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'book_id'   => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'author_name' => $this->author->name,
            "ISBN" => $this->ISBN
        ];
    }
}
