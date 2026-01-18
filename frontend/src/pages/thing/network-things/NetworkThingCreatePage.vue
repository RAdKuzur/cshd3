<template>
  <div class="p-6 bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <div class="max-w-4xl mx-auto">
      <!-- Заголовок и навигация -->
      <div class="mb-8">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-4">
            <router-link
                to="/things/network"
                class="text-gray-600 hover:text-gray-900 flex items-center gap-2 px-3 py-2 hover:bg-gray-100 transition-colors"
            >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
              </svg>
              Назад к списку
            </router-link>
            <div>
              <h1 class="text-3xl font-bold text-gray-900">Новое сетевое устройство</h1>
              <p class="text-gray-600 mt-2">Добавление нового сетевого устройства в систему</p>
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
            <!-- Основное устройство (обязательное) -->
            <div class="mb-8">
              <div class="flex items-center justify-between mb-4">
                <label class="block text-sm font-medium text-gray-700">
                  Основное устройство <span class="text-red-500">*</span>
                </label>
                <span class="text-xs text-gray-500">Обязательное поле</span>
              </div>

              <!-- Поиск по устройствам -->
              <div class="relative mb-2">
                <input
                    v-model="searchQuery"
                    type="text"
                    placeholder="Начните вводить название, инвентарный номер или ID устройства..."
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                    @input="handleSearch"
                >
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                  <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                  </svg>
                </div>
              </div>

              <!-- Список устройств -->
              <div v-if="isLoadingThings" class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                <div class="flex items-center justify-center">
                  <svg class="animate-spin h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  <span class="ml-2 text-gray-600">Загрузка устройств...</span>
                </div>
              </div>

              <div v-else-if="searchQuery && filteredThings.length === 0" class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                <div class="text-center text-gray-500">
                  Устройства не найдены. Попробуйте другой поисковый запрос.
                </div>
              </div>

              <div v-else-if="filteredThings.length > 0" class="border border-gray-200 rounded-lg max-h-64 overflow-y-auto">
                <div
                    v-for="thing in filteredThings"
                    :key="thing.id"
                    class="p-4 border-b border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors"
                    :class="{ 'bg-indigo-50': form.thing_id === thing.id }"
                    @click="selectThing(thing)"
                >
                  <div class="flex items-center justify-between">
                    <div>
                      <div class="font-medium text-gray-900">{{ thing.name }}</div>
                      <div class="text-sm text-gray-500">
                        Инв. №: {{ thing.inv_number }} |
                        ID: {{ thing.id }} |
                        Тип: {{ getTypeLabel(thing.thing_type_id) }}
                      </div>
                    </div>
                    <div class="text-right">
                      <div class="font-semibold text-indigo-600">{{ formatCurrency(thing.price) }}</div>
                      <div class="text-xs text-gray-500">Стоимость</div>
                    </div>
                  </div>
                </div>
              </div>

              <div v-else class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                <div class="text-center text-gray-500">
                  Начните вводить в поле выше для поиска устройства
                </div>
              </div>

              <!-- Выбранное устройство -->
              <div v-if="form.thing_id" class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-center justify-between">
                  <div>
                    <div class="font-medium text-gray-900">
                      Выбрано: {{ selectedThing?.name || `Устройство #${form.thing_id}` }}
                    </div>
                    <div class="text-sm text-gray-600">
                      Инвентарный номер: {{ selectedThing?.inv_number || 'Не указан' }} |
                      ID: {{ form.thing_id }}
                    </div>
                  </div>
                  <button
                      type="button"
                      @click="clearSelectedThing"
                      class="text-sm text-red-600 hover:text-red-800 hover:underline"
                  >
                    Отменить выбор
                  </button>
                </div>
              </div>

              <div v-if="errors.thing_id" class="mt-2 text-sm text-red-600">
                {{ errors.thing_id }}
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

            <!-- Кнопки действий -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
              <div>
                <span class="text-sm text-gray-500">
                  <span class="text-red-500">*</span> — обязательное поле
                </span>
              </div>

              <div class="flex items-center gap-3">
                <router-link
                    to="/things/network"
                    class="px-4 py-2 border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors flex items-center gap-2"
                >
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                  Отмена
                </router-link>

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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                  </svg>
                  {{ isSubmitting ? 'Создание...' : 'Создать устройство' }}
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
              <li>• <span class="font-medium">Основное устройство</span> — обязательно для заполнения</li>
              <li>• <span class="font-medium">IP-адрес</span> — должен быть валидным IP-адресом</li>
              <li>• <span class="font-medium">Номер телефона</span> — можно указывать в любом формате</li>
              <li>• <span class="font-medium">Комментарий</span> — дополнительная информация об устройстве</li>
            </ul>
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
  thing_id: null,
  ip_address: '',
  phone_number: '',
  comment: ''
})

// Ошибки валидации
const errors = reactive({
  thing_id: '',
  ip_address: '',
  phone_number: '',
  comment: ''
})

// Состояние
const isLoadingThings = ref(false)
const isSubmitting = ref(false)
const submitError = ref('')

// Данные для поиска
const things = ref([])
const searchQuery = ref('')
const selectedThing = ref(null)
const thingTypes = ref({})

// Фильтрованные устройства
const filteredThings = computed(() => {
  if (!searchQuery.value) {
    return things.value.slice(0, 10) // Показываем первые 10
  }

  const query = searchQuery.value.toLowerCase()
  return things.value.filter(thing =>
      (thing.name && thing.name.toLowerCase().includes(query)) ||
      (thing.inv_number && thing.inv_number.toString().toLowerCase().includes(query)) ||
      (thing.id && thing.id.toString().toLowerCase().includes(query))
  ).slice(0, 10) // Ограничиваем до 10 результатов
})

// Загрузка данных при монтировании
onMounted(async () => {
  await Promise.all([
    loadThings(),
    loadThingTypes()
  ])
})

// Загрузка списка устройств
const loadThings = async () => {
  try {
    isLoadingThings.value = true
    const response = await axios.get(`${BACKEND_URL}/api/things`)

    if (response.data.success && response.data.data) {
      things.value = response.data.data
    }
  } catch (err) {
    submitError.value = 'Не удалось загрузить список устройств'
  } finally {
    isLoadingThings.value = false
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

// Поиск устройств
const handleSearch = () => {
  // Поиск происходит автоматически через computed свойство
}

// Выбор устройства
const selectThing = (thing) => {
  form.thing_id = thing.id
  selectedThing.value = thing
  searchQuery.value = ''
  errors.thing_id = ''
}

// Очистка выбранного устройства
const clearSelectedThing = () => {
  form.thing_id = null
  selectedThing.value = null
}

// Получение метки типа устройства
const getTypeLabel = (typeId) => {
  if (typeId === null || typeId === undefined) return 'Не указан'
  return thingTypes.value[typeId] || `Тип ${typeId}`
}

// Форматирование валюты
const formatCurrency = (amount) => {
  if (!amount && amount !== 0) return '0 ₽'
  return new Intl.NumberFormat('ru-RU', {
    style: 'currency',
    currency: 'RUB',
    minimumFractionDigits: 0
  }).format(amount)
}

// Валидация формы
const validateForm = () => {
  let isValid = true

  // Очищаем предыдущие ошибки
  Object.keys(errors).forEach(key => errors[key] = '')

  // Валидация thing_id
  if (!form.thing_id) {
    errors.thing_id = 'Необходимо выбрать основное устройство'
    isValid = false
  }

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

// Отправка формы
const handleSubmit = async () => {
  // Валидация
  if (!validateForm()) {
    return
  }

  try {
    isSubmitting.value = true
    submitError.value = ''

    const response = await axios.post(`${BACKEND_URL}/api/network-things`, {
      thing_id: form.thing_id,
      ip_address: form.ip_address || null,
      phone_number: form.phone_number || null,
      comment: form.comment || null
    })

    if (response.data.success) {
      // Успешное создание
      const newNetworkThingId = response.data.data?.id
      if (newNetworkThingId) {
        alert('Сетевое устройство успешно создано!')
        router.push(`/things/network/view/${newNetworkThingId}`)
      } else {
        router.push('/things/network')
      }
    } else {
      // Ошибка от сервера
      submitError.value = response.data.message || 'Ошибка при создании устройства'
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
      submitError.value = err.message || 'Не удалось создать сетевое устройство'
    }
  } finally {
    isSubmitting.value = false
  }
}
</script>