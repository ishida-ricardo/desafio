Utilizados:
- Laravel 6.*
- MySQL 
- PHPUnit
- PHPLint

Como instalar o projeto:

1 - Git clone https://github.com/ishida-ricardo/desafio.git <br/>
2 - composer install <br/>
3 - Criar e configurar banco de dados (DB)  <br/>
3.1 - editar arquivo .env <br/>
3.2 - editar arquivo .env.testing <br/>
4 - php artisan migrate --seed <br/>
5 - php artisan serve <br/>

Como utilizar a api:

1 - Enviar requisições com header: <br/>
1.1 - Accept: application/json <br/>
1.2 - Content-Type: application/json <br/>
1.3 - Authorization: Bearer 0182387ce3cfbb4ff18d1575ae767d291926cc69e3b67707899f6b7b6b97e808 (usuário teste autenticado) <br/>
2 - Rotas disponíveis: <br/>
2.1 - GET /v1/products <br/>
2.2 - POST /v1/products <br/>
2.3 - POST /v1/customers <br/>
2.4 - GET /v1/orders <br/>
2.5 - POST /v1/orders <br/>
2.6 - PUT /v1/orders/{ID} <br/>

Executar testes automatizados:

1 - Criar e configurar banco de dados (DB)  <br/>
1.1 - editar arquivo .env.testing <br/>
2 - vendor\bin\phpunit <br/>
