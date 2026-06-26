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
        // Tabel bulan
        Schema::create('tb_bulan', function (Blueprint $table) {
            $table->char('id_bulan', 3)->primary();
            $table->string('nama_bulan', 10);
        });

        // Tabel layanan
        Schema::create('tb_layanan', function (Blueprint $table) {
            $table->id('id_layanan');
            $table->string('layanan', 20);
            $table->integer('tarif');
        });

        // Tabel pelanggan
        Schema::create('tb_pelanggan', function (Blueprint $table) {
            $table->char('id_pelanggan', 15)->primary();
            $table->string('nama_pelanggan', 20);
            $table->string('alamat', 40);
            $table->char('no_hp', 15);
            $table->char('status', 10)->default('Aktif');
            $table->unsignedBigInteger('id_layanan');
            
            $table->foreign('id_layanan')->references('id_layanan')->on('tb_layanan')
                ->onDelete('cascade')->onUpdate('cascade');
        });

        // Tabel pemakaian air
        Schema::create('tb_pakai', function (Blueprint $table) {
            $table->char('id_pakai', 11)->primary();
            $table->char('id_pelanggan', 15);
            $table->char('bulan', 3);
            $table->char('tahun', 4);
            $table->integer('awal');
            $table->integer('akhir');
            $table->integer('pakai');
            
            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('tb_pelanggan')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('bulan')->references('id_bulan')->on('tb_bulan')
                ->onDelete('cascade')->onUpdate('cascade');
        });

        // Tabel tagihan
        Schema::create('tb_tagihan', function (Blueprint $table) {
            $table->id('id_tagihan');
            $table->char('id_pakai', 11);
            $table->integer('tagihan');
            $table->string('status', 12)->default('Belum Bayar');
            
            $table->foreign('id_pakai')->references('id_pakai')->on('tb_pakai')
                ->onDelete('cascade')->onUpdate('cascade');
        });

        // Tabel pembayaran
        Schema::create('tb_pembayaran', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->unsignedBigInteger('id_tagihan');
            $table->date('tgl_bayar');
            $table->integer('uang_bayar');
            $table->integer('kembali');
            
            $table->foreign('id_tagihan')->references('id_tagihan')->on('tb_tagihan')
                ->onDelete('cascade')->onUpdate('cascade');
        });

        // Tabel user
        Schema::create('tb_user', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('nama_user', 20);
            $table->string('username', 15)->unique();
            $table->string('password', 255);
            $table->string('level', 15);
            $table->char('no_hp', 13);
            $table->char('no_rek', 15)->nullable();
            $table->timestamps();
        });

        // Tabel sessions untuk Laravel session
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // Tabel cache
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->integer('expiration');
        });

        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->integer('expiration');
        });

        // Tabel jobs untuk queue
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });

        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->integer('total_jobs');
            $table->integer('pending_jobs');
            $table->integer('failed_jobs');
            $table->longText('failed_job_ids');
            $table->mediumText('options')->nullable();
            $table->integer('cancelled_at')->nullable();
            $table->integer('created_at');
            $table->integer('finished_at')->nullable();
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('cache_locks');
        Schema::dropIfExists('cache');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('tb_pembayaran');
        Schema::dropIfExists('tb_tagihan');
        Schema::dropIfExists('tb_pakai');
        Schema::dropIfExists('tb_pelanggan');
        Schema::dropIfExists('tb_layanan');
        Schema::dropIfExists('tb_bulan');
        Schema::dropIfExists('tb_user');
    }
};
