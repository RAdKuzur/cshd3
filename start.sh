echo "Подготовка проекта..."

cp .env.example .env

echo "Подготавливаем фронтенд..."
cd frontend && npm install


echo "Устанавливаем бэкенд зависимости..."
cd ../backend && cp .env.example .env

echo "Установка завершена! Запускать Docker..."

cd .. && docker compose up --build -d
docker compose exec backend composer install
docker compose exec backend php artisan migrate

echo "Проект запущен"