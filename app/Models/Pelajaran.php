<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelajaran extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'code', 'start_time', 'end_time', 'classroom_id'];

    public function absensisiswas()
    {
        return $this->hasMany(AbsensiSiswa::class);
    }
    public function classroom()
    {
        return $this->belongsTo(\App\Models\Classroom::class);
    }
    }
