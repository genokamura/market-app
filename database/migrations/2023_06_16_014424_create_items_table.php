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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->decimal('price', 22);
            $table->integer('quantity')->default(0);
            $table->boolean('active')->default(true);
            $table->unsignedBigInteger('seller_id');
            $table->foreign('seller_id')->references('id')->on('users');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
