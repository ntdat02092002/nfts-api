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
        'creator_id',
        'owner_id',
        'topic_id',
        'reaction',
        'status'
    ];
}
