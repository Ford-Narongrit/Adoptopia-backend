<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowerUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'follower_id',
        'following_id',
        'accepted_at'
    ];

    public $table = "follower_user";
}
