<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

      <!-- Заголовок -->
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Настройки</h1>
        <p class="mt-2 text-sm text-gray-600">
          Управление безопасностью вашего аккаунта
        </p>
      </div>

      <!-- Основная карточка -->
      <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">

        <!-- Шапка карточки -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
          <h2 class="text-lg font-medium text-white flex items-center">
            <LockClosedIcon class="w-5 h-5 mr-2" />
            Сброс пароля
          </h2>
        </div>

        <!-- Контент -->
        <div class="p-6">

          <!-- Описание -->
          <div class="mb-6">
            <p class="text-gray-600">
              Введите ваш email, и мы отправим вам ссылку для сброса пароля.
              Ссылка будет действительна в течение 60 минут.
            </p>
          </div>

          <!-- Форма сброса пароля -->
          <div class="space-y-5">
            <!-- Поле email -->
            <div>
              <label for="reset-email" class="block text-sm font-medium text-gray-700 mb-1.5">
                Email для сброса пароля
              </label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <EnvelopeIcon class="h-5 w-5 text-gray-400" />
                </div>
                <input
                    id="reset-email"
                    v-model="forgotPasswordEmail"
                    type="email"
                    placeholder="your@email.com"
                    class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 sm:text-sm"
                    :class="{ 'border-red-300 bg-red-50 ring-1 ring-red-300': emailError }"
                    :disabled="isLoading"
                />
              </div>
              <p v-if="emailError" class="mt-1.5 text-xs text-red-600 flex items-center">
                <ExclamationTriangleIcon class="w-3.5 h-3.5 mr-1" />
                {{ emailError }}
              </p>
            </div>

            <!-- Сообщение об успехе/ошибке -->
            <transition
                enter-active-class="transition ease-out duration-300"
                enter-from-class="opacity-0 transform -translate-y-2"
                enter-to-class="opacity-100 transform translate-y-0"
                leave-active-class="transition ease-in duration-200"
                leave-from-class="opacity-100 transform translate-y-0"
                leave-to-class="opacity-0 transform -translate-y-2"
            >
              <div v-if="message"
                   class="p-4 rounded-xl text-sm flex items-start"
                   :class="messageType === 'success' ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-red-50 text-red-700 border border-red-200'"
              >
                <CheckCircleIcon v-if="messageType === 'success'" class="w-5 h-5 mr-2 flex-shrink-0" />
                <ExclamationTriangleIcon v-else class="w-5 h-5 mr-2 flex-shrink-0" />
                <span>{{ message }}</span>
              </div>
            </transition>

            <!-- Информационный блок -->
            <div class="bg-blue-50 rounded-xl p-4 border border-blue-200">
              <div class="flex">
                <InformationCircleIcon class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0" />
                <div class="text-sm text-blue-700">
                  <p class="font-medium mb-1">Что произойдет после отправки?</p>
                  <ul class="list-disc list-inside space-y-1 text-xs">
                    <li>Вы получите письмо со ссылкой для сброса пароля</li>
                    <li>Ссылка будет действительна 60 минут</li>
                    <li>Если письмо не пришло, проверьте папку "Спам"</li>
                  </ul>
                </div>
              </div>
            </div>

            <!-- Кнопка отправки -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-2">
              <button
                  @click="sendResetPasswordLink"
                  :disabled="isLoading || !forgotPasswordEmail || cooldown > 0"
                  class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100 disabled:hover:shadow-lg"
              >
                <ArrowPathIcon v-if="isLoading" class="w-4 h-4 mr-2 animate-spin" />
                <span v-else>Отправить ссылку для сброса</span>
              </button>

              <!-- Индикатор времени для повторной отправки -->
              <span v-if="cooldown > 0" class="text-sm text-gray-500 flex items-center">
                <ClockIcon class="w-4 h-4 mr-1" />
                Повторная отправка через {{ cooldown }}с
              </span>
            </div>
          </div>
        </div>

        <!-- Нижняя часть с дополнительной информацией -->
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
          <div class="flex items-center justify-between text-xs text-gray-500">
            <span class="flex items-center">
              <ShieldCheckIcon class="w-4 h-4 mr-1 text-green-500" />
              Защищено шифрованием
            </span>
            <span class="flex items-center">
              <ClockIcon class="w-4 h-4 mr-1 text-blue-500" />
              Ссылка действует 60 мин
            </span>
          </div>
        </div>
      </div>

      <!-- Кнопка назад -->
      <div class="mt-6 text-center">
        <button
            @click="goBack"
            class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 transition-colors duration-200"
        >
          <ArrowLeftIcon class="w-4 h-4 mr-1" />
          Назад
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onUnmounted } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
import { BACKEND_URL } from "@/router.js";
import {
  LockClosedIcon,
  EnvelopeIcon,
  CheckCircleIcon,
  ExclamationTriangleIcon,
  ArrowPathIcon,
  InformationCircleIcon,
  ShieldCheckIcon,
  ClockIcon,
  ArrowLeftIcon
} from '@heroicons/vue/24/outline'

const router = useRouter()

// Email для сброса пароля
const forgotPasswordEmail = ref('')
const isLoading = ref(false)
const message = ref('')
const messageType = ref('success')
const emailError = ref('')
const cooldown = ref(0)
let cooldownInterval = null

// Валидация email
const validateEmail = (email) => {
  const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
  return re.test(email)
}

// Отправка ссылки для сброса пароля
const sendResetPasswordLink = async () => {
  // Валидация
  if (!forgotPasswordEmail.value) {
    emailError.value = 'Введите email'
    return
  }

  if (!validateEmail(forgotPasswordEmail.value)) {
    emailError.value = 'Введите корректный email'
    return
  }

  emailError.value = ''
  isLoading.value = true
  message.value = ''

  try {
    const response = await axios.post(`${BACKEND_URL}/api/forgot-password`, {
      email: forgotPasswordEmail.value
    })

    // Успешная отправка
    message.value = 'Ссылка для сброса пароля отправлена на ваш email'
    messageType.value = 'success'

    // Очищаем поле
    forgotPasswordEmail.value = ''

    // Запускаем кулдаун
    startCooldown()

  } catch (error) {
    console.error('Ошибка при отправке запроса на сброс пароля:', error)

    if (error.response) {
      // Обработка ошибок от сервера
      switch (error.response.status) {
        case 404:
          message.value = 'Пользователь с таким email не найден'
          break
        case 429:
          message.value = 'Слишком много запросов. Попробуйте позже'
          break
        case 422:
          message.value = 'Некорректный email'
          break
        default:
          message.value = error.response.data?.message || 'Ошибка при отправке запроса'
      }
    } else if (error.request) {
      message.value = 'Нет ответа от сервера. Проверьте подключение к интернету'
    } else {
      message.value = 'Произошла ошибка. Пожалуйста, попробуйте снова'
    }

    messageType.value = 'error'
  } finally {
    isLoading.value = false
  }
}

// Запуск кулдауна
const startCooldown = () => {
  cooldown.value = 60 // 60 секунд

  if (cooldownInterval) {
    clearInterval(cooldownInterval)
  }

  cooldownInterval = setInterval(() => {
    if (cooldown.value > 0) {
      cooldown.value--
    } else {
      clearInterval(cooldownInterval)
      cooldownInterval = null
    }
  }, 1000)
}

// Возврат на предыдущую страницу
const goBack = () => {
  router.back()
}

// Очистка интервала при размонтировании
onUnmounted(() => {
  if (cooldownInterval) {
    clearInterval(cooldownInterval)
  }
})
</script>

<style scoped>
/* Анимации для переходов */
.v-enter-active,
.v-leave-active {
  transition: opacity 0.3s ease;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
}

/* Стилизация скроллбара */
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

/* Анимация для кнопки */
button:active {
  transform: translateY(1px);
}

/* Адаптивность */
@media (max-width: 640px) {
  .text-3xl {
    font-size: 1.875rem;
  }
}
</style>