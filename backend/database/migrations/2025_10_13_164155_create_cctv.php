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
    Schema::create('cctv', function (Blueprint $table) {
      $table->id();
      $table->string("name")->nullable();
      $table->string("description")->nullable();
      $table->string("photo")->nullable();
      $table->string("rtspUrl")->nullable();
      $table->string("latitude")->nullable();
      $table->string("longitude")->nullable();
      $table->foreignId("cctvCategoryId")->nullable()->references("id")->on("cctv_categories");
      $table->boolean("isActive")->default(true);
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
    Schema::dropIfExists('cctv');
  }
};
