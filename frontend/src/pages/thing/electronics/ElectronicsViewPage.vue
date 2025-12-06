<template>
  <div class="p-6 bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <div class="max-w-4xl mx-auto">
      <!-- Заголовок и навигация -->
      <div class="mb-8">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-4">
            <router-link
                to="/things/electronics"
                class="text-gray-600 hover:text-gray-900 flex items-center gap-2 px-3 py-2 hover:bg-gray-100 transition-colors"
            >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
              </svg>
              Назад
            </router-link>
            <div>
              <h1 class="text-3xl font-bold text-gray-900">Просмотр предмета</h1>
              <p class="text-gray-600 mt-2">Основное средство #{{ thing?.id }}</p>
            </div>
          </div>

          <div class="flex items-center gap-3">
            <button
                @click="handleEdit"
                class="px-4 py-2 bg-indigo-600 text-white font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors flex items-center gap-2"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
              </svg>
              Редактировать
            </button>
          </div>
        </div>
      </div>

      <!-- Индикатор загрузки -->
      <div v-if="isLoading" class="flex justify-center items-center h-64">
        <div class="text-gray-600">Загрузка данных...</div>
      </div>

      <div v-else-if="error" class="bg-red-50 border border-red-200 rounded-lg p-4">
        <div class="flex items-center">
          <svg class="w-5 h-5 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span class="text-red-800">{{ error }}</span>
        </div>
      </div>

      <!-- Основная информация -->
      <div v-if="!isLoading && thing && !error" class="bg-white shadow-lg border border-gray-200 p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-6 pb-2 border-b border-gray-200">
          Основная информация
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Название ОС</div>
            <div class="text-lg font-semibold text-gray-900">{{ thing?.name || 'Не указано' }}</div>
          </div>

          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Инвентарный номер</div>
            <div class="text-lg font-mono text-indigo-600 font-semibold">{{ thing?.inv_number || 'Не указан' }}</div>
          </div>

          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Серийный номер</div>
            <div class="text-lg font-mono text-gray-900">{{ thing?.serial_number || 'Не указан' }}</div>
          </div>

          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Дата ввода в эксплуатацию</div>
            <div class="text-lg text-gray-900">{{ formatDate(thing?.operation_date) || 'Не указана' }}</div>
            <div class="text-sm text-gray-500">{{ thing?.operation_date ? getYearsInUse(thing.operation_date) : '' }}</div>
          </div>
        </div>
      </div>

      <!-- Классификация и состояние -->
      <div v-if="!isLoading && thing && !error" class="bg-white shadow-lg border border-gray-200 p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-6 pb-2 border-b border-gray-200">
          Классификация и состояние
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Тип предмета</div>
            <div class="flex items-center gap-2">
              <div :class="getTypeColor(thing?.type)" class="w-8 h-8 rounded-full flex items-center justify-center text-white">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                </svg>
              </div>
              <div class="text-lg text-gray-900">{{ getTypeLabel(thing?.type) || 'Не указан' }}</div>
            </div>
          </div>

          <!-- Характеристика учёта -->
          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Характеристика учёта</div>
            <div class="flex items-center gap-2">
              <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
              </div>
              <div class="text-lg text-gray-900">{{ getBalanceLabel(thing?.balance) || 'Не указано' }}</div>
            </div>
          </div>

          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Родительский предмет</div>
            <div class="text-lg text-gray-900">
              {{ thing?.thing_parent_id ? thing.thing_parent_id : 'Не указан' }}
            </div>
          </div>

          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Состояние</div>
            <div class="flex items-center gap-2">
              <div :class="getConditionColor(thing?.condition)" class="w-8 h-8 rounded-full flex items-center justify-center text-white">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                </svg>
              </div>
              <div class="text-lg text-gray-900">{{ getConditionLabel(thing?.condition) || 'Не указано' }}</div>
            </div>
          </div>

          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Балансовая стоимость</div>
            <div class="text-2xl font-bold text-gray-900">{{ formatCurrency(thing?.price) || '0 ₽' }}</div>
          </div>
        </div>
      </div>

      <!-- Расположение (кабинет и этаж) -->
      <div v-if="!isLoading && thing && !error" class="bg-white shadow-lg border border-gray-200 p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-6 pb-2 border-b border-gray-200">
          Расположение
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Кабинет размещения</div>
            <div class="flex items-center gap-2">
              <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
              </div>
              <div class="text-lg font-semibold text-gray-900">
                {{ getAuditoriumName(thing?.auditorium_id) || 'Не указан' }}
              </div>
            </div>
          </div>

          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Этаж</div>
            <div class="flex items-center gap-2">
              <div class="w-8 h-8 bg-blue-50 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
              </div>
              <div class="text-lg text-gray-900">
                {{ getAuditoriumFloor(thing?.auditorium_id) || 'Не указан' }}
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Комментарий -->
      <div v-if="!isLoading && thing && !error && thing?.comment" class="bg-white shadow-lg border border-gray-200 p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Дополнительная информация</h2>

        <div>
          <div class="text-sm font-medium text-gray-500 mb-2">Комментарий</div>
          <div class="bg-gray-50 p-4 border border-gray-200 rounded-lg">
            <div class="text-gray-700 whitespace-pre-line">{{ thing.comment }}</div>
          </div>
        </div>
      </div>

      <!-- Дополнительная информация -->
      <div v-if="!isLoading && thing && !error" class="bg-white shadow-lg border border-gray-200 p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Системная информация</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">ID предмета</div>
            <div class="text-lg font-mono text-gray-900">{{ thing?.id || 'Не указан' }}</div>
          </div>

          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Дата создания</div>
            <div class="text-lg text-gray-900">{{ formatDate(thing?.created_at) || 'Не указана' }}</div>
          </div>

          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Последнее обновление</div>
            <div class="text-lg text-gray-900">{{ formatDate(thing?.updated_at) || 'Не указана' }}</div>
          </div>
        </div>
      </div>

      <!-- Действия -->
      <div v-if="!isLoading && thing && !error" class="mt-8 flex items-center justify-between bg-white shadow-lg border border-gray-200 p-6">
        <div class="text-sm text-gray-500">
          Статус: <span class="font-medium text-green-600">Активный</span>
        </div>

        <div class="flex items-center gap-3">
          <button
              @click="handlePrint"
              class="px-4 py-2 border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors flex items-center gap-2"
          >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Печать
          </button>

          <button
              @click="handleDelete"
              class="px-4 py-2 bg-red-600 text-white font-medium hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors flex items-center gap-2"
          >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
            Удалить
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'
import { BACKEND_URL } from "@/router.js"

const route = useRoute()
const router = useRouter()

// Данные
const thing = ref(null)
const auditoriums = ref([])
const isLoading = ref(true)
const error = ref(null)
const conditionsMap = ref({})
const typeMap = ref({})
const balanceTypes = ref({})

// Статические данные на случай ошибки загрузки

// Загрузка данных при монтировании
onMounted(async () => {
  await Promise.all([
    loadThingData(),
    loadConditions(),
    loadAuditoriums(),
    loadBalanceTypes()
  ])
})

// Загрузка данных предмета
const loadThingData = async () => {
  try {
    isLoading.value = true
    error.value = null
    const thingId = route.params.id

    const response = await axios.get(`${BACKEND_URL}/api/things/view/${thingId}`)
    const data = response.data

    if (data.success && data.data) {
      thing.value = data.data
      console.log('Полученные данные предмета:', thing.value)
    } else {
      throw new Error(data.message || 'Данные не найдены')
    }

  } catch (err) {
    console.error('Ошибка загрузки данных:', err)

    if (err.response) {
      // Сервер ответил с ошибкой
      if (err.response.status === 404) {
        error.value = 'Предмет не найден'
      } else {
        error.value = `Ошибка сервера: ${err.response.status}`
      }
    } else if (err.request) {
      // Запрос был сделан, но ответа не получено
      error.value = 'Нет ответа от сервера. Проверьте подключение.'
    } else {
      // Другая ошибка
      error.value = err.message || 'Не удалось загрузить данные предмета.'
    }
  } finally {
    isLoading.value = false
  }
}

// Загрузка характеристик учёта
const loadBalanceTypes = async () => {
  try {
    const response = await axios.get(`${BACKEND_URL}/api/info/balance`)
    const data = response.data

    if (data.success) {
      balanceTypes.value = data.types || {}
      console.log('Загруженные характеристики учёта:', balanceTypes.value)
    }
  } catch (err) {
    console.error('Ошибка загрузки характеристик учёта:', err)
    // Используем статические данные при ошибке
    balanceTypes.value = staticBalances
  }
}

// Загрузка аудиторий с этажами
const loadAuditoriums = async () => {
  try {
    const response = await axios.get(`${BACKEND_URL}/api/auditoriums/index`)
    const data = response.data

    if (data.success && data.data) {
      auditoriums.value = data.data
      console.log('Загруженные аудитории:', auditoriums.value)
    }
  } catch (err) {
    console.error('Ошибка загрузки аудиторий:', err)
    auditoriums.value = []
  }
}

// Загружаем условия и типы
const loadConditions = async () => {
  try {
    const response = await axios.get(`${BACKEND_URL}/api/info/thing-types`)
    const data = response.data

    if (data.success) {
      typeMap.value = data.types || {}
      conditionsMap.value = data.conditions || {}
      console.log('Загруженные условия:', conditionsMap.value)
      console.log('Загруженные типы:', typeMap.value)
    }
  } catch (err) {
    console.error('Ошибка загрузки условий:', err)
    // Используем статические данные при ошибке
    conditionsMap.value = staticConditions
    typeMap.value = {}
  }
}

// Получение названия кабинета по ID
const getAuditoriumName = (auditoriumId) => {
  if (!auditoriumId) return 'Не указан'

  const auditorium = auditoriums.value.find(a => a.id === auditoriumId)
  return auditorium ? auditorium.name : `ID: ${auditoriumId}`
}

// Получение этажа кабинета
const getAuditoriumFloor = (auditoriumId) => {
  if (!auditoriumId) return 'Не указан'

  const auditorium = auditoriums.value.find(a => a.id === auditoriumId)
  if (!auditorium || auditorium.floor === undefined || auditorium.floor === null) {
    return 'Не указан'
  }

  // Форматирование этажа с правильным склонением
  const floor = parseInt(auditorium.floor)
  const lastDigit = floor % 10
  const lastTwoDigits = floor % 100

  if (lastTwoDigits >= 11 && lastTwoDigits <= 19) {
    return `${floor} этаж`
  }

  switch (lastDigit) {
    case 1:
      return `${floor} этаж`
    case 2:
    case 3:
    case 4:
      return `${floor} этажа`
    default:
      return `${floor} этаж`
  }
}

// Получение метки характеристики учёта
const getBalanceLabel = (balanceId) => {
  if (balanceId === null || balanceId === undefined) return 'Не указано'

  if (Object.keys(balanceTypes.value).length > 0) {
    return balanceTypes.value[balanceId] || `Характеристика ${balanceId}`
  }
  return staticBalances[balanceId] || `Характеристика ${balanceId}`
}

// Методы форматирования
const formatDate = (dateString) => {
  if (!dateString) return ''
  try {
    return new Date(dateString).toLocaleDateString('ru-RU')
  } catch (e) {
    return dateString
  }
}

const formatCurrency = (amount) => {
  if (!amount && amount !== 0) return ''
  return new Intl.NumberFormat('ru-RU', {
    style: 'currency',
    currency: 'RUB',
    minimumFractionDigits: 0
  }).format(amount)
}

const getYearsInUse = (dateString) => {
  if (!dateString) return ''
  try {
    const now = new Date()
    const date = new Date(dateString)
    const years = now.getFullYear() - date.getFullYear()
    return years === 0 ? '<1 года' : `${years} ${getYearsText(years)}`
  } catch (e) {
    return ''
  }
}

const getYearsText = (years) => {
  if (years % 10 === 1 && years % 100 !== 11) return 'год'
  if ([2, 3, 4].includes(years % 10) && ![12, 13, 14].includes(years % 100)) return 'года'
  return 'лет'
}

// Метки для состояния
const getConditionLabel = (conditionId) => {
  if (conditionId === null || conditionId === undefined) return 'Не указано'

  if (Object.keys(conditionsMap.value).length > 0) {
    return conditionsMap.value[conditionId] || `Состояние ${conditionId}`
  }

  return staticConditions[conditionId] || `Состояние ${conditionId}`
}

const getConditionColor = (conditionId) => {
  if (conditionId === null || conditionId === undefined) return 'bg-gray-400'

  const colors = {
    1: 'bg-green-500',
    2: 'bg-red-500',
    3: 'bg-purple-400',
    4: 'bg-green-500',
    5: 'bg-green-400',
    6: 'bg-blue-400',
    7: 'bg-yellow-400',
    8: 'bg-orange-400',
  }

  return colors[conditionId] || 'bg-gray-400'
}

const getTypeLabel = (typeId) => {
  if (typeId === null || typeId === undefined) return 'Не указан'

  if (typeof typeId === 'string') {
    return typeId
  }

  if (Object.keys(typeMap.value).length > 0) {
    return typeMap.value[typeId] || `Тип ${typeId}`
  }

  return `Тип ${typeId}`
}

const getTypeColor = (typeId) => {
  if (typeId === null || typeId === undefined) return 'bg-gray-400'

  const colors = {
    1: 'bg-blue-500',
    2: 'bg-emerald-500',
    3: 'bg-purple-500',
    4: 'bg-amber-500',
    5: 'bg-red-500',
    6: 'bg-gray-500'
  }

  return colors[typeId] || 'bg-gray-400'
}

// Обработчики действий
const handleEdit = () => {
  router.push(`/things/electronics/edit/${route.params.id}`)
}

const handlePrint = () => {
  window.print()
}

const handleDelete = async () => {
  if (!confirm('Вы уверены, что хотите удалить этот предмет? Это действие нельзя отменить.')) {
    return
  }

  try {
    const thingId = route.params.id
    const response = await axios.delete(`${BACKEND_URL}/api/things/delete/${thingId}`, {
      headers: {
        'Content-Type': 'application/json',
      }
    })

    const data = response.data
    if (data.success) {
      alert('Предмет успешно удален')
      router.push('/things/electronics')
    } else {
      throw new Error(data.message || 'Ошибка при удалении')
    }
  } catch (err) {
    console.error('Ошибка удаления:', err)

    let errorMessage = 'Не удалось удалить предмет'
    if (err.response) {
      errorMessage += `: ${err.response.status}`
      if (err.response.data?.message) {
        errorMessage += ` - ${err.response.data.message}`
      }
    } else if (err.message) {
      errorMessage += `: ${err.message}`
    }

    alert(errorMessage)
  }
}
</script>

<style scoped>
@media print {
  .bg-gradient-to-br,
  .bg-gray-50,
  .bg-blue-50,
  button {
    background: white !important;
  }

  .shadow-lg,
  .border,
  button {
    box-shadow: none !important;
    border: 1px solid #e5e7eb !important;
  }

  button {
    display: none !important;
  }
}
</style>