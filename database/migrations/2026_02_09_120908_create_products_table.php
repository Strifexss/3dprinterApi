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
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('group_id'); // Referência ao grupo/categoria
            $table->uuid('tenant_id')->nullable()->index(); // multitenancy
            $table->uuid('created_by')->nullable(); // usuário que criou
            $table->uuid('updated_by')->nullable(); // usuário que atualizou
            $table->string('sku', 100)->unique();
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->string('unit', 20);
            $table->string('color', 50)->nullable();
            $table->string('material', 100)->nullable();
            $table->decimal('min_stock', 10, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable(); // soft delete
            $table->foreign('group_id')->references('id')->on('product_groups');
            $table->index(['sku', 'tenant_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
