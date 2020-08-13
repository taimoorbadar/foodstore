<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable = [
        'branch_id', 'name', 'price','catagory',
    ];
}
