echo "Подготовка проекта..."
echo "Настраиваем окружение проекта..."
cp .env.example .env

echo "Устанавливаем бэкенд окружение..."
cd backend && cp .env.example .env

echo "Окружение готово! Запускаем Docker..."

cd .. && docker compose up --build -d
docker compose exec frontend npm install
docker compose exec backend composer install
docker compose exec backend php artisan migrate
docker compose exec backend php artisan db:seed
docker compose exec backend php artisan storage:link

echo "Выдача прав на запись логов для laravel"
#docker compose exec -it backend chown -R www-data:www-data /var/www/html/storage
#docker compose exec -it backend chmod -R 775 /var/www/html/storage
#docker compose exec -it backend chown -R www-data:www-data /var/www/html/bootstrap/cache
#docker compose exec -it backend chmod -R 775 /var/www/html/bootstrap/cache

docker compose exec backend php artisan jwt:secret

echo "Проект запущен"