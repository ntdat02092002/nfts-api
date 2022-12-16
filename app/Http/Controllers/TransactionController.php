<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Nft;
use Illuminate\Support\Facades\DB;
use App\Filters\TransactionFilter;

class TransactionController extends Controller
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

        $TransactionFilter = new TransactionFilter($request);
        $transactions = Transaction::filter($TransactionFilter)
            ->orderBy($orderField, $order);
        $total = $transactions->count();

        $transactions = $transactions
            ->offset($offset)
            ->limit($limit)
            ->get();
        $currentPage = $transactions->count();

        // Return Json Response
        return response()->json([
            'transactions' => $transactions,
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
            // Xử lí trước khi tạo một giao dịch mới
            $nft = Nft::find($request->nft_id);
            if(!$nft) {
              return response()->json([
                'message'=>'NFT Not Found.'
              ], 404);
            }

            if ($nft->status == false) {
                return response()->json([
                    'message'=>'NFT is not for sale.'
                  ], 400);
            }

            $buyer_id = $request->buyer_id;

            $balance_buyer = DB::table("account_blances")
                ->where('user_id',$buyer_id)->value('balance');
            if($balance_buyer < $request->price) {
                return response()->json([
                    'message' => "Số dư tài khoản của bạn không đủ để thực hiện giao dịch này! 
                    Vui lòng nạp thêm tiền vào tài khoản"
                ], 400);
            }
            else {
                // Cập nhật số dư của ngươi mua
                DB::table("account_blances")
                    ->where('user_id',$request->buyer_id)
                    ->update(["balance" => ($balance_buyer - $request->price)]);

                // Cập nhật số dư của ngươi bán
                $balance_seller = DB::table("account_blances")
                    ->where("user_id",$request->seller_id)->value('balance');

                DB::table("account_blances")
                    ->where("user_id",$request->seller_id)
                    ->update(["balance" => ($balance_seller + $request->price)]);
                
                // Cập nhật id người sở hữu nft và giá của nft sau khi bán
                DB::table("nfts")
                    ->where("id",$request->nft_id)
                    ->update(["owner_id" => $request->buyer_id,
                                "price" => $request->price,
                                "status" => false]
                            );
            }

            // Create Transaction
            $transaction = Transaction::create([
                'name' => $request->name,
                'buyer_id' => $request->buyer_id,
                'seller_id' => $request->seller_id,
                'nft_id' => $request->nft_id,
                'date' => $request->date,
                'crypto_id' => $request->crypto_id,
                'price' => $request->price
            ]);

            return response()->json([
                'message' => "Transaction successfully created.",
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
        $transaction = Transaction::find($id);
        if(!$transaction){
             return response()->json([
                'message'=>'Transaction Not Found.'
            ],404);
        }

        // Return Json Response
        return response()->json([
            'transaction' => $transaction
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
            // Find Transactions
            $transaction = Transaction::find($id);
            if(!$transaction){
              return response()->json([
                'message'=>'Transaction Not Found.'
              ],404);
            }
    
            $transaction->name = $request->name;
            $transaction->buyer_id = $request->buyer_id;
            $transaction->seller_id = $request->seller_id;
            $transaction->nft_id = $request->nft_id;
            $transaction->date = $request->date;
            $transaction->crypto_id = $request->crypto_id;
            $transaction->price = $request->price;

            // Update Transaction
            $transaction->save();
    
            // Return Json Response
            return response()->json([
                'message' => "Transaction successfully updated.",
                'transaction' => $transaction
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
        // Transaction Detail 
        $transaction = Transaction::find($id);
        if(!$transaction){
            return response()->json([
                'message'=>'Transaction Not Found.'
            ],404);
        }

        // Delete Post
        $transaction->delete();

        // Return Json Response
        return response()->json([
            'message' => "Transaction successfully deleted."
        ],200);
    }
}
