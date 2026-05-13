<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-6">
    <div class="max-w-7xl mx-auto">
      <!-- Заголовок и навигация -->
      <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
          <div>
            <h1 class="text-3xl font-bold text-gray-900">Технические работы</h1>
            <p class="text-gray-600 mt-2">Настройка временного интервала для проведения технических работ системы</p>
          </div>

          <div class="flex flex-wrap items-center gap-3">
            <router-link
                to="/admin"
                class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:text-blue-600
                     transition-colors border border-gray-300 rounded-lg hover:border-blue-400"
            >
              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
              </svg>
              Назад
            </router-link>
          </div>
        </div>
      </div>

      <!-- Основной контент -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Форма -->
        <div class="lg:col-span-2">
          <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Заголовок формы -->
            <div class="bg-gradient-to-r from-orange-500 to-amber-600 px-8 py-6">
              <div class="flex items-center gap-4">
                <div class="bg-white/20 backdrop-blur-sm p-3 rounded-xl">
                  <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                </div>
                <div>
                  <h2 class="text-2xl font-bold text-white">Настройка интервала работ</h2>
                  <p class="text-orange-100 mt-1">Укажите дату и время начала и окончания технических работ</p>
                </div>
              </div>
            </div>

            <!-- Тело формы -->
            <div class="p-8">
              <div class="space-y-8">
                <!-- Поле "Дата и время начала" -->
                <div class="space-y-3">
                  <label class="block">
                    <span class="text-gray-700 font-medium flex items-center gap-2">
                      <svg class="w-5 h-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                      </svg>
                      Дата и время начала работ
                    </span>
                    <span class="text-sm text-gray-500">Система будет недоступна с этого момента</span>
                  </label>
                  <div class="relative">
                    <input
                        v-model="form.start_time"
                        type="datetime-local"
                        :min="minDateTime"
                        :class="[
                          'w-full px-4 py-3 pl-12 rounded-xl border-2 transition-all duration-200',
                          'focus:outline-none focus:ring-2 focus:ring-offset-2',
                          errors.start_time ? 'border-red-300 focus:border-red-500 focus:ring-red-200' : 'border-gray-300 focus:border-orange-500 focus:ring-orange-200'
                        ]"
                    />
                    <div class="absolute left-4 top-1/2 transform -translate-y-1/2">
                      <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                    </div>
                    <div v-if="errors.start_time" class="mt-2 text-sm text-red-600 flex items-center gap-1">
                      <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                      {{ errors.start_time }}
                    </div>
                  </div>
                </div>

                <!-- Поле "Дата и время окончания" -->
                <div class="space-y-3">
                  <label class="block">
                    <span class="text-gray-700 font-medium flex items-center gap-2">
                      <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                      Дата и время окончания работ
                    </span>
                    <span class="text-sm text-gray-500">Система снова станет доступна с этого момента</span>
                  </label>
                  <div class="relative">
                    <input
                        v-model="form.end_time"
                        type="datetime-local"
                        :min="form.start_time || minDateTime"
                        :class="[
                          'w-full px-4 py-3 pl-12 rounded-xl border-2 transition-all duration-200',
                          'focus:outline-none focus:ring-2 focus:ring-offset-2',
                          errors.end_time ? 'border-red-300 focus:border-red-500 focus:ring-red-200' : 'border-gray-300 focus:border-green-500 focus:ring-green-200'
                        ]"
                    />
                    <div class="absolute left-4 top-1/2 transform -translate-y-1/2">
                      <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                      </svg>
                    </div>
                    <div v-if="errors.end_time" class="mt-2 text-sm text-red-600 flex items-center gap-1">
                      <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                      {{ errors.end_time }}
                    </div>
                  </div>
                </div>

                <!-- Информация о длительности -->
                <div v-if="form.start_time && form.end_time" class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                  <h3 class="font-medium text-blue-900 mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Информация о запланированных работах
                  </h3>
                  <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                      <p class="text-sm text-blue-700">Начало:</p>
                      <p class="font-medium text-blue-900">{{ formatDateTime(form.start_time) }}</p>
                    </div>
                    <div class="space-y-1">
                      <p class="text-sm text-blue-700">Окончание:</p>
                      <p class="font-medium text-blue-900">{{ formatDateTime(form.end_time) }}</p>
                    </div>
                    <div class="sm:col-span-2 space-y-1">
                      <p class="text-sm text-blue-700">Общая продолжительность:</p>
                      <p class="font-medium text-blue-900">{{ calculateDuration() }}</p>
                    </div>
                  </div>
                </div>

                <!-- Кнопка отправки -->
                <div class="pt-4">
                  <button
                      @click="submitForm"
                      :disabled="loading || !isFormValid"
                      :class="[
                        'w-full flex items-center justify-center gap-3 px-6 py-4 rounded-xl font-medium',
                        'transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2',
                        loading || !isFormValid
                          ? 'bg-gray-300 text-gray-500 cursor-not-allowed'
                          : 'bg-gradient-to-r from-orange-500 to-amber-600 hover:from-orange-600 hover:to-amber-700 text-white hover:shadow-lg active:scale-[0.98] focus:ring-orange-500'
                      ]"
                  >
                    <svg v-if="loading" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <svg v-else class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 13l4 4L19 7" />
                    </svg>
                    {{ loading ? 'Отправка...' : 'Провести технические работы' }}
                  </button>

                  <p v-if="submitError" class="mt-3 text-sm text-red-600 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                    {{ submitError }}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Боковая панель с информацией -->
        <div class="space-y-6">
          <!-- Карточка предупреждения -->
          <div class="bg-gradient-to-br from-amber-50 to-orange-50 border border-amber-200 rounded-2xl p-6">
            <div class="flex items-start gap-3">
              <div class="bg-amber-100 p-2 rounded-lg">
                <svg class="w-6 h-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
              </div>
              <div>
                <h3 class="font-medium text-amber-900">Внимание!</h3>
                <p class="text-sm text-amber-800 mt-1">Во время технических работ система будет недоступна.</p>
              </div>
            </div>
          </div>

          <!-- Карточка рекомендаций -->
<!--          <div class="bg-white rounded-2xl shadow-lg p-6">-->
<!--            <h3 class="font-medium text-gray-900 mb-4 flex items-center gap-2">-->
<!--              <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
<!--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"-->
<!--                      d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />-->
<!--              </svg>-->
<!--              Рекомендации-->
<!--            </h3>-->
<!--            <ul class="space-y-3">-->
<!--              <li class="flex items-start gap-2">-->
<!--                <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
<!--                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />-->
<!--                </svg>-->
<!--                <span class="text-sm text-gray-700">Выбирайте время с минимальной нагрузкой на систему</span>-->
<!--              </li>-->
<!--              <li class="flex items-start gap-2">-->
<!--                <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
<!--                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />-->
<!--                </svg>-->
<!--                <span class="text-sm text-gray-700">Предупредите пользователей о предстоящих работах</span>-->
<!--              </li>-->
<!--              <li class="flex items-start gap-2">-->
<!--                <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
<!--                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />-->
<!--                </svg>-->
<!--                <span class="text-sm text-gray-700">Убедитесь, что все изменения сохранены</span>-->
<!--              </li>-->
<!--            </ul>-->
<!--          </div>-->

          <!-- Карточка активных работ -->
          <div v-if="activeTechWorks.length > 0" class="bg-white rounded-2xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
              <h3 class="font-medium text-gray-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Активные работы
              </h3>
              <span class="bg-purple-100 text-purple-800 text-xs font-medium px-3 py-1 rounded-full">
                {{ activeTechWorks.length }}
              </span>
            </div>
            <div class="space-y-4">
              <div v-for="work in activeTechWorks" :key="work.id" class="border border-gray-200 rounded-xl p-4 hover:border-purple-300 transition-colors">
                <div class="flex justify-between items-start mb-3">
                  <div>
                    <p class="text-sm font-medium text-gray-900">{{ formatDateTime(work.startTime) }}</p>
                    <p class="text-xs text-gray-600 mt-1">до {{ formatDateTime(work.endTime) }}</p>
                  </div>
                  <span :class="[
                    'text-xs font-medium px-2.5 py-1 rounded-full',
                    work.status === 1
                      ? 'bg-green-100 text-green-800 border border-green-200'
                      : 'bg-gray-100 text-gray-800 border border-gray-200'
                  ]">
                    {{ getStatusText(work.status) }}
                  </span>
                </div>

                <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                  <div class="text-xs text-gray-500">
                    {{ calculateWorkDuration(work.startTime, work.endTime) }}
                  </div>

                  <!-- Кнопка отмены (только для активных работ, которые еще не завершены) -->
                  <button
                      v-if="work.status === 1 && isWorkActive(work.endTime)"
                      @click="cancelTechWork(work.id)"
                      :disabled="cancellingWorkId === work.id"
                      :class="[
                        'flex items-center gap-2 px-3 py-1.5 text-xs font-medium rounded-lg',
                        'transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-1',
                        cancellingWorkId === work.id
                          ? 'bg-gray-200 text-gray-500 cursor-not-allowed'
                          : 'bg-gradient-to-r from-red-50 to-red-100 text-red-700 hover:from-red-100 hover:to-red-200 hover:text-red-800 border border-red-200 hover:border-red-300'
                      ]"
                  >
                    <svg v-if="cancellingWorkId === work.id" class="w-3 h-3 animate-spin" fill="none" viewBox="0 0 24 24">
                      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <svg v-else class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    {{ cancellingWorkId === work.id ? 'Отмена...' : 'Отменить' }}
                  </button>

                  <!-- Бейдж для завершенных работ -->
                  <span v-else-if="!isWorkActive(work.endTime)" class="text-xs text-gray-500 italic">
                    Завершено
                  </span>
                </div>
              </div>
            </div>
<!--            <div v-else class="text-center py-6">-->
<!--              <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
<!--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />-->
<!--              </svg>-->
<!--              <p class="text-gray-500 text-sm">Нет активных технических работ</p>-->
<!--            </div>-->
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
import {BACKEND_URL} from "@/router.js";

const router = useRouter()

// Состояние формы
const form = ref({
  start_time: '',
  end_time: ''
})

const errors = ref({})
const loading = ref(false)
const submitError = ref('')
const activeTechWorks = ref([])
const cancellingWorkId = ref(null)

// Вычисляем минимальную дату (текущий момент)
const minDateTime = computed(() => {
  const now = new Date()
  return now.toISOString().slice(0, 16)
})

// Проверка валидности формы
const isFormValid = computed(() => {
  return form.value.start_time && form.value.end_time &&
      new Date(form.value.end_time) > new Date(form.value.start_time)
})

// Проверка, активна ли еще техническая работа
const isWorkActive = (endTime) => {
  const now = new Date()
  const end = new Date(endTime)
  return now < end
}

// Получение текстового статуса
const getStatusText = (status) => {
  return status === 1 ? 'Активно' : 'Неактивно'
}

// Функция форматирования даты и времени
const formatDateTime = (datetime) => {
  if (!datetime) return ''
  const date = new Date(datetime)
  return date.toLocaleString('ru-RU', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

// Функция расчета длительности для формы
const calculateDuration = () => {
  if (!form.value.start_time || !form.value.end_time) return ''

  return calculateWorkDuration(form.value.start_time, form.value.end_time)
}

// Функция расчета длительности для работ
const calculateWorkDuration = (startTime, endTime) => {
  const start = new Date(startTime)
  const end = new Date(endTime)
  const duration = end - start

  const days = Math.floor(duration / (1000 * 60 * 60 * 24))
  const hours = Math.floor((duration % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))
  const minutes = Math.floor((duration % (1000 * 60 * 60)) / (1000 * 60))

  const parts = []
  if (days > 0) parts.push(`${days} д`)
  if (hours > 0) parts.push(`${hours} ч`)
  if (minutes > 0) parts.push(`${minutes} мин`)

  return parts.length > 0 ? parts.join(' ') : 'менее минуты'
}

// Функция отправки формы
const submitForm = async () => {
  if (!isFormValid.value || loading.value) return

  // Сброс ошибок
  errors.value = {}
  submitError.value = ''
  loading.value = true

  try {
    const response = await axios.post(`${BACKEND_URL}/api/tech-works`, {
      start_time: form.value.start_time,
      end_time: form.value.end_time
    })

    // Успешная отправка
    console.log('Технические работы запланированы:', response.data)

    // Показать уведомление об успехе
    alert('Технические работы успешно запланированы!')

    // Сброс формы
    form.value = {
      start_time: '',
      end_time: ''
    }

    // Обновить список активных работ
    fetchActiveTechWorks()

  } catch (error) {
    if (error.response?.status === 422) {
      // Обработка ошибок валидации
      const validationErrors = error.response.data.errors
      errors.value = {
        start_time: validationErrors.start_time?.[0],
        end_time: validationErrors.end_time?.[0]
      }
    } else {
      // Общая ошибка
      submitError.value = error.response?.data?.message || 'Произошла ошибка при отправке формы'
    }
    console.error('Ошибка при отправке формы:', error)
  } finally {
    loading.value = false
  }
}

// Функция отмены технических работ
const cancelTechWork = async (workId) => {
  if (!confirm('Вы уверены, что хотите отменить эти технические работы?')) {
    return
  }

  cancellingWorkId.value = workId

  try {
    const response = await axios.post(`${BACKEND_URL}/api/tech-works/${workId}/cancel`)

    console.log('Технические работы отменены:', response.data)

    // Обновить список активных работ
    await fetchActiveTechWorks()

    // Показать уведомление об успехе
    alert('Технические работы успешно отменены!')

  } catch (error) {
    console.error('Ошибка при отмене технических работ:', error)
    alert(error.response?.data?.message || 'Произошла ошибка при отмене технических работ')
  } finally {
    cancellingWorkId.value = null
  }
}

// Функция загрузки активных технических работ
const fetchActiveTechWorks = async () => {
  try {
    const response = await axios.get(`${BACKEND_URL}/api/tech-works`)
    if (response.data.success && response.data.data) {
      activeTechWorks.value = response.data.data
    }
  } catch (error) {
    console.error('Ошибка при загрузке активных работ:', error)
    activeTechWorks.value = []
  }
}

// Загружаем активные работы при монтировании компонента
onMounted(() => {
  fetchActiveTechWorks()
})
</script>

<style scoped>
/* Кастомные стили для input[type="datetime-local"] */
input[type="datetime-local"]::-webkit-calendar-picker-indicator {
  background: transparent;
  bottom: 0;
  color: transparent;
  cursor: pointer;
  height: auto;
  left: 0;
  position: absolute;
  right: 0;
  top: 0;
  width: auto;
}

/* Анимации */
@keyframes slideIn {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.bg-white {
  animation: slideIn 0.3s ease-out;
}

/* Плавные переходы для состояний */
.transition-all {
  transition-property: all;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

/* Стили для disabled состояния */
button:disabled {
  cursor: not-allowed;
  opacity: 0.7;
}

/* Кастомный скроллбар */
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

/* Анимация появления карточек */
.border-gray-200 {
  animation: fadeInUp 0.3s ease-out;
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(5px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>