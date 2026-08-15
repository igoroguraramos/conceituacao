# Gerenciador de Usuários e Perfis

## Descrição do Projeto

Aplicação full stack composta por:

- **Backend**: API em Laravel 12 (PHP 8.2) responsável pela autenticação e pelo gerenciamento de usuários e perfis, com relacionamento muitos-para-muitos entre eles.
- **Frontend**: SPA em Vue 3 que consome a API do backend.
- **Banco de dados**: MySQL 8.4.
- **Autenticação**: Laravel Sanctum utilizando tokens de acesso (login e logout com revogação de token).
- **Mensageria**: RabbitMQ, usado para desassociar perfis de usuários de forma assíncrona (producer/consumer).
- **Documentação da API**: OpenAPI/Swagger através do L5 Swagger.

Toda a stack é orquestrada via Docker Compose, com cinco serviços:

| Serviço        | Descrição                                       | Porta         |
|----------------|--------------------------------------------------|---------------|
| `mysql`        | Banco de dados MySQL 8.4                          | 3306          |
| `rabbitmq`     | Broker de mensageria (fila `rabbitmq`)            | 5672 / 15672* |
| `backend`      | API Laravel (PHP 8.2 + `artisan serve`)           | 8000          |
| `queue-worker` | Consumer que processa os jobs da fila RabbitMQ    | —             |
| `frontend`     | SPA Vue 3 (Vite dev server)                       | 5173          |

\* `5672` é a porta AMQP (usada pela aplicação); `15672` é o painel de gerenciamento web do RabbitMQ (`http://localhost:15672`, usuário/senha padrão `guest`/`guest`).

---

## Passos para Configurar o Ambiente

### Pré-requisitos
- Docker e Docker Compose instalados

### 1. Clonar o repositório
```bash
git clone git@github.com:igoroguraramos/conceituacao.git
cd conceituacao-new
```

### 2. Configurar variáveis de ambiente

**Backend** — copie o `.env.example` e ajuste a conexão com o banco e com o RabbitMQ para apontar para os serviços do Compose:
```bash
cp backend/.env.example backend/.env
```
No `backend/.env`, configure:
```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=secret

QUEUE_CONNECTION=rabbitmq
RABBITMQ_HOST=rabbitmq
```

**Frontend** — copie o `.env.example`:
```bash
cp frontend/.env.example frontend/.env
```

### 3. Subir os containers
```bash
docker-compose up --build
```

Isso vai:
- Subir o MySQL e aguardar o healthcheck ficar pronto;
- Subir o RabbitMQ (fica disponível em `5672`, painel em `15672`);
- Buildar e subir o backend Laravel (`composer install` já ocorre no build da imagem);
- Subir o `queue-worker`, que roda `php artisan queue:work rabbitmq` e fica escutando os jobs de desassociação de perfil;
- Subir o frontend, instalando as dependências (`npm install`) e iniciando o Vite (`npm run dev`).

### 4. Gerar a chave da aplicação Laravel
Em outro terminal, com os containers rodando:
```bash
docker exec -it app_backend php artisan key:generate
```

### 5. Acessar a aplicação
- Frontend: http://localhost:5173
- Backend (API): http://localhost:8000/api
- Swagger: http://localhost:8000/api/documentation
- Painel do RabbitMQ: http://localhost:15672 (usuário/senha: `guest`/`guest`)

---

## Como rodar as migrations e seeders

Com os containers rodando, execute:
```bash
docker exec -it app_backend php artisan migrate --seed
```

Isso cria as tabelas (incluindo `personal_access_tokens`, usada pelo Sanctum) e popula o banco com o perfil "Administrador" (`ProfileSeeder`) e o usuário de teste (`UserSeeder`).

Se as migrations já tiverem sido rodadas sem seed, é possível rodar só os seeders:
```bash
docker exec -it app_backend php artisan db:seed
```

## Usuário e senha de teste para login

| Campo    | Valor               |
|----------|---------------------|
| E-mail   | `admin@example.com` |
| Senha    | `password`          |

---

## Desassociação de perfil (assíncrona)

Diferente das demais operações de perfil (criar, editar, excluir, associar), a **desassociação** de um perfil de um usuário (`DELETE /api/users/{user}/profiles`) é processada de forma assíncrona:

1. A API valida a requisição e publica uma mensagem na fila do RabbitMQ para cada perfil a ser desassociado, respondendo imediatamente com `202 Accepted`.
2. O serviço `queue-worker` consome essas mensagens em background e efetiva a remoção do vínculo no banco.

Por isso, o usuário pode continuar aparecendo com o perfil por um curto período após a chamada — o frontend já reflete a remoção imediatamente na tela (atualização otimista), mas a consistência no banco só é garantida depois que o worker processa a fila. Para acompanhar o processamento, é possível ver os logs do consumer com:
```bash
docker logs -f app_queue_worker
```
