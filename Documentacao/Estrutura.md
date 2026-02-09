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