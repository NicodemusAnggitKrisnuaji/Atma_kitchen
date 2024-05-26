<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePemesanansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemesanans', function (Blueprint $table) {
            $table->string('id_pemesanan', 20)->primary();
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_produk');
            $table->date('tanggal_pesan')->nullable();
            $table->date('tanggal_lunas')->nullable();
            $table->date('tanggal_ambil')->nullable();
            $table->string('jenis_pengiriman', 50)->nullable();
            $table->enum('status', ['belum dibayar', 'sudah dibayar', 'pembayaran valid', 'diterima', 'ditolak', 'diproses', 'siap di-pickup', 'sedang dikirim kurir', 'sudah di pickup', 'selesai'])->default('belum dibayar');
            $table->decimal('total', 10, 2);
            $table->timestamps();
        });

        // Table to store auto increment value
        Schema::create('auto_increments', function (Blueprint $table) {
            $table->id();
            $table->integer('dummy')->nullable();
        });

        // Create the trigger for id_pemesanan
        DB::unprepared('
        CREATE TRIGGER before_insert_pemesanans
        BEFORE INSERT ON pemesanans
        FOR EACH ROW
        BEGIN
            DECLARE current_year VARCHAR(2);
            DECLARE current_month VARCHAR(2);
            DECLARE next_id INT;
            DECLARE formatted_id VARCHAR(20);
        
            -- Dapatkan tahun saat ini dalam format "YY"
            SET current_year = DATE_FORMAT(CURRENT_DATE, "%y");
            
            -- Dapatkan bulan saat ini dalam format "MM"
            SET current_month = DATE_FORMAT(CURRENT_DATE, "%m");
        
            -- Masukkan nilai dummy untuk mendapatkan nilai autoincrement berikutnya
            INSERT INTO auto_increments (dummy) VALUES (0);
            SET next_id = LAST_INSERT_ID();
        
            -- Gabungkan tahun, bulan, dan id autoincrement
            SET formatted_id = CONCAT(current_year, ".", current_month, ".", next_id);
        
            -- Tetapkan nilai id_pemesanan yang baru
            SET NEW.id_pemesanan = formatted_id;
        END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pemesanans');
        Schema::dropIfExists('auto_increments');
        DB::unprepared('DROP TRIGGER IF EXISTS before_insert_pemesanans');
    }
}
