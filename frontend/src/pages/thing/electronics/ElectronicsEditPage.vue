<template>
  <div class="p-6 bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <div class="max-w-4xl mx-auto">
      <!-- Заголовок -->
      <div class="mb-8">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-3xl font-bold text-gray-900">Редактирование предмета</h1>
            <p class="text-gray-600 mt-2">Редактирование основного средства #{{ thingId }}</p>
          </div>
          <router-link
              to="/things/electronics"
              class="text-gray-600 hover:text-gray-900 flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-gray-100 transition-colors"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Назад к списку
          </router-link>
        </div>
      </div>

      <!-- Индикатор загрузки -->
      <div v-if="isLoading && !error" class="flex justify-center items-center h-64">
        <div class="text-gray-600">Загрузка данных...</div>
      </div>

      <!-- Ошибка -->
      <div v-else-if="error" class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
        <div class="flex items-center">
          <svg class="w-5 h-5 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span class="text-red-800">{{ error }}</span>
        </div>
      </div>

      <!-- Форма редактирования -->
      <div v-if="!isLoading && !error && formData" class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
        <form @submit.prevent="handleSubmit">
          <!-- Основная информация -->
          <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-6 pb-2 border-b border-gray-200">
              Основная информация
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Название ОС -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Название основного средства *
                </label>
                <input
                    v-model="formData.name"
                    type="text"
                    disabled
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                    placeholder="Например: Ноутбук Dell Latitude 5420"
                />
                <p class="mt-1 text-sm text-gray-500">
                  Полное название основного средства
                </p>
              </div>

              <!-- Серийный номер -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Серийный номер
                </label>
                <input
                    v-model="formData.serial_number"
                    type="text"
                    disabled
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                    placeholder="Например: CN-0R3XX1-64180-2B9-016K"
                />
                <p class="mt-1 text-sm text-gray-500">
                  Уникальный номер производителя
                </p>
              </div>

              <!-- Инвентарный номер -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Инвентарный номер
                </label>
                <input
                    v-model="formData.inv_number"
                    type="text"
                    disabled
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                    placeholder="Например: INV-2024-001"
                />
                <p class="mt-1 text-sm text-gray-500">
                  Внутренний инвентарный номер организации
                </p>
              </div>

              <!-- Дата введения в эксплуатацию -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Дата введения в эксплуатацию
                </label>
                <input
                    v-model="formData.operation_date"
                    type="date"
                    disabled
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                />
                <p class="mt-1 text-sm text-gray-500">
                  Дата начала использования предмета
                </p>
              </div>
            </div>
          </div>

          <!-- Классификация и состояние -->
          <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-6 pb-2 border-b border-gray-200">
              Классификация и состояние
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Тип предмета -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Тип предмета *
                </label>
                <select
                    v-model="formData.thing_type_id"
                    required
                    disabled
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                >
                  <option value="">Выберите тип</option>
                  <option
                      v-for="(name, id) in types"
                      :key="id"
                      :value="parseInt(id)"
                  >
                    {{ name }}
                  </option>
                </select>
                <p class="mt-1 text-sm text-gray-500">
                  Категория основного средства
                </p>
              </div>

              <!-- Характеристика учёта -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Характеристика учёта
                </label>
                <select
                    disabled
                    v-model="formData.balance"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                >
                  <option value="">Выберите характеристику</option>
                  <option
                      v-for="(name, id) in balanceTypes"
                      :key="id"
                      :value="parseInt(id)"
                  >
                    {{ name }}
                  </option>
                </select>
                <p class="mt-1 text-sm text-gray-500">
                  Тип учёта основного средства
                </p>
              </div>

              <!-- Родительский предмет -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Родительский предмет (опционально)
                </label>
                <select
                    v-model="formData.thing_parent_id"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                >
                  <option value="">Не выбрано</option>
                  <option
                      v-for="item in parentThings"
                      :key="item.id"
                      :value="item.id"
                  >
                    {{ item.inv_number }}
                  </option>
                </select>
                <p class="mt-1 text-sm text-gray-500">
                  Если предмет является частью другого ОС
                </p>
              </div>

              <!-- Аудитория размещения -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Кабинет размещения
                </label>
                <select
                    v-model="formData.auditorium_id"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                >
                  <option value="">Не выбрано</option>
                  <option
                      v-for="auditorium in auditoriums"
                      :key="auditorium.id"
                      :value="auditorium.id"
                  >
                    {{ auditorium.name }}
                  </option>
                </select>
                <p class="mt-1 text-sm text-gray-500">
                  Кабинет, где находится предмет
                </p>
              </div>

              <!-- Состояние -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Состояние
                </label>
                <select
                    v-model="selectedCondition"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                >
                  <option value="">Выберите состояние</option>
                  <option
                      v-for="(label, key) in conditions"
                      :key="key"
                      :value="label"
                  >
                    {{ label }}
                  </option>
                </select>
                <p class="mt-1 text-sm text-gray-500">
                  Текущее состояние предмета
                </p>
              </div>

              <!-- Балансовая стоимость -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Балансовая стоимость *
                </label>
                <div class="relative">
                  <input
                      v-model.number="formData.price"
                      type="number"
                      min="0"
                      step="0.01"
                      class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                      placeholder="0.00"
                  />
                  <span class="absolute left-3 top-3.5 text-gray-500">₽</span>
                </div>
                <p class="mt-1 text-sm text-gray-500">
                  Стоимость на момент приобретения
                </p>
              </div>
            </div>
          </div>

          <!-- Комментарий -->
          <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">
              Дополнительная информация
            </h2>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Комментарий
              </label>
              <textarea
                  v-model="formData.comment"
                  rows="4"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                  placeholder="Введите дополнительную информацию о предмете..."
              ></textarea>
              <p class="mt-1 text-sm text-gray-500">
                Дополнительные заметки, особенности, история ремонта и т.д.
              </p>
            </div>
          </div>

          <!-- Кнопки действий -->
          <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
            <router-link
                to="/things"
                class="px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors"
            >
              Отмена
            </router-link>
            <button
                type="button"
                @click="handleReset"
                class="px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors"
                :disabled="isSubmitting"
            >
              Сбросить изменения
            </button>
            <button
                type="submit"
                :disabled="isSubmitting"
                class="px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
            >
              <span v-if="isSubmitting">
                <svg class="animate-spin h-5 w-5 inline-block mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Сохранение...
              </span>
              <span v-else>
                Сохранить изменения
              </span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref, reactive, onMounted, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from "axios"
import {BACKEND_URL} from "@/router.js";

const route = useRoute()
const router = useRouter()

const thingId = route.params.id

// Данные формы
const formData = ref(null)
const originalData = ref(null)

// Состояние как число (ID из API)
const conditionId = ref(null)

// Динамические данные с сервера
const types = ref({})
const conditions = ref({})
const balanceTypes = ref({}) // Добавляем характеристики учёта
const parentThings = ref([])
const auditoriums = ref([])
const isLoading = ref(false)
const isSubmitting = ref(false)
const error = ref(null)

// Вычисляемое свойство для выбранного состояния
const selectedCondition = computed({
  get() {
    // Преобразуем ID состояния в строку для поиска в условиях
    if (conditionId.value !== null && conditions.value[conditionId.value]) {
      return conditions.value[conditionId.value]
    }
    return ''
  },
  set(value) {
    // Находим ID по строковому значению
    for (const [key, label] of Object.entries(conditions.value)) {
      if (label === value) {
        conditionId.value = parseInt(key)
        break
      }
    }
  }
})

// Загрузка данных при монтировании компонента
onMounted(async () => {
  await Promise.all([
    loadThingData(),
    loadFormData()
  ])
})

// Загрузка данных предмета для редактирования
const loadThingData = async () => {
  try {
    isLoading.value = true
    error.value = null

    const response = await axios.get(BACKEND_URL + `/api/things/${thingId}`)

    if (response.data.success && response.data.data) {
      const data = response.data.data

      console.log('Полученные данные от API:', data)

      // Сохраняем оригинальный ID состояния
      conditionId.value = data.condition

      // Форматирование даты для input type="date"
      let operationDate = ''
      if (data.operation_date) {
        try {
          const date = new Date(data.operation_date)
          operationDate = date.toISOString().split('T')[0]
        } catch (e) {
          console.error('Ошибка форматирования даты:', e)
          operationDate = data.operation_date
        }
      }

      // Преобразование данных для формы
      formData.value = {
        name: data.name || '',
        serial_number: data.serial_number || '',
        inv_number: data.inv_number || '',
        operation_date: operationDate,
        thing_type_id: data.type || '',
        balance: data.balance || '', // Добавляем поле характеристики учёта
        thing_parent_id: data.thing_parent_id || '',
        auditorium_id: data.auditorium_id || '',
        price: data.price || 0,
        comment: data.comment || ''
      }

      originalData.value = {
        ...JSON.parse(JSON.stringify(formData.value)),
        condition: conditionId.value
      }

      console.log('Данные для формы:', formData.value)
      console.log('ID состояния:', conditionId.value)
      console.log('ID характеристики учёта:', formData.value.balance)
      console.log('ID аудитории:', formData.value.auditorium_id)
    } else {
      throw new Error('Данные предмета не найдены')
    }

  } catch (err) {
    console.error('Ошибка загрузки данных предмета:', err)
    error.value = 'Не удалось загрузить данные предмета. Проверьте соединение с сервером.'
  } finally {
    isLoading.value = false
  }
}

// Загрузка типов, условий, родительских предметов и аудиторий с сервера
const loadFormData = async () => {
  try {
    // Загружаем все данные параллельно
    const [typesResponse, balanceResponse, parentsResponse, auditoriumsResponse] = await Promise.all([
      axios.get(BACKEND_URL + '/api/info/thing-types'),
      axios.get(BACKEND_URL + '/api/info/balance'), // Добавляем запрос характеристик учёта
      axios.get(BACKEND_URL + '/api/things/simple-electronics'),
      axios.get(BACKEND_URL + '/api/auditoriums')
    ])

    // Обработка типов и условий
    if (typesResponse.data.success) {
      types.value = typesResponse.data.types || {}
      conditions.value = typesResponse.data.conditions || {}
      console.log('Загруженные типы:', types.value)
      console.log('Загруженные условия:', conditions.value)

      // После загрузки условий, обновляем вычисляемое свойство
      console.log('Текущее состояние предмета (ID):', conditionId.value)
      console.log('Соответствующая метка:', conditions.value[conditionId.value])
    } else {
      console.error('Ошибка загрузки типов и условий:', typesResponse.data)
      types.value = {}
      conditions.value = {}
    }

    // Обработка характеристик учёта
    if (balanceResponse.data.success) {
      balanceTypes.value = balanceResponse.data.types || {}
      console.log('Загруженные характеристики учёта:', balanceTypes.value)
    } else {
      console.error('Ошибка загрузки характеристик учёта:', balanceResponse.data)
      balanceTypes.value = {}
    }

    // Обработка родительских предметов
    if (parentsResponse.data.success) {
      parentThings.value = parentsResponse.data.data || []
      console.log('Загруженные родительские предметы:', parentThings.value)
    } else {
      console.error('Ошибка загрузки родительских предметов:', parentsResponse.data)
      parentThings.value = []
    }

    // Обработка аудиторий
    if (auditoriumsResponse.data.success) {
      auditoriums.value = auditoriumsResponse.data.data || []
      console.log('Загруженные аудитории:', auditoriums.value)
    } else {
      console.error('Ошибка загрузки аудиторий:', auditoriumsResponse.data)
      auditoriums.value = []
    }

  } catch (error) {
    console.error('Ошибка при загрузке данных формы:', error)
    types.value = {}
    conditions.value = {}
    balanceTypes.value = {}
    parentThings.value = []
    auditoriums.value = []
  }
}

// Сброс изменений
const handleReset = () => {
  if (originalData.value) {
    formData.value = JSON.parse(JSON.stringify(originalData.value))
    conditionId.value = originalData.value.condition
  }
}

// Обработка отправки формы
const handleSubmit = async () => {
  try {
    isSubmitting.value = true

    // Валидация
    if (!formData.value.name || !formData.value.thing_type_id) {
      alert('Пожалуйста, заполните все обязательные поля (Название, Тип предмета и Стоимость)')
      return
    }

    // Подготовка данных для отправки
    const dataToSend = {
      name: formData.value.name,
      serial_number: formData.value.serial_number,
      inv_number: formData.value.inv_number,
      operation_date: formData.value.operation_date,
      thing_type_id: parseInt(formData.value.thing_type_id),
      balance: formData.value.balance ? parseInt(formData.value.balance) : null, // Добавляем характеристику учёта
      thing_parent_id: formData.value.thing_parent_id ? parseInt(formData.value.thing_parent_id) : null,
      auditorium_id: formData.value.auditorium_id ? parseInt(formData.value.auditorium_id) : null,
      condition: conditionId.value,
      price: parseFloat(formData.value.price),
      comment: formData.value.comment || ''
    }

    console.log('Отправляемые данные для обновления:', dataToSend)

    // Отправка данных на сервер
    const response = await axios.put(
        BACKEND_URL + `/api/things/${thingId}`,
        dataToSend,
        {
          headers: {
            'Content-Type': 'application/json',
          }
        }
    )

    if (response.data && response.data.success) {
      alert('Предмет успешно обновлен!')
      router.push('/things')
    } else {
      throw new Error(response.data?.message || 'Ошибка при обновлении предмета')
    }

  } catch (error) {
    console.error('Ошибка при обновлении предмета:', error)

    let errorMessage = 'Произошла ошибка при обновлении предмета'

    if (error.response) {
      if (error.response.data && error.response.data.message) {
        errorMessage = error.response.data.message
      } else if (error.response.status === 422) {
        const validationErrors = error.response.data.errors
        errorMessage = 'Ошибки валидации:\n'
        for (const field in validationErrors) {
          errorMessage += `• ${validationErrors[field].join(', ')}\n`
        }
      } else if (error.response.data && error.response.data.error) {
        errorMessage = error.response.data.error
      }
    } else if (error.request) {
      errorMessage = 'Не удалось получить ответ от сервера. Проверьте подключение к интернету.'
    }

    alert(errorMessage)
  } finally {
    isSubmitting.value = false
  }
}
</script>