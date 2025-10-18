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
    Schema::create('cctv_service_units', function (Blueprint $table) {
      $table->id();
      $table->string("name")->nullable();
      $table->string("description")->nullable();
      $table->softDeletes();
      $table->dateTime("createdAt")->useCurrent();
      $table->dateTime("updatedAt")->useCurrentOnUpdate()->useCurrent();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('cctv_service_units');
  }
};
