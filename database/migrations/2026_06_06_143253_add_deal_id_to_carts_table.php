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
    Schema::table('carts', function (Blueprint $table) {
        // Add deal_id. We make it nullable because a cart item might be a product OR a deal
        $table->unsignedBigInteger('deal_id')->nullable()->after('product_id');
    });
}

public function down()
{
    Schema::table('carts', function (Blueprint $table) {
        $table->dropColumn('deal_id');
    });
}
};
