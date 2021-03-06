<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adopt extends Model
{
    use HasFactory , SoftDeletes;


    public function user(){
        return $this->belongsTo(User::class);
    }
    public function adopt_image(){
        return $this->hasMany(AdoptImage::class);
    }
    public function category(){
        return $this->belongsToMany(Category::class)->withTimestamps();
    }
    public function trade(){
        return $this->hasOne(Trade::class);
    }
    public function ota_sug(){
        return $this->hasMany(OtaSug::class);
    }
    public function adoptHistories() {
        return $this->hasMany(AdopHistory::class);
    }
}
