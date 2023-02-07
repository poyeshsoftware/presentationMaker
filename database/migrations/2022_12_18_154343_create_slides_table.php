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
        Schema::create('slides', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("slug");
            $table->unsignedBigInteger('slide_collection_id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('image_id')->nullable();
            $table->unsignedTinyInteger('slide_type'); // 0 - slide, 1 - popup, 2 - frame
            $table->unsignedBigInteger("order_num")->default(0);
            $table->timestamps();


            $table->foreign('slide_collection_id')->references('id')->on('slide_collections')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('parent_id')->references('id')->on('slides')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('image_id')->references('id')->on('images')
                ->onUpdate('cascade')
                ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('slides');
    }
};
