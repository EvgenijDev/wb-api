# WB API - Интеграция с Wildberries API

Проект для получения данных о продажах, заказах, остатках и доходах из Wildberries API.

## Доступ к серверу

```bash
# SSH доступ
ssh checker@194.87.196.158
# Пароль: Kx9#mP2$vL7@nQ4&wR8

# После входа вы увидите приветствие с командами

# Перейти в папку проекта
cd /var/www/wb-api

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
