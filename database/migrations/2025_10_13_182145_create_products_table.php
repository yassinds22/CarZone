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
Schema::create('products', function (Blueprint $table) {
    $table->id();

  
    $table->string('title');
    $table->text('description')->nullable();
    $table->string('model')->nullable();
    
  
    $table->decimal('price', 10, 2)->default(0.00);
    $table->enum('condition', ['جديدة', 'مستخدمة', 'مصدومة'])->default('جديدة');
    $table->enum('engine_cylinders', ['4', '6', '8'])->default('4');
    $table->enum('fuel_type', ['ديزل', 'بترول', 'كهرباء', 'هجين'])->default('بترول');
   
   
    $table->decimal('latitude', 10, 8)->nullable()->comment('Latitude for Google Maps');
    $table->decimal('longitude', 11, 8)->nullable()->comment('Longitude for Google Maps');

  
    $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
    $table->foreignId('brand_id')->nullable()->constrained('brands')->nullOnDelete();
    $table->foreignId('province_id')->nullable()->constrained('provinces')->nullOnDelete();
    $table->softDeletes();

    $table->timestamps();

   
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
