<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->uuid('client_id');
            $table->uuid('tenant_id')->nullable();
            $table->string('nome');
            $table->enum('tipo', ['PRINCIPAL', 'SECUNDARIO']);
            $table->string('ddd', 3);
            $table->string('telefone');
            $table->string('email');
            $table->boolean('is_deleted')->default(false);
            $table->text('notes')->nullable();
            // ...existing code...
            $table->timestampTz('created_at')->nullable();
            $table->timestampTz('updated_at')->nullable();
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
