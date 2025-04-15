# Task Manager API (Laravel 8.83.29)

Мини-CRM для управления задачами с RESTful API, реализованный на Laravel 8.83.29 с использованием слоистой архитектуры (Repository + Service).

## 📌 Основные возможности

- 🔐 Аутентификация через Laravel Sanctum
- ✅ CRUD операции для задач
- 🔍 Фильтрация задач по статусу
- 🛡️ Авторизация действий через политики
- 🧪 Покрытие тестами (PHPUnit)

## 🛠 Технологический стек

- PHP 7.4+/8.0
- Laravel 8.83.29
- MySQL/PostgreSQL/SQLite
- Laravel Sanctum (API Auth)
- PHPUnit (тестирование)

## 📦 Установка

1. Клонировать репозиторий:
```bash
git clone https://github.com/your-repo/task-manager.git
cd task-manager
```

2. Установить зависимости:
```bash
composer install
```

3. Настройка окружения:
```bash
cp .env.example .env
php artisan key:generate
```

4. Настройте БД в `.env`:
```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_manager
DB_USERNAME=root
DB_PASSWORD=
```

5. Запустить миграции:
```bash
php artisan migrate
```

6. Установите Sanctum:
```bash
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```

## 🚀 Запуск

```bash
php artisan serve
```

API будет доступно по адресу: `http://localhost:8000/api`

## 📚 API Endpoints

### 🔐 Аутентификация
Используйте Sanctum токен для доступа к API.

Тестовый роут логина
```bash
 http://localhost:8000/api/test-login
```

### 📝 Задачи

| Метод | Endpoint                | Описание                     |
|-------|-------------------------|-----------------------------|
| GET   | `/api/tasks`            | Список задач пользователя   |
| GET   | `/api/tasks?status=new` | Фильтрация по статусу       |
| POST  | `/api/tasks`            | Создание новой задачи       |
| PUT   | `/api/tasks/{id}`       | Обновление задачи           |
| DELETE| `/api/tasks/{id}`       | Удаление задачи             |

### Пример запроса (создание задачи):
```bash
curl -X POST http://localhost:8000/api/tasks \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"title": "Новая задача", "description": "Описание"}'
```

## 🏗 Архитектура

```
app/
├── Http/           # Контроллеры
├── Models/         # Модели данных
├── Repositories/   # Слой работы с БД
├── Services/       # Бизнес-логика
└── Policies/       # Авторизация
```

## 🧪 Тестирование

Запуск тестов:
```bash
php artisan test
```

Тесты покрывают:
- Создание/обновление задач
- Авторизацию доступа
- Фильтрацию по статусу
