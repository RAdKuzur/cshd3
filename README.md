## МОСОБЛСУД.УЧЁТ

Проект состоит из backend (Laravel) и frontend части, запускается в Docker Compose. Ниже описан полный порядок запуска, инициализации и работы с проектом в dev и prod окружениях.

---

## Требования

* Docker
* Docker Compose (v2)
* Bash (для запуска скриптов)

---

## Запуск проекта

### 1. Старт контейнеров

В зависимости от окружения выполните один из скриптов:

**Локальная разработка (dev):**

```bash
./local.sh
```

**Продакшен (prod):**

```bash
./deploy.sh
```

Скрипты поднимают все необходимые контейнеры через Docker Compose.

---

### 2. Установка зависимостей

После того как контейнеры запущены, необходимо установить зависимости:

**Backend (PHP / Laravel):**

```bash
docker compose exec backend composer install
docker compose exec backend composer update
```

**Frontend (Node.js):**

```bash
docker compose exec frontend npm install
```

---

### 3. Первичная инициализация Laravel

При первом запуске проекта выполните следующие команды:

```bash
docker compose exec backend php artisan key:generate
docker compose exec backend php artisan storage:link
```

---

### 4. Инициализация данных

Для заполнения базы данных начальными данными:

```bash
docker compose exec backend php artisan db:seed
```

---

### 5. Права доступа к хранилищу

Для корректной работы Laravel необходимо выдать права на каталоги `storage` и `bootstrap/cache`:

```bash
docker compose exec -it backend chown -R www-data:www-data /var/www/html/storage
docker compose exec -it backend chmod -R 775 /var/www/html/storage

docker compose exec -it backend chown -R www-data:www-data /var/www/html/bootstrap/cache
docker compose exec -it backend chmod -R 775 /var/www/html/bootstrap/cache
```

---

## Мониторинг и метрики (Grafana)

### Prometheus queries

**Среднее время выполнения HTTP-запроса:**

```promql
rate(app_http_request_duration_seconds_sum[time])
/
rate(app_http_request_duration_seconds_count[time])
```

**RPS (Requests Per Second):**

```promql
rate(app_http_requests_all_total[time])
```
**Loki:**
```promql
rate({service="container_name"}[time])
```
Эти запросы можно использовать напрямую в Grafana Dashboard.

---

## Нагрузочное тестирование

Для проведения нагрузочного тестирования используется **Artillery**.

Запуск теста:

```bash
artillery run artillery.yml
```

Конфигурация сценариев находится в файле `artillery.yml`.

---

## Полезные команды

Остановить проект:

```bash
docker compose down
```

Пересобрать контейнеры:

```bash
docker compose build --no-cache
```

Просмотр логов:

```bash
docker compose logs -f
```