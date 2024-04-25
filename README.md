# Super-Waffle

#### Desafio 02

---

### DEV Container:

Executando DEV Container:

`` docker compose build ``

`` docker compose up ``

Instalando Dependências:

`` docker compose exec -it app composer install ``

Executando Migrations:

`` docker compose exec -it app ./vendor/bin/doctrine-migrations migrations:execute --up SuperWaffle\\Migrations\\Version20240421232509 ``

Executando Testes:

`` docker exec -it app ./vendor/bin/phpunit ``