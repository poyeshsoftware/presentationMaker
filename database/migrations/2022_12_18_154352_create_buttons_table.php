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
        Schema::create('buttons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('slide_id');
            $table->unsignedMediumInteger('left');
            $table->unsignedMediumInteger('top');
            $table->unsignedMediumInteger('width');
            $table->unsignedMediumInteger('height');
            $table->unsignedTinyInteger("type");
            $table->unsignedBigInteger('link_slide_id')->nullable();;
            $table->timestamps();

            $table->foreign('slide_id')->references('id')->on('slides')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('link_slide_id')->references('id')->on('slides')
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
        Schema::dropIfExists('buttons');
    }
};
