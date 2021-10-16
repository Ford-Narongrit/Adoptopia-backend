<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;

class PaymentHistoryResource extends JsonResource
{
    public function toArray($request)
    {   
        $amount = number_format( (float) $this->amount, 2, '.', '');
        $status = $this->status;   
        
        $counterPartyId = $this->trans_user;
        if(!$counterPartyId){
            $counterUsername = "-";
            $description = "You ". $status ." ". $amount . " baht."; 
        }
        else {
            $counterParty = User::findOrFail($counterPartyId);
            $counterUsername = $counterParty->username;
            $status === "earn" ? $pepo = "from" : $pepo = "to";
            $description = "You ". $status ."ed ". $amount . " baht " . $pepo ." ". $counterUsername; 
        }
            
        return [
            'Date' => $this->created_at->format('j M Y'),
            'Description' => $description,
            'Type' => $status,
            'Amount' => $amount,
            'Counterparty' => $counterUsername
        ];
    }
}
