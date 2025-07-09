<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perenangs', function (Blueprint $table) {
            $table->id();
            // Tambahkan kolom user_id di sini
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // 'constrained()' akan otomatis membuat foreign key ke tabel 'users'
            // 'onDelete('cascade')' akan menghapus perenang jika user pemiliknya dihapus

            $table->string('nama');
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin');
            $table->float('tinggi');
            $table->float('berat');
            $table->float('panjang_lengan_kiri');
            $table->float('panjang_lengan_kanan');
            $table->float('panjang_armspan');
            $table->float('panjang_kaki');
            $table->string('last_prediction_gaya')->nullable();
            $table->string('last_prediction_jarak')->nullable();
            $table->float('last_prediction_time')->nullable();
            $table->string('last_prediction_performance')->nullable();
            $table->string('last_prediction_percentage')->nullable();
            $table->date('last_prediction_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perenangs');
    }
};