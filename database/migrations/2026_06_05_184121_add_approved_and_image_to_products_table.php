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
        Schema::table('products', function (Blueprint $table) {
            // Adds the moderation flag field cleanly (defaulting to 1 so items stay active)
            if (!Schema::hasColumn('products', 'approved')) {
                $table->tinyInteger('approved')->default(1)->after('description');
            }
            
            // Safety Check: Adds the image field tracking path string if your schema missed it earlier
            if (!Schema::hasColumn('products', 'image')) {
                $table->string('image')->nullable()->after('approved');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['approved', 'image']);
        });
    }
};