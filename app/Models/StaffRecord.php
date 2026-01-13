<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StaffRecord extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'emp_date', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
