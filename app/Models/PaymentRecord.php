<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentRecord extends Model
{
    use HasFactory;

    protected $fillable =['student_id', 'payment_id', 'amt_paid', 'year', 'paid', 'balance', 'ref_no'];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function receipt()
    {
        return $this->hasMany(Receipt::class, 'pr_id');
    }
}
