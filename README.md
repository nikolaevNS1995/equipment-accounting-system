# 📦 Учет оборудования и мебели — Laravel 11 API

Проект на **Laravel 11**, представляющий собой REST API для учета оборудования и мебели. Реализована авторизация по **JWT**, использован **Docker** для контейнеризации, **MySQL** как СУБД и **Redis** для кеширования и очередей. Поддерживается автогенерация Swagger-документации.

---

## 🚀 Основной функционал

- CRUD API для оборудования, мебели, кабинетов, площадок, сотрудников, перемещений и д.р.
- JWT-аутентификация (через `tymon/jwt-auth`)
- Swagger-документация по всем маршрутам
- Ролевая модель доступа: администратор, инженер, сотрудник
- Redis — кеширование и очереди
- Laravel Job/Queue поддержка
- Docker-окружение для разработки и деплоя

---

## 🐳 Быстрый старт через Docker

### 1. Клонируйте репозиторий:

```bash
git clone https://github.com/nikolaevNS1995/equipment-accounting-system.git
cd equipment-accounting-system
```

### 2. Создайте `.env`:

```bash
cp .env.example .env
```

Пример основных настроек:

```env
APP_NAME=equipment_accouting
APP_ENV=local
APP_KEY=
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=project_db
DB_PORT=3306
DB_DATABASE=lardocker
DB_USERNAME=root
DB_PASSWORD=root

CACHE_STORE=redis
QUEUE_CONNECTION=redis
REDIS_HOST=project_redis
REDIS_CLIENT=predis

JWT_SECRET=
```

### 3. Запуск контейнеров

```bash
docker-compose up -d --build
```

### 4. Инициализация проекта

```bash
docker exec -it app php artisan key:generate
docker exec -it app php artisan jwt:secret
docker exec -it app php artisan migrate --seed
```

---

## 🔐 Аутентификация через JWT

Получите токен через `/api/auth/login`, отправив `email` и `password`.

Пример запроса:

```http
POST /api/auth/login
Content-Type: application/json

{
  "email": "admin@example.com",
  "password": "password"
}
```

Ответ:

```json
{
  "access_token": "your.jwt.token",
  "token_type": "bearer",
  "expires_in": 3600
}
```

🔐 **Для всех защищённых маршрутов** добавляйте заголовок:

```
Authorization: Bearer your.jwt.token
```

---

## 📚 Документация API

- Swagger UI: [`/api/documentation`](http://localhost/api/documentation)
- Генерация документации:

```bash
docker exec -it app php artisan l5-swagger:generate
```

---

## 🧪 Тестирование

```bash
docker exec -it app php artisan test
```

---

## 📌 Полезные команды

```bash
# Очистка кешей
docker exec -it app php artisan optimize:clear

# Очереди
docker exec -it app php artisan queue:work

# Повторная генерация ключей
docker exec -it app php artisan key:generate
docker exec -it app php artisan jwt:secret
```

---

## 🗂️ Структура

- `app/Models` — модели (Equipment, Category, etc.)
- `app/Http/Controllers/Api` — контроллеры API
- `app/Http/Middleware` — middleware (включая JWT)
- `routes/api.php` — маршруты API
- `config/l5-swagger.php` — настройки Swagger

---

## 📄 Лицензия

MIT

**Автор:** Николаев Никита Сергеевич 
**Контакт:** nikolaevns1995@gmail.com
