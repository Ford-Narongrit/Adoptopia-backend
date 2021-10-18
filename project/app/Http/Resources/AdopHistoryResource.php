<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;
use App\Models\Adopt;

class AdopHistoryResource extends JsonResource
{
    
    public function toArray($request)
    {
        $status = $this->status;
        $counterParty = User::findOrFail($this->trans_user);
        $counterUsername = $counterParty->username;

        if($status == 'DTA'){
            if($this->adopt_id){
                $adopt = Adopt::findOrFail($this->adopt_id);
                $verb = "gave";
                $pepo = "to";
            }
            if($this->trans_adopt) {
                $adopt = Adopt::findOrFail($this->trans_adopt);
                $verb = "received";
                $pepo = "from";
            }
            $adoptName = $adopt->name;
            $description = "You ".$verb. "  \"".$adoptName."\"  ".$pepo." ".$counterUsername;
        }
        if($status == 'OTA') {
            $transAdoptName = "";
            if($this->adopt_id){
                $adopt = Adopt::findOrFail($this->adopt_id);
                $adoptName = $adopt->name;
            }
            if($this->trans_adopt) {
                $trans_adopt = Adopt::findOrFail($this->trans_adopt);
                $transAdoptName = $trans_adopt->name;
            }
            $description = "You traded \"".$adoptName."\"  for             \"".$transAdoptName."\"";
            $adoptName = $transAdoptName;
        }

        return [
            'Date' => $this->created_at->format('j M Y'),
            'Description' => $description,
            'Type' => $status,
            'Adop' => $adoptName,
            'Counterparty' => $counterUsername
        ];
    }
}
