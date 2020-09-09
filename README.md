# README

Olá, obrigado pela oportunidade! :-D

**Tasks**

Deverá desenvolver uma aplicação que utilize PHP (se possível na versão
mais recente que você conseguir) e Framework Laravel – versão 5 ou acima, onde
deve utilizar o sistema de autenticação padrão do Laravel. 4. A aplicação deve ser capaz de realizar uma requisição via CURL com PHP ao site
Quest MultiMarcas ([https://www.questmultimarcas.com.br/estoque](https://www.questmultimarcas.com.br/estoque)) e capturar os
dados dos veículos retornados na busca (Se possível utilizar REGEX, para capturar
os dados) 5. Os dados devem ser salvos em um banco de dados MySQL ou Postgres.

**Sobre o projeto**

Estou utilizando o php na versão 7.3 o host usado no desenvolvimento é um ubuntu 20.04

a versão do laravel utilizada é a 6.18.0

**utilização do sistema**

1. clonar o repositório em um diretório de serviço apache ou ngnix ou clonar em um diretório de sua escolha e iniciar pelo servidor interno do php usando o comando `php artisan serve`

2. renomear o arquivo .env.exemple para .env

3. executar os comandos:
   \$`composer update;` após
   \$`php artisan config:cache;` após
   \$`php artisan key:generate;` após
   \$`php artisan migrate;`
