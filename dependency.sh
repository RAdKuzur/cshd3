echo "Установка зависимостей..."

# Фронтенд
echo "Устанавливаем фронтенд зависимости..."
cd frontend && npm install

# Бэкенд
echo "Устанавливаем бэкенд зависимости..."
cd ../backend && composer install
cp .env.example .env
echo "Установка завершена!"

cho "Запуск базы данных..."
cd .. && docker compose up db pgadmin -de