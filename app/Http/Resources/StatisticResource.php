<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StatisticResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        
        return [
            'users_count' => $this->users_count,
            'posts_count' => $this->posts_count,
            'latest_user_id' => $this->latest_user_id,
            'latest_user_email' => $this->latest_user_email,
            'latest_user_created_at' => $this->latest_user_created_at,
            'latest_post_title' => $this->latest_post_title,
            'latest_post_id' => $this->latest_post_id,
            'latest_post_created_at' => $this->latest_post_created_at
        ];
    }
}
