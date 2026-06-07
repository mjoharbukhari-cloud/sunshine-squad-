<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Fix Products Table
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'shop_id')) {
                $table->foreignId('shop_id')->after('id')->nullable()->constrained()->onDelete('cascade');
            }
        });

        // Fix Deals Table
        Schema::table('deals', function (Blueprint $table) {
            if (!Schema::hasColumn('deals', 'shop_id')) {
                $table->foreignId('shop_id')->after('id')->nullable()->constrained()->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['shop_id']);
            $table->dropColumn('shop_id');
        });

        Schema::table('deals', function (Blueprint $table) {
            $table->dropForeign(['shop_id']);
            $table->dropColumn('shop_id');
        });
    }
};