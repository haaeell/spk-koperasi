<?php
namespace App\Imports;

use App\Models\Koperasi;
use Maatwebsite\Excel\Concerns\ToModel;

class KoperasiImport implements ToModel
{
    public function model(array $row)
    {
        return new Koperasi([
            'kode' => $row[0],
            'nama' => $row[1],
            'alamat' => $row[2],
        ]);
    }
}
