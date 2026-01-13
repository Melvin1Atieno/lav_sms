<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class County extends Model
{
    use HasFactory;

    protected $primaryKey = 'county_id';
    
    public function ministry()
    {
       // return $this->hasMany(Ministry::class);
    }
}
