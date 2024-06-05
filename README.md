# Sistema de Registro de Ponto

Este é um sistema de registro de ponto desenvolvido em PHP com suporte a MySQL. Ele permite que os usuários registrem seus horários de entrada e saída, e que administradores visualizem relatórios de horas trabalhadas e IPs não autorizados.

## Funcionalidades

- Página de login do usuário
- Registro de horários de início e término de trabalho
- Exibição do total de dias trabalhados no mês
- Página administrativa com relatórios de funcionários, incluindo total de dias e horas trabalhadas
- Tabela detalhada com dias da semana, hora de entrada e saída, e nome do usuário
- Exportação de dados para PDF e XLSX
- Registro de tentativas de acesso não autorizadas por IP
- Design responsivo para dispositivos móveis

## Estrutura do Projeto

```
meu_sistema/
├── index.php
├── login.php
├── registro_trabalho.php
├── relatorio.php
├── visualizar_ips.php
├── controle_acesso.php
├── includes/
│   ├── db.php
│   ├── header.php
│   └── footer.php
├── css/
│   └── estilo.css
├── js/
│   └── script.js
└── logs/
    └── unauthorized_ips.log
```

## Configuração do Banco de Dados

1. Crie o banco de dados e as tabelas necessárias utilizando o seguinte script SQL:

```sql
CREATE DATABASE sistema_trabalho CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE sistema_trabalho;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    senha VARCHAR(255) NOT NULL
);

CREATE TABLE registros_trabalho (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    data DATE NOT NULL,
    hora_entrada TIME,
    hora_saida TIME,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);
```

2. Configure a conexão com o banco de dados no arquivo `includes/db.php`.

## Instalação

1. Clone este repositório para o seu servidor local.
2. Configure o servidor Apache para permitir a reescrita de URLs com o `.htaccess`.
3. Configure o banco de dados conforme as instruções acima.
4. Acesse a página inicial no navegador.

## Direitos Autorais

© 2024 AndreTsC. Todos os direitos reservados.

Se você gostou deste projeto, considere fazer uma doação via PayPal para `andrebauru@hotmail.com`.

## Contato

Para mais informações, entre em contato pelo email `andrebauru@hotmail.com`.
