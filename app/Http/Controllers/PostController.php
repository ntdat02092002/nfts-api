<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Filters\postFilter;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // All Posts
        // $posts = Post::all();

        $postFilter = new postFilter($request);
        $posts = Post::filter($postFilter)->get();
        $total = $posts->count();

        // Return Json Response
        return response()->json([
            'posts' => $posts,
            'total' => $total
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // Create Post
            $post = Post::create([
                'name' => $request->name,
                'description' => $request->description
            ]);
    
            // Return Json Response
            return response()->json([
                'message' => "Post successfully created.",
                'post' => $post
            ],200);
        } catch (\Exception $e) {
            // Return Json Response
            return response()->json([
                'message' => "Something went really wrong!"
            ],500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Post Detail 
        $post = Post::find($id);
        if(!$post){
             return response()->json([
                'message'=>'Post Not Found.'
            ],404);
        }

        // Return Json Response
        return response()->json([
            'post' => $post
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            // Find Post
            $post = Post::find($id);
            if(!$post){
              return response()->json([
                'message'=>'Post Not Found.'
              ],404);
            }
    
            $post->name = $request->name;
            $post->description = $request->description;

            // Update Post
            $post->save();
    
            // Return Json Response
            return response()->json([
                'message' => "Post successfully updated.",
                'post' => $post
            ],200);
        } catch (\Exception $e) {
            // Return Json Response
            return response()->json([
                'message' => "Something went really wrong!",
            ],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Post Detail 
        $post = Post::find($id);
        if(!$post){
            return response()->json([
                'message'=>'Post Not Found.'
            ],404);
        }

        // Delete Post
        $post->delete();

        // Return Json Response
        return response()->json([
            'message' => "Post successfully deleted."
        ],200);
    }
}
