<h4 align="center">
  <br />
  <img src="resources/doc/icon.png">
  <br />
    Personal Finance 
  <br />
</h4>

<p align="center">
  <img src="https://img.shields.io/github/last-commit/EricNeves/personalFinance?display_timestamp=author&style=flat-square&logo=git&labelColor=%23010409&color=%23F05032">
  <img src="https://img.shields.io/github/languages/top/ericneves/personalFinance?style=flat-square&logo=php&logoColor=%23fff&label=PHP&labelColor=%23777BB4&color=%231C47CB">
  <img src="https://img.shields.io/github/license/ericneves/personalFinance?style=flat-square&logo=github&logoColor=white&labelColor=%23000000&color=%23DEEB52">
</p>

<p align="center">
    Aplicação web desenvolvida com <strong>PHP</strong> e <strong>Angular</strong>, destacando a implementação de princípios de componentização no backend, como <strong>REP (Release/Reuse Equivalence Principle)</strong>, <strong>CCP (Common Closure Principle)</strong> e <strong>CRP (Common Reuse Principle)</strong>, além da adoção do princípio arquitetural <strong>Ports and Adapters (Hexagonal)</strong> e testes automatizados com Pest.
</p> 

<p align="center">Data de criação: Oct 20, 2024</p>

https://github.com/user-attachments/assets/24dfde31-f6d9-4b3d-92ae-18ad7eea7ec4

#### Intro 📖

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
> - Classes que possuem um forte aclopamento entre si e são reutilizadas juntas devem pertencer ao mesmo componente.
> - Segundo o CRP, as classes que não têm uma forte ligação entre si não devem ficar no mesmo componente.
> 

Esses princípios, juntamente com outros como o **SOLID**, facilitam a **manutenção** e a **escalabilidade** da aplicação, reduzindo os recursos necessários para criar e manter o **software**, além de promoverem uma estrutura mais **robusta** e **flexível**.

- [x] Ports and Adapters Architecture
- [x] Solid Principles
- [x] Component Principles
- [x] Automated Tests - (Unit/Functional)
- [x] PSR 1,2,4 and 7

No **frontend**, o projeto adota uma organização modular, separando pages, components, services, models e outros elementos, bem como a manipulação de eventos e ciclo de vida dos componentes.

- [x] Reactive Forms
- [x] Services
- [x] Modules
- [x] Guards
- [x] Interceptors
- [x] Components
- [x] Utils

#### Features 🚀

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

#### How to execute ? 💡

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

#### Tests 🔋

```sh
# enter the container
$ docker exec -it www bash

# run tests
$ composer test
```

#### Author 🗿

<table>
  <tr>
    <td align="center">
      <a href="https://www.instagram.com/ericneves_dev/">
        <img src="https://avatars.githubusercontent.com/u/32256029" width="100px;" alt=""/>
        <br />
        <sub>
          <b>Eric Neves</b>
        </sub>
      </a>
    </td>
  </tr>
  <tr>
    <td>
      <a href="https://www.instagram.com/ericneves_dev/">
        <img src="https://img.shields.io/badge/Instagram-E4405F?style=for-the-badge&logo=instagram&logoColor=white" width="100%">
      </a> 
      <br />
      <a href="https://linkedin.com/in/ericnevesrr"> 
        <img src="https://img.shields.io/badge/LinkedIn-0077B5?style=for-the-badge&logo=linkedin&logoColor=white" width="100%">
      </a>
    </td>
  </tr>
</table>

#### License 📋

<img src="https://img.shields.io/github/license/ericneves/personalFinance?style=flat-square&logo=github&logoColor=white&labelColor=%23000000&color=%23DEEB52">
