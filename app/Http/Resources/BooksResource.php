<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BooksResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => (string)$this->id,
            'type' => 'books',
            'attributes' => [
                'name' => $this->name,
                'description' => $this->description,
                'publication_year' => $this->publication_year,
                'stock' => $this->stock,
                'is_active' => $this->is_active
            ],
            'author' => $this->author,
            'genre' => $this->genre,
        ];
    }
}
