<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Crypto;
class CryptoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // read all crypto
        $cryptos = Crypto::all();
        return response()->json([
            'cryptos' => $cryptos
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
            // Create Crypto
            $crypto = Crypto::create([
                'name' => $request->name
            ]);
    
            // Return Json Response
            return response()->json([
                'message' => "Crypto successfully created.",
                'crypto' => $crypto
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
        // Crypto Detail 
        $crypto = Crypto::find($id);
        if(!$crypto){
             return response()->json([
                'message'=>'Crypto Not Found.'
            ],404);
        }

        // Return Json Response
        return response()->json([
            'crypto' => $crypto
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
            // Find Crypto
            $crypto = Crypto::find($id);
            if(!$crypto){
              return response()->json([
                'message'=>'Crypto Not Found.'
              ],404);
            }
    
            $crypto->name = $request->name;

            // Update Crypto
            $crypto->save();
    
            // Return Json Response
            return response()->json([
                'message' => "Crypto successfully updated.",
                'crypto' => $crypto
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
        // Crypto Detail 
        $crypto = Crypto::find($id);
        if(!$crypto){
            return response()->json([
                'message'=>'Crypto Not Found.'
            ],404);
        }

        // Delete Post
        $crypto->delete();

        // Return Json Response
        return response()->json([
            'message' => "Crypto successfully deleted."
        ],200);
    }
}
