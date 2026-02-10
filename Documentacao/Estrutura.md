# 12. Padrão de Service (Exemplo Kanban)

O Service deve receber o Repository por interface, trabalhar com DTOs e garantir atomicidade das operações críticas usando transações. Veja exemplo:

```php
use App\Repositories\interfaces\KanbanBoardRepositoryInterface;
use App\Services\interfaces\KanbanBoardServiceInterface;
use App\Dto\KanbanBoards\KanbanBoardDto;
use App\Dto\KanbanBoards\KanbanBoardSearchDto;
use Illuminate\Support\Facades\DB;

class KanbanBoardService implements KanbanBoardServiceInterface
{
    public function __construct(private KanbanBoardRepositoryInterface $repository) {}

    public function all(KanbanBoardSearchDto $dto)
    {
        return $this->repository->all($dto);
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function create(KanbanBoardDto $dto)
    {
        return DB::transaction(function () use ($dto) {
            return $this->repository->create($dto);
        });
    }

    public function update($id, KanbanBoardDto $dto)
    {
        return DB::transaction(function () use ($id, $dto) {
            return $this->repository->update($id, $dto);
        });
    }

    public function delete($id)
    {
        return DB::transaction(function () use ($id) {
            return $this->repository->delete($id);
        });
    }
}
```

# 13. Padrão de Repository (Exemplo Kanban)

O Repository deve receber DTOs, aplicar filtros multi-tenant e garantir o uso correto do tenant_id global. Veja exemplo:

```php
use App\Models\KanbanBoard;
use App\Dto\KanbanBoards\KanbanBoardDto;
use App\Dto\KanbanBoards\KanbanBoardSearchDto;

class KanbanBoardRepository implements KanbanBoardRepositoryInterface
{
    public function all(KanbanBoardSearchDto $dto)
    {
        $query = KanbanBoard::query();
        // Filtro multi-tenant global
        $query->where('tenant_id', $dto->tenant_id)
              ->orWhereNull('tenant_id');
        // Outros filtros
        if ($dto->printer_id) {
            $query->where('printer_id', $dto->printer_id);
        }
        // ... demais filtros ...
        return $query->get();
    }

    public function find($id)
    {
        return KanbanBoard::findOrFail($id);
    }

    public function create(KanbanBoardDto $dto)
    {
        return KanbanBoard::create($dto->toArray());
    }

    public function update($id, KanbanBoardDto $dto)
    {
        $kanban = KanbanBoard::findOrFail($id);
        $kanban->update($dto->toArray());
        return $kanban;
    }

    public function delete($id)
    {
        $kanban = KanbanBoard::findOrFail($id);
        return $kanban->delete();
    }
}
```
# 11. Padrão de Controller (Exemplo Kanban)

As controllers devem seguir o padrão de uso de Service por interface, receber FormRequests customizadas, utilizar DTOs para transferência de dados, Resources para resposta e tratar erros com try/catch. Veja um exemplo baseado no fluxo do Kanban:

```php
use App\Http\Requests\KanbanBoards\StoreKanbanBoardRequest;
use App\Http\Requests\KanbanBoards\UpdateKanbanBoardRequest;
use App\Http\Requests\KanbanBoards\KanbanBoardSearchRequest;
use App\Dto\KanbanBoards\KanbanBoardDto;
use App\Dto\KanbanBoards\KanbanBoardSearchDto;
use App\Http\Resources\KanbanBoardResource;
use App\Services\interfaces\KanbanBoardServiceInterface;

class KanbanBoardController extends Controller
{
    public function __construct(private KanbanBoardServiceInterface $service) {}

    public function index(KanbanBoardSearchRequest $request)
    {
        try {
            $kanbans = $this->service->all(new KanbanBoardSearchDto($request->validated()));
            return response()->json(KanbanBoardResource::collection($kanbans), 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar kanban boards.'], 500);
        }
    }

    public function show($id)
    {
        try {
            $kanban = $this->service->find($id);
            if ($kanban) {
                return response()->json(new KanbanBoardResource($kanban), 200);
            }
            return response()->json(['error' => 'Kanban board não encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar kanban board.'], 500);
        }
    }

    public function store(StoreKanbanBoardRequest $request)
    {
        try {
            $dto = new KanbanBoardDto($request->validated());
            $created = $this->service->create($dto);
            return response()->json(new KanbanBoardResource($created), 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao salvar kanban board.'], 500);
        }
    }

    public function update(UpdateKanbanBoardRequest $request, $id)
    {
        try {
            $dto = new KanbanBoardDto($request->validated());
            $updated = $this->service->update($id, $dto);
            if ($updated) {
                return response()->json(new KanbanBoardResource($updated), 200);
            }
            return response()->json(['error' => 'Kanban board não encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao atualizar kanban board.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $deleted = $this->service->delete($id);
            if ($deleted) {
                return response()->json(['message' => 'Kanban board removido com sucesso.'], 200);
            }
            return response()->json(['error' => 'Kanban board não encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao remover kanban board.'], 500);
        }
    }
}
```

> **Resumo:**
> - Sempre use Service por interface (injeção no construtor)
> - Use FormRequests customizadas (herdando de AbstractRequest)
> - Utilize DTOs para entrada de dados
> - Use Resources para saída de dados
> - Trate erros com try/catch e retorne mensagens padronizadas
# 10. AbstractRequest e Validação Multi-Tenant

Para padronizar a validação e garantir que o campo `tenant_id` seja sempre atribuído corretamente nas requests, o projeto utiliza uma classe base chamada `AbstractRequest`.

Todas as FormRequests customizadas devem estender `AbstractRequest` ao invés de `FormRequest` diretamente. Isso garante que, ao chamar `$request->validated()`, o campo `tenant_id` do usuário autenticado seja automaticamente incluído nos dados validados, facilitando o controle multi-tenant e evitando erros de omissão.

Exemplo de uso:

```php
use App\Http\Requests\AbstractRequest;

class StoreKanbanBoardRequest extends AbstractRequest
{
    public function rules()
    {
        return [
            // ... regras de validação ...
        ];
    }
}
```

> **Importante:** Nunca estenda diretamente de `FormRequest` em novas requests, sempre utilize `AbstractRequest` para manter o padrão e garantir o correto funcionamento do multi-tenancy.

# 9. Multi-Tenancy e Tenant Global

Por padrão, todas as entidades que possuem o campo `tenant_id` devem considerar registros com `tenant_id = null` como globais (acessíveis a todos os tenants). Ou seja, ao buscar entidades multi-tenant, sempre inclua na consulta:

```php
$query->where('tenant_id', $tenantId)
    ->orWhereNull('tenant_id');
```

Assim, cada tenant acessa seus próprios registros e também os registros globais (com `tenant_id` nulo). Esse padrão deve ser seguido em todos os repositórios, services e buscas relacionadas a entidades multi-tenant.

> **Importante:** As requests de busca (search) já atribuem automaticamente o `tenant_id` do usuário logado, garantindo o filtro correto em todas as operações.

# Documentação de Estrutura de Programação e Boas Práticas

## 1. Estrutura do Projeto

O projeto segue uma arquitetura baseada em camadas, separando responsabilidades em Controllers, Services, Repositories e DTOs. Isso facilita a manutenção, testes e evolução do sistema.

```
app/
  Http/
    Controllers/   # Camada de entrada (HTTP)
  Services/         # Lógica de negócio
  Repositories/     # Acesso a dados
  Dto/              # Objetos de transferência de dados
  Models/           # Modelos Eloquent
  Providers/        # Service Providers para binds e configs
```

## 2. Inversão de Dependência com Interfaces

Utilize interfaces para desacoplar implementações concretas. Os Services e Repositories devem depender de interfaces, não de classes concretas.

**Exemplo de Interface:**
```php
// app/Repositories/interfaces/ClientRepositoryInterface.php
interface ClientRepositoryInterface {
    public function find($id);
    public function all();
}
```


**Implementação:**
```php
// app/Repositories/ClientRepository.php
use App\Repositories\interfaces\ClientRepositoryInterface;

class ClientRepository implements ClientRepositoryInterface {
    public function find($id) { /* ... */ }
    public function all() { /* ... */ }
}
```

**Implementando Interface no Service:**
```php
// app/Services/ClientService.php
use App\Services\interfaces\ClientServiceInterface;
use App\Repositories\interfaces\ClientRepositoryInterface;

class ClientService implements ClientServiceInterface {
    public function __construct(private ClientRepositoryInterface $repo) {}
    public function getAllClients() {
        return $this->repo->all();
    }
    public function getClient($id) {
        return $this->repo->find($id);
    }
    // ... outros métodos CRUD
}
```

## 3. Binds no Provider

No `AppServiceProvider`, faça o bind das interfaces para as implementações:

```php
// app/Providers/AppServiceProvider.php
public function register()
{
    $this->app->bind(
        \App\Repositories\interfaces\ClientRepositoryInterface::class,
        \App\Repositories\ClientRepository::class
    );
}
```

## 4. Controller, Service e Repository

- **Controller:** Recebe a requisição, valida e delega para o Service.
- **Service:** Contém a lógica de negócio e orquestra chamadas ao Repository.
- **Repository:** Responsável pelo acesso a dados.

**Exemplo Controller:**
```php
class ClientController extends Controller {
    public function __construct(private ClientService $service) {}
    public function index() {
        return $this->service->getAllClients();
    }
}
```

**Exemplo Service:**
```php
class ClientService {
    public function __construct(private ClientRepositoryInterface $repo) {}
    public function getAllClients() {
        return $this->repo->all();
    }
}
```

**Exemplo Repository:**
```php
class ClientRepository implements ClientRepositoryInterface {
    public function all() {
        return Client::all();
    }
}
```

## 5. Boas Práticas SOLID

- **S**: Cada classe deve ter uma única responsabilidade.
- **O**: Prefira extensão a modificação de código existente.
- **L**: Subtipos devem ser substituíveis por seus tipos base.
- **I**: Separe interfaces grandes em menores e específicas.
- **D**: Dependa de abstrações, não de implementações concretas.

## 6. Exemplos de Modelos

### Interface e Bind
```php
// Interface
interface ProductServiceInterface { /* ... */ }
// Bind
$this->app->bind(ProductServiceInterface::class, ProductService::class);
```


### Service implementando interface
```php
use App\Services\interfaces\ProductServiceInterface;
use App\Repositories\interfaces\ProductRepositoryInterface;

class ProductService implements ProductServiceInterface {
    public function __construct(private ProductRepositoryInterface $repo) {}
    // ...
}
```


### Controller usando Service por interface
```php
use App\Services\interfaces\ProductServiceInterface;

class ProductController extends Controller {
    public function __construct(private ProductServiceInterface $service) {}
    // ...
}
```

## 8. Exemplo de Fluxo Básico de CRUD

### 1. Controller
```php
class ClientController extends Controller {
    public function __construct(private ClientServiceInterface $service) {}

    public function index() {
        return $this->service->getAllClients();
    }

    public function show($id) {
        return $this->service->getClient($id);
    }

    public function store(Request $request) {
        return $this->service->createClient($request->all());
    }

    public function update(Request $request, $id) {
        return $this->service->updateClient($id, $request->all());
    }

    public function destroy($id) {
        return $this->service->deleteClient($id);
    }
}
```

### 2. Service
```php
class ClientService implements ClientServiceInterface {
    public function __construct(private ClientRepositoryInterface $repo) {}

    public function getAllClients() {
        return $this->repo->all();
    }
    public function getClient($id) {
        return $this->repo->find($id);
    }
    public function createClient(array $data) {
        return $this->repo->create($data);
    }
    public function updateClient($id, array $data) {
        return $this->repo->update($id, $data);
    }
    public function deleteClient($id) {
        return $this->repo->delete($id);
    }
}
```

### 3. Repository
```php
class ClientRepository implements ClientRepositoryInterface {
    public function all() {
        return Client::all();
    }
    public function find($id) {
        return Client::findOrFail($id);
    }
    public function create(array $data) {
        return Client::create($data);
    }
    public function update($id, array $data) {
        $client = Client::findOrFail($id);
        $client->update($data);
        return $client;
    }
    public function delete($id) {
        $client = Client::findOrFail($id);
        $client->delete();
        return true;
    }
}
```

## 7. Outras Boas Práticas

- Use DTOs para transferir dados entre camadas.
- Valide dados no Request antes de chegar ao Controller.
- Separe regras de negócio dos Controllers.
- Escreva testes para Services e Repositories.
- Utilize migrations para versionar o banco de dados.

---

Siga este padrão para garantir um código limpo, testável e de fácil manutenção.