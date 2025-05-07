<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiSiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pelajaran_id',
        'classroom_id',
        'date',
        'check_in_time',
        'check_out_time',
        'status',
        'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function pelajaran()
    {
        return $this->belongsTo(Pelajaran::class);
    }
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
}
