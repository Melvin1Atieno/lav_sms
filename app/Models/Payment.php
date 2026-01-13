<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'amount', 'my_class_id', 'description', 'year', 'ref_no'];

    public function my_class()
    {
        return $this->belongsTo(MyClass::class);
    }
}
