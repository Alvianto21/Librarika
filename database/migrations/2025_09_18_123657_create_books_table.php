<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string("judul");
            $table->string("slug")->unique();
            $table->char("ISBN", 13)->unique();
            $table->string("penulis");
            $table->string("penerbit")->nullable();
            $table->year("tahun_terbit")->nullable();
            $table->string("foto_sampul")->nullable();
            $table->integer("jml_pinjam")->default(0);
            $table->string("kondisi");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
