<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdopHistory extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function trans_user() {
        return $this->belongsTo(User::class, 'trans_user');
    }
    public function adopt(){
        return $this->belongsTo(Adopt::class);
    }
    public function trans_adopt(){
        return $this->belongsTo(Adopt::class, 'trans_adopt');
    }
}
