<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('koperasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kode');
            $table->string('alamat');
            $table->timestamps();
        });

        Schema::create('kriteria', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kode');
            $table->decimal('bobot', 5, 2);
            $table->enum('jenis', ['benefit', 'cost']);
            $table->timestamps();
        });

        Schema::create('sub_kriteria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kriteria_id')->constrained('kriteria')->onDelete('cascade');
            $table->string('nama');
            $table->string('kode');
            $table->decimal('bobot', 5, 2);
            $table->timestamps();
        });

        Schema::create('alternatif', function (Blueprint $table) {
            $table->id();
            $table->foreignId('koperasi_id')->constrained('koperasi')->onDelete('cascade');
            $table->foreignId('kriteria_id')->constrained('kriteria')->onDelete('cascade');
            $table->foreignId('sub_kriteria_id')->constrained('sub_kriteria')->onDelete('cascade');
            $table->decimal('nilai', 8, 2);
            $table->timestamps();
        });
    
    
    }
    public function down(): void
    {
        Schema::dropIfExists('koperasi');
        Schema::dropIfExists('kriteria');
        Schema::dropIfExists('alternatif');
        Schema::dropIfExists('sub_kriteria');
    }
};
