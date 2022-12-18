<?php

namespace App\Http\Controllers;
use App\Models\Nft;
use Illuminate\Http\Request;
use App\Filters\NftFilter;
use Illuminate\Support\Str;
use Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NFTController extends Controller
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

        $NftFilter = new NftFilter($request);
        $nfts = Nft::filter($NftFilter)
            ->orderBy($orderField, $order);
        $total = $nfts->count();

        $nfts= $nfts
            ->offset($offset)
            ->limit($limit)
            ->get();
        $currentPage = $nfts->count();

        // Return Json Response
        return response()->json([
            'nfts' => $nfts,
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
        $imageNft = Str::random(32).".".$request->url_image_nft->getClientOriginalExtension();
        try {
            // Create NFT
            $nft = Nft::create([
                'name' => $request->name,
                'crypto_id' => $request->crypto_id,
                'description' => $request->description,
                // 'url_image_nft' => $request->url_image_nft,
                'url_image_nft' => $imageNft,
                'owner_id' => $request->owner_id,
                'creator_id' => $request->creator_id,
                'collection_id' => $request->collection_id,
                'reaction' => $request->reaction,
                'status' => $request->status,
                'price' => $request->price
            ]);
    
            # Save Image nft
            Storage::disk('nftImages')->put($imageNft, file_get_contents($request->url_image_nft));

            // Return Json Response
            return response()->json([
                'message' => "NFT successfully created.",
                'nft' => $nft
            ],200);
        } catch (\Exception $e) {
            // Return Json Response
            return response()->json([
                'message' => "Something went really wrong!",
                'e' =>$e
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
        // NFT Detail 
        $nft = Nft::with("collection", "creator", "owner", "crypto")->find($id);
        if(!$nft){
             return response()->json([
                'message'=>'NFT Not Found.'
            ],404);
        }

        // Return Json Response
        return response()->json([
            'nft' => $nft
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
            $nft = Nft::find($id);
            if(!$nft){
              return response()->json([
                'message'=>'NFT Not Found.'
              ],404);
            }
    
            $nft->name = $request->name;
            $nft->crypto_id = $request->crypto_id;
            $nft->description = $request->description;
            // $nft->url_image_nft = $request->url_image_nft;
            $nft->owner_id = $request->owner_id;
            $nft->creator_id = $request->creator_id;
            $nft->collection_id = $request->collection_id;
            $nft->reaction = $request->reaction;
            $nft->status = $request->status;
            $nft->price = $request->price;

            if($request->url_image_nft) {
                // Public storage
                $storage = Storage::disk('nftImages');
    
                // Old iamge delete
                if($storage->exists($nft->url_image_nft))
                    $storage->delete($nft->url_image_nft);
    
                // Image name
                $imageNameNft = Str::random(32).".".$request->url_image_nft->getClientOriginalExtension();
                $nft->url_image_nft = $imageNameNft;
    
                // Image save in public folder
                $storage->put($imageNameNft, file_get_contents($request->url_image_nft));
            }

            // Update Nft
            $nft->save();
    
            // Return Json Response
            return response()->json([
                'message' => "NFT successfully updated.",
                'nft' => $nft
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
        $nft = Nft::find($id);
        if(!$nft){
            return response()->json([
                'message'=>'NFT Not Found.'
            ],404);
        }
        // Public storage
        $storageNft = Storage::disk('nftImages');
        if($storageNft->exists($nft->url_image_nft))
            $storageNft->delete($nft->url_image_nft);

        // Delete Nft
        $nft->delete();

        // Return Json Response
        return response()->json([
            'message' => "NFT successfully deleted."
        ],200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trending(Request $request)
    {
        $limit = $request->limit ? $request->limit : 20;
        $page = $request->page && $request->page > 0 ? $request->page : 1;
        $offset = ($page - 1) * $limit;
        
        DB::statement("SET SQL_MODE=''");//this is the trick use it just before your query where you have used group by. Note: make sure your query is correct.

        $nfts = Nft::with("collection", "creator", "owner", "crypto")
            ->join('transactions', 'nfts.id', '=', 'transactions.nft_id')
            ->select('nfts.*', DB::raw('count(*) as number_of_transaction'))
            ->whereDate('transactions.created_at', Carbon::yesterday())
            ->groupBy('nfts.id')
            ->orderByRaw('count(*) DESC');

        $total = $nfts->count();

        $nfts= $nfts
            ->offset($offset)
            ->limit($limit)
            ->get();
        $currentPage = $nfts->count();

        // Return Json Response
        return response()->json([
            'nfts' => $nfts,
            'page' => $page,
            'currentPage' => $currentPage,
            'total' => $total
        ], 200);
    }
}
