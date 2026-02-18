<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 flex items-center justify-center p-4">
    <div class="max-w-md w-full">

      <!-- Основная карточка -->
      <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8 relative overflow-hidden">

        <!-- Декоративные элементы -->
        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-100 to-purple-100 rounded-bl-full opacity-50"></div>
        <div class="absolute bottom-0 left-0 w-24 h-24 bg-gradient-to-tr from-blue-100 to-purple-100 rounded-tr-full opacity-50"></div>

        <!-- Иконка замка -->
        <div class="relative mb-8">
          <div class="w-20 h-20 mx-auto bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl rotate-45 flex items-center justify-center shadow-lg">
            <svg class="w-10 h-10 text-white -rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
          </div>

          <!-- Анимированные точки -->
          <div class="absolute -top-1 -right-1 w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
          <div class="absolute -bottom-1 -left-1 w-2 h-2 bg-blue-400 rounded-full animate-ping"></div>
        </div>

        <!-- Заголовок -->
        <div class="text-center mb-8">
          <h2 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-2">
            Смена пароля
          </h2>
          <p class="text-gray-500 text-sm">
            Введите новый пароль для вашей учетной записи
          </p>
        </div>

        <!-- Форма -->
        <form @submit.prevent="handleSubmit" class="space-y-5">
          <!-- Email поле -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
              <span class="flex items-center">
                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Электронная почта
              </span>
            </label>
            <input
                v-model="form.email"
                type="email"
                placeholder="example@mail.com"
                required
                :disabled="loading"
                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 disabled:bg-gray-50 disabled:text-gray-500"
                :class="{ 'border-red-300 bg-red-50': errors.email }"
            />
            <p v-if="errors.email" class="mt-1 text-xs text-red-500">{{ errors.email }}</p>
          </div>

          <!-- Новый пароль -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
              <span class="flex items-center">
                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                Новый пароль
              </span>
            </label>
            <div class="relative">
              <input
                  :type="showPassword ? 'text' : 'password'"
                  v-model="form.password"
                  placeholder="········"
                  required
                  :disabled="loading"
                  class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 disabled:bg-gray-50"
                  :class="{ 'border-red-300 bg-red-50': errors.password }"
                  @input="validatePassword"
              />
              <button
                  type="button"
                  @click="showPassword = !showPassword"
                  class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
              >
                <svg v-if="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                </svg>
              </button>
            </div>
          </div>

          <!-- Индикатор сложности пароля -->
          <div v-if="form.password" class="space-y-1">
            <div class="flex gap-1 h-1">
              <div class="flex-1 rounded-full transition-all duration-300"
                   :class="passwordStrength >= 1 ? 'bg-red-500' : 'bg-gray-200'"></div>
              <div class="flex-1 rounded-full transition-all duration-300"
                   :class="passwordStrength >= 2 ? 'bg-yellow-500' : 'bg-gray-200'"></div>
              <div class="flex-1 rounded-full transition-all duration-300"
                   :class="passwordStrength >= 3 ? 'bg-green-500' : 'bg-gray-200'"></div>
            </div>
            <p class="text-xs text-gray-500">{{ passwordStrengthText }}</p>
          </div>

          <!-- Подтверждение пароля -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
              <span class="flex items-center">
                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Подтвердите пароль
              </span>
            </label>
            <input
                :type="showConfirmPassword ? 'text' : 'password'"
                v-model="form.confirmPassword"
                placeholder="········"
                required
                :disabled="loading"
                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 disabled:bg-gray-50"
                :class="{
                'border-green-500 bg-green-50': form.confirmPassword && form.password === form.confirmPassword,
                'border-red-300 bg-red-50': form.confirmPassword && form.password !== form.confirmPassword
              }"
            />
            <p v-if="form.confirmPassword && form.password !== form.confirmPassword"
               class="mt-1 text-xs text-red-500">
              Пароли не совпадают
            </p>
          </div>

          <!-- Сообщение об ошибке -->
          <div v-if="errorMessage"
               class="p-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-600 flex items-start">
            <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ errorMessage }}
          </div>

          <!-- Кнопка отправки -->
          <button
              type="submit"
              :disabled="loading || !isFormValid"
              class="w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100 relative overflow-hidden group"
          >
            <span class="relative z-10 flex items-center justify-center">
              <svg v-if="loading" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              {{ loading ? 'Сохранение...' : 'Сохранить новый пароль' }}
            </span>
            <div class="absolute inset-0 bg-gradient-to-r from-blue-700 to-purple-700 opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted, onUnmounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import axios from 'axios'
import {BACKEND_URL} from "@/router.js";

const router = useRouter()
const route = useRoute()

// Извлекаем параметры из URL
const expires = route.query.expires
const signature = route.query.signature

// Состояние формы
const form = reactive({
  email: '',
  password: '',
  confirmPassword: ''
})

const loading = ref(false)
const errorMessage = ref('')
const errors = reactive({
  email: '',
  password: ''
})

const showPassword = ref(false)
const showConfirmPassword = ref(false)
const timeRemaining = ref('')

// Настройка Axios
const api = axios.create({
  baseURL: BACKEND_URL,
  timeout: 10000,
  headers: {
    'Content-Type': 'application/json'
  }
})

// Валидация пароля
const validatePassword = () => {
  const password = form.password

  if (password.length < 8) {
    errors.password = 'Пароль должен содержать минимум 8 символов'
  } else if (!/[A-Z]/.test(password)) {
    errors.password = 'Пароль должен содержать хотя бы одну заглавную букву'
  } else if (!/[0-9]/.test(password)) {
    errors.password = 'Пароль должен содержать хотя бы одну цифру'
  } else {
    errors.password = ''
  }
}

// Сложность пароля
const passwordStrength = computed(() => {
  const pwd = form.password
  if (!pwd) return 0

  let strength = 0
  if (pwd.length >= 8) strength++
  if (/[A-Z]/.test(pwd)) strength++
  if (/[0-9]/.test(pwd)) strength++
  if (/[^A-Za-z0-9]/.test(pwd)) strength++

  return Math.min(strength, 3)
})

const passwordStrengthText = computed(() => {
  const strength = passwordStrength.value
  if (strength === 0) return 'Введите пароль'
  if (strength === 1) return 'Слабый пароль'
  if (strength === 2) return 'Средний пароль'
  return 'Надежный пароль'
})

// Валидация формы
const isFormValid = computed(() => {
  return form.email &&
      form.password &&
      form.confirmPassword &&
      form.password === form.confirmPassword
})

// Таймер обратного отсчета
const updateTimeRemaining = () => {
  if (!expires) {
    timeRemaining.value = 'не ограничен'
    return
  }

  const expiryDate = new Date(expires)
  const now = new Date()
  const diff = expiryDate - now

  if (diff <= 0) {
    timeRemaining.value = 'истек'
    errorMessage.value = 'Срок действия ссылки истек. Запросите новую ссылку для смены пароля.'
  } else {
    const minutes = Math.floor(diff / 60000)
    const seconds = Math.floor((diff % 60000) / 1000)
    timeRemaining.value = `${minutes} мин ${seconds} сек`
  }
}

let timerInterval

// Обработка отправки формы
const handleSubmit = async () => {
  if (!isFormValid.value) return

  loading.value = true
  errorMessage.value = ''

  try {
    const response = await api.post(
        `/api/change-password?expires=${expires}&signature=${signature}`,
        {
          email: form.email,
          password: form.password,
          confirmPassword: form.confirmPassword
        }
    )

    // Успешная смена пароля
    if (response.status === 200) {
      // Показываем уведомление об успехе
      const notification = document.createElement('div')
      notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg z-50 animate-slide-in'
      notification.textContent = 'Пароль успешно изменен!'
      document.body.appendChild(notification)

      setTimeout(() => {
        notification.remove()
        router.push('/login')
      }, 2000)
    }

  } catch (error) {
    if (error.response) {
      // Ошибка от сервера
      switch (error.response.status) {
        case 400:
          errorMessage.value = 'Неверные данные. Проверьте введенную информацию.'
          break
        case 401:
          errorMessage.value = 'Срок действия ссылки истек. Запросите новую ссылку.'
          break
        case 404:
          errorMessage.value = 'Пользователь не найден.'
          break
        case 422:
          errorMessage.value = 'Пароль не соответствует требованиям безопасности.'
          break
        default:
          errorMessage.value = error.response.data.message || 'Произошла ошибка при смене пароля.'
      }
    } else if (error.request) {
      errorMessage.value = 'Нет ответа от сервера. Проверьте подключение к интернету.'
    } else {
      errorMessage.value = 'Произошла ошибка. Пожалуйста, попробуйте снова.'
    }
  } finally {
    loading.value = false
  }
}

// Инициализация
onMounted(() => {
  updateTimeRemaining()
  timerInterval = setInterval(updateTimeRemaining, 1000)

  // Автозаполнение email из URL, если есть
  const emailFromUrl = route.query.email
  if (emailFromUrl) {
    form.email = emailFromUrl
  }
})

onUnmounted(() => {
  if (timerInterval) clearInterval(timerInterval)
})
</script>

<style scoped>
@keyframes slide-in {
  from {
    transform: translateX(100%);
    opacity: 0;
  }
  to {
    transform: translateX(0);
    opacity: 1;
  }
}

.animate-slide-in {
  animation: slide-in 0.3s ease-out;
}

/* Дополнительные стили для улучшения UX */
input:-webkit-autofill,
input:-webkit-autofill:hover,
input:-webkit-autofill:focus {
  -webkit-box-shadow: 0 0 0px 1000px white inset;
  transition: background-color 5000s ease-in-out 0s;
}

/* Кастомный скроллбар */
::-webkit-scrollbar {
  width: 8px;
  height: 8px;
}

::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 10px;
}

::-webkit-scrollbar-thumb {
  background: #c5c5c5;
  border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
  background: #a8a8a8;
}
</style>