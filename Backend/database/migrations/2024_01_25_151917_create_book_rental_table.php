<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('book_rental', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->string('people_id');
        $table->string('book_id');
        $table->dateTime('delivery_date');
        $table->foreign('people_id')
          ->references('id')
          ->on('people')
          ->onDelete('cascade');
        $table->foreign('book_id')
          ->references('id')
          ->on('book')
          ->onDelete('cascade');
        $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('book_rental');
  }
};
