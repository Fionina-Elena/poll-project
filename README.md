# Poll Project

Простой опросник с публичной страницей.

## Технологии
- Backend: Laravel 10, PHP 8.1+
- Frontend: Vue 3, Vuex, Vue Router, MDB Vue UI Kit
- База данных: MySQL

## Требования
- PHP >= 8.1
- Composer
- Node.js & npm
- MySQL

## Установка и запуск (без Docker)

1. Установка зависимостей PHP:
   ```bash
   composer install
   ```

2. Настройка окружения:
   - Настроить `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` в `.env` под свою БД.

3. Миграции базы данных:
   ```bash
   php artisan migrate
   ```

4. Запуск сервера Laravel:
   ```bash
   php artisan serve
   ```

5. Установка зависимостей фронтенда:
   ```bash
   npm install
   ```

6. Запуск фронтенда (Vite):
   ```bash
   npm run dev
   ```

## Как пользоваться
1. Открыть `http://localhost/create` — создание опроса.
2. После создания --> ссылка вида `/poll/code`.
3. Переход по ссылке, выберать вариант и проголосовать.
4. Результаты видны сразу после голосования.

