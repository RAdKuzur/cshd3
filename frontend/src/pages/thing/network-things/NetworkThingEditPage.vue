<template>
  <div class="p-6 bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <div class="max-w-4xl mx-auto">
      <!-- Заголовок и навигация -->
      <div class="mb-8">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-4">
            <router-link
                :to="`/things/network/view/${networkThingId}`"
                class="text-gray-600 hover:text-gray-900 flex items-center gap-2 px-3 py-2 hover:bg-gray-100 transition-colors"
            >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
              </svg>
              Назад
            </router-link>
            <div>
              <h1 class="text-3xl font-bold text-gray-900">Редактирование сетевого устройства</h1>
              <p class="text-gray-600 mt-2">Устройство #{{ networkThingId }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Индикатор загрузки -->
      <div v-if="isLoading" class="flex justify-center items-center h-64">
        <div class="text-gray-600">Загрузка данных...</div>
      </div>

      <div v-else-if="error" class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
        <div class="flex items-center">
          <svg class="w-5 h-5 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span class="text-red-800">{{ error }}</span>
        </div>
      </div>

      <!-- Основная форма -->
      <div v-if="!isLoading && !error" class="bg-white shadow-lg border border-gray-200 rounded-xl">
        <div class="p-6">
          <div v-if="submitError" class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex items-center">
              <svg class="w-5 h-5 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span class="text-red-800">{{ submitError }}</span>
            </div>
          </div>

          <form @submit.prevent="handleSubmit">
            <!-- Основное устройство (только чтение) -->
            <div class="mb-8">
              <div class="flex items-center justify-between mb-4">
                <label class="block text-sm font-medium text-gray-700">
                  Основное устройство
                </label>
                <span class="text-xs text-gray-500">Нельзя изменить</span>
              </div>

              <div v-if="selectedThing" class="p-4 bg-gray-50 border border-gray-200 rounded-lg">
                <div class="flex items-center justify-between">
                  <div>
                    <div class="font-medium text-gray-900">
                      {{ selectedThing.name || `Устройство #${form.thing_id}` }}
                    </div>
                    <div class="text-sm text-gray-600">
                      Инвентарный номер: {{ selectedThing.inv_number || 'Не указан' }} |
                      ID: {{ form.thing_id }}
                    </div>
                  </div>
                  <div class="text-right">
                    <div class="font-semibold text-indigo-600">{{ formatCurrency(selectedThing.price) }}</div>
                    <div class="text-xs text-gray-500">Стоимость</div>
                  </div>
                </div>
              </div>

              <div v-else class="p-4 bg-gray-50 border border-gray-200 rounded-lg">
                <div class="flex items-center">
                  <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  <span class="text-gray-600">Загрузка информации об устройстве...</span>
                </div>
              </div>

              <div class="mt-2 text-sm text-gray-500">
                Для изменения основного устройства создайте новое сетевое устройство.
              </div>
            </div>

            <!-- Сетевая информация -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
              <!-- IP-адрес -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  IP-адрес
                  <span class="text-xs text-gray-500 ml-1">(необязательно)</span>
                </label>
                <div class="relative">
                  <input
                      v-model="form.ip_address"
                      type="text"
                      placeholder="Например: 192.168.1.1"
                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                      :class="{ 'border-red-300': errors.ip_address }"
                  >
                  <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3" />
                    </svg>
                  </div>
                </div>
                <div v-if="errors.ip_address" class="mt-2 text-sm text-red-600">
                  {{ errors.ip_address }}
                </div>
              </div>

              <!-- Номер телефона -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Номер телефона
                  <span class="text-xs text-gray-500 ml-1">(необязательно)</span>
                </label>
                <div class="relative">
                  <input
                      v-model="form.phone_number"
                      type="text"
                      placeholder="Например: +7 (999) 123-45-67"
                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                      :class="{ 'border-red-300': errors.phone_number }"
                  >
                  <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                  </div>
                </div>
                <div v-if="errors.phone_number" class="mt-2 text-sm text-red-600">
                  {{ errors.phone_number }}
                </div>
              </div>
            </div>

            <!-- Комментарий -->
            <div class="mb-8">
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Комментарий
                <span class="text-xs text-gray-500 ml-1">(необязательно)</span>
              </label>
              <textarea
                  v-model="form.comment"
                  rows="4"
                  placeholder="Введите комментарий или описание устройства..."
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all resize-none"
                  :class="{ 'border-red-300': errors.comment }"
              ></textarea>
              <div v-if="errors.comment" class="mt-2 text-sm text-red-600">
                {{ errors.comment }}
              </div>
              <div class="mt-1 text-sm text-gray-500">
                {{ form.comment?.length || 0 }} / 1000 символов
              </div>
            </div>

            <!-- Дополнительная информация -->
            <div class="mb-8 bg-gray-50 border border-gray-200 rounded-lg p-4">
              <h3 class="text-sm font-medium text-gray-700 mb-3">Дополнительная информация</h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <div class="text-xs font-medium text-gray-500 mb-1">Инвентарный номер</div>
                  <div class="font-mono text-gray-900">{{ networkThingData?.inv_number || 'Не указан' }}</div>
                </div>
                <div>
                  <div class="text-xs font-medium text-gray-500 mb-1">Тип устройства</div>
                  <div class="flex items-center gap-2">
                    <div :class="getTypeColor(networkThingData?.type)" class="w-4 h-4 rounded-full"></div>
                    <div>{{ getTypeLabel(networkThingData?.type) }}</div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Кнопки действий -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
              <div>
                <router-link
                    :to="`/things/network/view/${networkThingId}`"
                    class="text-sm text-gray-500 hover:text-gray-700 hover:underline"
                >
                  Вернуться без сохранения
                </router-link>
              </div>

              <div class="flex items-center gap-3">
                <button
                    type="button"
                    @click="handleCancel"
                    class="px-4 py-2 border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors flex items-center gap-2"
                >
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                  Отмена
                </button>

                <button
                    type="submit"
                    :disabled="isSubmitting"
                    class="px-6 py-2 bg-indigo-600 text-white font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  <svg v-if="isSubmitting" class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                  {{ isSubmitting ? 'Сохранение...' : 'Сохранить изменения' }}
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- Подсказка -->
<!--      <div v-if="!isLoading && !error" class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">-->
<!--        <div class="flex items-start">-->
<!--          <svg class="w-5 h-5 text-blue-400 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">-->
<!--            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />-->
<!--          </svg>-->
<!--          <div>-->
<!--            <h3 class="text-sm font-medium text-blue-800 mb-1">Важная информация</h3>-->
<!--            <ul class="text-sm text-blue-700 space-y-1">-->
<!--              <li>• Основное устройство нельзя изменить после создания</li>-->
<!--              <li>• Для изменения основного устройства создайте новое сетевое устройство</li>-->
<!--              <li>• Все изменения сохраняются сразу после нажатия кнопки "Сохранить"</li>-->
<!--            </ul>-->
<!--          </div>-->
<!--        </div>-->
<!--      </div>-->
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'
import { BACKEND_URL } from "@/router.js"

const route = useRoute()
const router = useRouter()

const networkThingId = route.params.id

// Данные формы
const form = reactive({
  thing_id: null,
  ip_address: '',
  phone_number: '',
  comment: ''
})

// Исходные данные (для сравнения изменений)
const originalData = reactive({
  ip_address: '',
  phone_number: '',
  comment: ''
})

// Данные сетевого устройства
const networkThingData = ref(null)
const selectedThing = ref(null)
const thingTypes = ref({})

// Состояние
const isLoading = ref(true)
const isSubmitting = ref(false)
const error = ref('')
const submitError = ref('')

// Ошибки валидации
const errors = reactive({
  ip_address: '',
  phone_number: '',
  comment: ''
})

// Проверка наличия изменений
const hasChanges = computed(() => {
  return form.ip_address !== originalData.ip_address ||
      form.phone_number !== originalData.phone_number ||
      form.comment !== originalData.comment
})

// Загрузка данных при монтировании
onMounted(async () => {
  await Promise.all([
    loadNetworkThingData(),
    loadThingTypes()
  ])
})

// Загрузка данных сетевого устройства
const loadNetworkThingData = async () => {
  try {
    isLoading.value = true
    error.value = ''

    const response = await axios.get(`${BACKEND_URL}/api/network-things/${networkThingId}`)
    const data = response.data

    if (data.success && data.data) {
      networkThingData.value = data.data

      // Заполняем форму
      form.thing_id = data.data.thing_id
      form.ip_address = data.data.ip_address || ''
      form.phone_number = data.data.phone_number || ''
      form.comment = data.data.comment || ''

      // Сохраняем оригинальные данные
      originalData.ip_address = data.data.ip_address || ''
      originalData.phone_number = data.data.phone_number || ''
      originalData.comment = data.data.comment || ''

      // Загружаем информацию об основном устройстве
      await loadThingData(data.data.thing_id)

    } else {
      throw new Error(data.message || 'Данные не найдены')
    }

  } catch (err) {

    if (err.response) {
      if (err.response.status === 404) {
        error.value = 'Сетевое устройство не найдено'
      } else {
        error.value = `Ошибка сервера: ${err.response.status}`
      }
    } else if (err.request) {
      error.value = 'Нет ответа от сервера. Проверьте подключение.'
    } else {
      error.value = err.message || 'Не удалось загрузить данные устройства.'
    }
  } finally {
    isLoading.value = false
  }
}

// Загрузка информации об основном устройстве
const loadThingData = async (thingId) => {
  try {
    const response = await axios.get(`${BACKEND_URL}/api/things/${thingId}`)

    if (response.data.success && response.data.data) {
      selectedThing.value = response.data.data
    }
  } catch (err) {
    // Не показываем ошибку пользователю, просто оставляем selectedThing как null
  }
}

// Загрузка типов устройств
const loadThingTypes = async () => {
  try {
    const response = await axios.get(`${BACKEND_URL}/api/info/thing-types`)

    if (response.data.success) {
      thingTypes.value = response.data.types || {}
    }
  } catch (err) {
  }
}

// Получение метки типа устройства
const getTypeLabel = (typeId) => {
  if (typeId === null || typeId === undefined) return 'Не указан'
  return thingTypes.value[typeId] || `Тип ${typeId}`
}

// Цвет для типа устройства
const getTypeColor = (typeId) => {
  if (typeId === null || typeId === undefined) return 'bg-gray-400'

  // Генерируем цвет на основе typeId
  const colors = [
    'bg-blue-500',
    'bg-green-500',
    'bg-purple-500',
    'bg-red-500',
    'bg-yellow-500',
    'bg-indigo-500',
    'bg-pink-500',
    'bg-teal-500',
    'bg-orange-500',
    'bg-cyan-500'
  ]
  const index = typeId % colors.length
  return colors[index] || 'bg-gray-400'
}

// Форматирование валюты
const formatCurrency = (amount) => {
  if (!amount && amount !== 0) return '0 ₽'
  return new Intl.NumberFormat('ru-RU', {
    style: 'currency',
    currency: 'RUB',
    minimumFractionDigits: 2
  }).format(amount)
}

// Валидация формы
const validateForm = () => {
  let isValid = true

  // Очищаем предыдущие ошибки
  Object.keys(errors).forEach(key => errors[key] = '')

  // Валидация ip_address (если указан)
  if (form.ip_address) {
    // Простая валидация IP-адреса
    const ipRegex = /^(\d{1,3}\.){3}\d{1,3}$/
    if (!ipRegex.test(form.ip_address)) {
      errors.ip_address = 'Введите корректный IP-адрес (например: 192.168.1.1)'
      isValid = false
    }
  }

  // Валидация phone_number (если указан)
  if (form.phone_number && form.phone_number.length > 50) {
    errors.phone_number = 'Номер телефона слишком длинный'
    isValid = false
  }

  // Валидация comment (если указан)
  if (form.comment && form.comment.length > 1000) {
    errors.comment = 'Комментарий не должен превышать 1000 символов'
    isValid = false
  }

  return isValid
}

// Обработчик отмены
const handleCancel = () => {
  if (hasChanges.value) {
    if (confirm('У вас есть несохраненные изменения. Вы уверены, что хотите уйти?')) {
      router.push(`/things/network/view/${networkThingId}`)
    }
  } else {
    router.push(`/things/network/view/${networkThingId}`)
  }
}

// Отправка формы
const handleSubmit = async () => {
  // Проверка изменений
  if (!hasChanges.value) {
    alert('Нет изменений для сохранения')
    return
  }

  // Валидация
  if (!validateForm()) {
    return
  }

  try {
    isSubmitting.value = true
    submitError.value = ''

    // Подготавливаем данные для отправки
    const updateData = {
      thing_id: form.thing_id, // Отправляем всегда
      ip_address: form.ip_address || null,
      phone_number: form.phone_number || null,
      comment: form.comment || null
    }

    const response = await axios.put(`${BACKEND_URL}/api/network-things/${networkThingId}`, updateData)

    if (response.data.success) {
      // Успешное обновление
      alert('Изменения успешно сохранены!')
      router.push(`/things/network/view/${networkThingId}`)
    } else {
      // Ошибка от сервера
      submitError.value = response.data.message || 'Ошибка при сохранении изменений'
    }

  } catch (err) {

    if (err.response) {
      // Ошибки валидации от сервера
      if (err.response.status === 422) {
        const validationErrors = err.response.data.errors || {}
        Object.keys(validationErrors).forEach(key => {
          if (errors[key] !== undefined) {
            errors[key] = validationErrors[key][0] || 'Ошибка валидации'
          }
        })
        submitError.value = 'Пожалуйста, исправьте ошибки в форме'
      } else if (err.response.status === 400) {
        submitError.value = err.response.data.message || 'Некорректный запрос'
      } else if (err.response.status === 404) {
        submitError.value = 'Сетевое устройство не найдено'
      } else {
        submitError.value = `Ошибка сервера: ${err.response.status}`
      }
    } else if (err.request) {
      submitError.value = 'Нет ответа от сервера. Проверьте подключение.'
    } else {
      submitError.value = err.message || 'Не удалось сохранить изменения'
    }
  } finally {
    isSubmitting.value = false
  }
}
</script>