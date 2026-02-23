<template>
  <div class="p-6 bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <div class="max-w-8xl mx-auto">
      <!-- Заголовок и элементы управления -->
      <div class="mb-8">
        <div class="mt-6 flex gap-4 flex-wrap">
          <div class="flex-1 min-w-[300px]">
            <div class="relative">
              <input
                  v-model="searchQuery"
                  type="text"
                  placeholder="Поиск по названию, серийному или инвентарному номеру, местоположению..."
                  class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
              >
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </div>
            </div>
          </div>

          <div class="flex gap-4 flex-wrap">
            <select
                v-model="conditionFilter"
                class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
            >
              <option value="">Все состояния</option>
              <option v-for="(label, key) in conditions" :key="key" :value="parseInt(key)">
                {{ label }}
              </option>
            </select>

            <select
                v-model="balanceFilter"
                class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
            >
              <option value="">Все категории учёта</option>
              <option v-for="(name, id) in balanceTypes" :key="id" :value="parseInt(id)">
                {{ name }}
              </option>
            </select>

            <select
                v-model="sortField"
                class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
            >
              <option value="operation_date">Сортировка по дате</option>
              <option value="name">По названию</option>
              <option value="price">По стоимости</option>
              <option value="condition">По состоянию</option>
              <option value="auditorium_name">По местоположению</option>
              <option value="balance">По категории учёта</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Загрузка -->
      <div v-if="isLoading" class="text-center py-12">
        <svg class="animate-spin mx-auto h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <p class="mt-2 text-gray-600">Загрузка ваших ценностей...</p>
      </div>

      <!-- Ошибка -->
      <div v-if="error" class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
        {{ error }}
      </div>

      <!-- Таблица -->
      <div v-else-if="!isLoading" class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
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
                      class="w-4 h-4 ml-1 transition-transform"
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
                    <router-link :to="`/profile/${username}/inventory/${item.id}`" class="block">
                      <div class="text-sm font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors hover:underline">
                        {{ item.name || `Ценность ${item.id}` }}
                      </div>
                    </router-link>
                    <div class="text-sm text-gray-500">
                      Инв. №: {{ item.inv_number }}
                    </div>
                    <div class="text-xs text-gray-400">
                      Сер. №: {{ item.serial_number }}
                    </div>
                  </div>
                </div>
              </td>

              <!-- Состояние и тип -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div :class="getConditionColor(item.condition)" class="flex-shrink-0 h-8 w-8 rounded-full flex items-center justify-center mr-3">
                    <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                    </svg>
                  </div>
                  <div>
                    <div class="text-sm font-medium text-gray-900">{{ getConditionLabel(item.condition) }}</div>
                    <div class="text-xs text-gray-500">{{ getTypeName(item.thing_type_id) }}</div>
                    <div v-if="item.thing_parent_id" class="text-xs text-blue-600">
                      В составе: {{ getParentName(item.thing_parent_id) }}
                    </div>
                  </div>
                </div>
              </td>

              <!-- Категория учёта -->
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
                  </div>
                </div>
              </td>

              <!-- Местоположение -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-8 w-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                    <svg class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                  </div>
                  <div>
                    <div class="text-sm font-semibold text-gray-900">
                      {{ getAuditoriumName(item.auditorium_id) }}
                    </div>
                    <div v-if="item.auditorium_id" class="text-xs text-gray-500">
                      {{ getAuditoriumDetails(item.auditorium_id) }}
                    </div>
                    <div v-else class="text-xs text-gray-500">
                      Местоположение не указано
                    </div>
                  </div>
                </div>
              </td>

              <!-- Дата приобретения -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900 font-medium">{{ formatDate(item.operation_date) }}</div>
                <div class="text-xs text-gray-500">{{ getYearsInUse(item.operation_date) }} во владении</div>
              </td>

              <!-- Стоимость -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-8 w-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                    <svg
                        class="h-4 w-4 text-green-600"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                    >
                      <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                      />
                    </svg>
                  </div>
                  <div>
                    <div class="text-sm font-semibold text-gray-900">
                      {{ formatCurrency(item.price) }}
                    </div>
                    <div class="text-xs text-gray-500">
                      Балансовая стоимость
                    </div>
                  </div>
                </div>
              </td>
            </tr>
            </tbody>
          </table>
        </div>

        <!-- Пустое состояние -->
        <div v-if="!isLoading && filteredItems.length === 0" class="text-center py-12">
          <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
          </svg>
          <h3 class="mt-2 text-sm font-medium text-gray-900">У вас пока нет материальных ценностей</h3>
        </div>

        <!-- Пагинация -->
        <div v-if="!isLoading && filteredItems.length > 0" class="px-6 py-4 border-t border-gray-200 bg-gray-50">
          <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700">
              Показано с {{ startIndex }} по {{ endIndex }} из {{ filteredItems.length }} записей
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
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'
import { BACKEND_URL } from "@/router.js"

const route = useRoute()
const router = useRouter()
const username = route.params.username

// Реактивные данные
const headers = ref([
  { key: 'name', label: 'Наименование и номер' },
  { key: 'condition', label: 'Состояние и тип' },
  { key: 'balance', label: 'Категория учёта' },
  { key: 'auditorium_name', label: 'Местоположение' },
  { key: 'operation_date', label: 'Дата приобретения' },
  { key: 'price', label: 'Стоимость' },
])

const items = ref([])
const auditoriums = ref([])
const types = ref({})
const conditions = ref({})
const balanceTypes = ref({})
const isLoading = ref(false)
const error = ref(null)

const searchQuery = ref('')
const conditionFilter = ref('')
const balanceFilter = ref('')
const sortField = ref('operation_date')
const sortKey = ref('operation_date')
const sortOrder = ref('desc')

// Пагинация
const currentPage = ref(1)
const itemsPerPage = ref(10)

// Загрузка данных
const loadData = async () => {
  try {
    isLoading.value = true
    error.value = null

    // Загружаем данные параллельно
    const [inventoryResponse, typesResponse, balanceResponse, auditoriumsResponse] = await Promise.all([
      axios.get(`${BACKEND_URL}/api/inventory/${username}`),
      axios.get(`${BACKEND_URL}/api/info/thing-types`),
      axios.get(`${BACKEND_URL}/api/info/balance`),
      axios.get(`${BACKEND_URL}/api/auditoriums`)
    ])

    // Сохраняем характеристики учёта
    if (balanceResponse.data.success) {
      balanceTypes.value = balanceResponse.data.types || {}
    }

    // Сохраняем аудитории
    if (auditoriumsResponse.data.success) {
      auditoriums.value = auditoriumsResponse.data.data || []
    }

    if (inventoryResponse.data.success) {
      items.value = inventoryResponse.data.data.map(item => {
        return {
          id: item.id,
          name: item.name,
          inv_number: item.inv_number,
          serial_number: item.serial_number,
          thing_type_id: item.thing_type_id,
          condition: item.condition,
          balance: item.balance || null,
          thing_parent_id: item.thing_parent_id,
          operation_date: item.operation_date,
          price: item.price,
          auditorium_id: item.auditorium_id,
          comment: item.comment,
          is_composite: item.is_composite,
          is_blocked: item.is_blocked,
          children: item.children || []
        }
      })
    } else {
      throw new Error('Не удалось загрузить список ценностей')
    }

    if (typesResponse.data.success) {
      types.value = typesResponse.data.types || {}
      conditions.value = typesResponse.data.conditions || {}
    }

  } catch (err) {
    error.value = err.message
    console.error('Ошибка загрузки:', err)
  } finally {
    isLoading.value = false
  }
}

onMounted(() => {
  loadData()
})

// Вычисляемые свойства
const filteredItems = computed(() => {
  let filtered = items.value

  // Фильтрация по поиску
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(item =>
        (item.name && item.name.toLowerCase().includes(query)) ||
        (item.serial_number && item.serial_number.toLowerCase().includes(query)) ||
        (item.inv_number && item.inv_number.toString().toLowerCase().includes(query)) ||
        (getTypeName(item.thing_type_id) && getTypeName(item.thing_type_id).toLowerCase().includes(query)) ||
        (getAuditoriumName(item.auditorium_id) && getAuditoriumName(item.auditorium_id).toLowerCase().includes(query)) ||
        (getBalanceLabel(item.balance) && getBalanceLabel(item.balance).toLowerCase().includes(query))
    )
  }

  // Фильтрация по состоянию
  if (conditionFilter.value !== '') {
    const conditionId = parseInt(conditionFilter.value)
    filtered = filtered.filter(item => item.condition === conditionId)
  }

  // Фильтрация по категории учёта
  if (balanceFilter.value !== '') {
    const balanceId = parseInt(balanceFilter.value)
    filtered = filtered.filter(item => item.balance === balanceId)
  }

  // Сортировка
  filtered = [...filtered].sort((a, b) => {
    let aVal = a[sortKey.value]
    let bVal = b[sortKey.value]

    if (sortKey.value === 'operation_date') {
      aVal = new Date(aVal || 0)
      bVal = new Date(bVal || 0)
    } else if (sortKey.value === 'condition') {
      aVal = getConditionLabel(a.condition)
      bVal = getConditionLabel(b.condition)
    } else if (sortKey.value === 'auditorium_name') {
      aVal = getAuditoriumName(a.auditorium_id) || 'Я'
      bVal = getAuditoriumName(b.auditorium_id) || 'Я'
    } else if (sortKey.value === 'balance') {
      aVal = getBalanceLabel(a.balance) || 'Я'
      bVal = getBalanceLabel(b.balance) || 'Я'
    }

    if (aVal < bVal) return sortOrder.value === 'asc' ? -1 : 1
    if (aVal > bVal) return sortOrder.value === 'asc' ? 1 : -1
    return 0
  })

  return filtered
})

// Пагинация
const totalPages = computed(() => Math.ceil(filteredItems.value.length / itemsPerPage.value))

const paginatedItems = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return filteredItems.value.slice(start, end)
})

const startIndex = computed(() => (currentPage.value - 1) * itemsPerPage.value + 1)
const endIndex = computed(() => Math.min(currentPage.value * itemsPerPage.value, filteredItems.value.length))

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

// Методы
const getTypeName = (typeId) => {
  if (!typeId) return 'Не указано'
  return types.value[typeId] || `Тип ${typeId}`
}

const getConditionLabel = (condition) => {
  if (condition === null || condition === undefined) return 'Не указано'
  return conditions.value[condition] || `Состояние ${condition}`
}

const getConditionColor = (condition) => {
  if (condition === null || condition === undefined) return 'bg-gray-400'

  const colors = {
    1: 'bg-green-500',   // Отличное
    2: 'bg-red-500',     // Списано
    3: 'bg-purple-400',  // Требует ремонта
    4: 'bg-green-500',   // Хорошее
    5: 'bg-green-400',   // Рабочее
    6: 'bg-blue-400',    // Новое
    7: 'bg-yellow-400',  // Удовлетворительное
    8: 'bg-orange-400',  // Требует замены
  }

  return colors[condition] || 'bg-gray-400'
}

const getBalanceLabel = (balanceId) => {
  if (balanceId === null || balanceId === undefined) return 'Не указано'

  if (Object.keys(balanceTypes.value).length > 0) {
    return balanceTypes.value[balanceId] || `Категория ${balanceId}`
  }

  const staticBalances = {
    1: 'Основное средство',
    2: 'За балансом'
  }
  return staticBalances[balanceId] || `Категория ${balanceId}`
}

const getAuditoriumName = (auditoriumId) => {
  if (!auditoriumId) return 'Не указано'
  const auditorium = auditoriums.value.find(a => a.id === auditoriumId)
  return auditorium ? `${auditorium.name} (${auditorium.number})` : `Аудитория ${auditoriumId}`
}

const getAuditoriumDetails = (auditoriumId) => {
  if (!auditoriumId) return ''
  const auditorium = auditoriums.value.find(a => a.id === auditoriumId)
  if (!auditorium) return ''

  const parts = []
  if (auditorium.floor) parts.push(`${auditorium.floor} этаж`)
  return parts.join(', ')
}

const getParentName = (parentId) => {
  if (!parentId) return ''
  const parent = items.value.find(item => item.id === parentId)
  return parent ? parent.name : `ID ${parentId}`
}

const sortTable = (key) => {
  if (sortKey.value === key) {
    sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc'
  } else {
    sortKey.value = key
    sortOrder.value = 'asc'
  }
}

const prevPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--
  }
}

const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++
  }
}

const goToPage = (page) => {
  currentPage.value = page
}

const formatDate = (dateString) => {
  if (!dateString) return 'Не указана'
  try {
    return new Date(dateString).toLocaleDateString('ru-RU')
  } catch (e) {
    return dateString
  }
}

const formatCurrency = (amount) => {
  if (!amount && amount !== 0) return '0 ₽'
  return new Intl.NumberFormat('ru-RU', {
    style: 'currency',
    currency: 'RUB',
    minimumFractionDigits: 2
  }).format(amount)
}

const getYearsInUse = (dateString) => {
  if (!dateString) return 'Неизвестно'
  try {
    const now = new Date()
    const date = new Date(dateString)
    const years = now.getFullYear() - date.getFullYear()
    const months = now.getMonth() - date.getMonth()

    if (years === 0) {
      return months === 0 ? '<1 мес.' : `${months} ${getMonthsText(months)}`
    }
    return `${years} ${getYearsText(years)}`
  } catch (e) {
    return 'Неизвестно'
  }
}

const getYearsText = (years) => {
  if (years % 10 === 1 && years % 100 !== 11) return 'год'
  if ([2, 3, 4].includes(years % 10) && ![12, 13, 14].includes(years % 100)) return 'года'
  return 'лет'
}

const getMonthsText = (months) => {
  if (months % 10 === 1 && months % 100 !== 11) return 'месяц'
  if ([2, 3, 4].includes(months % 10) && ![12, 13, 14].includes(months % 100)) return 'месяца'
  return 'месяцев'
}

// Watchers
watch([searchQuery, conditionFilter, balanceFilter], () => {
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