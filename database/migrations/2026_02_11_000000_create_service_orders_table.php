<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('service_orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tenant_id');
            $table->uuid('budget_id')->nullable();
            $table->uuid('client_id')->nullable();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('printer_id')->nullable();
            $table->unsignedBigInteger('responsible_id')->nullable();
            $table->timestamp('expected_date')->nullable();
            $table->timestamp('delivery_date')->nullable();
            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreign('budget_id')->references('id')->on('budgets')->onDelete('set null');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('set null');
            $table->foreign('printer_id')->references('id')->on('printers')->onDelete('set null');
            $table->foreign('responsible_id')->references('id')->on('users')->onDelete('set null');
            $table->index(['tenant_id','client_id','printer_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('service_orders');
    }
}
