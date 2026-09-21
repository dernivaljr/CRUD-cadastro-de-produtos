# CRUD de Cadastro de Produtos

Projeto acadêmico desenvolvido para a disciplina de Desenvolvimento Web II da Fatec, com foco em operações básicas de CRUD em PHP e MySQL.

## Objetivo

O sistema permite:
- cadastrar produtos;
- listar produtos em estoque;
- buscar produtos por descrição ou categoria;
- editar informações;
- excluir registros.

## Tecnologias utilizadas

- PHP
- MySQL
- HTML
- CSS
- Bootstrap
- JavaScript

## Estrutura do projeto

```text
contas/
├── cadastro/
│   ├── cadastro_contas.html
│   ├── conexao.php
│   ├── gravar.php
│   ├── login.html
│   ├── usuario.php
│   └── validar.php
├── cadastro_de_produtos/
│   ├── produtos.frm
│   └── produtos.ibd
├── produtos/
│   ├── assets/
│   ├── css/
│   ├── atualizar.php
│   ├── controle_produtos.php
│   ├── editar.php
│   ├── excluir.php
│   ├── listagem.php
│   ├── salvar.php
│   └── vender.php
├── .gitignore
└── README.md
```

## Pré-requisitos

- Servidor web local (USBWebserver, XAMPP ou WAMP)
- PHP
- MySQL
- Navegador web

## Como executar localmente

1. Inicie o servidor web e o MySQL.
2. Copie esta pasta para o diretório de projetos do servidor.
3. Verifique as configurações de conexão em:
   - `produtos/assets/db.php`
   - `cadastro/conexao.php`
4. Acesse o sistema pelo navegador, partindo da área de cadastro/login e depois pelo módulo de produtos.

## Observações

Este projeto foi desenvolvido como trabalho conceitual para fins acadêmicos. A ideia é demonstrar o uso de operações CRUD em um ambiente Web simples e funcional.

## Autor

Projeto desenvolvido por alunos da Fatec, com foco em prática de desenvolvimento Web.
