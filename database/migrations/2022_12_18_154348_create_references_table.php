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
        Schema::create('references', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('slide_id');
            $table->unsignedBigInteger("order_num")->default(0);
            $table->unsignedTinyInteger("type");
            $table->string("prefix")->nullable();
            $table->string("text");
            $table->timestamps();

            $table->foreign('slide_id')->references('id')->on('slides')
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
        Schema::dropIfExists('references');
    }
};
