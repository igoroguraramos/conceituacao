## **Objetivos**
1. **Criar** uma aplicação Laravel de backend para gerenciar usuários e seus perfis, onde cada usuário pode ter múltiplos perfis. O objetivo é avaliar suas habilidades em PHP, Laravel, e boas práticas de desenvolvimento.

2. **Criar** uma segunda aplicação VUE (2 ou 3) que irá consumir os dados da primeira aplicação. 

3. **Criar** docker-compose para subir o banco de dados e as aplicações (backend e frontend);

**Resumo:** Após o término do projeto. Deveremos rodar o Docker-compose build e poderemos avaliar o resultado da sua aplicação.

---

## **Requisitos de Negócio**

1. **Autenticação de Usuário**:
    - Implementar um sistema de autenticação que permita o registro, login e logout de usuários.

2. **Gerenciamento de Usuários**:
    - Criar um módulo para gerenciar usuários, com as seguintes operações:
        - Criar
        - Editar
        - Excluir
        - Listar

    - Validação: Deve impedir o usuário de cadastrar se não fornecer essas informações
        - name: obrigatório
        - email: obrigatório

3. **Gerenciamento de Perfis**:
    - Criar um módulo para gerenciar perfis, com as seguintes operações:
        - Criar
        - Editar
        - Excluir
        - Listar

- Validação: Deve impedir o usuário de cadastrar se não fornecer essas informações
- perfil: obrigatório

4. **Cadastrar Perfil Administrador automaticamente (seeder)**:

5. **Relacionamento Usuário-Perfis**:
    - Um usuário pode ter múltiplos perfis e vice-versa (relacionamento muitos-para-muitos).
    - Criar uma funcionalidade para associar/desassociar perfis a usuários.
    - Listar os perfis de um usuário.

6. **Controle de Acesso**:
    - Apenas usuários autenticados podem acessar o sistema.
    - Apenas usuários com o perfil "Administrador" podem gerenciar perfis e associações.

## **Requisitos Diferenciais**
- Implementar a funcionalidade de desassociar perfis de forma assíncrona, ou seja, implementar uma mensageria com kafka ou RabbitMQ usando o conceito de producer/consumer de mensagens.

---

## **Entrega**

1. **Repositório**:
    - Fazer um fork deste repositório.

2. **README-novo do Projeto**:
    - Crie um novo Readme "Readme-novo.md"
    - Inclua as seguintes informações:
        - Descrição do projeto.
        - Passos para configurar o ambiente.
        - Como rodar as migrations e seeders.
        - Usuário e senha de teste para login.

3. **Pontos de Verificação**:
    - O sistema deve atender a todos os requisitos mencionados.

4. **Entrega Plus**
    - Utilizar arquitetura DDD
    - Utilizar TDD
    - Utilizar Swagger

---

## **Critérios de Avaliação**

1. **Funcionamento**:
    - A aplicação atende a todos os requisitos funcionais descritos?

2. **Interface e Usabilidade**:
    - A aplicação possui uma interface clara e funcional?

3. **Código**:
    - O código é legível.

---

## **Configuração do Projeto**

### **Requisitos**
- PHP >= 8.2
- Composer
- Banco de dados relacional (MySQL, Sqlite, PostgreSQL ou outro compatível com Laravel)
- Laravel >= 12.x
- Frontend usando VUE (2 ou 3)

---

## **Commit**
- Faça o clone deste Readme e suba no seu repositório pessoal
 
