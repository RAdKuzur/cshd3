<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-red-50 flex items-center justify-center p-6">
    <div class="max-w-2xl mx-auto">

      <!-- Основной контент -->
      <div class="bg-white rounded-3xl shadow-2xl border border-gray-200 p-12 text-center relative overflow-hidden">

        <!-- Анимированная иконка -->
        <div class="mb-8">
          <div class="relative inline-block">
            <div class="w-32 h-32 bg-gradient-to-br from-red-100 to-pink-100 rounded-full flex items-center justify-center mx-auto mb-4 animate-pulse">
              <svg class="w-16 h-16 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
              </svg>
            </div>

            <!-- Анимированные круги -->
            <div class="absolute -top-2 -right-2 w-8 h-8 bg-red-500 rounded-full animate-bounce"></div>
            <div class="absolute -bottom-2 -left-2 w-6 h-6 bg-purple-500 rounded-full animate-bounce" style="animation-delay: 0.2s;"></div>
            <div class="absolute top-4 -right-4 w-4 h-4 bg-yellow-500 rounded-full animate-bounce" style="animation-delay: 0.4s;"></div>
          </div>
        </div>

        <!-- Код ошибки -->
        <div class="mb-6">
          <span class="text-8xl font-bold bg-gradient-to-r from-red-700 to-pink-700 bg-clip-text text-transparent">
            403
          </span>
        </div>

        <!-- Заголовок -->
        <h1 class="text-4xl font-bold text-gray-900 mb-4">
          Доступ запрещен
        </h1>

        <!-- Описание -->
        <p class="text-xl text-gray-600 mb-8 leading-relaxed">
          У вас недостаточно прав для доступа к этой странице.
          Это может быть связано с ограничениями вашей учетной записи или настройками доступа.
        </p>

        <!-- Сообщение о разрешениях -->
        <div class="bg-gradient-to-r from-red-50 to-pink-50 rounded-xl p-6 mb-8 border border-red-200">
          <div class="flex items-center justify-center space-x-2 text-red-700 mb-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="font-semibold">Информация о разрешениях</span>
          </div>
          <div class="text-red-600 text-sm space-y-2 text-left max-w-md mx-auto">
            <div class="flex items-start">
              <svg class="w-4 h-4 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span>Вы авторизованы, но у вашей учетной записи недостаточно привилегий</span>
            </div>
            <div class="flex items-start">
              <svg class="w-4 h-4 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
              </svg>
              <span>Доступ к этому ресурсу ограничен настройками безопасности</span>
            </div>
            <div class="flex items-start">
              <svg class="w-4 h-4 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
              </svg>
              <span>Требуется более высокий уровень доступа или специальные разрешения</span>
            </div>
          </div>
        </div>

        <!-- Текущие разрешения -->
        <div class="mb-8">
          <div class="inline-block bg-gray-100 rounded-lg px-4 py-2">
            <div class="flex items-center space-x-2 text-gray-700">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
              <span class="text-sm font-medium">Текущая роль: <span class="text-red-600">Пользователь</span></span>
            </div>
          </div>
          <p class="text-sm text-gray-500 mt-2">Требуемая роль: <span class="font-semibold">Администратор</span></p>
        </div>

        <!-- Кнопки действий -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8">
          <button
              @click="goHome"
              class="group relative overflow-hidden bg-gradient-to-r from-red-500 to-pink-500 hover:from-red-600 hover:to-pink-600 text-white font-semibold py-4 px-8 rounded-xl shadow-lg transition-all duration-300 transform hover:scale-105 hover:shadow-xl"
          >
            <span class="relative z-10 flex items-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
              </svg>
              На главную страницу
            </span>
          </button>

          <button
              @click="requestAccess"
              class="group relative overflow-hidden bg-white text-gray-700 font-semibold py-4 px-8 rounded-xl border border-gray-300 shadow-sm hover:shadow-md transition-all duration-300 transform hover:scale-105"
          >
            <span class="relative z-10 flex items-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              Запросить доступ
            </span>
          </button>

          <button
              @click="contactAdmin"
              class="group relative overflow-hidden bg-gradient-to-r from-gray-700 to-gray-900 hover:from-gray-800 hover:to-black text-white font-semibold py-4 px-8 rounded-xl shadow-lg transition-all duration-300 transform hover:scale-105 hover:shadow-xl"
          >
            <span class="relative z-10 flex items-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
              Связаться с администратором
            </span>
          </button>
        </div>

        <!-- Альтернативные пути -->
        <div class="mt-8 pt-6 border-t border-gray-200">
          <h3 class="text-lg font-semibold text-gray-700 mb-4">Альтернативные действия:</h3>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-w-lg mx-auto">
            <button
                @click="goToDashboard"
                class="p-3 text-left bg-blue-50 hover:bg-blue-100 rounded-lg border border-blue-200 transition-colors group"
            >
              <div class="flex items-center">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-200 transition-colors">
                  <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                  </svg>
                </div>
                <div>
                  <div class="font-medium text-blue-800">Перейти в панель управления</div>
                  <div class="text-xs text-blue-600">Доступные вам функции</div>
                </div>
              </div>
            </button>

            <button
                @click="viewDocumentation"
                class="p-3 text-left bg-green-50 hover:bg-green-100 rounded-lg border border-green-200 transition-colors group"
            >
              <div class="flex items-center">
                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-green-200 transition-colors">
                  <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                  </svg>
                </div>
                <div>
                  <div class="font-medium text-green-800">Документация по доступу</div>
                  <div class="text-xs text-green-600">Узнайте о требованиях к ролям</div>
                </div>
              </div>
            </button>
          </div>
        </div>

        <!-- Декор -->
        <div class="absolute -bottom-10 -left-10 w-20 h-20 bg-red-200 rounded-full opacity-20 animate-pulse"></div>
        <div class="absolute -top-10 -right-10 w-16 h-16 bg-pink-200 rounded-full opacity-30 animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/3 -left-8 w-10 h-10 bg-purple-200 rounded-full opacity-25 animate-pulse" style="animation-delay: 0.5s;"></div>
        <div class="absolute bottom-1/4 -right-6 w-12 h-12 bg-orange-200 rounded-full opacity-20 animate-pulse" style="animation-delay: 0.8s;"></div>
      </div>

      <!-- Статистика -->
      <div class="mt-8 text-center">
        <p class="text-sm text-gray-500">
          Попытка доступа зафиксирована в логах системы.
          <button @click="viewLogs" class="text-red-600 hover:text-red-700 underline">Подробнее о политике доступа</button>
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'

// Методы навигации
const goHome = () => {
  window.location.href = '/'
}

const requestAccess = () => {
  // Запрос дополнительных прав доступа
  const requestData = {
    userId: 'current-user-id', // В реальном приложении это будет динамически
    requestedResource: window.location.pathname,
    timestamp: new Date().toISOString()
  }
  console.log('Access request:', requestData)
  alert('Запрос на получение доступа отправлен администратору. Вы получите уведомление по почте.')
}

const contactAdmin = () => {
  window.location.href = 'mailto:admin@example.com?subject=Запрос%20доступа%20к%20ресурсу&body=Здравствуйте,%20я%20хотел%20бы%20получить%20доступ%20к%20ресурсу:%20' + window.location.href
}

const goToDashboard = () => {
  window.location.href = '/dashboard'
}

const viewDocumentation = () => {
  window.location.href = '/docs/access-policy'
}

const viewLogs = () => {
  window.location.href = '/security/logs'
}

// Сбор информации о попытке доступа
const reportForbiddenAttempt = () => {
  const accessInfo = {
    url: window.location.href,
    userAgent: navigator.userAgent,
    timestamp: new Date().toISOString(),
    errorCode: 403,
    errorType: 'Forbidden',
    userRole: 'User', // В реальном приложении это будет из контекста авторизации
    requiredRole: 'Admin'
  }
  console.log('Forbidden access attempt:', accessInfo)
  // Здесь можно отправить информацию на сервер для логирования
}

// При загрузке компонента собираем информацию о попытке доступа
onMounted(() => {
  reportForbiddenAttempt()

  // Анимация для иконки запрета
  const icon = document.querySelector('.w-16.h-16')
  if (icon) {
    setInterval(() => {
      icon.style.transform = 'rotate(5deg)'
      setTimeout(() => {
        icon.style.transform = 'rotate(-5deg)'
        setTimeout(() => {
          icon.style.transform = 'rotate(0deg)'
        }, 200)
      }, 200)
    }, 5000)
  }
})
</script>

<style scoped>
/* Дополнительные анимации */
@keyframes float {
  0%, 100% { transform: translateY(0px); }
  50% { transform: translateY(-10px); }
}

@keyframes shake {
  0%, 100% { transform: translateX(0); }
  10%, 30%, 50%, 70%, 90% { transform: translateX(-2px); }
  20%, 40%, 60%, 80% { transform: translateX(2px); }
}

.animate-float {
  animation: float 3s ease-in-out infinite;
}

.animate-shake {
  animation: shake 0.5s ease-in-out;
}

/* Стили для запрещающей иконки */
svg {
  transition: transform 0.3s ease;
}

/* Градиентный фон для кнопок */
button {
  position: relative;
  overflow: hidden;
}

button::after {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
  transition: left 0.7s;
}

button:hover::after {
  left: 100%;
}

/* Специальный эффект для главной кнопки */
button.bg-gradient-to-r.from-red-500::before {
  content: '';
  position: absolute;
  top: -2px;
  left: -2px;
  right: -2px;
  bottom: -2px;
  background: linear-gradient(45deg, #ef4444, #ec4899, #ef4444);
  border-radius: 14px;
  z-index: -1;
  opacity: 0;
  transition: opacity 0.3s;
}

button.bg-gradient-to-r.from-red-500:hover::before {
  opacity: 1;
}
</style>