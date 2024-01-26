# Desafio para Estágio

O objetivo do teste é criar uma aplicação que possibilite o usuário gerenciar uma biblioteca

## 🚀 Começando

Essas instruções permitirão que você obtenha uma cópia do projeto em operação na sua máquina local para fins de desenvolvimento e teste.

### 📋 Pré-requisitos

Para inciar esse projeto é imprescindível ter as seguintes ferramentas instaladas em sua máquina:
- [Node.js](https://nodejs.org/en)
- [PHP](https://www.php.net/downloads.php)
- [Composer](https://getcomposer.org/download/)
- [MySQL](https://dev.mysql.com/downloads/mysql/)

Observação: mesmo que tenha instalado algum dos itens acima, recomenda-se ainda sim instalar a versão mais atual para evitar conflitos ou problemas.

### 🔧 Instalação

Para instalar todas as dependências necessárias para o projeto basta:
1. Abra um terminal de sua escolha e navega até pasta do projeto "Backend"
1. Já dentro da pasta, execute dois comandos: ``` composer install ``` e ``` npm i ```
1. Agora navega até a pasta do projeto "Frontend"
1. Já dentro da pasta, execute um comando: ``` npm i ```

Agora é importante criar um database novo no MySQL, para isso basta executar o seguinte comando em um terminal com conexão com o banco ou então em uma plataforma gerenciadora do banco de dados:

```
CREATE DATABASE library;
```

Agora é necessário criar um arquivo com o nome ".env" dentro da pasta "Backend":
1. Navega até pasta do projeto "Backend"
1. Já dentro da pasta, copie o arquivo ".env.example" e cole no mesmo local de cópia
1. Renomeie a cópia para ".env"
1. No arquivo ".env" realize a configuração com o banco de dados
  -Deixe DB_CONNECTION como sendo mysql
  -Em DB_HOST coloque localhost
  -Em DB_PORT coloque a porta em que seu banco de dados está configurado, caso não tenha feito alteração, por padrão é 3306
  -Em DB_DATABASE coloque library
  -Em DB_USERNAME coloque seu usuário do banco de dados, por padrão é root
  -EM DB_PASSWORD coloque a senha do usuário, essa senha você definiu quando instalou o MySQL

Para a configuração do ".env", sempre coloque o valor imediatamente depois do sinal de igual ("=") e o valor não precisa estar entre aspas

Com o database configurado, basta rodar:
```
php artisan migrate
```
Isso criará todas as tabelas necessárias no banco de dados.

## 📦 Executando o Projeto

Para executar o projeto basta:
1. Abra um terminal de sua escolha e navega até pasta do projeto "Backend"
1. Execute ``` php artisan serve ```
1. Abra outro terminal de sua escolha e navega até pasta do projeto "Frontend"
1. Execute ``` npm run dev ```

Após a execução do comando ``` npm run dev ``` uma URL será gerada no console, basta copiar e colar na URL do navegador. Com isso você já estará vendo a interface do projeto.

*Observação*: após executar o comando ``` php artisan serve ```, verifique se a URL gerada está de acordo com a que está dentro de "Frontend/src/main.js". É imprescídivel que as URLs sejam a mesma com excessão do "/api" que é o final da URL do arquivo main.js. Se tiver divergência, basta alterar de acordo com a gerada pelo comando executado.

## 🛠️ Construído com
- [Laravel](https://laravel.com/): excelente Framework para desenvolvimento tanto Front-end quanto Back-end, facilita demais a criação de páginas dinâmicas, controle de rota e comunicação com o banco de dados. Nesse projeto, utilizamos o Laravel apenas como uma API, neste caso, ele não é responsável por renderizar páginas para nós, apenas para interceptar requisões HTTP. Ele deixa muito fácil também a criação de API baseadas no padrão MVC, uma vez que quando instalado já vem com um design de pastas próprio para isso, assim como já possui classes base de Controllers e Modelss, outro ponto é possibilitar o uso de migrations de maneira bem simples.
- [Vue](https://vuejs.org/): excelente Framework para desenvolvimento Front-end, facilita demais a criação de páginas dinâmicas, principalmente quando se tem que renderizar itens após uma chamada da API do Back-end. Outro ponto positivo é que ele já vem com ferramentas para evitar problemas de segurança, pois todo texto que é colocado em um input, o Vue automaticamente higieniza (sanitize) ele.
- [Vuetify](https://vuetifyjs.com/en/): é usado junto do Vue, é um Framework de componentes, ele já vem com diversos componentes prontos que auxilia muito o desenvolvimento.
- [Axios](https://axios-http.com/ptbr/docs/intro): é usado para realizar requisões em nossa API, sua semântica é bem simples e poderosa, assim como contém configurações que auxiliam durante o desenvolvimento, como colocar uma URL base para toda suas requisições.
- [cpf-cnpj-validator](https://www.npmjs.com/package/cpf-cnpj-validator?activeTab=readme): é apenas uma biblioteca para validar CPF, uma vez que é necessário sua validação para cadastrar no banco de dados
- [date-fns](https://date-fns.org/): biblioteca usada para manipulação de datas, torna-se muito útil quando se tem que manipular datas, seja para adição de mês, dia ou ano, assim como formatação de datas.