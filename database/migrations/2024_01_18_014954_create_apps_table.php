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
        Schema::create('apps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->unique();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->string('name');
            $table->text('url');
            $table->enum('type_icon', ['svg', 'url_img', 'upload_img'])->nullable();
            $table->text('icon')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apps');
    }
};
