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
        Schema::table('printers', function (Blueprint $table) {
            $table->string('model')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('serial_number')->nullable();
            $table->enum('technology', [
                'FDM', 'SLA', 'DLP', 'SLS', 'MSLA', 'FGF', 'POLYJET', 'DMLS', 'BINDERJET', 'OUTRAS'
            ])->nullable();
            $table->date('acquisition_date')->nullable();
            $table->date('warranty_until')->nullable();
            $table->string('status')->nullable();
            $table->string('location')->nullable();
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('printers', function (Blueprint $table) {
            $table->dropColumn([
                'model',
                'manufacturer',
                'serial_number',
                'technology',
                'acquisition_date',
                'warranty_until',
                'status',
                'location',
                'notes',
            ]);
        });
    }
};
