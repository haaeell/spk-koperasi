<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatPerhitungan extends Model
{
    protected $table = 'riwayat_perhitungan';

    protected $fillable = [
        'kode_koperasi',
        'nilai_akhir',
        'peringkat',
    ];
}
