<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Filters\TopicFilter;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orderField = $request->orderBy ? $request->orderBy : 'id';
        $order = $request->order ? $request->order : 'asc';
        $limit = $request->limit ? $request->limit : 20;
        $page = $request->page && $request->page > 0 ? $request->page : 1;
        $offset = ($page - 1) * $limit;

        $TopicFilter = new TopicFilter($request);
        $topics = Topic::filter($TopicFilter)
            ->orderBy($orderField, $order);
        $total = $topics->count();

        $topics = $topics
            ->offset($offset)
            ->limit($limit)
            ->get();
        $currentPage = $topics->count();

        // Return Json Response
        return response()->json([
            'topics' => $topics,
            'page' => $page,
            'currentPage' => $currentPage,
            'total' => $total
        ], 200);
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
            // Create Topic
            Topic::create([
                'name' => $request->name,
                'image_url' => $request->image_url
            ]);

            // Return Json Response
            return response()->json([
                'message' => "Topic successfully created."
            ], 200);
        } catch (\Exception $e) {
            // Return Json Response
            return response()->json([
                'message' => "Something went really wrong!"
            ], 500);
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
        //Topics Detail
        $topic = Topic::find($id);
        if ($topic) {
            return response()->json([
                'message' => 'Topic Not Found'
            ], 404);
        }

        return response()->json([
            'topic' => $topic
        ], 200);
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
            $topic = Topic::find($id);
            if (!$topic) {
                return response()->json([
                    'message' => 'Topic Not Found.'
                ], 404);
            }

            $topic->name = $request->name;
            $topic->image_url = $request->image_url;

            // if($request->image_url) {
            //     // Public storage
            //     $storage = Storage::disk('public');

            //     // Old iamge delete
            //     if($storage->exists($topic->image))
            //         $storage->delete($topic->image);

            //     // Image name
            //     $imageName = Str::random(32).".".$request->image->getClientOriginalExtension();
            //     $topic->image = $imageName;

            //     // Image save in public folder
            //     $storage->put($imageName, file_get_contents($request->image));
            // }

            // Update Post
            $topic->save();

            // Return Json Response
            return response()->json([
                'message' => "Topic successfully updated."
            ], 200);
        } catch (\Exception $e) {
            // Return Json Response
            return response()->json([
                'message' => "Something went really wrong!"
            ], 500);
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
        $topic = Topic::find($id);
        if (!$topic) {
            return response()->json([
                'message' => 'Topic Not Found.'
            ], 404);
        }

        // Public storage
        // $storage = Storage::disk('public');

        // Iamge delete
        // if($storage->exists($topic->image))
        //     $storage->delete($topic->image);

        // Delete Post
        $topic->delete();

        // Return Json Response
        return response()->json([
            'message' => "Topic successfully deleted."
        ], 200);
    }
}