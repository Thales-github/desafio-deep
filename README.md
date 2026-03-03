# 📚 Sistema de Cadastro de Alunos

Sistema completo de CRUD (Create, Read, Update, Delete) para gerenciamento de alunos, desenvolvido com **Laravel 12**, utilizando **Blade** e **Bootstrap** no front-end, e **MySQL** rodando em **Docker** para o banco de dados.

## 📋 Sobre o Projeto

Este projeto é uma aplicação web completa para gerenciamento de alunos, com uma arquitetura que separa a API (backend) da interface web, permitindo tanto o consumo via API quanto uma interface amigável para usuários finais.

### ✨ Funcionalidades

- ✅ **CRUD Completo**: Cadastrar, Listar, Visualizar, Editar e Excluir alunos
- ✅ **Validações**: Campos obrigatórios, email único, CPF único, data válida
- ✅ **Máscaras**: Formatação automática de CPF, telefone e CEP
- ✅ **Busca de Endereço**: Auto-preenchimento via CEP (API ViaCEP)
- ✅ **Interface Responsiva**: Bootstrap 5 com design moderno
- ✅ **Tabela Dinâmica**: DataTables com paginação, busca e ordenação
- ✅ **Feedback Visual**: Mensagens de sucesso/erro e validações em tempo real
- ✅ **Modal de Confirmação**: Para exclusão de registros

## 🚀 Tecnologias Utilizadas

| Tecnologia | Versão | Finalidade               |
| ---------- | ------ | ------------------------ |
| PHP        | 8.2+   | Linguagem principal      |
| Laravel    | 12.x   | Framework PHP            |
| MySQL      | 8.0    | Banco de dados           |
| Docker     | 24.0+  | Containerização do banco |
| Bootstrap  | 5.3    | Framework CSS            |
| jQuery     | 3.7+   | Manipulação DOM e AJAX   |
| DataTables | 1.13+  | Tabelas dinâmicas        |


## ⚙️ Configuração do Ambiente

### Pré-requisitos

- PHP 8.2 ou superior
- Composer
- Docker e Docker Compose
- Git

### Passo a Passo para Instalação

#### 1. Clone o repositório
```bash
git clone https://github.com/seu-usuario/desafio-deep.git
cd desafio-deep
