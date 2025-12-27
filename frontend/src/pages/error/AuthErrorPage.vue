<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 flex items-center justify-center p-6">
    <div class="max-w-2xl mx-auto">

      <!-- Основной контент -->
      <div class="bg-white rounded-3xl shadow-2xl border border-gray-200 p-12 text-center relative overflow-hidden">

        <!-- Анимированная иконка -->
        <div class="mb-8">
          <div class="relative inline-block">
            <div class="w-32 h-32 bg-gradient-to-br from-yellow-100 to-orange-100 rounded-full flex items-center justify-center mx-auto mb-4 animate-pulse">
              <svg class="w-16 h-16 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
              </svg>
            </div>

            <!-- Анимированные круги -->
            <div class="absolute -top-2 -right-2 w-8 h-8 bg-red-400 rounded-full animate-bounce"></div>
            <div class="absolute -bottom-2 -left-2 w-6 h-6 bg-blue-400 rounded-full animate-bounce" style="animation-delay: 0.2s;"></div>
          </div>
        </div>

        <!-- Код ошибки -->
        <div class="mb-6">
          <span class="text-8xl font-bold bg-gradient-to-r from-yellow-600 to-orange-600 bg-clip-text text-transparent">
            401
          </span>
        </div>

        <!-- Заголовок -->
        <h1 class="text-4xl font-bold text-gray-900 mb-4">
          Требуется авторизация
        </h1>

        <!-- Описание -->
        <p class="text-xl text-gray-600 mb-8 leading-relaxed">
          У вас нет необходимых прав для доступа к этой странице.
          Пожалуйста, войдите в систему или проверьте свои учетные данные.
        </p>

        <!-- Сообщение о доступе -->
        <div class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-xl p-6 mb-8 border border-yellow-200">
          <div class="flex items-center justify-center space-x-2 text-yellow-700 mb-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
            <span class="font-semibold">Информация о доступе</span>
          </div>
          <ul class="text-yellow-600 text-sm space-y-1 text-left max-w-md mx-auto">
            <li class="flex items-start">
              <span class="mr-2">•</span>
              <span>Для доступа к этой странице требуется действительная авторизация</span>
            </li>
            <li class="flex items-start">
              <span class="mr-2">•</span>
              <span>Возможно, ваш сеанс истек или вы вышли из системы</span>
            </li>
            <li class="flex items-start">
              <span class="mr-2">•</span>
              <span>Проверьте правильность введенных учетных данных</span>
            </li>
          </ul>
        </div>

        <!-- Кнопки действий -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
          <button
              @click="goToLogin"
              class="group relative overflow-hidden bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white font-semibold py-4 px-8 rounded-xl shadow-lg transition-all duration-300 transform hover:scale-105 hover:shadow-xl"
          >
            <span class="relative z-10 flex items-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
              </svg>
              Войти в систему
            </span>
          </button>

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

        <!-- Альтернативные варианты -->
        <div class="mt-8">
          <div class="text-sm text-gray-500 mb-4">Или воспользуйтесь другими способами:</div>
          <div class="flex flex-wrap justify-center gap-3">
            <button
                @click="goToRegistration"
                class="px-4 py-2 text-sm bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg border border-blue-200 transition-colors"
            >
              Регистрация
            </button>
            <button
                @click="recoverPassword"
                class="px-4 py-2 text-sm bg-green-50 hover:bg-green-100 text-green-700 rounded-lg border border-green-200 transition-colors"
            >
              Восстановить пароль
            </button>
            <button
                @click="contactSupport"
                class="px-4 py-2 text-sm bg-purple-50 hover:bg-purple-100 text-purple-700 rounded-lg border border-purple-200 transition-colors"
            >
              Поддержка
            </button>
          </div>
        </div>

        <!-- Индикатор безопасности -->
        <div class="mt-8 pt-6 border-t border-gray-200">
          <div class="flex items-center justify-center text-sm text-gray-500">
            <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
            <span>Эта страница защищена системой авторизации</span>
          </div>
        </div>

        <!-- Декор -->
        <div class="absolute -bottom-10 -left-10 w-20 h-20 bg-yellow-200 rounded-full opacity-20 animate-pulse"></div>
        <div class="absolute -top-10 -right-10 w-16 h-16 bg-orange-200 rounded-full opacity-30 animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 -left-8 w-12 h-12 bg-red-200 rounded-full opacity-20 animate-pulse" style="animation-delay: 0.5s;"></div>
      </div>

      <!-- Статистика -->
      <div class="mt-8 text-center">
        <p class="text-sm text-gray-500">
          Если вы считаете, что это ошибка, пожалуйста,
          <button @click="contactSupport" class="text-orange-600 hover:text-orange-700 underline">сообщите нам</button>
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'

// Методы навигации
const goToLogin = () => {
  // В реальном приложении здесь был бы переход на страницу входа
  window.location.href = '/login'
}

const goHome = () => {
  window.location.href = '/'
}

const goToRegistration = () => {
  window.location.href = '/register'
}

const recoverPassword = () => {
  window.location.href = '/password-recovery'
}

const contactSupport = () => {
  window.location.href = '/contact'
}

// Сбор информации о попытке доступа
const reportAccessAttempt = () => {
  const accessInfo = {
    url: window.location.href,
    userAgent: navigator.userAgent,
    timestamp: new Date().toISOString(),
    errorCode: 401,
    errorType: 'Unauthorized'
  }
  console.log('Access attempt report:', accessInfo)
  // Здесь можно отправить информацию на сервер
}

// При загрузке компонента собираем информацию о попытке доступа
onMounted(() => {
  reportAccessAttempt()
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

/* Анимация для иконки замка */
@keyframes lockShake {
  0%, 100% { transform: translateX(0); }
  25% { transform: translateX(-2px); }
  75% { transform: translateX(2px); }
}

svg {
  animation: lockShake 5s ease-in-out infinite;
}
</style>