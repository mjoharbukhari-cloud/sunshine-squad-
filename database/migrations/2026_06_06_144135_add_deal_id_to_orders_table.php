<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('orders', function (Blueprint $table) {
        // Add the missing column
        $table->unsignedBigInteger('deal_id')->nullable()->after('product_id');
        
        // Also ensure product_id is nullable as discussed previously
        $table->unsignedBigInteger('product_id')->nullable()->change();
    });
}

public function down()
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropColumn('deal_id');
        $table->unsignedBigInteger('product_id')->nullable(false)->change();
    });
}
};
