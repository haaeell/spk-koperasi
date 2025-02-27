<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubKriteria extends Model
{
    use HasFactory;

    protected $table = 'sub_kriteria';
    protected $fillable = ['nama', 'bobot', 'kriteria_id', 'kode'];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }

}
