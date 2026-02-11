# Documentação: Estrutura e como manter o OpenAPI (Swagger)

Este documento explica onde está a especificação OpenAPI do projeto, como ela está organizada e como adicionar/atualizar endpoints e modelos (schemas).

Localização
- Arquivo principal da spec: `public/swagger.yaml`
- Visualização HTML: `public/swagger.html` e `public/swagger.blade.php`

Visão geral da estrutura OpenAPI (OpenAPI 3)
- `openapi`, `info`, `servers`, `tags`: metadados do documento.
- `paths`: lista de endpoints. Cada rota tem métodos (get, post, put, delete), `summary`, `tags`, `security`, `parameters`, `requestBody` e `responses`.
- `components`: local para `schemas`, `securitySchemes`, `responses` reutilizáveis.
- `components.schemas`: modelos (ex.: `Budget`, `BudgetItem`, `Product`). Use `$ref` para referenciar schemas em `paths`.

Boas práticas para editar
1. Sempre faça backup ou crie um branch antes de alterar `public/swagger.yaml`.
2. Mantenha `tags` agrupadas por área (ex.: `Orcamentos`, `Clientes`).
3. Para cada endpoint, inclua exemplos em `responses` com dados reais o suficiente para compreensão.
4. Use `components.schemas` para modelar objetos e referencie-os via `$ref: '#/components/schemas/SeuSchema'`.
5. Declare `securitySchemes` em `components.securitySchemes` e use `security: - bearerAuth: []` nos endpoints que exigem autenticação.
6. Formatos: datas em ISO 8601, valores numéricos com `type: number` e `format: float` quando apropriado.

Exemplo rápido (schemas)

Budget:
```yaml
Budget:
  type: object
  properties:
    id:
      type: string
    tenant_id:
      type: string
    status:
      type: string
    description:
      type: string
    client_id:
      type: string
    internal_note:
      type: string
    price:
      type: number
      format: float
    items:
      type: array
      items:
        $ref: '#/components/schemas/BudgetItem'
```

BudgetItem:
```yaml
BudgetItem:
  type: object
  properties:
    id:
      type: string
    product_id:
      type: string
    quantity:
      type: number
      format: float
```

Exemplo rápido (path)

```yaml
/budgets:
  get:
    summary: Lista orçamentos
    tags: [Orcamentos]
    security: [{ bearerAuth: [] }]
    responses:
      '200':
        description: Lista de orçamentos
        content:
          application/json:
            schema:
              type: array
              items:
                $ref: '#/components/schemas/Budget'
```

Validação e visualização
- Valide o YAML com um linter OpenAPI (ex.: `swagger-cli validate public/swagger.yaml` ou ferramentas online).
- Para testar localmente, certifique-se de que `public/swagger.yaml` esteja acessível pela rota usada em `public/swagger.html`.
- Se usar um bundle Swagger UI estático, atualize o caminho para o YAML caso mude de local.

Fluxo sugerido para adicionar um novo endpoint
1. Adicione/atualize o schema em `components.schemas` (se necessário).
2. Adicione o `path` com `requestBody` referenciando o schema (ou schema inline).
3. Adicione exemplos em `responses` para facilitar entendimento.
4. Rode uma validação YAML.
5. Abra `public/swagger.html` (ou a UI que vocês usam) e teste o endpoint.

Contato
- Se precisar que eu atualize algum endpoint específico ou gere a versão HTML atualizada, me peça que eu executo os passos.
