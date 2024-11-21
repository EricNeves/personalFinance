<h4 align="center">
  <br />
  <img src="resources/doc/icon.png">
  <br />
    Personal Finance 
  <br />
</h4>

<p align="center">
  <img src="">
  <img src="">
  <img src="">
</p>

<p align="center">
    Aplicação web desenvolvida com <strong>PHP</strong> e <strong>Angular</strong>, destacando a implementação de princípios de componentização no backend, como <strong>REP (Release/Reuse Equivalence Principle)</strong>, <strong>CCP (Common Closure Principle)</strong> e <strong>CRP (Common Reuse Principle)</strong>, além da adoção do princípio arquitetural <strong>Ports and Adapters (Hexagonal)</strong>.
</p> 

<p align="center">Data de criação: Oct 20, 2024</p>

#### Intro

**Personal Finance** é um sistema web desenvolvido com **PHP** e **Angular**, concebido para o gerenciamento de finanças pessoais, garantindo que os usuários mantenham o controle financeiro em dia.

No backend o projeto incorpora recursos que foram mencionados no livro **Arquitetura Limpa** de **Uncle Bob**, como princípios de componentização, que priorizam a manutenção do código. Em determinados cenários, a **manutenção** é mais importante do que a **reutilização**, garantindo que os impactos de mudanças sejam minimizados ao revalidar e reimplantar o código-fonte.

#### Component Principles

> 
> **REP (Release/Reuse Equivalence Principle)** 
> - Do ponto de vista do design e da arquitetura de software, esse princípio significa que as classes e módulos formados em um componente devem pertencer a um grupo coeso. O componente não pode simplesmente consistir em uma mistura aleatória de classes e módulos, mas deve haver algum tema ou propósito abrangente que todos esses módulos compartilhem.
>

>
> **CCP (Common Closure Principle)**
> - Esse é o Single Responsibility Principle reformulado para ser aplicável aos componentes. Assim como SRP diz que uma classe não deve conter muitas razões para mudar, CCP diz que um componente não deve ter várias razões para mudar.
> - Quando o código de uma aplicação tem que mudar, é preferível que todas as mudanças ocorram em um componente em vez de serem distribuídas por vários componentes.
> - O CCP determina que todas as classes com probabilidade de mudar pelas mesmas razões sejam reunidas em um só lugar.
> 

>
> **CRP (Common Reuse Principle)**
> - Segundo esse princípio, as classes e módulos que tendem a ser reutilizados juntos pertecem ao mesmo componente.
> - Classes que possuem um forte aclopamente entre si e são reutilizadas juntas devem pertencer ao mesmo componente.
> - Segundo o CRP, as classes que não têm uma forte ligação entre si não devem ficar no mesmo componente.
> 

Esses princípios, juntamente com outros como o **SOLID**, facilitam a **manutenção** e a **escalabilidade** da aplicação, reduzindo os recursos necessários para criar e manter o **software**, além de promoverem uma estrutura mais **robusta** e **flexível**.

- [x] Ports and Adapters Architecture
- [x] Solid Principles
- [x] Component Principles
- [x] Automated Tests - (Unit/Functional)
- [x] PSR 1,2,4 and 7

No **frontend**, o projeto adota uma organização modular, separando pages, components, services, models e outros elementos.

- [x] Reactive Forms
- [x] Services
- [x] Modules
- [x] Guards
- [x] Interceptors
- [x] Components
- [x] Utils

#### Features

- Backend
  - PHP 8.2
  - Ports and Adapters Architecture
  - Authentication - JWT
  - Middlewares
  - Routes
  - Http
  - Database
    - Postres:15
  - Dependencies
    - vlucas/phpdotenv: ^5.6
    - ramsey/uuid: ^4.7
    - pestphp/pest: ^3.5
    - mockery/mockery: ^1.6
- Frontend
  - Angular 17
  - Routes
  - Guards
  - Interceptors
  - Models
  - Services
  - Dependencies
    - ngx-pagination: ^6.0.3
    - primeflex: ^3.3.1
    - primeng: ^17.18.11
    - primeicons: ^7.0.0
- DevOps
  - Docker
  - Docker Compose
  - Nginx  

#### How to execute ?

> [!NOTE]
>
> Para garantir a execução bem-sucedida da aplicação, é essencial seguir os passos abaixo.
>

```sh

# dir
$ cd personalFinance

# install web dependencies
$ cd web && pnpm install

# install www dependencies
$ cd www && composer install && cp .env.exemple .env

# root dir
$ docker compose up -d --build

```

- [x] Backend: http://127.0.0.1:8080
- [x] Frontend: http://127.0.0.1:4200

#### Tests

```sh
# enter container
$ docker exec -it www bash

# run tests
$ composer test
```
