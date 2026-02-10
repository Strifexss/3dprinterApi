<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $status = [
        'REQUESTED',
        'APPROVED',
        'PREPARING',
        'PRINTING',
        'FINISHING',
        'READY',
        'DELIVERED',
        'CANCELLED'
    ];
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kanban_boards', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tenant_id');
            $table->unsignedBigInteger('printer_id');
            $table->enum('from_status', $this->status);
            $table->enum('to_status', $this->status);
            $table->unsignedBigInteger('changed_by_id');
            $table->dateTime('changed_at');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->foreign('printer_id')->references('id')->on('printers');
            $table->foreign('changed_by_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kanban_boards');
    }
};
