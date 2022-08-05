<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Http\Resources\CommentResource;
use App\Http\Requests\PostRequest;
use App\Http\Requests\CommentRequest;

class PostController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $posts = Post::paginate(5);
        return response()->json($posts);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function findPost($id)
    {
        $posts = Post::find($id);
        $comments = Comment::where('post_id', $id)->get();
        return response()->json([
            'title' => $posts->title,
            'description' => $posts->description,
            'user_id' => $posts->user_id,
            'status' => $posts->status,
            'url' => $posts->url,
            'comments' => $comments
        ]);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function create(PostRequest $request)
    {
        $post = Post::create([
            'title' => $request['title'],
            'description' => $request['description'],
            'user_id' => auth()->user()->id,
            'status' => $request['status'],
            'url' => $request['url']
        ]);
        
        return new PostResource($post);
    }
    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post, $id)
    {
        if(Post::findOrFail($id)){
            if(auth()->user()->id == Post::find($id)->user_id){
                $post = Post::findOrFail($id);
                $post->update($request->validated());
                return response()->json(["message"=>"Post został zaktualizowany!"]);
            } elseif(auth()->user()->role == 1) {
                $post = Post::where('id', $id)->update($request->validated());
                return response()->json(["message"=>"Post został zaktualizowany!"]);
            } else {
                return response()->json(["message"=>"Nie jesteś właścicielem tego postu!"]);
            }
        } else {
            return response()->json(["message"=>"Nie ma takiego postu, lub został już usunięty!"]);
        }
    }
    /**
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post, $id)
    {
        if(Post::find($id)){
            if(auth()->user()->id == Post::find($id)->user_id){
                Post::find($id)->delete();
                return response()->json(["message"=>"Post $id został usunięty"]);
            } elseif(auth()->user()->role == 1) {
                Post::find($id)->delete();
                return response()->json(["message"=>"Post $id został usunięty"]);
            } else {
                return response()->json(["message"=>"Nie jesteś właścicielem tego postu!"]);
            }
        } else {
            return response()->json(["message"=>"Nie ma takiego postu, lub został już usunięty!"]);
        }
        
    }
    public function storeComment(CommentRequest $request, $id){
        if(Post::find($id)){
            $comment = Comment::create([
                'post_id' => $id,
                'user_id' => auth()->user()->id,
                'content' => $request->content
            ]);
            return new CommentResource($comment);
        } else {
            return response()->json(["message"=>"Nie ma takiego postu, lub został już usunięty!"]);
        }
    }
    public function deleteComment(Comment $comment, Post $post, $id, $comment_id){
        if(Post::find($id)){
            if(auth()->user()->id == Comment::find($comment_id)->user_id || auth()->user()->id == Post::find($id)->user_id){
                Comment::find($comment_id)->delete();
                return response()->json(["message"=>"Komentarz $comment_id został usunięty"]);
            } else {
                return response()->json(["message"=>"Nie jesteś właścicielem tego postu lub komentarza!"]);
            }
        } else {
            return response()->json(["message"=>"Nie ma takiego postu, lub został już usunięty!"]);
        }
    }
}
