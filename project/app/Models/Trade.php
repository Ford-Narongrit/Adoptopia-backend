<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trade extends Model
{
    use HasFactory, SoftDeletes;

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function adopt(){
        return $this->belongsTo(Adopt::class);
    }
    public function dta_sug(){
        return $this->hasMany(DtaSug::class);
    }
    public function ota_sug(){
        return $this->hasMany(OtaSug::class);
    }
    public function noti(){
        return $this->hasMany(Notification::class);
    }
}
