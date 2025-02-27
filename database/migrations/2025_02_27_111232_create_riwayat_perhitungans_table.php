<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('riwayat_perhitungan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_koperasi');
            $table->decimal('nilai_akhir', 8, 4);
            $table->integer('peringkat');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('riwayat_perhitungans');
    }
};
