<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aspirasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('kategori');
            $table->string('judul');
            $table->longText('deskripsi');
            $table->enum('status', ['pending', 'processing', 'completed'])->default('pending');
            $table->longText('feedback')->nullable();
            $table->timestamp('tanggal_submit')->useCurrent();
            $table->timestamp('tanggal_penyelesaian')->nullable();
            $table->integer('progres')->default(0);
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('aspirasi');
    }
};
