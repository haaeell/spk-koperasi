<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternatif extends Model
{
    use HasFactory;

    protected $table = 'penilaian';
    protected $fillable = ['koperasi_id', 'sub_kriteria_id','kriteria_id', 'nilai'];

    public function koperasi()
    {
        return $this->belongsTo(Koperasi::class);
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }

    public function subKriteria()
    {
        return $this->belongsTo(SubKriteria::class);
    }
}
