<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');

            // Polymorphic relation (Product OR Deal)
            $table->unsignedBigInteger('reviewable_id');
            $table->string('reviewable_type');

            $table->tinyInteger('rating'); // 1 to 5
            $table->text('comment');

            $table->timestamps();

            // Foreign key
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
