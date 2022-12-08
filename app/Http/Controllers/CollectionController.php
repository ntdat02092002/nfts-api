<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collection;
use App\Filters\CollectionFilter;

class CollectionController extends Controller
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

        $collectionFilter = new CollectionFilter($request);
        $collections = Collection::filter($collectionFilter)
            ->orderBy($orderField, $order);
        $total = $collections->count();

        $collections= $collections
            ->offset($offset)
            ->limit($limit)
            ->get();
        $currentPage = $collections->count();

        // Return Json Response
        return response()->json([
            'collections' => $collections,
            'page' => $page,
            'currentPage' => $currentPage,
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

            $imageNameLogo = Str::random(32).".".$request->url_image_logo->getClientOriginalExtension();
            $imageNameBanner = Str::random(32).".".$request->url_image_banner->getClientOriginalExtension();
            // Create Post
            $collection = Collection::create([
                'name' => $request->name,
                'url_image_logo' => $imageNameLogo,
                'url_image_banner' => $imageNameBanner,
                'creator_id' => $request->creator_id,
                'owner_id' => $request->owner_id,
                'topic_id' => $request->topic_id,
                'reaction' => $request->reaction,
                'status' => $request->status,
            ]);
            
            // Save Image in Storage folder
            Storage::disk('public')->put($imageNameLogo, file_get_contents($request->url_image_logo));
            Storage::disk('public')->put($imageNameBanner, file_get_contents($request->url_image_banner));
            
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
            // $collection->url_image_logo = $request->url_image_logo;
            // $collection->url_image_banner = $request->url_image_banner;
            $collection->owner_id = $request->owner_id;
            $collection->topic_id = $request->topic_id;
            $collection->reaction = $request->reaction;
            $collection->status = $request->status;

            if($request->url_image_logo) {
                // Public storage
                $storage = Storage::disk('public');
    
                // Old iamge delete
                if($storage->exists($collection->url_image_logo))
                    $storage->delete($collection->url_image_logo);
    
                // Image name
                $imageNameLogo = Str::random(32).".".$request->url_image_logo->getClientOriginalExtension();
                $collection->url_image_logo = $imageNameLogo;
    
                // Image save in public folder
                $storage->put($imageNameLogo, file_get_contents($request->url_image_logo));
            }
            if($request->url_image_banner) {
                // Public storage
                $storage = Storage::disk('public');
    
                // Old iamge delete
                if($storage->exists($collection->url_image_banner))
                    $storage->delete($collection->url_image_banner);
    
                // Image name
                $imageNameBanner = Str::random(32).".".$request->url_image_banner->getClientOriginalExtension();
                $collection->url_image_banner = $imageNameBanner;
    
                // Image save in public folder
                $storage->put($imageNameBanner, file_get_contents($request->url_image_banner));
            }

            // Update Post
            $collection->save();
    
            // Return Json Response
            return response()->json([
                'message' => "Collection successfully updated.",
                'collection' => $collection
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

        // Public storage
        $storage = Storage::disk('public');

        // Iamge delete
        if($storage->exists($collection->url_image_logo))
            $storage->delete($collection->url_image_logo);

        if($storage->exists($collection->url_image_banner))
            $storage->delete($collection->url_image_banner);

        // Delete Post
        $collection->delete();

        // Return Json Response
        return response()->json([
            'message' => "Collection successfully deleted."
        ],200);
    }
}
