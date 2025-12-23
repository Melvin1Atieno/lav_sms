<?php

namespace App\Models;

use Eloquent;

class County extends Eloquent
{

    protected $primaryKey = 'county_id';
    public function ministry()
    {
       // return $this->hasMany(Ministry::class);
    }
}
