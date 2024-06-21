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
        Schema::create('category_vlog', function (Blueprint $table) {
            $table->unsignedBiginteger('vlog_id');
            $table->unsignedBiginteger('category_id');

            $table->foreign('vlog_id')->references('id')->on('vlog')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('category')->onDelete('cascade');

            $table->unique(['vlog_id', 'category_id']); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_vlog');
    }
};
