<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DtaSug extends Model
{
    use HasFactory, SoftDeletes;

    public function trade_adops(){
        return $this->belongsTo(TradeAdop::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
