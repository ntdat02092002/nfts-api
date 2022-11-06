<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;

class Topic extends Model
{
    use HasFactory;
    use Filterable;

    protected $table = 'topics';

    protected $fillable = [
    	'name'
    ];
}
