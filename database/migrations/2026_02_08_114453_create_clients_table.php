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
        Schema::create('clients', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tenant_id')->nullable()->index(); // multitenancy opcional
            $table->string('nome', 255);
            $table->string('razao_social', 255)->nullable();
            $table->string('cpf_cnpj', 20)->unique(); // normalizado, unique
            $table->enum('tipo_pessoa', ['F', 'J']);
            $table->jsonb('extras')->nullable(); // flexibilidade
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->timestamp('deleted_at')->nullable(); // soft delete
            $table->text('fulltext_nome')->nullable(); // campo para tsvector
            $table->unique(['cpf_cnpj', 'tenant_id']); // unicidade multitenancy
        });
        // Índice GIN para busca full-text (PostgreSQL)
        \DB::statement('CREATE INDEX clients_fulltext_nome_gin ON clients USING gin (to_tsvector(\'portuguese\', fulltext_nome));');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
