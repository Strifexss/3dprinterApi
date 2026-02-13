<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceOrderItemsTable extends Migration
{
    public function up()
    {
        Schema::create('service_order_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tenant_id');
            $table->uuid('service_order_id');
            $table->uuid('product_id')->nullable();
            $table->integer('quantity')->default(1);
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreign('service_order_id')->references('id')->on('service_orders')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            $table->index(['service_order_id','product_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('service_order_items');
    }
}
