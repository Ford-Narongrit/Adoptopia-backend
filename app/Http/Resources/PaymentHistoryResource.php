<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentHistoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'date' => $this->created_at->format('j M Y'),
            'name' => $this->description,
            'type' => $this->status,
            'amount' => $this->amount,
        ];
    }
}
