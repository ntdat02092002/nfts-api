<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountBlance;

class AccountBalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // read all AccountBlance
        $accountBlances = AccountBlance::all();
        return response()->json([
            'accountBlances' => $accountBlances
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
            // Create AccountBlance
            $accountBlance = AccountBlance::create([
                'user_id' => $request->user_id,
                'crypto_id' => $request->crypto_id,
                'balance' => $request->balance
            ]);
    
            // Return Json Response
            return response()->json([
                'message' => "Account Blance successfully created.",
                'accountBlance' => $accountBlance
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
        // AccountBlance Detail 
        $accountBlance = AccountBlance::find($id);
        if(!$accountBlance){
             return response()->json([
                'message'=>'Account Blance Not Found.'
            ],404);
        }

        // Return Json Response
        return response()->json([
            'accountBlance' => $accountBlance
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
            $accountBlance = AccountBlance::find($id);
            if(!$accountBlance){
              return response()->json([
                'message'=>'Account Blance Not Found.'
              ],404);
            }
    
            $accountBlance->user_id = $request->user_id;
            $accountBlance->crypto_id = $request->crypto_id;
            $accountBlance->balance = $request->balance;

            // Update AccountBlance
            $accountBlance->save();
    
            // Return Json Response
            return response()->json([
                'message' => "Account Blance successfully updated.",
                'accountBlance' => $AccountBlance
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
        $accountBlance = AccountBlance::find($id);
        if(!$accountBlance){
            return response()->json([
                'message'=>'Account Blance Not Found.'
            ],404);
        }

        // Delete Post
        $accountBlance->delete();

        // Return Json Response
        return response()->json([
            'message' => "Account Blance successfully deleted."
        ],200);
    }
}
