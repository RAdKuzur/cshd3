<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-orange-50 flex items-center justify-center p-6">
    <div class="max-w-2xl mx-auto">

      <!-- Основной контент -->
      <div class="bg-white rounded-3xl shadow-2xl border border-gray-200 p-12 text-center relative overflow-hidden">

        <!-- Анимированная иконка -->
        <div class="mb-8">
          <div class="relative inline-block">
            <div class="w-32 h-32 bg-gradient-to-br from-orange-100 to-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4 animate-pulse">
              <svg class="w-16 h-16 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>

            <!-- Анимированные круги -->
            <div class="absolute -top-2 -right-2 w-8 h-8 bg-orange-500 rounded-full animate-bounce"></div>
            <div class="absolute -bottom-2 -left-2 w-6 h-6 bg-yellow-500 rounded-full animate-bounce" style="animation-delay: 0.2s;"></div>
            <div class="absolute top-4 -right-4 w-4 h-4 bg-amber-500 rounded-full animate-bounce" style="animation-delay: 0.4s;"></div>
          </div>
        </div>

        <!-- Код ошибки -->
        <div class="mb-6">
          <span class="text-8xl font-bold bg-gradient-to-r from-orange-700 to-amber-700 bg-clip-text text-transparent">
            400
          </span>
        </div>

        <!-- Заголовок -->
        <h1 class="text-4xl font-bold text-gray-900 mb-4">
          Неверный запрос
        </h1>

        <!-- Описание -->
        <p class="text-xl text-gray-600 mb-8 leading-relaxed">
          Сервер не может обработать ваш запрос из-за синтаксической ошибки.
          Пожалуйста, проверьте введенные данные и попробуйте снова.
        </p>

        <!-- Сообщение о возможных причинах -->
        <div class="bg-gradient-to-r from-orange-50 to-amber-50 rounded-xl p-6 mb-8 border border-orange-200">
          <div class="flex items-center justify-center space-x-2 text-orange-700 mb-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="font-semibold">Возможные причины</span>
          </div>
          <div class="text-orange-600 text-sm space-y-2 text-left max-w-md mx-auto">
            <div class="flex items-start">
              <svg class="w-4 h-4 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span>Некорректный формат отправленных данных</span>
            </div>
            <div class="flex items-start">
              <svg class="w-4 h-4 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
              </svg>
              <span>Поврежденные или некорректные параметры запроса</span>
            </div>
            <div class="flex items-start">
              <svg class="w-4 h-4 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
              </svg>
              <span>Файл cookie поврежден или устарел</span>
            </div>
          </div>
        </div>

        <!-- Информация о запросе -->
<!--        <div class="mb-8 bg-gray-50 rounded-lg p-4 border border-gray-200">-->
<!--          <div class="flex items-center justify-between text-sm text-gray-600 mb-2">-->
<!--            <span class="font-medium">Детали запроса:</span>-->
<!--            <button @click="copyRequestDetails" class="text-orange-600 hover:text-orange-700 flex items-center">-->
<!--              <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">-->
<!--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />-->
<!--              </svg>-->
<!--              Копировать-->
<!--            </button>-->
<!--          </div>-->
<!--          <div class="bg-white rounded p-3 text-xs font-mono text-left overflow-x-auto">-->
<!--            <div><span class="text-gray-500">URL:</span> <span class="text-gray-900">{{ currentUrl }}</span></div>-->
<!--            <div><span class="text-gray-500">Метод:</span> <span class="text-gray-900">{{ requestMethod }}</span></div>-->
<!--            <div><span class="text-gray-500">Время:</span> <span class="text-gray-900">{{ currentTime }}</span></div>-->
<!--          </div>-->
<!--        </div>-->

        <!-- Кнопки действий -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8">
          <button
              @click="goBack"
              class="group relative overflow-hidden bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 text-white font-semibold py-4 px-8 rounded-xl shadow-lg transition-all duration-300 transform hover:scale-105 hover:shadow-xl"
          >
            <span class="relative z-10 flex items-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
              </svg>
              Вернуться назад
            </span>
          </button>

<!--          <button-->
<!--              @click="reloadPage"-->
<!--              class="group relative overflow-hidden bg-white hover:bg-gray-50 text-gray-700 font-semibold py-4 px-8 rounded-xl shadow-lg transition-all duration-300 transform hover:scale-105 border-2 border-orange-200 hover:border-orange-300"-->
<!--          >-->
<!--            <span class="relative z-10 flex items-center">-->
<!--              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">-->
<!--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />-->
<!--              </svg>-->
<!--              Обновить страницу-->
<!--            </span>-->
<!--          </button>-->
        </div>

        <!-- Дополнительные действия -->
<!--        <div class="flex justify-center space-x-4 text-sm">-->
<!--          <button @click="clearCookies" class="text-gray-500 hover:text-orange-600 transition-colors flex items-center">-->
<!--            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">-->
<!--              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />-->
<!--            </svg>-->
<!--            Очистить куки-->
<!--          </button>-->
<!--          <button @click="contactSupport" class="text-gray-500 hover:text-orange-600 transition-colors flex items-center">-->
<!--            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">-->
<!--              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 0l3.536 3.536M9.172 9.172L5.636 5.636m3.536 3.536l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />-->
<!--            </svg>-->
<!--            Связаться с поддержкой-->
<!--          </button>-->
<!--        </div>-->

        <!-- Декор -->
        <div class="absolute -bottom-10 -left-10 w-20 h-20 bg-orange-200 rounded-full opacity-20 animate-pulse"></div>
        <div class="absolute -top-10 -right-10 w-16 h-16 bg-amber-200 rounded-full opacity-30 animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/3 -left-8 w-10 h-10 bg-yellow-200 rounded-full opacity-25 animate-pulse" style="animation-delay: 0.5s;"></div>
        <div class="absolute bottom-1/4 -right-6 w-12 h-12 bg-orange-200 rounded-full opacity-20 animate-pulse" style="animation-delay: 0.8s;"></div>
      </div>

      <!-- Подсказка -->
<!--      <div class="mt-8 text-center">-->
<!--        <p class="text-sm text-gray-500">-->
<!--          Ошибка 400: Bad Request.-->
<!--          <button @click="viewDocumentation" class="text-orange-600 hover:text-orange-700 underline">Подробнее об ошибке</button>-->
<!--        </p>-->
<!--      </div>-->
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

// Реактивные данные
const currentUrl = ref('')
const requestMethod = ref('GET')
const currentTime = ref('')

// Методы навигации
const goBack = () => {
  window.history.back()
}

const reloadPage = () => {
  window.location.reload()
}

const clearCookies = () => {
  // Очистка куков (упрощенная версия)
  document.cookie.split(";").forEach((c) => {
    document.cookie = c
        .replace(/^ +/, "")
        .replace(/=.*/, "=;expires=" + new Date().toUTCString() + ";path=/");
  });
  alert('Куки очищены. Попробуйте обновить страницу.')
}

const contactSupport = () => {
  window.location.href = 'mailto:support@example.com?subject=Ошибка%20400%20Bad%20Request&body=Подробное%20описание%20проблемы:%0A%0AURL:%20' + window.location.href
}

const viewDocumentation = () => {
  window.location.href = '/docs/errors/400'
}

const copyRequestDetails = () => {
  const details = `URL: ${currentUrl.value}\nМетод: ${requestMethod.value}\nВремя: ${currentTime.value}`
  navigator.clipboard.writeText(details)
  alert('Детали запроса скопированы в буфер обмена')
}

// Сбор информации об ошибке
const reportBadRequest = () => {
  const errorInfo = {
    url: window.location.href,
    userAgent: navigator.userAgent,
    timestamp: new Date().toISOString(),
    errorCode: 400,
    errorType: 'Bad Request',
    referrer: document.referrer || 'direct'
  }

  // Здесь можно отправить информацию на сервер
  console.log('400 Error reported:', errorInfo)
}

// При загрузке компонента
onMounted(() => {
  currentUrl.value = window.location.href
  requestMethod.value = 'GET' // В реальном приложении нужно получать из контекста запроса
  currentTime.value = new Date().toLocaleString()

  reportBadRequest()
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

/* Стили для иконки */
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
button.bg-gradient-to-r.from-orange-500::before {
  content: '';
  position: absolute;
  top: -2px;
  left: -2px;
  right: -2px;
  bottom: -2px;
  background: linear-gradient(45deg, #f97316, #f59e0b, #f97316);
  border-radius: 14px;
  z-index: -1;
  opacity: 0;
  transition: opacity 0.3s;
}

button.bg-gradient-to-r.from-orange-500:hover::before {
  opacity: 1;
}
</style>