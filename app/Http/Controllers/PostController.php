<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Post;
use Validator;



class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = DB::table('posts');
        
        if($request->user_id){
            //user posts by (user_id)
            return $posts->where('user_id', $request->user_id);   
            
        }elseif ($request->id) {
            //single post by (id) 
            return $posts->where('id', $request->id)->first();   
        }
        else{
            //all posts
            return $posts->get();
        }
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required|unique:posts|max:255',
            'body' => 'required',
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
            ]);
        } else {
            $post = Post::create($request->all());
            return response()->json([
                "success" => true,
            ]);
        }
    }
    public function update(Request $request)
    {
        $user = Auth::user();
        if(!$user->isAdmin && $user->id != $request->user_id){
            return response()->json([
                "success" => false,
                "msg" => "not your post",
            ]);
        }else{

            $validator = Validator::make($request->all(),[
                'title' => 'required|max:255',
                'body' => 'required',
                'user_id' => 'required|exists:users,id',
                'category_id' => 'required|exists:categories,id',
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    "success" => false,
                ]);
            } else {
                Post::where('id', $request->id)->update($request->all());
                return response()->json([
                    "success" => true,
                    "user" => $user,
                ]);
            }
        }
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();
        if(!$user->isAdmin && $user->id != $request->user_id){
            return response()->json([
                "success" => false,
                "msg" => "not your post",
            ]);
        }else{
            $post = Post::where('id', $request->id)->delete();
            if (!Post::where('id', $request->id)->exists()) {
                return response()->json([
                    "success" => true,
                ]);
            }
        }
    }

    public function login(Request $request)
    {
        if (Auth::attempt($request->only('name', 'password'))) {
            $user = Auth::user();
            $token = User::find($user->id)->createToken('auth_token')->plainTextToken;
            return response()->json([
                'user' => $user,
                'success' => true,
                'token' => $token,
            ]);
        }
    }
}
