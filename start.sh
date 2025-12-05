echo "Установка зависимостей..."

# Фронтенд
echo "Устанавливаем фронтенд зависимости..."
cd frontend && npm install

# Бэкенд
echo "Устанавливаем бэкенд зависимости..."
cd ../backend && composer install
cp .env.example .env
echo "Установка завершена! Можете запускать docker compose up"