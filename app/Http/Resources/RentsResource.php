<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RentsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (string)$this->id,
            'type' => 'rents',
            'attributes' => [
                'from_date' => $this->from_date,
                'to_date' => $this->to_date,
                'retruned_date' => $this->returned_date,
                'delivered' => $this->delivered,
                'returned' => $this->returned,
                'created_at' => $this->created_at,
                'user' => $this->user,
                'book' => $this->book,
            ],
        ];
    }
}
