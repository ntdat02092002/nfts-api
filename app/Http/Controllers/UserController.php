<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $user = User::find($id);
        if(!$user){
             return response()->json([
                'message'=>'User Not Found.'
            ],404);
        }

        // Return Json Response
        return response()->json([
            'user' => $user
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
                // Find User
                $user = User::find($id);
                if(!$user){
                    return response()->json([
                        'message'=>'User Not Found.'
                    ],404);
                }
                
                if($request->name) {
                    $user->name = $request->name;
                }
                if($request->email) {
                    $user->email = $request->email;
                }

                // $user->avatar = $request->avatar;
                // $user->cover = $request->cover;
            
                if($request->avatar) {
                    // Public storage
                    $storage = Storage::disk('avatarImages');
                
                    // Old iamge delete
                    if($storage->exists($user->avatar))
                        $storage->delete($user->avatar);
                
                    // Image name
                    $imageNameUser = Str::random(32).".".$request->avatar->getClientOriginalExtension();
                    $user->avatar = $imageNameUser;
                
                    // Image save in public folder
                    $storage->put($imageNameUser, file_get_contents($request->avatar));
                }
                if($request->cover) {
                    // Public storage
                    $storage = Storage::disk('coverImages');
                
                    // Old iamge delete
                    if($storage->exists($user->cover))
                        $storage->delete($user->cover);
                
                    // Image name
                    $imageNameUser = Str::random(32).".".$request->cover->getClientOriginalExtension();
                    $user->cover = $imageNameUser;
                
                    // Image save in public folder
                    $storage->put($imageNameUser, file_get_contents($request->cover));
                }

                // Update User
                $user->save();
                
                // Return Json Response
                return response()->json([
                    'message' => "User successfully updated.",
                    'user' => $user
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
        // User Detail 
        $user = User::find($id);
        if(!$user){
            return response()->json([
                'message'=>'User Not Found.'
            ],404);
        }

        // Public storage
        $storageUser = Storage::disk('userImages');

        // Iamge delete
        if($storageUser->exists($user->avatar))
            $storageUser->delete($user->avatar);

        if($storageUser->exists($user->cover))
            $storageUser->delete($user->cover);

        // Delete User
        $user->delete();

        // Return Json Response
        return response()->json([
            'message' => "User successfully deleted."
        ],200);
    }
}
