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
    	'name',
        'image_url'
    ];

    public function collections()
    {
        return $this->hasMany('App\Models\Collection');
    }
}
