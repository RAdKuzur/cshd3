<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-4 md:p-6">
    <div class="max-w-4xl mx-auto">
      <!-- Заголовок и навигация -->
      <div class="mb-8 md:mb-12">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
          <div>
            <div class="flex items-center gap-3 mb-2">
              <router-link
                  to="/admin"
                  class="flex items-center gap-2 text-gray-600 hover:text-blue-600 transition-colors"
              >
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Назад
              </router-link>
            </div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Активация лицензии</h1>
            <p class="text-gray-600 mt-2">Введите лицензионный ключ для активации системы</p>
          </div>

<!--          <div class="flex items-center gap-2 text-sm text-gray-500">-->
<!--            <div class="w-2 h-2 rounded-full" :class="statusColor"></div>-->
<!--            {{ statusText }}-->
<!--          </div>-->
        </div>
      </div>

      <!-- Основной контент -->
      <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <!-- Заголовок карточки -->
        <div class="border-b border-gray-100 p-6 md:p-8">
          <div class="flex items-center gap-4">
            <div class="p-3 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl">
              <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
              </svg>
            </div>
            <div>
              <h2 class="text-xl font-semibold text-gray-900">Лицензионный ключ</h2>
              <p class="text-gray-600 mt-1">Введите ваш уникальный ключ лицензии</p>
            </div>
          </div>
        </div>

        <!-- Форма ввода -->
        <div class="p-6 md:p-8">
          <form @submit.prevent="activateLicence" class="space-y-6">
            <!-- Поле ввода -->
            <div>
              <label for="licence_key" class="block text-sm font-medium text-gray-700 mb-2">
                Лицензионный ключ
              </label>
              <div class="relative">
                <input
                    v-model="licenceKey"
                    id="licence_key"
                    type="text"
                    :disabled="loading"
                    :class="[
                    'w-full px-4 py-3 pl-12 border rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-1 transition-all',
                    error ? 'border-red-300 focus:border-red-500 focus:ring-red-500 bg-red-50' :
                           'border-gray-300 focus:border-green-500 focus:ring-green-500 hover:border-gray-400'
                  ]"Лицензия успешно активирована!
                    Система готова к работе с полным функционалом.


                    autocomplete="off"
                    spellcheck="false"
                />
                <div class="absolute left-4 top-1/2 transform -translate-y-1/2">
                  <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                  </svg>
                </div>

                <!-- Кнопка копирования из буфера -->
                <button
                    type="button"
                    @click="pasteFromClipboard"
                    :disabled="loading"
                    class="absolute right-4 top-1/2 transform -translate-y-1/2 flex items-center gap-2 px-3 py-1.5 text-sm text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors"
                >
                  <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                  </svg>
                  Вставить
                </button>
              </div>

              <!-- Сообщение об ошибке -->
              <div v-if="error" class="mt-2 flex items-start gap-2 text-red-600 text-sm">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ error }}</span>
              </div>

              <!-- Подсказка -->
<!--              <p class="mt-2 text-sm text-gray-500">-->
<!--                Лицензионный ключ обычно имеет формат: 5 групп по 5 символов, разделенных дефисами-->
<!--              </p>-->
            </div>

            <!-- Информационная панель -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-100 rounded-xl p-4">
              <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                  <h3 class="font-medium text-blue-900">Перед активацией убедитесь, что:</h3>
                  <ul class="mt-2 space-y-1 text-sm text-blue-700">
                    <li class="flex items-center gap-2">
                      <div class="w-1 h-1 bg-blue-500 rounded-full"></div>
                      Ключ введен без ошибок и лишних пробелов
                    </li>
                    <li class="flex items-center gap-2">
                      <div class="w-1 h-1 bg-blue-500 rounded-full"></div>
                      У вас есть стабильное интернет-соединение
                    </li>
<!--                    <li class="flex items-center gap-2">-->
<!--                      <div class="w-1 h-1 bg-blue-500 rounded-full"></div>-->
<!--                      Система не находится в процессе обновления-->
<!--                    </li>-->
                  </ul>
                </div>
              </div>
            </div>

            <!-- Кнопка активации -->
            <div>
              <button
                  type="submit"
                  :disabled="loading || !licenceKey.trim()"
                  :class="[
                  'w-full py-3 px-6 rounded-xl font-semibold transition-all duration-200',
                  'focus:outline-none focus:ring-2 focus:ring-offset-2',
                  loading || !licenceKey.trim()
                    ? 'bg-gray-100 text-gray-400 cursor-not-allowed'
                    : 'bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white shadow-lg hover:shadow-xl active:scale-[0.98]'
                ]"
              >
                <div class="flex items-center justify-center gap-3">
                  <svg v-if="loading" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  <svg v-else class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5 13l4 4L19 7" />
                  </svg>
                  <span>{{ loading ? 'Активация...' : 'Активировать лицензию' }}</span>
                </div>
              </button>

              <!-- Альтернативные действия -->
              <div class="mt-4 flex flex-wrap gap-4 justify-center">
                <button
                    type="button"
                    @click="resetForm"
                    :disabled="loading"
                    class="px-4 py-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors"
                >
                  Очистить форму
                </button>
<!--                <button-->
<!--                    type="button"-->
<!--                    @click="generateTestKey"-->
<!--                    :disabled="loading"-->
<!--                    class="px-4 py-2 text-sm text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors"-->
<!--                >-->
<!--                  Использовать тестовый ключ-->
<!--                </button>-->
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- Успешная активация -->
<!--      <Transition-->
<!--          enter-active-class="transition-all duration-300 ease-out"-->
<!--          enter-from-class="opacity-0 scale-95"-->
<!--          enter-to-class="opacity-100 scale-100"-->
<!--          leave-active-class="transition-all duration-200 ease-in"-->
<!--          leave-from-class="opacity-100 scale-100"-->
<!--          leave-to-class="opacity-0 scale-95"-->
<!--      >-->
<!--        <div-->
<!--            v-if="success"-->
<!--            class="mt-6 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-2xl p-6 shadow-lg"-->
<!--        >-->
<!--          <div class="flex items-start gap-4">-->
<!--            <div class="p-2 bg-green-100 rounded-lg">-->
<!--              <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
<!--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"-->
<!--                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />-->
<!--              </svg>-->
<!--            </div>-->
<!--            <div class="flex-1">-->
<!--              <h3 class="font-semibold text-green-900 text-lg">Лицензия успешно активирована!</h3>-->
<!--              <p class="text-green-700 mt-1">Система готова к работе с полным функционалом.</p>-->
<!--              <div class="mt-4 flex flex-wrap gap-3">-->
<!--                <router-link-->
<!--                    to="/admin"-->
<!--                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium"-->
<!--                >-->
<!--                  Вернуться в админку-->
<!--                </router-link>-->
<!--                <button-->
<!--                    @click="activateAnother"-->
<!--                    class="px-4 py-2 bg-white text-green-600 border border-green-300 rounded-lg hover:bg-green-50 transition-colors text-sm font-medium"-->
<!--                >-->
<!--                  Активировать другую лицензию-->
<!--                </button>-->
<!--              </div>-->
<!--            </div>-->
<!--            <button-->
<!--                @click="success = false"-->
<!--                class="p-1 text-green-600 hover:text-green-800 hover:bg-green-100 rounded-lg transition-colors"-->
<!--            >-->
<!--              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
<!--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />-->
<!--              </svg>-->
<!--            </button>-->
<!--          </div>-->
<!--        </div>-->
<!--      </Transition>-->

      <!-- Информация о лицензии -->
<!--      <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">-->
<!--        &lt;!&ndash; Срок действия &ndash;&gt;-->
<!--        <div class="bg-white rounded-xl border border-gray-200 p-5">-->
<!--          <div class="flex items-center gap-3 mb-4">-->
<!--            <div class="p-2 bg-blue-100 rounded-lg">-->
<!--              <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
<!--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"-->
<!--                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />-->
<!--              </svg>-->
<!--            </div>-->
<!--            <h3 class="font-semibold text-gray-900">Срок действия</h3>-->
<!--          </div>-->
<!--          <p class="text-gray-600 text-sm">Лицензия активируется на 1 год с момента активации</p>-->
<!--        </div>-->

<!--        &lt;!&ndash; Поддержка &ndash;&gt;-->
<!--        <div class="bg-white rounded-xl border border-gray-200 p-5">-->
<!--          <div class="flex items-center gap-3 mb-4">-->
<!--            <div class="p-2 bg-purple-100 rounded-lg">-->
<!--              <svg class="w-5 h-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
<!--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"-->
<!--                      d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />-->
<!--              </svg>-->
<!--            </div>-->
<!--            <h3 class="font-semibold text-gray-900">Техническая поддержка</h3>-->
<!--          </div>-->
<!--          <p class="text-gray-600 text-sm">Включена на весь период действия лицензии</p>-->
<!--        </div>-->
<!--      </div>-->
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

const router = useRouter()
const licenceKey = ref('')
const loading = ref(false)
const error = ref('')
const success = ref(false)

// Вычисляемые свойства для статуса
const statusColor = computed(() => {
  if (success.value) return 'bg-green-500'
  if (error.value) return 'bg-red-500'
  if (loading.value) return 'bg-yellow-500'
  return 'bg-gray-400'
})

const statusText = computed(() => {
  if (success.value) return 'Активировано'
  if (error.value) return 'Ошибка'
  if (loading.value) return 'В процессе'
  return 'Не активно'
})

// Метод для активации лицензии
const activateLicence = async () => {
  if (!licenceKey.value.trim()) {
    error.value = 'Пожалуйста, введите лицензионный ключ'
    return
  }

  loading.value = true
  error.value = ''

  try {
    await axios.post(BACKEND_URL + '/api/licence', {
      licence_key: licenceKey.value.trim()
    })

    success.value = true
    // Можно сохранить ключ в localStorage для отображения в будущем
    localStorage.setItem('lastLicenceKey', licenceKey.value)

  } catch (err) {
    error.value = err.response?.data?.message ||
        err.response?.data?.error ||
        'Ошибка активации лицензии. Проверьте ключ и попробуйте снова.'

    // Автоматически очищаем ошибку через 5 секунд
    setTimeout(() => {
      error.value = ''
    }, 5000)
  } finally {
    loading.value = false
  }
}

// Вставить из буфера обмена
const pasteFromClipboard = async () => {
  try {
    const text = await navigator.clipboard.readText()
    licenceKey.value = text.trim()
    error.value = ''
  } catch (err) {
    error.value = 'Не удалось получить доступ к буферу обмена'
  }
}

// Генерация тестового ключа
const generateTestKey = () => {
  const parts = []
  const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789' // Исключаем похожие символы

  for (let i = 0; i < 5; i++) {
    let part = ''
    for (let j = 0; j < 5; j++) {
      part += chars.charAt(Math.floor(Math.random() * chars.length))
    }
    parts.push(part)
  }

  licenceKey.value = parts.join('-')
  error.value = ''
}

// Сброс формы
const resetForm = () => {
  licenceKey.value = ''
  error.value = ''
  success.value = false
}

// Активировать другую лицензию
const activateAnother = () => {
  success.value = false
  licenceKey.value = ''
}

// При монтировании проверяем сохраненный ключ
import { onMounted } from 'vue'
import {BACKEND_URL} from "@/router.js";

onMounted(() => {
  const savedKey = localStorage.getItem('lastLicenceKey')
  if (savedKey) {
    licenceKey.value = savedKey
  }
})
</script>

<style scoped>
/* Анимация для поля ввода при фокусе */
input:focus {
  box-shadow: 0 0 0 3px rgba(72, 187, 120, 0.1);
}

/* Стили для скролла (если понадобится) */
::-webkit-scrollbar {
  width: 8px;
}

::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 4px;
}

::-webkit-scrollbar-thumb {
  background: #c1c1c1;
  border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
  background: #a1a1a1;
}

/* Адаптивные стили */
@media (max-width: 640px) {
  .grid {
    grid-template-columns: 1fr;
  }
}
</style>