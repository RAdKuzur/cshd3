<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 flex items-center justify-center p-6">
    <div class="max-w-2xl mx-auto">

      <!-- Основной контент -->
      <div class="bg-white rounded-3xl shadow-2xl border border-gray-200 p-12 text-center relative overflow-hidden">

        <!-- Анимированная иконка -->
        <div class="mb-8">
          <div class="relative inline-block">
            <div class="w-32 h-32 bg-gradient-to-br from-blue-100 to-purple-100 rounded-full flex items-center justify-center mx-auto mb-4 animate-pulse">
              <svg class="w-16 h-16 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.282 16.5c-.77.833.192 2.5 1.732 2.5z" />
              </svg>
            </div>

            <!-- Анимированные элементы -->
            <div class="absolute -top-2 -right-2 w-8 h-8 bg-blue-500 rounded-full animate-bounce"></div>
            <div class="absolute -bottom-2 -left-2 w-6 h-6 bg-purple-500 rounded-full animate-bounce" style="animation-delay: 0.2s;"></div>
            <div class="absolute top-4 -right-4 w-4 h-4 bg-yellow-500 rounded-full animate-bounce" style="animation-delay: 0.4s;"></div>

            <!-- Круги с ошибками -->
            <div class="absolute top-0 left-1/4 w-3 h-3 bg-red-400 rounded-full animate-ping"></div>
            <div class="absolute bottom-4 right-1/4 w-2 h-2 bg-orange-400 rounded-full animate-ping" style="animation-delay: 0.3s;"></div>
          </div>
        </div>

        <!-- Код ошибки с анимацией -->
        <div class="mb-6 relative">
          <div class="relative inline-block">
            <span class="text-8xl font-bold bg-gradient-to-r from-blue-700 to-purple-700 bg-clip-text text-transparent animate-shake">
              500
            </span>
            <div class="absolute -top-2 -right-4">
              <span class="text-sm font-bold text-red-500 bg-red-100 px-2 py-1 rounded-full animate-pulse">
                ОШИБКА
              </span>
            </div>
          </div>
        </div>

        <!-- Заголовок -->
        <h1 class="text-4xl font-bold text-gray-900 mb-4">
          Что-то пошло не так
        </h1>

        <!-- Описание -->
        <p class="text-xl text-gray-600 mb-8 leading-relaxed">
          Произошла внутренняя ошибка сервера. Обратитесь к администратору.
        </p>

        <!-- Карточка с деталями ошибки -->
        <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl p-6 mb-8 border border-blue-200">
          <div class="flex items-center justify-center space-x-2 text-blue-700 mb-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="font-semibold">Техническая информация</span>
          </div>

          <div class="text-gray-700 text-sm space-y-2 text-left max-w-md mx-auto">
            <div class="flex items-start bg-white p-3 rounded-lg">
              <svg class="w-4 h-4 mt-0.5 mr-2 flex-shrink-0 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <div>
                <span class="font-medium">Статус:</span>
                <span class="ml-2 text-red-600 font-semibold">500 Internal Server Error</span>
              </div>
            </div>
          </div>
        </div>
        <!-- Кнопки действий -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8">
          <button
              @click="goHome"
              class="group relative overflow-hidden bg-white text-gray-700 font-semibold py-4 px-8 rounded-xl border border-gray-300 shadow-sm hover:shadow-md transition-all duration-300 transform hover:scale-105"
          >
            <span class="relative z-10 flex items-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
              </svg>
              На главную страницу
            </span>
          </button>
        </div>

        <!-- Что можно сделать -->
        <div class="mt-8 pt-6 border-t border-gray-200">
          <h3 class="text-lg font-semibold text-gray-700 mb-4">Что вы можете сделать:</h3>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-w-lg mx-auto">
            <div class="p-3 text-left bg-green-50 rounded-lg border border-green-200">
              <div class="flex items-center">
                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                  <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                  </svg>
                </div>
                <div>
                  <div class="font-medium text-green-800">Очистить кэш браузера</div>
                  <div class="text-xs text-green-600">CTRL + SHIFT + R для перезагрузки</div>
                </div>
              </div>
            </div>

            <div class="p-3 text-left bg-yellow-50 rounded-lg border border-yellow-200">
              <div class="flex items-center">
                <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                  <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
                <div>
                  <div class="font-medium text-yellow-800">Подождать несколько минут</div>
                  <div class="text-xs text-yellow-600">Проблема может решиться сама</div>
                </div>
              </div>
            </div>

            <div class="p-3 text-left bg-red-50 rounded-lg border border-red-200">
              <div class="flex items-center">
                <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                  <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
                <div>
                  <div class="font-medium text-red-800">Проверить подключение</div>
                  <div class="text-xs text-red-600">Убедитесь в стабильности интернета</div>
                </div>
              </div>
            </div>

            <div class="p-3 text-left bg-blue-50 rounded-lg border border-blue-200">
              <div class="flex items-center">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                  <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
                <div>
                  <div class="font-medium text-blue-800">Сообщить о проблеме</div>
                  <div class="text-xs text-blue-600">Наша команда уже работает</div>
                </div>
              </div>
            </div>
          </div>
        </div>


        <!-- Декор -->
        <div class="absolute -bottom-10 -left-10 w-20 h-20 bg-blue-200 rounded-full opacity-20 animate-pulse"></div>
        <div class="absolute -top-10 -right-10 w-16 h-16 bg-purple-200 rounded-full opacity-30 animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/3 -left-8 w-10 h-10 bg-red-200 rounded-full opacity-25 animate-pulse" style="animation-delay: 0.5s;"></div>
        <div class="absolute bottom-1/4 -right-6 w-12 h-12 bg-green-200 rounded-full opacity-20 animate-pulse" style="animation-delay: 0.8s;"></div>

        <!-- Анимированные элементы ошибки -->
        <div class="absolute top-20 left-10 animate-float">
          <div class="w-4 h-4 bg-red-400 rounded-full opacity-70"></div>
        </div>
        <div class="absolute bottom-20 right-12 animate-float" style="animation-delay: 0.5s;">
          <div class="w-3 h-3 bg-yellow-400 rounded-full opacity-70"></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

// Генерация случайного ID для запроса
const generateId = () => {
  return Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15)
}

const currentTime = ref('')
const requestId = ref(generateId())
const sessionId = ref(generateId().substring(0, 10))
const recoveryProgress = ref(0)
const countdown = ref(30)
let countdownInterval = null
let progressInterval = null

// Обновление времени
const updateTime = () => {
  const now = new Date()
  currentTime.value = now.toLocaleTimeString('ru-RU', {
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit'
  }) + '.' + now.getMilliseconds().toString().padStart(3, '0')
}

// Симуляция прогресса восстановления
const simulateRecovery = () => {
  progressInterval = setInterval(() => {
    if (recoveryProgress.value < 95) {
      recoveryProgress.value += Math.random() * 10
      if (recoveryProgress.value > 95) recoveryProgress.value = 95
    }
  }, 1000)
}

// Обратный отсчет до автоматической перезагрузки
const startCountdown = () => {
  countdownInterval = setInterval(() => {
    if (countdown.value > 0) {
      countdown.value--
    } else {
      clearInterval(countdownInterval)
      reloadPage()
    }
  }, 1000)
}

// Методы действий
const reloadPage = () => {
  window.location.reload()
}

const goHome = () => {
  window.location.href = '/'
}

const contactSupport = () => {
  const subject = encodeURIComponent(`Сообщение об ошибке 500 - ${requestId.value}`)
  const body = encodeURIComponent(`Сообщение об ошибке\n\nID запроса: ${requestId.value}\nВремя: ${currentTime.value}\nСтраница: ${window.location.href}\n\nОписание проблемы:\n`)
  window.location.href = `mailto:support@example.com?subject=${subject}&body=${body}`
}

const reportError = () => {
  const errorReport = {
    errorId: requestId.value,
    url: window.location.href,
    userAgent: navigator.userAgent,
    timestamp: new Date().toISOString(),
    screenResolution: `${window.screen.width}x${window.screen.height}`,
    cookiesEnabled: navigator.cookieEnabled,
    language: navigator.language
  }

  console.log('Отчет об ошибке:', errorReport)
  alert('Дополнительная информация об ошибке отправлена. Спасибо!')

  // Здесь можно отправить данные на сервер
  // fetch('/api/error-report', {
  //   method: 'POST',
  //   headers: { 'Content-Type': 'application/json' },
  //   body: JSON.stringify(errorReport)
  // })
}

// Логирование ошибки при загрузке
const logServerError = () => {
  const errorInfo = {
    errorCode: 500,
    errorType: 'Internal Server Error',
    requestId: requestId.value,
    sessionId: sessionId.value,
    url: window.location.href,
    timestamp: new Date().toISOString(),
    userAgent: navigator.userAgent
  }

  console.error('Server Error Detected:', errorInfo)

  // В реальном приложении здесь была бы отправка на сервер
  // sendErrorToAnalytics(errorInfo)
}

// Инициализация
onMounted(() => {
  updateTime()
  setInterval(updateTime, 100)

  simulateRecovery()
  startCountdown()
  logServerError()

  // Анимация для иконки ошибки
  const icon = document.querySelector('.w-16.h-16')
  if (icon) {
    setInterval(() => {
      icon.classList.add('animate-shake')
      setTimeout(() => {
        icon.classList.remove('animate-shake')
      }, 500)
    }, 5000)
  }
})

// Очистка интервалов при размонтировании
onUnmounted(() => {
  if (countdownInterval) clearInterval(countdownInterval)
  if (progressInterval) clearInterval(progressInterval)
})
</script>

<style scoped>
/* Дополнительные анимации */
@keyframes float {
  0%, 100% { transform: translateY(0px) rotate(0deg); }
  50% { transform: translateY(-10px) rotate(5deg); }
}

@keyframes shake {
  0%, 100% { transform: translateX(0) rotate(0deg); }
  10%, 30%, 50%, 70%, 90% { transform: translateX(-2px) rotate(-1deg); }
  20%, 40%, 60%, 80% { transform: translateX(2px) rotate(1deg); }
}

@keyframes pulse-glow {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.7; box-shadow: 0 0 10px rgba(59, 130, 246, 0.5); }
}

.animate-float {
  animation: float 3s ease-in-out infinite;
}

.animate-shake {
  animation: shake 0.5s ease-in-out;
}

.animate-glow {
  animation: pulse-glow 2s ease-in-out infinite;
}

/* Стили для иконки ошибки */
svg {
  transition: all 0.3s ease;
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
button.bg-gradient-to-r.from-blue-500::before {
  content: '';
  position: absolute;
  top: -2px;
  left: -2px;
  right: -2px;
  bottom: -2px;
  background: linear-gradient(45deg, #3b82f6, #8b5cf6, #3b82f6);
  border-radius: 14px;
  z-index: -1;
  opacity: 0;
  transition: opacity 0.3s;
}

button.bg-gradient-to-r.from-blue-500:hover::before {
  opacity: 1;
}

/* Анимация для прогресс-бара */
.progress-bar {
  transition: width 0.5s ease-in-out;
}

/* Адаптивность */
@media (max-width: 640px) {
  .text-8xl {
    font-size: 4rem;
  }

  .text-4xl {
    font-size: 2rem;
  }

  .p-12 {
    padding: 1.5rem;
  }
}
</style>