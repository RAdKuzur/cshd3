<template>
  <div class="p-6 bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <div class="max-w-8xl mx-auto">
      <!-- Заголовок -->
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Фильтр АРМ</h1>
        <p class="text-gray-600 mt-2">Поиск по отделу и дате</p>
      </div>

      <!-- Форма фильтрации -->
      <div class="mb-8 bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
          <!-- Выбор отдела -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Отдел
            </label>
            <select
                v-model="selectedBranch"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                :class="{ 'border-red-500': errors.branch }"
            >
              <option value="">Выберите отдел</option>
              <option
                  v-for="branch in branches"
                  :key="branch.id"
                  :value="branch.id"
              >
                {{ branch.name }}
              </option>
            </select>
            <p v-if="errors.branch" class="mt-1 text-sm text-red-600">
              {{ errors.branch }}
            </p>
          </div>

          <!-- Дата начала -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Дата начала
            </label>
            <input
                type="date"
                v-model="startDate"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                :class="{ 'border-red-500': errors.startDate }"
            >
            <p v-if="errors.startDate" class="mt-1 text-sm text-red-600">
              {{ errors.startDate }}
            </p>
          </div>

          <!-- Дата окончания -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Дата окончания
            </label>
            <input
                type="date"
                v-model="endDate"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                :class="{ 'border-red-500': errors.endDate }"
            >
            <p v-if="errors.endDate" class="mt-1 text-sm text-red-600">
              {{ errors.endDate }}
            </p>
          </div>

          <!-- Кнопка поиска -->
          <div class="flex items-end">
            <button
                @click="validateAndSearch"
                :disabled="isLoading"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-semibold shadow-sm transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
            >
              {{ isLoading ? 'Поиск...' : 'Найти мат. ценности' }}
            </button>
          </div>
        </div>

        <!-- Сообщение об ошибке валидации -->
        <div v-if="validationError" class="mt-4 p-3 bg-red-50 border border-red-200 rounded-lg">
          <p class="text-red-600 text-sm">{{ validationError }}</p>
        </div>
      </div>

      <!-- Результаты поиска -->
      <div v-if="things.length > 0" class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
        <!-- Статистика -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
          <div class="flex justify-between items-center">
            <div>
              <h2 class="text-lg font-semibold text-gray-900">
                Результаты поиска
              </h2>
              <p class="text-sm text-gray-600">
                Найдено АРМ: {{ things.length }}
                <span v-if="searchPerformed" class="ml-4">
                  За период: {{ formatDate(startDate) }} - {{ formatDate(endDate) }}
                </span>
              </p>
            </div>
            <div class="flex items-center space-x-4">
              <!-- Сортировка -->
              <select
                  v-model="sortField"
                  class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
              >
                <option value="operation_date">Сортировка по дате</option>
                <option value="name">По названию</option>
                <option value="price">По стоимости</option>
                <option value="condition">По состоянию</option>
                <option value="auditorium_name">По аудитории</option>
                <option value="balance">По характеристике учёта</option>
              </select>

              <!-- Количество на странице -->
              <select
                  v-model="itemsPerPage"
                  class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
              >
                <option value="10">10 на странице</option>
                <option value="25">25 на странице</option>
                <option value="50">50 на странице</option>
                <option value="100">100 на странице</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Таблица -->
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead class="bg-gradient-to-r from-indigo-500 to-purple-600">
            <tr>
              <th
                  v-for="header in headers"
                  :key="header.key"
                  class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider cursor-pointer"
                  @click="sortTable(header.key)"
              >
                <div class="flex items-center">
                  {{ header.label }}
                  <svg
                      v-if="sortKey === header.key"
                      class="w-4 h-4 ml-1"
                      :class="sortOrder === 'asc' ? 'rotate-180' : ''"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                  >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                  </svg>
                </div>
              </th>
            </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
            <tr
                v-for="item in paginatedItems"
                :key="item.id"
                class="hover:bg-gradient-to-r hover:from-indigo-50 hover:to-white transition-all duration-200 group"
            >
              <!-- Инвентарный номер и название -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-10 w-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                    </svg>
                  </div>
                  <div class="ml-4">
                    <router-link :to="`/things/view/${item.id}`" class="block">
                      <div class="text-sm font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors hover:underline">
                        {{ item.name || `Вещь ${item.id}` }}
                      </div>
                    </router-link>
                    <div class="text-sm text-gray-500">
                      Инв. №: {{ item.inv_number || 'Не указан' }}
                    </div>
                    <div v-if="item.serial_number" class="text-xs text-gray-400">
                      Сер. №: {{ item.serial_number }}
                    </div>
                  </div>
                </div>
              </td>

              <!-- Тип и состояние -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div :class="getConditionColor(item.condition)" class="flex-shrink-0 h-8 w-8 rounded-full flex items-center justify-center mr-3">
                    <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                    </svg>
                  </div>
                  <div>
                    <div class="text-sm font-medium text-gray-900">{{ getConditionLabel(item.condition) }}</div>
                    <div class="text-xs text-gray-500">{{ getTypeName(item.type) }}</div>
                    <div v-if="item.parent" class="text-xs text-blue-600">
                      Родитель: {{ item.parent }}
                    </div>
                  </div>
                </div>
              </td>

              <!-- Характеристика учёта -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-8 w-8 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                    <svg class="h-4 w-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                  </div>
                  <div>
                    <div class="text-sm font-medium text-gray-900">
                      {{ getBalanceLabel(item.balance) }}
                    </div>
                    <div class="text-xs text-indigo-500">
                      Характеристика учёта
                    </div>
                  </div>
                </div>
              </td>

              <!-- Кабинет размещения -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-8 w-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                    <svg class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                  </div>
                  <div>
                    <div class="text-sm font-semibold text-gray-900">
                      {{ item.auditorium_name || 'Не указана' }}
                    </div>
                    <div v-if="item.auditorium_floor" class="text-xs text-gray-500">
                      {{ item.auditorium_floor }}
                    </div>
                  </div>
                </div>
              </td>

              <!-- Дата ввода в эксплуатацию -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900 font-medium">{{ formatDate(item.operation_date) }}</div>
                <div class="text-xs text-gray-500">{{ getYearsInUse(item.operation_date) }} в использовании</div>
              </td>

              <!-- Балансовая стоимость -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-8 w-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                    <svg class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                  </div>
                  <div>
                    <div class="text-sm font-semibold text-gray-900">
                      {{ formatCurrency(item.price) }}
                    </div>
                    <div class="text-xs text-gray-500">
                      Стоимость
                    </div>
                  </div>
                </div>
              </td>

              <!-- Действия -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center space-x-2">
                  <!-- Кнопка просмотра -->
                  <router-link :to="`/things/view/${item.id}`">
                    <button class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Просмотреть">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                      </svg>
                    </button>
                  </router-link>

                  <!-- Кнопка редактирования -->
                  <router-link :to="`/things/edit/${item.id}`">
                    <button class="p-2 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Редактировать">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                      </svg>
                    </button>
                  </router-link>
                </div>
              </td>
            </tr>
            </tbody>
          </table>
        </div>

        <!-- Пагинация -->
        <div v-if="things.length > 0" class="px-6 py-4 border-t border-gray-200 bg-gray-50">
          <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700">
              Показано с {{ startIndex }} по {{ endIndex }} из {{ things.length }} записей
            </div>
            <div class="flex items-center space-x-2">
              <button
                  @click="prevPage"
                  :disabled="currentPage === 1"
                  class="px-3 py-1 rounded-md border border-gray-300 text-sm font-medium"
                  :class="currentPage === 1 ? 'text-gray-400 cursor-not-allowed' : 'text-gray-700 hover:bg-gray-100'"
              >
                Назад
              </button>

              <div class="flex space-x-1">
                <button
                    v-for="page in visiblePages"
                    :key="page"
                    @click="goToPage(page)"
                    class="w-8 h-8 rounded-md text-sm font-medium"
                    :class="page === currentPage
                    ? 'bg-indigo-600 text-white'
                    : 'text-gray-700 hover:bg-gray-100'"
                >
                  {{ page }}
                </button>
                <span v-if="showEllipsis" class="px-2 py-1 text-gray-500">...</span>
              </div>

              <button
                  @click="nextPage"
                  :disabled="currentPage === totalPages"
                  class="px-3 py-1 rounded-md border border-gray-300 text-sm font-medium"
                  :class="currentPage === totalPages ? 'text-gray-400 cursor-not-allowed' : 'text-gray-700 hover:bg-gray-100'"
              >
                Вперед
              </button>
            </div>

            <select
                v-model="itemsPerPage"
                class="px-3 py-1 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
            >
              <option value="5">5 на странице</option>
              <option value="10">10 на странице</option>
              <option value="20">20 на странице</option>
              <option value="50">50 на странице</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Сообщение, если ничего не найдено -->
      <div v-if="!isLoading && searchPerformed && things.length === 0" class="text-center py-12">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8">
          <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <h3 class="mt-4 text-lg font-medium text-gray-900">Вещи не найдены</h3>
          <p class="mt-2 text-sm text-gray-500">
            По вашему запросу за период с {{ formatDate(startDate) }} по {{ formatDate(endDate) }} ничего не найдено
          </p>
        </div>
      </div>

      <!-- Загрузка -->
      <div v-if="isLoading" class="text-center py-12">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8">
          <svg class="animate-spin mx-auto h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          <p class="mt-4 text-gray-600">Поиск вещей...</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch, onMounted } from 'vue'

// Заголовки таблицы
const headers = ref([
  { key: 'name', label: 'Название и номер' },
  { key: 'condition', label: 'Состояние и тип' },
  { key: 'balance', label: 'Характеристика учёта' },
  { key: 'auditorium_name', label: 'Кабинет размещения' },
  { key: 'operation_date', label: 'Дата введения в эксплуатацию' },
  { key: 'price', label: 'Балансовая стоимость' },
  { key: 'actions', label: 'Действия' }
])

// Реактивные переменные для фильтрации
const branches = ref([])
const selectedBranch = ref('')
const startDate = ref('')
const endDate = ref('')
const things = ref([])
const isLoading = ref(false)
const searchPerformed = ref(false)
const validationError = ref('')
const errors = ref({
  branch: '',
  startDate: '',
  endDate: ''
})

// Справочники
const types = ref({})
const conditions = ref({})
const balanceTypes = ref({})
const auditoriums = ref([])

// Сортировка и пагинация
const sortField = ref('operation_date')
const sortKey = ref('operation_date')
const sortOrder = ref('desc')
const currentPage = ref(1)
const itemsPerPage = ref(10)

// Загрузка справочников при монтировании
onMounted(async () => {
  await loadBranches()
  await loadReferenceData()

  // Устанавливаем сегодняшнюю дату по умолчанию
  const today = new Date().toISOString().split('T')[0]
  const weekAgo = new Date()
  weekAgo.setDate(weekAgo.getDate() - 7)
  startDate.value = weekAgo.toISOString().split('T')[0]
  endDate.value = today
})

// Функция для загрузки списка отделов
const loadBranches = async () => {
  try {
    const response = await fetch('/api/info/branches')
    if (!response.ok) throw new Error(`Ошибка загрузки отделов: ${response.status}`)

    const data = await response.json()
    if (data.success) {
      branches.value = data.data
    } else {
      throw new Error('Не удалось загрузить список отделов')
    }
  } catch (error) {
    validationError.value = 'Не удалось загрузить список отделов'
  }
}

// Загрузка справочных данных
const loadReferenceData = async () => {
  try {
    const [typesResponse, balanceResponse, auditoriumsResponse] = await Promise.all([
      fetch('/api/info/thing-types'),
      fetch('/api/info/balance'),
      fetch('/api/auditoriums')
    ])

    // Типы и состояния
    if (typesResponse.ok) {
      const data = await typesResponse.json()
      if (data.success) {
        types.value = data.types || {}
        conditions.value = data.conditions || {}
      }
    }

    // Характеристики учёта
    if (balanceResponse.ok) {
      const data = await balanceResponse.json()
      if (data.success) {
        balanceTypes.value = data.types || {}
      }
    }

    // Аудитории
    if (auditoriumsResponse.ok) {
      const data = await auditoriumsResponse.json()
      if (data.success) {
        auditoriums.value = data.data || []
      }
    }
  } catch (error) {
  }
}

// Валидация формы
const validateForm = () => {
  errors.value = { branch: '', startDate: '', endDate: '' }
  validationError.value = ''

  let isValid = true

  if (!selectedBranch.value) {
    errors.value.branch = 'Выберите отдел'
    isValid = false
  }

  if (!startDate.value) {
    errors.value.startDate = 'Укажите дату начала'
    isValid = false
  }

  if (!endDate.value) {
    errors.value.endDate = 'Укажите дату окончания'
    isValid = false
  }

  if (startDate.value && endDate.value && startDate.value > endDate.value) {
    errors.value.startDate = 'Дата начала не может быть позже даты окончания'
    isValid = false
  }

  return isValid
}

// Поиск вещей
const searchThings = async () => {
  searchPerformed.value = true

  try {
    isLoading.value = true
    things.value = []

    // Собираем параметры для запроса
    const params = new URLSearchParams()
    params.append('branchId', selectedBranch.value)
    params.append('startDate', startDate.value)
    params.append('endDate', endDate.value)

    // Отправляем GET запрос
    const url = `/api/things/filter-arm?${params.toString()}`
    const response = await fetch(url)

    if (!response.ok) {
      throw new Error(`Ошибка поиска: ${response.status}`)
    }

    const data = await response.json()

    if (data.success) {
      // Обогащаем данные информацией из справочников
      things.value = (data.data || []).map(item => {
        // Находим аудиторию по ID
        const auditorium = auditoriums.value.find(a => a.id === item.auditorium_id)
        const auditoriumName = auditorium ? auditorium.name : 'Не указана'
        const auditoriumFloor = auditorium ? getFloorText(auditorium.floor) : ''

        return {
          id: item.id,
          name: item.name || `Вещь ${item.id}`,
          inv_number: item.inv_number,
          serial_number: item.serial_number,
          type: item.thing_type_id,
          condition: item.condition,
          balance: item.balance || null,
          parent: item.thing_parent_id,
          operation_date: item.operation_date,
          price: item.price,
          auditorium_id: item.auditorium_id,
          auditorium_name: auditoriumName,
          auditorium_floor: auditoriumFloor
        }
      })

      // Сбрасываем пагинацию при новом поиске
      currentPage.value = 1
    } else {
      throw new Error(data.message || 'Не удалось выполнить поиск')
    }
  } catch (error) {
    validationError.value = error.message || 'Произошла ошибка при поиске вещей'
  } finally {
    isLoading.value = false
  }
}

// Основная функция для валидации и поиска
const validateAndSearch = () => {
  if (validateForm()) {
    searchThings()
  }
}

// === ВСПОМОГАТЕЛЬНЫЕ ФУНКЦИИ ДЛЯ ТАБЛИЦЫ ===

// Сортировка
const sortTable = (key) => {
  if (sortKey.value === key) {
    sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc'
  } else {
    sortKey.value = key
    sortOrder.value = 'asc'
  }
}

// Фильтрация и сортировка данных для отображения
const filteredAndSortedItems = computed(() => {
  let items = [...things.value]

  // Сортировка
  items.sort((a, b) => {
    let aVal = a[sortKey.value]
    let bVal = b[sortKey.value]

    if (sortKey.value === 'operation_date') {
      aVal = new Date(aVal)
      bVal = new Date(bVal)
    } else if (sortKey.value === 'condition') {
      aVal = Object.values(conditions.value).indexOf(getConditionLabel(a.condition))
      bVal = Object.values(conditions.value).indexOf(getConditionLabel(b.condition))
    } else if (sortKey.value === 'auditorium_name') {
      aVal = a.auditorium_name || 'Я'
      bVal = b.auditorium_name || 'Я'
    } else if (sortKey.value === 'balance') {
      aVal = getBalanceLabel(a.balance) || 'Я'
      bVal = getBalanceLabel(b.balance) || 'Я'
    }

    if (aVal < bVal) return sortOrder.value === 'asc' ? -1 : 1
    if (aVal > bVal) return sortOrder.value === 'asc' ? 1 : -1
    return 0
  })

  return items
})

// Пагинация
const totalPages = computed(() => Math.ceil(filteredAndSortedItems.value.length / itemsPerPage.value))

const paginatedItems = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return filteredAndSortedItems.value.slice(start, end)
})

const startIndex = computed(() => (currentPage.value - 1) * itemsPerPage.value + 1)
const endIndex = computed(() => Math.min(currentPage.value * itemsPerPage.value, filteredAndSortedItems.value.length))

const visiblePages = computed(() => {
  const pages = []
  const maxVisible = 5
  let start = Math.max(1, currentPage.value - Math.floor(maxVisible / 2))
  let end = Math.min(totalPages.value, start + maxVisible - 1)

  if (end - start + 1 < maxVisible) {
    start = Math.max(1, end - maxVisible + 1)
  }

  for (let i = start; i <= end; i++) {
    pages.push(i)
  }

  return pages
})

const showEllipsis = computed(() => totalPages.value > visiblePages.value.length)

// Навигация по страницам
const prevPage = () => currentPage.value > 1 && currentPage.value--
const nextPage = () => currentPage.value < totalPages.value && currentPage.value++
const goToPage = (page) => currentPage.value = page

// Вспомогательные функции
const getTypeName = (typeId) => types.value[typeId] || `Тип ${typeId}`
const getConditionLabel = (condition) => conditions.value[condition] || 'Не указано'
const getBalanceLabel = (balanceId) => balanceTypes.value[balanceId] || 'Не указано'

const getConditionColor = (condition) => {
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
  return colors[condition] || 'bg-gray-400'
}

const getFloorText = (floorNumber) => {
  if (!floorNumber && floorNumber !== 0) return ''
  const lastDigit = floorNumber % 10
  const lastTwoDigits = floorNumber % 100

  if (lastTwoDigits >= 11 && lastTwoDigits <= 19) return `${floorNumber} этаж`

  switch (lastDigit) {
    case 1: return `${floorNumber} этаж`
    case 2:
    case 3:
    case 4: return `${floorNumber} этажа`
    default: return `${floorNumber} этаж`
  }
}

const formatDate = (dateString) => {
  if (!dateString) return 'Не указана'
  try {
    return new Date(dateString).toLocaleDateString('ru-RU')
  } catch {
    return dateString
  }
}

const formatCurrency = (amount) => {
  if (!amount && amount !== 0) return '0 ₽'
  return new Intl.NumberFormat('ru-RU', {
    style: 'currency',
    currency: 'RUB',
    minimumFractionDigits: 0
  }).format(amount)
}

const getYearsInUse = (dateString) => {
  if (!dateString) return 'Неизвестно'
  try {
    const now = new Date()
    const date = new Date(dateString)
    const years = now.getFullYear() - date.getFullYear()
    return years === 0 ? '<1 года' : `${years} ${getYearsText(years)}`
  } catch {
    return 'Неизвестно'
  }
}

const getYearsText = (years) => {
  if (years % 10 === 1 && years % 100 !== 11) return 'год'
  if ([2, 3, 4].includes(years % 10) && ![12, 13, 14].includes(years % 100)) return 'года'
  return 'лет'
}

// Сброс пагинации при изменении фильтров
watch([selectedBranch, startDate, endDate], () => {
  currentPage.value = 1
})

watch([sortField], () => {
  sortKey.value = sortField.value
  sortOrder.value = 'desc'
})

watch(itemsPerPage, () => {
  currentPage.value = 1
})
</script>