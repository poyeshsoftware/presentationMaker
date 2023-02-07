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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->unsignedBigInteger('menu_category_id');
            $table->unsignedBigInteger("order_num")->default(0);
            $table->unsignedBigInteger('link_slide_id')->nullable();
            $table->unsignedTinyInteger('type')->default(0);
            $table->text('style')->nullable();
            $table->timestamps();

            $table->foreign('menu_category_id')->references('id')->on('menu_categories')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('link_slide_id')->references('id')->on('slides')
                ->onUpdate('cascade')
                ->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
