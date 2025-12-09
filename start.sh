echo "Подготовка проекта..."

cp .env.example .env

echo "Подготавливаем фронтенд..."
cd frontend && npm install


echo "Устанавливаем бэкенд зависимости..."
cd ../backend && cp .env.example .env

echo "Установка завершена! Запускаем Docker..."

cd .. && docker compose up --build -d
docker compose exec backend composer install
docker compose exec backend php artisan migrate

echo "Выдача прав на запись логов для laravel"
docker compose exec -it backend chown -R www-data:www-data /var/www/html/storage
docker compose exec -it backend chmod -R 775 /var/www/html/storage
docker compose exec -it backend chown -R www-data:www-data /var/www/html/bootstrap/cache
docker compose exec -it backend chmod -R 775 /var/www/html/bootstrap/cache

docker compose exec backend php artisan jwt:secret

echo "Проект запущен"