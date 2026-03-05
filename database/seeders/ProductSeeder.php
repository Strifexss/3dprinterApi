<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\ProductGroup;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Buscar o primeiro tenant disponível
        $tenant = DB::table('tenants')->first();
        $tenantId = $tenant ? $tenant->id : null;

        // Buscar os grupos criados para este tenant
        $groups = ProductGroup::where('tenant_id', $tenantId)->get()->keyBy('name');

        // Verificar se existem grupos
        if ($groups->isEmpty()) {
            $this->command->warn('Nenhum grupo encontrado. Execute ProductGroupSeeder primeiro.');
            return;
        }

        $products = [
            [
                'group_name' => 'Filamentos',
                'sku' => 'FIL-001',
                'name' => 'Filamento PLA Preto 1kg',
                'description' => 'Filamento PLA de alta qualidade, cor preta, rolo de 1kg',
                'unit' => 'kg',
                'color' => 'Preto',
                'material' => 'PLA',
                'min_stock' => 5.00,
                'stock' => 25.50,
                'is_active' => true,
            ],
            [
                'group_name' => 'Filamentos',
                'sku' => 'FIL-002',
                'name' => 'Filamento ABS Branco 1kg',
                'description' => 'Filamento ABS resistente, cor branca, rolo de 1kg',
                'unit' => 'kg',
                'color' => 'Branco',
                'material' => 'ABS',
                'min_stock' => 3.00,
                'stock' => 15.00,
                'is_active' => true,
            ],
            [
                'group_name' => 'Resinas',
                'sku' => 'RES-001',
                'name' => 'Resina UV Standard 1L',
                'description' => 'Resina fotopolimérica padrão para impressoras SLA/DLP',
                'unit' => 'l',
                'color' => 'Transparente',
                'material' => 'Resina UV',
                'min_stock' => 2.00,
                'stock' => 8.50,
                'is_active' => true,
            ],
            [
                'group_name' => 'Peças',
                'sku' => 'PEC-001',
                'name' => 'Bico Hotend 0.4mm',
                'description' => 'Bico de impressão em latão, diâmetro 0.4mm',
                'unit' => 'un',
                'color' => null,
                'material' => 'Latão',
                'min_stock' => 10.00,
                'stock' => 50.00,
                'is_active' => true,
            ],
            [
                'group_name' => 'Peças',
                'sku' => 'PEC-002',
                'name' => 'Motor de Passo NEMA 17',
                'description' => 'Motor de passo para impressoras 3D',
                'unit' => 'un',
                'color' => null,
                'material' => 'Metal',
                'min_stock' => 5.00,
                'stock' => 12.00,
                'is_active' => true,
            ],
            [
                'group_name' => 'Consumíveis',
                'sku' => 'CON-001',
                'name' => 'Fita Kapton 50mm x 30m',
                'description' => 'Fita resistente ao calor para mesa de impressão',
                'unit' => 'un',
                'color' => 'Laranja',
                'material' => 'Poliimida',
                'min_stock' => 3.00,
                'stock' => 10.00,
                'is_active' => true,
            ],
            [
                'group_name' => 'Ferramentas',
                'sku' => 'FER-001',
                'name' => 'Espátula Metálica',
                'description' => 'Espátula para remoção de peças da mesa',
                'unit' => 'un',
                'color' => null,
                'material' => 'Aço Inox',
                'min_stock' => 5.00,
                'stock' => 15.00,
                'is_active' => true,
            ],
            [
                'group_name' => 'Químicos',
                'sku' => 'QUI-001',
                'name' => 'Álcool Isopropílico 99% 1L',
                'description' => 'Álcool isopropílico para limpeza de resinas e peças',
                'unit' => 'l',
                'color' => null,
                'material' => 'IPA',
                'min_stock' => 2.00,
                'stock' => 6.00,
                'is_active' => true,
            ],
            [
                'group_name' => 'Embalagens',
                'sku' => 'EMB-001',
                'name' => 'Caixa de Papelão 30x30x30cm',
                'description' => 'Caixa para envio de produtos impressos',
                'unit' => 'un',
                'color' => 'Marrom',
                'material' => 'Papelão',
                'min_stock' => 20.00,
                'stock' => 100.00,
                'is_active' => true,
            ],
            [
                'group_name' => 'Materiais Especiais',
                'sku' => 'ESP-001',
                'name' => 'Filamento TPU Flexível 500g',
                'description' => 'Filamento flexível TPU para impressões que requerem elasticidade',
                'unit' => 'kg',
                'color' => 'Natural',
                'material' => 'TPU',
                'min_stock' => 1.00,
                'stock' => 3.50,
                'is_active' => true,
            ],
        ];

        foreach ($products as $productData) {
            $groupName = $productData['group_name'];
            unset($productData['group_name']);

            // Verificar se o grupo existe
            if (!isset($groups[$groupName])) {
                $this->command->warn("Grupo '{$groupName}' não encontrado. Pulando produto {$productData['sku']}");
                continue;
            }

            Product::create(array_merge([
                'id' => (string)\Illuminate\Support\Str::uuid(),
                'group_id' => $groups[$groupName]->id,
                'tenant_id' => $tenantId,
            ], $productData));
        }

        $this->command->info('10 produtos criados com sucesso!');
    }
}
