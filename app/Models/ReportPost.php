<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportPost extends Model
{
    use HasFactory;

    public function reportBy(){
        return $this->belongsTo(User::class, 'reported_by','id');
    }

    public function post(){
        return $this->belongsTo(Trade::class, 'post_id','id');
    }
}
