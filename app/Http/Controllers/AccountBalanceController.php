<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountBlance;
use App\Filters\AccountBalanceFilter;

class AccountBalanceController extends Controller
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

        $AccountBalanceFilter = new AccountBalanceFilter($request);
        $accountBalances = AccountBlance::filter($AccountBalanceFilter)
            ->orderBy($orderField, $order);
        $total = $accountBalances->count();

        $accountBalances = $accountBalances
            ->offset($offset)
            ->limit($limit)
            ->get();
        $currentPage = $accountBalances->count();

        // Return Json Response
        return response()->json([
            'accountBalances' => $accountBalances,
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
 
            $accountBlance->balance += $request->balance;

            // Update AccountBlance
            $accountBlance->save();
    
            // Return Json Response
            return response()->json([
                'message' => "Account Blance successfully updated.",
                'accountBlance' => $accountBlance
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
