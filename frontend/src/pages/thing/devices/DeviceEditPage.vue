<template>
  <div class="p-6 bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <div class="max-w-4xl mx-auto">
      <!-- Заголовок и навигация -->
      <div class="mb-8">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-4">
            <router-link
                :to="`/things/devices`"
                class="text-gray-600 hover:text-gray-900 flex items-center gap-2 px-3 py-2 hover:bg-gray-100 transition-colors"
            >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
              </svg>
              Назад
            </router-link>
            <div>
              <h1 class="text-3xl font-bold text-gray-900">Редактирование устройства</h1>
              <p class="text-gray-600 mt-2">Устройство</p>
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
            <!-- Модель устройства (обязательное) -->
            <div class="mb-8">
              <div class="flex items-center justify-between mb-4">
                <label class="block text-sm font-medium text-gray-700">
                  Модель устройства <span class="text-red-500">*</span>
                </label>
                <span class="text-xs text-gray-500">Обязательное поле</span>
              </div>

              <!-- Поиск по моделям -->
              <div class="relative mb-2">
                <input
                    v-model="searchQuery"
                    type="text"
                    placeholder="Начните вводить название модели или производителя..."
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                    @input="handleSearch"
                >
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                  <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                  </svg>
                </div>
              </div>

              <!-- Список моделей -->
              <div v-if="isLoadingModels" class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                <div class="flex items-center justify-center">
                  <svg class="animate-spin h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  <span class="ml-2 text-gray-600">Загрузка моделей...</span>
                </div>
              </div>

              <div v-else-if="searchQuery && filteredModels.length === 0" class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                <div class="text-center text-gray-500">
                  Модели не найдены. Попробуйте другой поисковый запрос.
                </div>
              </div>

              <div v-else-if="filteredModels.length > 0" class="border border-gray-200 rounded-lg max-h-64 overflow-y-auto">
                <div
                    v-for="model in filteredModels"
                    :key="model.id"
                    class="p-4 border-b border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors"
                    :class="{ 'bg-indigo-50': form.model_id === model.id }"
                    @click="selectModel(model)"
                >
                  <div class="flex items-center justify-between">
                    <div>
                      <div class="font-medium text-gray-900">{{ model.name }}</div>
                      <div class="text-sm text-gray-500">
                        Производитель: {{ getCompanyName(model.company_id) || 'Не указан' }} |
                        ID: {{ model.id }}
                      </div>
                    </div>
                    <div class="text-right">
                      <div class="text-xs text-gray-500">Модель</div>
                    </div>
                  </div>
                </div>
              </div>

              <div v-else class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                <div class="text-center text-gray-500">
                  Начните вводить в поле выше для поиска модели устройства
                </div>
              </div>

              <!-- Выбранная модель -->
              <div v-if="form.model_id" class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-center justify-between">
                  <div>
                    <div class="font-medium text-gray-900">
                      Выбрано: {{ selectedModel?.name || `Модель #${form.model_id}` }}
                    </div>
                    <div class="text-sm text-gray-600">
                      Производитель: {{ getCompanyName(selectedModel?.company_id) || 'Не указан' }} |
                      ID: {{ form.model_id }}
                    </div>
                  </div>
                  <button
                      type="button"
                      @click="clearSelectedModel"
                      class="text-sm text-red-600 hover:text-red-800 hover:underline"
                  >
                    Отменить выбор
                  </button>
                </div>
              </div>

              <div v-if="errors.model_id" class="mt-2 text-sm text-red-600">
                {{ errors.model_id }}
              </div>
            </div>

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
                Для изменения основного устройства создайте новое устройство.
              </div>
            </div>

            <!-- Кнопки действий -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
              <div>
                <router-link
                    :to="`/things/devices/view/${deviceId}`"
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
                    :disabled="isSubmitting || !hasChanges"
                    class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed shadow-sm hover:shadow"
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

const deviceId = route.params.id

// Данные формы
const form = reactive({
  model_id: null,
  thing_id: null
})

// Исходные данные (для сравнения изменений)
const originalData = reactive({
  model_id: null
})

// Данные устройства
const deviceData = ref(null)
const models = ref([])
const companies = ref([])
const selectedModel = ref(null)
const selectedThing = ref(null)
const thingTypes = ref({})

// Состояние
const isLoading = ref(true)
const isLoadingModels = ref(false)
const isSubmitting = ref(false)
const error = ref('')
const submitError = ref('')
const searchQuery = ref('')

// Ошибки валидации
const errors = reactive({
  model_id: '',
  thing_id: ''
})

// Проверка наличия изменений
const hasChanges = computed(() => {
  return form.model_id !== originalData.model_id
})

// Фильтрованные модели
const filteredModels = computed(() => {
  if (!searchQuery.value) {
    return models.value.slice(0, 10) // Показываем первые 10
  }

  const query = searchQuery.value.toLowerCase()
  return models.value.filter(model =>
      (model.name && model.name.toLowerCase().includes(query)) ||
      (getCompanyName(model.company_id) && getCompanyName(model.company_id).toLowerCase().includes(query))
  ).slice(0, 10) // Ограничиваем до 10 результатов
})

// Загрузка данных при монтировании
onMounted(async () => {
  await Promise.all([
    loadDeviceData(),
    loadModels(),
    loadCompanies(),
    loadThingTypes()
  ])
})

// Загрузка данных устройства
const loadDeviceData = async () => {
  try {
    isLoading.value = true
    error.value = ''

    const response = await axios.get(`${BACKEND_URL}/api/devices/${deviceId}`)
    const data = response.data

    if (data.success && data.data) {
      deviceData.value = data.data

      // Заполняем форму
      form.model_id = data.data.model_id
      form.thing_id = data.data.thing_id

      // Сохраняем оригинальные данные
      originalData.model_id = data.data.model_id

      // Загружаем информацию о модели
      if (data.data.model_id) {
        await loadModelData(data.data.model_id)
      }

      // Загружаем информацию об основном устройстве
      if (data.data.thing_id) {
        await loadThingData(data.data.thing_id)
      }

    } else {
      throw new Error(data.message || 'Данные не найдены')
    }

  } catch (err) {
    if (err.response) {
      if (err.response.status === 404) {
        error.value = 'Устройство не найдено'
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

// Загрузка информации о модели
const loadModelData = async (modelId) => {
  try {
    const response = await axios.get(`${BACKEND_URL}/api/models/${modelId}`)

    if (response.data.success && response.data.data) {
      selectedModel.value = response.data.data
    }
  } catch (err) {
    // Не показываем ошибку пользователю
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
    // Не показываем ошибку пользователю
  }
}

// Загрузка списка моделей
const loadModels = async () => {
  try {
    isLoadingModels.value = true
    const response = await axios.get(`${BACKEND_URL}/api/models`)

    if (response.data.success && response.data.data) {
      models.value = response.data.data
    }
  } catch (err) {
    console.error('Ошибка загрузки моделей:', err)
  } finally {
    isLoadingModels.value = false
  }
}

// Загрузка компаний
const loadCompanies = async () => {
  try {
    const response = await axios.get(`${BACKEND_URL}/api/companies`)

    if (response.data.success) {
      companies.value = response.data.data || []
    }
  } catch (err) {
    console.error('Ошибка загрузки компаний:', err)
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
    console.error('Ошибка загрузки типов устройств:', err)
  }
}

// Получение названия компании по ID
const getCompanyName = (companyId) => {
  const company = companies.value.find(c => c.id === companyId)
  return company ? company.name : null
}

// Поиск моделей
const handleSearch = () => {
  // Поиск происходит автоматически через computed свойство
}

// Выбор модели
const selectModel = (model) => {
  form.model_id = model.id
  selectedModel.value = model
  searchQuery.value = ''
  errors.model_id = ''
}

// Очистка выбранной модели
const clearSelectedModel = () => {
  form.model_id = null
  selectedModel.value = null
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

  // Валидация model_id
  if (!form.model_id) {
    errors.model_id = 'Необходимо выбрать модель устройства'
    isValid = false
  }

  // Валидация thing_id
  if (!form.thing_id) {
    errors.thing_id = 'Основное устройство не выбрано'
    isValid = false
  }

  return isValid
}

// Обработчик отмены
const handleCancel = () => {
  if (hasChanges.value) {
    if (confirm('У вас есть несохраненные изменения. Вы уверены, что хотите уйти?')) {
      router.push(`/things/devices/view/${deviceId}`)
    }
  } else {
    router.push(`/things/devices/view/${deviceId}`)
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
      model_id: form.model_id,
      thing_id: form.thing_id // Отправляем всегда
    }

    const response = await axios.put(`${BACKEND_URL}/api/devices/${deviceId}`, updateData)

    if (response.data.success) {
      // Успешное обновление
      alert('Изменения успешно сохранены!')
      router.push(`/things/devices/view/${deviceId}`)
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
        submitError.value = 'Устройство не найдено'
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