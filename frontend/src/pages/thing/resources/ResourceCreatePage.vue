<template>
  <div class="p-6 bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <div class="max-w-4xl mx-auto">
      <!-- Заголовок и навигация -->
      <div class="mb-8">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-4">
            <router-link
                to="/things/resources"
                class="text-gray-600 hover:text-gray-900 flex items-center gap-2 px-3 py-2 hover:bg-gray-100 transition-colors"
            >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
              </svg>
              Назад
            </router-link>
            <div>
              <h1 class="text-3xl font-bold text-gray-900">Новый расходный материал</h1>
              <p class="text-gray-600 mt-2">Добавление нового расходного материала в систему</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Основная форма -->
      <div class="bg-white shadow-lg border border-gray-200 rounded-xl">
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
            <!-- Название материала -->
            <div class="mb-6">
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Название материала <span class="text-red-500">*</span>
              </label>
              <div class="relative">
                <input
                    v-model="form.name"
                    type="text"
                    placeholder="Введите название материала..."
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                    :class="{ 'border-red-300': errors.name }"
                >
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                  <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                  </svg>
                </div>
              </div>
              <div v-if="errors.name" class="mt-2 text-sm text-red-600">
                {{ errors.name }}
              </div>
              <div class="mt-1 text-sm text-gray-500">
                Например: "Картридж HP 123", "Бумага А4 500 листов"
              </div>
            </div>

            <!-- Тип материала -->
            <div class="mb-6">
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Тип материала <span class="text-red-500">*</span>
              </label>
              <select
                  v-model="form.type"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all bg-white"
                  :class="{ 'border-red-300': errors.type }"
              >
                <option value="">Выберите тип материала</option>
                <option
                    v-for="(label, id) in resourceTypes"
                    :key="id"
                    :value="parseInt(id)"
                >
                  {{ label }}
                </option>
              </select>
              <div v-if="errors.type" class="mt-2 text-sm text-red-600">
                {{ errors.type }}
              </div>
              <div class="mt-1 text-sm text-gray-500">
                Выберите категорию расходного материала
              </div>
            </div>

            <!-- Количество -->
            <div class="mb-8">
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Количество на складе <span class="text-red-500">*</span>
              </label>
              <div class="relative">
                <input
                    v-model="form.amount"
                    type="number"
                    min="0"
                    step="1"
                    placeholder="Введите количество..."
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                    :class="{ 'border-red-300': errors.amount }"
                >
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                  <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
              </div>
              <div v-if="errors.amount" class="mt-2 text-sm text-red-600">
                {{ errors.amount }}
              </div>

              <!-- Индикатор уровня запасов -->
              <div class="mt-4">
                <div class="flex justify-between text-sm mb-1">
                  <span class="text-gray-600">Уровень запасов</span>
                  <span class="font-medium text-gray-900">{{ getStockPercentage() }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                  <div
                      :class="getStockBarColor()"
                      class="h-2.5 rounded-full transition-all duration-300"
                      :style="{ width: getStockPercentage() + '%' }"
                  ></div>
                </div>
                <div class="mt-2 flex items-center justify-between text-xs text-gray-500">
                  <span :class="getStockStatusClass(form.amount || 0)" class="px-2 py-1 rounded">
                    {{ getStockStatusLabel(form.amount || 0) }}
                  </span>
                  <span>Макс: 100 единиц</span>
                </div>
              </div>
            </div>

            <!-- Предварительный просмотр -->
            <div v-if="form.name || form.type || form.amount" class="mb-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
              <h3 class="text-sm font-medium text-blue-800 mb-3">Предварительный просмотр</h3>
              <div class="space-y-3">
                <div v-if="form.name" class="flex items-center justify-between">
                  <span class="text-sm text-blue-700">Название:</span>
                  <span class="font-medium text-blue-900">{{ form.name }}</span>
                </div>
                <div v-if="form.type" class="flex items-center justify-between">
                  <span class="text-sm text-blue-700">Тип:</span>
                  <span class="font-medium text-blue-900">{{ getResourceTypeLabel(form.type) }}</span>
                </div>
                <div v-if="form.amount !== null && form.amount !== ''" class="flex items-center justify-between">
                  <span class="text-sm text-blue-700">Количество:</span>
                  <span class="font-medium text-blue-900">{{ form.amount }} единиц</span>
                </div>
              </div>
            </div>

            <!-- Кнопки действий -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
              <div>
                <span class="text-sm text-gray-500">
                  <span class="text-red-500">*</span> — обязательное поле
                </span>
              </div>

              <div class="flex items-center gap-3">
                <router-link
                    to="/things/resources"
                    class="px-4 py-2 border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors flex items-center gap-2 rounded-lg"
                >
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                  Отмена
                </router-link>

                <button
                    type="submit"
                    :disabled="isSubmitting"
                    class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors flex items-center gap-2 rounded-lg shadow-sm hover:shadow disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  <svg v-if="isSubmitting" class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                  </svg>
                  {{ isSubmitting ? 'Создание...' : 'Создать материал' }}
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- Подсказка -->
      <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-start">
          <svg class="w-5 h-5 text-blue-400 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <div>
            <h3 class="text-sm font-medium text-blue-800 mb-1">Информация о заполнении</h3>
            <ul class="text-sm text-blue-700 space-y-1">
              <li>• <span class="font-medium">Название материала</span> — обязательно для заполнения</li>
              <li>• <span class="font-medium">Тип материала</span> — выберите из списка доступных типов</li>
              <li>• <span class="font-medium">Количество</span> — укажите количество единиц на складе</li>
              <li>• <span class="font-medium">Индикатор запасов</span> — показывает текущий уровень запасов</li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Легенда статусов запасов -->
      <div class="mt-4 bg-gray-50 border border-gray-200 rounded-lg p-4">
        <h3 class="text-sm font-medium text-gray-700 mb-2">Легенда статусов запасов</h3>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-2">
          <div class="flex items-center">
            <div class="w-3 h-3 rounded-full bg-emerald-500 mr-2"></div>
            <span class="text-xs text-gray-600">В избытке (≥50)</span>
          </div>
          <div class="flex items-center">
            <div class="w-3 h-3 rounded-full bg-green-500 mr-2"></div>
            <span class="text-xs text-gray-600">Достаточно (20-49)</span>
          </div>
          <div class="flex items-center">
            <div class="w-3 h-3 rounded-full bg-yellow-500 mr-2"></div>
            <span class="text-xs text-gray-600">Мало (10-19)</span>
          </div>
          <div class="flex items-center">
            <div class="w-3 h-3 rounded-full bg-orange-500 mr-2"></div>
            <span class="text-xs text-gray-600">Критически мало (1-9)</span>
          </div>
          <div class="flex items-center">
            <div class="w-3 h-3 rounded-full bg-red-500 mr-2"></div>
            <span class="text-xs text-gray-600">Нет в наличии (0)</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted, computed } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
import { BACKEND_URL } from "@/router.js"

const router = useRouter()

// Данные формы
const form = reactive({
  name: '',
  type: '',
  amount: ''
})

// Ошибки валидации
const errors = reactive({
  name: '',
  type: '',
  amount: ''
})

// Состояние
const isSubmitting = ref(false)
const submitError = ref('')

// Данные
const resourceTypes = ref({})

// Загрузка данных при монтировании
onMounted(async () => {
  await loadResourceTypes()
})

// Загрузка типов материалов
const loadResourceTypes = async () => {
  try {
    const response = await axios.get(`${BACKEND_URL}/api/info/resource-types`)

    if (response.data.success) {
      resourceTypes.value = response.data.data || {}
    }
  } catch (err) {
    console.error('Ошибка загрузки типов материалов:', err)
  }
}

// Получение метки типа материала
const getResourceTypeLabel = (typeId) => {
  if (!typeId) return 'Не выбран'
  return resourceTypes.value[typeId] || `Тип ${typeId}`
}

// Цвет прогресс-бара
const getStockBarColor = () => {
  const amount = parseInt(form.amount) || 0
  if (amount >= 50) return 'bg-emerald-500'
  if (amount >= 20) return 'bg-green-500'
  if (amount >= 10) return 'bg-yellow-500'
  if (amount >= 1) return 'bg-orange-500'
  return 'bg-red-500'
}

// Процент запасов (максимум 100 для визуализации)
const getStockPercentage = () => {
  const amount = parseInt(form.amount) || 0
  // Логика: считаем, что 100 единиц = 100%
  const maxAmount = 100
  const percentage = (amount / maxAmount) * 100
  return Math.min(Math.round(percentage), 100)
}

// Статус запасов
const getStockStatusLabel = (amount) => {
  const amt = parseInt(amount) || 0
  if (amt >= 50) return 'В избытке'
  if (amt >= 20) return 'Достаточно'
  if (amt >= 10) return 'Мало'
  if (amt >= 1) return 'Критически мало'
  return 'Нет в наличии'
}

const getStockStatusClass = (amount) => {
  const amt = parseInt(amount) || 0
  if (amt >= 50) return 'bg-emerald-100 text-emerald-800 text-xs px-2 py-1 rounded'
  if (amt >= 20) return 'bg-green-100 text-green-800 text-xs px-2 py-1 rounded'
  if (amt >= 10) return 'bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded'
  if (amt >= 1) return 'bg-orange-100 text-orange-800 text-xs px-2 py-1 rounded'
  return 'bg-red-100 text-red-800 text-xs px-2 py-1 rounded'
}

// Валидация формы
const validateForm = () => {
  let isValid = true

  // Очищаем предыдущие ошибки
  Object.keys(errors).forEach(key => errors[key] = '')

  // Валидация name
  if (!form.name.trim()) {
    errors.name = 'Необходимо указать название материала'
    isValid = false
  } else if (form.name.length > 255) {
    errors.name = 'Название не должно превышать 255 символов'
    isValid = false
  }

  // Валидация type
  if (!form.type) {
    errors.type = 'Необходимо выбрать тип материала'
    isValid = false
  } else if (isNaN(parseInt(form.type))) {
    errors.type = 'Некорректный тип материала'
    isValid = false
  }

  // Валидация amount
  if (form.amount === '' || form.amount === null) {
    errors.amount = 'Необходимо указать количество'
    isValid = false
  } else {
    const amountNum = parseInt(form.amount)
    if (isNaN(amountNum)) {
      errors.amount = 'Количество должно быть числом'
      isValid = false
    } else if (amountNum < 0) {
      errors.amount = 'Количество не может быть отрицательным'
      isValid = false
    } else if (amountNum > 999999) {
      errors.amount = 'Слишком большое количество'
      isValid = false
    }
  }

  return isValid
}

// Отправка формы
const handleSubmit = async () => {
  // Валидация
  if (!validateForm()) {
    return
  }

  try {
    isSubmitting.value = true
    submitError.value = ''

    // Подготавливаем данные для отправки
    const postData = {
      name: form.name.trim(),
      type: parseInt(form.type),
      amount: parseInt(form.amount)
    }

    const response = await axios.post(`${BACKEND_URL}/api/resources`, postData)

    if (response.data.success) {
      // Успешное создание
      const newResourceId = response.data.data?.id
      if (newResourceId) {
        alert('Материал успешно создан!')
        router.push(`/things/resources/view/${newResourceId}`)
      } else {
        router.push('/things/resources')
      }
    } else {
      // Ошибка от сервера
      submitError.value = response.data.message || 'Ошибка при создании материала'
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
      } else {
        submitError.value = `Ошибка сервера: ${err.response.status}`
      }
    } else if (err.request) {
      submitError.value = 'Нет ответа от сервера. Проверьте подключение.'
    } else {
      submitError.value = err.message || 'Не удалось создать материал'
    }
  } finally {
    isSubmitting.value = false
  }
}
</script>