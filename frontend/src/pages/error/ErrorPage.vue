<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 flex items-center justify-center p-6">
    <div class="max-w-2xl mx-auto">

      <!-- Основной контент -->
      <div class="bg-white rounded-3xl shadow-2xl border border-gray-200 p-12 text-center">

        <!-- Анимированная иконка -->
        <div class="mb-8">
          <div class="relative inline-block">
            <div class="w-32 h-32 bg-gradient-to-br from-red-100 to-pink-100 rounded-full flex items-center justify-center mx-auto mb-4 animate-pulse">
              <svg class="w-16 h-16 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
              </svg>
            </div>

            <!-- Анимированные круги -->
            <div class="absolute -top-2 -right-2 w-8 h-8 bg-yellow-400 rounded-full animate-bounce"></div>
            <div class="absolute -bottom-2 -left-2 w-6 h-6 bg-green-400 rounded-full animate-bounce" style="animation-delay: 0.2s;"></div>
          </div>
        </div>

        <!-- Код ошибки -->
        <div class="mb-6">
          <span class="text-8xl font-bold bg-gradient-to-r from-red-600 to-pink-600 bg-clip-text text-transparent">
            404
          </span>
        </div>

        <!-- Заголовок -->
        <h1 class="text-4xl font-bold text-gray-900 mb-4">
          Страница не найдена
        </h1>

        <!-- Описание -->
        <p class="text-xl text-gray-600 mb-8 leading-relaxed">
          К сожалению, мы не смогли найти страницу, которую вы ищете.
          Возможно, она была перемещена или удалена.
        </p>

        <!-- Дополнительная информация -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 mb-8 border border-blue-200">
          <div class="flex items-center justify-center space-x-2 text-blue-700 mb-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="font-semibold">Что можно сделать?</span>
          </div>
          <ul class="text-blue-600 text-sm space-y-1">
            <li>• Проверьте правильность введенного URL адреса</li>
            <li>• Вернитесь на предыдущую страницу</li>
            <li>• Перейдите на главную страницу</li>
            <li>• Свяжитесь со службой поддержки</li>
          </ul>
        </div>

        <!-- Кнопки действий -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
          <button
              @click="goHome"
              class="group relative overflow-hidden bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-semibold py-4 px-8 rounded-xl shadow-lg transition-all duration-300 transform hover:scale-105 hover:shadow-xl"
          >
            <span class="relative z-10 flex items-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
              </svg>
              На главную страницу
            </span>
          </button>

          <button
              @click="goBack"
              class="group relative overflow-hidden bg-white text-gray-700 font-semibold py-4 px-8 rounded-xl border border-gray-300 shadow-sm hover:shadow-md transition-all duration-300 transform hover:scale-105"
          >
            <span class="relative z-10 flex items-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
              </svg>
              Вернуться назад
            </span>
          </button>
        </div>

        <!-- Ссылка на поддержку -->
        <div class="mt-8 pt-6 border-t border-gray-200">
          <button
              @click="contactSupport"
              class="text-indigo-600 hover:text-indigo-700 font-medium transition-colors duration-200 flex items-center justify-center mx-auto group"
          >
            <span class="flex items-center">
              Связаться со службой поддержки
              <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
              </svg>
            </span>
          </button>
        </div>

        <!-- Декор -->
        <div class="absolute -bottom-10 -left-10 w-20 h-20 bg-yellow-200 rounded-full opacity-20 animate-pulse"></div>
        <div class="absolute -top-10 -right-10 w-16 h-16 bg-blue-200 rounded-full opacity-30 animate-pulse" style="animation-delay: 1s;"></div>
      </div>

      <!-- Статистика -->
      <div class="mt-8 text-center">
        <p class="text-sm text-gray-500">
          Если проблема повторяется, пожалуйста,
          <button @click="contactSupport" class="text-indigo-600 hover:text-indigo-700 underline">сообщите нам</button>
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

const goBack = () => {
  window.history.back()
}

const contactSupport = () => {
  window.location.href = '/contact'
}

// Можно добавить логику для сбора информации об ошибке
const reportError = () => {
  const errorInfo = {
    url: window.location.href,
    userAgent: navigator.userAgent,
    timestamp: new Date().toISOString()
  }
  console.log('Error report:', errorInfo)
  // Здесь можно отправить информацию на сервер
}

// При загрузке компонента можно собрать информацию об ошибке
onMounted(() => {
  reportError()
})
</script>

<style scoped>
/* Дополнительные анимации */
@keyframes float {
  0%, 100% { transform: translateY(0px); }
  50% { transform: translateY(-10px); }
}

.animate-float {
  animation: float 3s ease-in-out infinite;
}

/* Градиентные тени */
.shadow-gradient {
  box-shadow: 0 10px 30px -10px rgba(99, 102, 241, 0.3);
}
</style>