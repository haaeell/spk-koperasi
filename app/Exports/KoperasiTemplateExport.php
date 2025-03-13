<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;

class KoperasiTemplateExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return ["Kode", "Nama", "Alamat"];
    }

    public function array(): array
    {
        return [
            ["K001", "Koperasi Makmur", "Jl. Sudirman No. 1"],
            ["K002", "Koperasi Sejahtera", "Jl. Merdeka No. 5"],
        ];
    }
}
