<?php

namespace App\Models;

use Eloquent;

class StudentParent extends Eloquent
{
    protected $table = 'student_parents';
    
    protected $fillable = [
        'student_record_id', 'relationship', 'first_name', 'last_name', 'id_number', 'phone_number', 'email'
    ];

    public function studentRecord()
    {
        return $this->belongsTo(StudentRecord::class, 'student_record_id');
    }
}
