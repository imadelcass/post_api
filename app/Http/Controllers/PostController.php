<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Post::with('category')->latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        $post = Post::create([
            "title" => $request->title,
            "body" => $request->body,
            "category_id" => $request->category_id,
            "user_id" => Auth::user()->id,
        ]);

        return response()->json([
            "success" => true,
            "post" => Post::with('category')->where('id', $post->id)->get(),
            "msg" => "The post is created"], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return response()->json(Post::with('category')->where('id', $post->id)->get());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update($request->only(["title", "body", "category_id"]));
        return response()->json([
            "success" => true,
            "post" => Post::with('category')->where('id', $post->id)->get(),
            "msg" => "The post is updated"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if (Gate::allows('delete-post', $post)) {
            $post->delete();
            return response()->json([
                "success" => true,
                "post" => $post,
                "msg" => "The post is deleted"]);
        }
        return response()->json(["success" => false, "msg" => "The post is not deleted"], 403);
    }
}
