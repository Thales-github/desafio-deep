# 📚 Sistema de Escola

Sistema completo de CRUD (Create, Read, Update, Delete) para gerenciamento de alunos, professores e disciplinas.
Foi desenvolvido com **Laravel 12**, utilizando **Blade** e **Bootstrap** no front-end, e **MySQL** rodando em **Docker** para o banco de dados.

## 📋 Sobre o Projeto

Este projeto é uma aplicação web completa para gerenciamento de escola, com uma arquitetura que separa a API (backend) da interface web, permitindo tanto o consumo via API quanto uma interface amigável para usuários finais.

### ✨ Funcionalidades

- ✅ **CRUD Completo**: Cadastrar, Listar, Visualizar, Editar e Excluir alunos
- ✅ **Validações**: Campos obrigatórios, email único, CPF único, data válida
- ✅ **Máscaras**: Formatação automática de CPF, telefone e CEP
- ✅ **Interface Responsiva**: Bootstrap 5 com design moderno
- ✅ **Tabela Dinâmica**: DataTables com paginação, busca e ordenação
- ✅ **Modal de Confirmação**: Para exclusão de registros

## 🚀 Tecnologias Utilizadas

| Tecnologia | Versão | Finalidade               |
| ---------- | ------ | ------------------------ |
| PHP        | 8.2+   | Linguagem principal      |
| Laravel    | 12.x   | Framework PHP            |
| MySQL      | 8.0    | Banco de dados           |
| Docker     | 24.0+  | Containerização (Laravel Sail) |
| Blade  |     12.x   | Motor de templates       |
| Bootstrap  | 5.3    | Framework CSS            |
| jQuery     | 3.7+   | Manipulação DOM e AJAX   |
| DataTables | 1.13+  | Tabelas dinâmicas        |


## ⚙️ Configuração do Ambiente

### Pré-requisitos

- PHP 8.2 ou superior
- Composer
- Docker e Docker Compose
- Git

### Passo a passo (Laravel Sail)

Com o `.env` padrão do Sail, `DB_HOST=mysql` só existe **dentro da rede Docker**. Por isso as migrations devem rodar **pelo Sail**, não com `php artisan` direto no WSL/Linux.

1. **Clonar e entrar no projeto**

```bash
git clone https://github.com/Thales-github/desafio-deep
cd desafio-deep
```

2. **Instalar dependências (no host)**

```bash
composer install
cp .env.example .env   # se ainda não existir
php artisan key:generate
```

3. **Subir os containers**

```bash
./sail up -d
```

4. **Migrations (sempre via Sail quando `DB_HOST=mysql`)**

```bash
./sail artisan migrate
```

5.  **Url da aplicação disponibilizada**

```bash
localhost/alunos
```

6. **Desenvolvimento**

- App pelo Sail: `./sail open` ou acesse a URL que o Sail expõe (em geral `http://localhost`, conforme `APP_PORT` no `.env`).
- Ou, no host: `./sail artisan serve` se quiser usar o servidor embutido **dentro** do container.

**Resumo:** use `./sail artisan …`, `./sail composer …`, `./sail npm …` para tudo que precisa falar com o MySQL em `mysql`.

### Se quiser usar `php artisan` no host

Aí o `.env` precisa apontar para o MySQL publicado na máquina, por exemplo `DB_HOST=127.0.0.1` e a porta mapeada (`DB_PORT=3306` ou `FORWARD_DB_PORT` se você alterou). Isso é um fluxo separado do Sail com `DB_HOST=mysql`.