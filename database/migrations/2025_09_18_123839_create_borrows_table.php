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
        Schema::create('borrows', function (Blueprint $table) {
            $table->id();
            $table->string("kode_pinjam", 45)->unique();
            $table->foreignId("user_id")->constrained();
            $table->foreignId("book_id")->constrained();
            $table->date("tgl_pinjam");
            $table->date("tgl_kembali")->nullable();
            $table->string("status_pinjam")->default("menunggu");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrows');
    }
};
