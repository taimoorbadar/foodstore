<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branches extends Model
{
    protected $fillable = [
        'bid', 'bname', 'baddress',
    ];
}
