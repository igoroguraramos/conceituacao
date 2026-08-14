# Gerenciador de Usuários e Perfis

## Descrição do Projeto

Aplicação full stack composta por:

- **Backend**: API em Laravel 12 (PHP 8.2) responsável pela autenticação e pelo gerenciamento de usuários e perfis, com relacionamento muitos-para-muitos entre eles.
- **Frontend**: SPA em Vue 3 que consome a API do backend.
- **Banco de dados**: MySQL 8.4.
- **Autenticação**: Laravel Sanctum utilizando tokens de acesso.
- **Documentação da API**: OpenAPI/Swagger através do L5 Swagger.

Toda a stack é orquestrada via Docker Compose, com três serviços:

| Serviço    | Descrição                          | Porta  |
|------------|-------------------------------------|--------|
| `mysql`    | Banco de dados MySQL 8.4            | 3306   |
| `backend`  | API Laravel (PHP 8.2 + `artisan serve`) | 8000   |
| `frontend` | SPA Vue 3 (Vite dev server)          | 5173   |

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

**Backend** — copie o `.env.example` e ajuste a conexão com o banco para apontar para o serviço `mysql` do Compose:
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
- Buildar e subir o backend Laravel (`composer install` já ocorre no build da imagem);
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

---

## Como rodar as migrations e seeders

Com os containers rodando, execute:
```bash
docker exec -it app_backend php artisan migrate --seed
```

Isso cria as tabelas (incluindo `personal_access_tokens`, usada pelo Sanctum) e popula o banco com o usuário de teste via `UserSeeder`.

Se as migrations já tiverem sido rodadas sem seed, é possível rodar só os seeders:
```bash
docker exec -it app_backend php artisan db:seed
```

## Usuário e senha de teste para login

| Campo    | Valor               |
|----------|---------------------|
| E-mail   | `admin@example.com` |
| Senha    | `password`          |
