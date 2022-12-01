<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;

class Collection extends Model
{
    use HasFactory;
    use Filterable;

    protected $table = 'collections';

    protected $fillable = [
    	'name',
        'url_image_logo',
        'url_image_banner',
        'creator_id',
        'owner_id',
        'topic_id',
        'reaction',
        'status',
        'price'
    ];

    public function creator() 
    {
        return $this->belongsTo('App\Models\User', 'creator_id');
    }

    public function owner() 
    {
        return $this->belongsTo('App\Models\User', 'owner_id');
    }

    public function topic() 
    {
        return $this->belongsTo('App\Models\Topic', 'topic_id');
    }

    public function nfts()
    {
        return $this->hasMany('App\Models\Nft');
    }
}
