<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OtaSug extends Model
{
    use HasFactory, SoftDeletes;

    public function trade(){
        return $this->belongsTo(Trade::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function adopt(){
        return $this->belongsTo(Adopt::class);
    }
}