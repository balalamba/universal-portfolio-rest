<?php

namespace App\Http\Controllers;

use App\Blog;
use App\User;
use Illuminate\Http\Request;
use JWTAuth;

class adminController extends Controller
{

    public function allUsers(Request $request)
    {
    	$users = User::all();
        $response = [
        'users' => $users
        ];
        return response()->json($response,200);
    }
    // public function deleteBlog(Request $request, $id)
    // {
    //     $blog = Blog::find($id);
    //     if(!$blog){
    //         return response()->json(["message" => "Blog was\'n found."],404);
    //     }
    //     $blog->delete();
    //     $response = [
    //     'message' => 'Post deleted.'
    //     ];
    //     return response()->json($response,200);
    // }
    // public function putBlog(Request $request, $id)
    // {
    //     $blog = Blog::find($id);
    //     if(!$blog){
    //         return response()->json(["message" => "Blog was\'n found."],404);
    //     }
    //     $blog->content = $request->input('content');
    //     $blog->title = $request->input('title');
    //     $blog->slug = $request->input('slug');
    //     $blog->save();
    //     $response = [
    //     'blog' => $blog
    //     ];
    //     return response()->json($response,200);
    // }
    // public function addBlog(Request $request)
    // {
    //         // if(!$user = JWTAuth::parseToken()->authenticate()) {
    //      //        return response()->json(["message" => "User not found"],404);
    //      //    }
    //         $blog = new Blog();
    //         $blog->title = $request->input('title');
    //         $blog->content = $request->input('title');
    //         $blog->active = $request->input('active');
    //         $blog->slug = $request->input('slug');
    //         $blog->save();
    //         return response()->json([
    //             'blog' => $blog
    //             ],201);
    // }
};
