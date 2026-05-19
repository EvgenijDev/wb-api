# WB API - Интеграция с Wildberries API

Проект для получения данных о продажах, заказах, остатках и доходах из Wildberries API.

## 1. Server (VPS) deployment

## Доступ к серверу

```bash
# SSH доступ
ssh checker@194.87.196.158
# Пароль: Kx9#mP2$vL7@nQ4&wR8

# После входа вы увидите приветствие с командами

# Перейти в папку проекта
cd /var/www/wb-api

# Импорт продаж за период
php artisan import:wb sales --from=2026-01-01 --to=2026-01-31

# Импорт заказов за период
php artisan import:wb orders --from=2026-01-01 --to=2026-01-31

# Импорт остатков (текущий день)
php artisan import:wb stocks --from=2026-05-19

# Импорт поступлений за период
php artisan import:wb incomes --from=2026-01-01 --to=2026-01-31

# Подключение к MySQL
mysql -u wb_user -pStrongPassword123! wb_api

SELECT COUNT(*) FROM sales;
SELECT COUNT(*) FROM orders;
SELECT COUNT(*) FROM stocks;
SELECT COUNT(*) FROM incomes;

```

## 2. Local deployment

### Requirements
- PHP 8.1+
- Composer
- MySQL 8+
- Git

```bash
git clone https://github.com/EvgenijDev/wb-api.git
cd wb-api

composer install

cp .env.example .env
php artisan key:generate

php artisan migrate

# Импорт продаж за период
php artisan import:wb sales --from=2026-01-01 --to=2026-01-31

# Импорт заказов за период
php artisan import:wb orders --from=2026-01-01 --to=2026-01-31

# Импорт остатков (текущий день)
php artisan import:wb stocks --from=2026-05-19

# Импорт поступлений за период
php artisan import:wb incomes --from=2026-01-01 --to=2026-01-31
```

## 3. Local deployment Docker setup

### Requirements
- Docker
- Docker Compose

### Run project

```bash

git clone https://github.com/EvgenijDev/wb-api.git
cd wb-api

cp .env.example .env
docker-compose up -d --build
docker compose exec php composer install
docker compose exec php php artisan key:generate
docker compose exec php php artisan migrate

# Импорт заказов за период
docker compose exec php php artisan import:wb orders --from=2026-05-01 --to=2026-05-18

# Импорт продаж за период
docker compose exec php php artisan import:wb sales --from=2026-01-01 --to=2026-01-31

# Импорт остатков (текущий день)
docker compose exec php php artisan import:wb stocks --from=2026-05-19

# Импорт поступлений за период
docker compose exec php php artisan import:wb incomes --from=2026-01-01 --to=2026-01-31
```
# Подключение к MySQL

## SSH доступ
```bash
ssh checker@194.87.196.158
# Пароль: Kx9#mP2$vL7@nQ4&wR8

mysql -u wb_user -pStrongPassword123! wb_api

SELECT COUNT(*) FROM sales;
SELECT COUNT(*) FROM orders;
SELECT COUNT(*) FROM stocks;
SELECT COUNT(*) FROM incomes;