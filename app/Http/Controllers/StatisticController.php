<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Statistic;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Http\Requests\PostRequest;
use App\Http\Resources\UserResource;
use App\Http\Requests\UserRequest;
use App\Http\Resources\StatisticResource;
use App\Http\Requests\StatisticRequest;

class StatisticController extends Controller
{
    public function index(StatisticRequest $request){
        $usersCount = User::count();
        $postsCount = Post::count();
        $latestUser = User::orderBy('created_at', 'DESC')->first();
        $latestPost = Post::orderBy('created_at', 'DESC')->first();
        Statistic::create([
            'users_count' => $usersCount,
            'posts_count' => $postsCount,
            'latest_user_id' => $latestUser->id,
            'latest_user_email' => $latestUser->email,
            'latest_user_created_at' => $latestUser->created_at->diffForHumans(),
            'latest_post_title' => $latestPost->title,
            'latest_post_id' => $latestPost->id,
            'latest_post_created_at' => $latestPost->created_at->diffForHumans()
        ]);
        return response()->json([
            'users_count' => $usersCount,
            'posts_count' => $postsCount,
            'latest_user_id' => $latestUser->id,
            'latest_user_email' => $latestUser->email,
            'latest_user_created_at' => $latestUser->created_at->diffForHumans(),
            'latest_post_title' => $latestPost->title,
            'latest_post_id' => $latestPost->id,
            'latest_post_created_at' => $latestPost->created_at->diffForHumans()
        ]);
    }
}
