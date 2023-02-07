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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('image_dimension_id')->nullable();
            $table->string('type');
            $table->string('file_name');
            $table->string('address');
            $table->smallInteger('width');
            $table->smallInteger('height');
            $table->string('format', 20);
            $table->string('alt')->default("");
            $table->timestamps();

            $table->foreign('image_dimension_id')->references('id')->on('image_dimensions')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('parent_id')->references('id')->on('images')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('project_id')->references('id')->on('projects')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
