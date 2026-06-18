<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('userId');
            $table->string('nama');
            $table->longText('alamat');
            $table->string('provinsi');
            $table->string('kota');
            $table->date('tanggal');
            $table->string('noTransaksi')->default('-');
            $table->string('produk');
            $table->integer('vol');
            $table->integer('harga');
            $table->integer('ongkir')->default(0);
            $table->integer('subsidi')->default(0);
            $table->integer('jumlahBayar');
            $table->string('rekening');
            $table->string('ekspedisi');
            $table->string('statusCustomer');
            $table->string('statusRO')->nullable();
            $table->string('promoCRM')->nullable();
            $table->string('namaCS');
            $table->string('namaADV')->nullable();
            $table->string('kategoriDivisi')->nullable();
            $table->string('namaInputter');
            $table->string('gudang');
            $table->string('ket')->nullable();
            $table->string('namaToko')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
