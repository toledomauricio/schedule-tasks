# Projeto de Schedules 🗓️

Este é um projeto de exemplo para gerenciar agendamentos (schedules) utilizando o Laravel 11. Ele fornece uma API RESTful para criar, ler, atualizar e excluir agendamentos. O projeto também inclui testes unitários para garantir o funcionamento correto das funcionalidades.

## Funcionalidades

- CRUD completo para agendamentos.
- Filtragem de agendamentos por intervalo de datas.
- Autenticação de usuários com Laravel Sanctum.
- Validação de datas para evitar cadastros em finais de semana e sobreposição de datas.

## Tecnologias Utilizadas

- Laravel 11
- PHP 8.3
- MySQL (ou outro banco de dados suportado pelo Laravel)
- PHPUnit para testes unitários

## Requisitos

- PHP >= 8.3
- Composer
- MySQL (ou outro banco de dados suportado pelo Laravel)

## Instalação

1. Clone o repositório:

2. Instale as dependências do Composer:
`composer install`

3. Crie um arquivo `.env` baseado no `.env.example` e configure suas variáveis de ambiente, incluindo as configurações do banco de dados.

4. Gere a chave de aplicativo:
`php artisan key:generate`

6. Inicie o servidor local:
`php artisan serve`

## Documentação da API
Você pode acessar o nosso swagger no link: `https://documenter.getpostman.com/view/31039731/2sA358c528`

## Testes Unitários

O projeto inclui testes unitários para garantir que as funcionalidades estejam funcionando corretamente. Você pode executar os testes usando o comando `php artisan test`.

## PHP 8.3 e Laravel 11

Este projeto utiliza PHP 8.3 e Laravel 11 para aproveitar os recursos mais recentes e as melhorias de desempenho oferecidas pelas versões mais recentes da linguagem e do framework.

