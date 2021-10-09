<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\DtaSug;

class TradeAdop extends Model
{
    use HasFactory, SoftDeletes;

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function adopt(){
        return $this->belongsTo(Adopt::class);
    }
    public function dta_sugs(){
        return $this->hasMany(DtaSug::class);
    }
}
