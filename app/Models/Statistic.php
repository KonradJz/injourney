<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_count',
        'posts_count',
        'latest_user_id',
        'latest_user_email',
        'latest_user_created_at',
        'latest_post_title',
        'latest_post_id',
        'latest_post_created_at'
    ];
}
