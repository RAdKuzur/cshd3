<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 flex flex-col justify-center items-center p-6">

    <!-- Основной контейнер -->
    <div class="w-full max-w-md">

      <!-- Карточка входа -->
      <div class="bg-white rounded-3xl shadow-2xl border border-gray-200 p-8">

        <!-- Заголовок -->
        <div class="text-center mb-8">
          <!-- Логотип -->
          <div class="flex justify-center mb-6">
            <div class="w-20 h-20 bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl flex items-center justify-center shadow-lg">
              <ScaleIcon class="w-10 h-10 text-white" />
            </div>
          </div>

          <h2 class="text-3xl font-bold text-gray-900 mb-2">
            Добро пожаловать
          </h2>
          <p class="text-gray-600 text-lg">
            Войдите в систему Мособлсуд
          </p>
        </div>

        <!-- Форма входа -->
        <form class="space-y-6" @submit.prevent="handleLogin">

          <!-- Поле email -->
          <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
              <span class="flex items-center">
                <EnvelopeIcon class="w-4 h-4 text-gray-400 mr-2" />
                Адрес электронной почты
              </span>
            </label>
            <div class="relative">
              <input
                  v-model="form.email"
                  type="email"
                  id="email"
                  required
                  class="block w-full px-4 py-3 border border-gray-300 rounded-xl bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                  placeholder="your.email@example.com"
              >
              <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                <CheckCircleIcon
                    v-if="emailValid"
                    class="h-5 w-5 text-green-500"
                />
              </div>
            </div>
          </div>

          <!-- Поле пароля -->
          <div>
            <div class="flex items-center justify-between mb-2">
              <label for="password" class="block text-sm font-semibold text-gray-700">
                <span class="flex items-center">
                  <LockClosedIcon class="w-4 h-4 text-gray-400 mr-2" />
                  Пароль
                </span>
              </label>
              <button
                  type="button"
                  @click="showForgotPassword = true"
                  class="text-sm font-medium text-indigo-600 hover:text-indigo-500 transition-colors"
              >
                Забыли пароль?
              </button>
            </div>
            <div class="relative">
              <input
                  v-model="form.password"
                  :type="showPassword ? 'text' : 'password'"
                  id="password"
                  required
                  class="block w-full px-4 py-3 border border-gray-300 rounded-xl bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                  placeholder="Введите ваш пароль"
              >
              <button
                  type="button"
                  @click="showPassword = !showPassword"
                  class="absolute inset-y-0 right-0 pr-3 flex items-center"
              >
                <EyeIcon v-if="showPassword" class="h-5 w-5 text-gray-400 hover:text-gray-600" />
                <EyeSlashIcon v-else class="h-5 w-5 text-gray-400 hover:text-gray-600" />
              </button>
            </div>
          </div>

          <!-- Запомнить меня -->
          <div class="flex items-center">
            <input
                v-model="form.remember"
                id="remember"
                type="checkbox"
                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
            >
            <label for="remember" class="ml-2 block text-sm text-gray-700">
              Запомнить меня
            </label>
          </div>

          <!-- Кнопка входа -->
          <div>
            <button
                type="submit"
                :disabled="loading"
                class="group relative w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed"
            >
              <span class="flex items-center">
                <ArrowRightIcon v-if="!loading" class="w-5 h-5 mr-2 transform group-hover:translate-x-1 transition-transform" />
                <ArrowPathIcon v-else class="w-5 h-5 mr-2 animate-spin" />
                {{ loading ? 'Вход...' : 'Войти в систему' }}
              </span>
            </button>
          </div>
        </form>

        <!-- Дополнительная информация -->
        <div class="mt-8 pt-6 border-t border-gray-200">
          <div class="text-center">
            <p class="text-sm text-gray-600">
              Возникли проблемы со входом?
              <button
                  @click="contactSupport"
                  class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors"
              >
                Свяжитесь с поддержкой
              </button>
            </p>
          </div>
        </div>
      </div>

      <!-- Информация о системе -->
      <div class="mt-8 text-center">
        <div class="bg-white/50 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
          <h3 class="text-lg font-semibold text-gray-900 mb-2">
            Московский областной суд
          </h3>
          <p class="text-gray-600 text-sm">
            Единая система управления основными средствами, кадрами и документооборотом
          </p>
          <div class="mt-4 flex justify-center space-x-6 text-xs text-gray-500">
            <span>🔒 Безопасно</span>
            <span>⚡ Быстро</span>
            <span>🎯 Удобно</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Модальное окно восстановления пароля -->
    <div
        v-if="showForgotPassword"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50"
        @click="showForgotPassword = false"
    >
      <div
          class="bg-white rounded-2xl p-6 max-w-md w-full"
          @click.stop
      >
        <h3 class="text-xl font-bold text-gray-900 mb-4">Восстановление пароля</h3>
        <p class="text-gray-600 mb-4">
          Введите ваш email, и мы вышлем инструкции по восстановлению пароля.
        </p>
        <input
            type="email"
            placeholder="your.email@example.com"
            class="w-full px-4 py-3 border border-gray-300 rounded-xl mb-4 focus:outline-none focus:ring-2 focus:ring-indigo-500"
        >
        <div class="flex space-x-3">
          <button
              @click="showForgotPassword = false"
              class="flex-1 px-4 py-3 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 transition-colors"
          >
            Отмена
          </button>
          <button
              class="flex-1 px-4 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition-colors"
          >
            Отправить
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import {
  ScaleIcon,
  EnvelopeIcon,
  LockClosedIcon,
  EyeIcon,
  EyeSlashIcon,
  ArrowRightIcon,
  ArrowPathIcon,
  CheckCircleIcon
} from '@heroicons/vue/24/outline'

// Реактивные данные
const form = ref({
  email: '',
  password: '',
  remember: false
})

const loading = ref(false)
const showPassword = ref(false)
const showForgotPassword = ref(false)

// Валидация email
const emailValid = computed(() => {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
  return form.value.email && emailRegex.test(form.value.email)
})

// Обработка входа
const handleLogin = async () => {
  if (!emailValid.value || !form.value.password) {
    return
  }

  loading.value = true

  try {
    // Имитация запроса на сервер
    await new Promise(resolve => setTimeout(resolve, 1500))
    console.log('Вход выполнен:', form.value)
    // Здесь будет реальная логика входа
  } catch (error) {
    console.error('Ошибка входа:', error)
  } finally {
    loading.value = false
  }
}

// Контакт с поддержкой
const contactSupport = () => {
  window.location.href = 'mailto:support@mosoblsud.ru'
}
</script>

<style scoped>
/* Дополнительные стили для улучшения UX */
input:focus {
  box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

/* Анимация появления модального окна */
.fixed {
  animation: fadeIn 0.3s ease-out;
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}
</style>