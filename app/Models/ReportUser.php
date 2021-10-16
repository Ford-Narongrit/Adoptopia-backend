<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportUser extends Model
{
    use HasFactory;

    public function reportBy(){
        return $this->belongsTo(User::class, 'reported_by','id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id','id');
    }
}
