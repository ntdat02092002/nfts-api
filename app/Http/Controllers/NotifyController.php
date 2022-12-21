<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notify;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Filters\NotifyFilter;

class NotifyController extends Controller
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

        $notifyFilter = new NotifyFilter($request);
        $notifies = Notify::filter($notifyFilter)
            ->orderBy($orderField, $order);
        $total = $notifies->count();

        $notifies= $notifies
            ->offset($offset)
            ->limit($limit)
            ->get();
        $currentPage = $notifies->count();

        // Return Json Response
        return response()->json([
            'notifies' => $notifies,
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
            // Create Notify
            $notify = Notify::create([
                'user_id' => $request->user_id,
                'notify' => $request->notify,
                'seen' => $request->seen,
            ]);
            
            // Return Json Response
            return response()->json([
                'message' => "Notify successfully created.",
                'notify' => $notify
            ],200);
        } catch (\Exception $e) {
            // Return Json Response
            return response()->json([
                'message' => "Something went really wrong!",
                'e' => $e
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
