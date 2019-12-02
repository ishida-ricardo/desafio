Utilizados:
- Laravel 6.*
- MySQL 
- PHPUnit
- PHPLint

Como instalar o projeto:

1 - Git clone url_projeto
2 - composer install
3 - Criar e configurar banco de dados (DB) 
3.1 - editar arquivo .env
3.2 - editar arquivo .env.testing
4 - php artisan migrate --seed
5 - php artisan serve

Como utilizar a api:

1 - Enviar requisições com header:
1.1 - Accept: application/json
1.2 - Content-Type: application/json
1.3 - Authorization: Bearer 0182387ce3cfbb4ff18d1575ae767d291926cc69e3b67707899f6b7b6b97e808 (usuário teste autenticado)
2 - Rotas disponíveis:
2.1 - GET /v1/products
2.2 - POST /v1/products
2.3 - POST /v1/customers
2.4 - GET /v1/orders
2.5 - POST /v1/orders
2.6 - PUT /v1/orders/{ID}

Executar testes automatizados:

1 - Criar e configurar banco de dados (DB) 
1.1 - editar arquivo .env.testing
2 - vendor\bin\phpunit
