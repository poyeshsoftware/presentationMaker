<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('image_dimensions', function (Blueprint $table) {
            $table->id();
            $table->string('type', 60)->index();
            $table->unsignedSmallInteger('dimension_value')->nullable()->default(null);
            $table->unsignedSmallInteger('second_dimension_value')->nullable()->default(null);
            $table->tinyInteger('mode')->default(0); // 0 > scale down by width, 1 > scale by height, 2 > scale by boh
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('image_dimensions');
    }
};
