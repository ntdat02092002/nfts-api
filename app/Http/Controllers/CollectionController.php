<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Collection;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // read all collection
        $collections = Collection::all();
        return response()->json([
            'collections' => $collections
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
            $collection = Collection::create([
                'name' => $request->name,
                'creator_id' => $request->creator_id,
                'owner_id' => $request->owner_id,
                'topic_id' => $request->topic_id,
                'reaction' => $request->reaction,
                'status' => $request->status,
                'price' => $request->price
            ]);
    
            // Return Json Response
            return response()->json([
                'message' => "Collection successfully created.",
                'collection' => $collection
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
        $collection = Collection::find($id);
        if(!$collection){
             return response()->json([
                'message'=>'Collection Not Found.'
            ],404);
        }

        // Return Json Response
        return response()->json([
            'collection' => $collection
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
            // Find Collection
            $collection = Collection::find($id);
            if(!$collection){
              return response()->json([
                'message'=>'Collection Not Found.'
              ],404);
            }
    
            $collection->name = $request->name;
            $collection->owner_id = $request->owner_id;
            $collection->topic_id = $request->topic_id;
            $collection->reaction = $request->reaction;
            $collection->status = $request->status;
            $collection->price = $request->price;

            // Update Post
            $collection->save();
    
            // Return Json Response
            return response()->json([
                'message' => "Collection successfully updated.",
                'collection' => $post
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
        $collection = Collection::find($id);
        if(!$collection){
            return response()->json([
                'message'=>'Collection Not Found.'
            ],404);
        }

        // Delete Post
        $collection->delete();

        // Return Json Response
        return response()->json([
            'message' => "Collection successfully deleted."
        ],200);
    }
}
