<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
     protected $table = 'attendance';

    public function student()
    {
        return $this->belongsTo(User::class, 'stu_id');
    }

    protected $fillable = [
    'stu_id',
    'date',
    'status',
];
}
