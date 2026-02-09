<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductGroup;

class ProductGroupSeeder extends Seeder
{
    public function run(): void
    {
        $groups = [
            [
                'name' => 'Filamentos',
                'description' => 'Todos os filamentos plásticos (PLA, ABS, PETG, Nylon, TPU, etc.) para impressoras FDM',
                'is_active' => true,
            ],
            [
                'name' => 'Resinas',
                'description' => 'Materiais líquidos para impressoras SLA, DLP, etc.',
                'is_active' => true,
            ],
            [
                'name' => 'Peças',
                'description' => 'Componentes e peças de reposição para impressoras (hotend, motor, placa, sensor, etc.)',
                'is_active' => true,
            ],
            [
                'name' => 'Consumíveis',
                'description' => 'Produtos de uso recorrente (spray aderente, fita, desengraxante, lubrificante, etc.)',
                'is_active' => true,
            ],
            [
                'name' => 'Ferramentas',
                'description' => 'Alicates, pinças, espátulas, chaves, instrumentos de medição — para manutenção ou uso',
                'is_active' => true,
            ],
            [
                'name' => 'Embalagens',
                'description' => 'Caixas, plásticos bolha, sacos zip, proteções — itens usados na expedição de peças',
                'is_active' => true,
            ],
            [
                'name' => 'Produtos Acabados',
                'description' => 'Peças impressas prontas e armazenadas para entrega ou venda',
                'is_active' => true,
            ],
            [
                'name' => 'Acessórios Diversos',
                'description' => 'Peças não essenciais, upgrades, complementos para impressoras ou área de trabalho',
                'is_active' => true,
            ],
            [
                'name' => 'Químicos',
                'description' => 'Solventes, álcool isopropílico, limpa bico, etc. para limpeza e pós-processamento',
                'is_active' => true,
            ],
        ];

        foreach ($groups as $group) {
            ProductGroup::create(array_merge([
                'id' => (string)\Illuminate\Support\Str::uuid(),
            ], $group));
        }
    }
}
