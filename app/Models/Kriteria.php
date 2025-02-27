<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;

    protected $table = 'kriteria';
    protected $fillable = ['nama', 'bobot', 'jenis', 'kode'];

    public function alternatif()
    {
        return $this->hasMany(Alternatif::class);
    }

    public function subKriterias()
    {
        return $this->hasMany(SubKriteria::class);
    }
    public function subKriteria()
    {
        return $this->hasMany(SubKriteria::class);
    }

}
