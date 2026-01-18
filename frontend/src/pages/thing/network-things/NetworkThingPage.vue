<template>
  <div class="p-6 bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <div class="max-w-8xl mx-auto">
      <!-- Заголовок и элементы управления -->
      <div class="mb-8">
        <div class="flex justify-between items-center">
          <div>
            <h1 class="text-3xl font-bold text-gray-900">Сетевые устройства</h1>
            <p class="text-gray-600 mt-2">Всего устройств: {{ filteredItems.length }}</p>
          </div>
          <router-link to="/things/network/create">
            <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-semibold shadow-sm transition-colors">
              + Добавить сетевое устройство
            </button>
          </router-link>
        </div>

        <!-- Панель поиска и фильтров -->
        <div class="mt-6 flex gap-4 flex-wrap">
          <div class="flex-1 min-w-[300px]">
            <div class="relative">
              <input
                  v-model="searchQuery"
                  type="text"
                  placeholder="Поиск по IP-адресу, телефону, инвентарному номеру, комментарию..."
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
                v-model="typeFilter"
                class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
            >
              <option value="">Все типы</option>
              <option v-for="(label, id) in networkTypes" :key="id" :value="parseInt(id)">
                {{ label }}
              </option>
            </select>

            <select
                v-model="auditoriumFilter"
                class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
            >
              <option value="">Все аудитории</option>
              <option v-for="auditorium in auditoriums" :key="auditorium.id" :value="auditorium.id">
                {{ auditorium.name }}
              </option>
            </select>

            <select
                v-model="sortField"
                class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
            >
              <option value="ip_address">Сортировка по IP</option>
              <option value="phone_number">По телефону</option>
              <option value="type">По типу</option>
              <option value="inv_number">По инв. номеру</option>
              <option value="auditorium_name">По аудитории</option>
              <option value="comment">По комментарию</option>
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
        <p class="mt-2 text-gray-600">Загрузка данных...</p>
      </div>

      <!-- Сообщение об ошибке -->
      <div v-else-if="error" class="bg-red-50 border border-red-200 rounded-xl p-6 mb-6">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
            </svg>
          </div>
          <div class="ml-3">
            <h3 class="text-sm font-medium text-red-800">Ошибка загрузки</h3>
            <p class="text-sm text-red-700 mt-1">{{ error }}</p>
          </div>
        </div>
      </div>

      <!-- Таблица -->
      <div v-else class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
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
              <!-- IP-адрес -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3" />
                    </svg>
                  </div>
                  <div class="ml-4">
                    <div class="text-sm font-semibold text-gray-900">
                      {{ item.ip_address || 'Не указан' }}
                    </div>
                    <div class="text-xs text-gray-500">
                      ID устройства: {{ item.thing_id }}
                    </div>
                  </div>
                </div>
              </td>

              <!-- Номер телефона -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-8 w-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                    <svg class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                  </div>
                  <div>
                    <div class="text-sm font-medium text-gray-900">
                      {{ item.phone_number || 'Не указан' }}
                    </div>
                  </div>
                </div>
              </td>

              <!-- Тип устройства -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div :class="getTypeColor(item.type)" class="flex-shrink-0 h-8 w-8 rounded-lg flex items-center justify-center mr-3">
                    <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                  </div>
                  <div>
                    <div class="text-sm font-medium text-gray-900">
                      {{ getNetworkTypeLabel(item.type) }}
                    </div>
                    <div class="text-xs text-gray-500">
                      Тип устройства
                    </div>
                  </div>
                </div>
              </td>

              <!-- Инвентарный номер -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-semibold text-gray-900">
                  {{ item.inv_number }}
                </div>
                <div class="text-xs text-gray-500">
                  Инвентарный номер
                </div>
              </td>

              <!-- Аудитория -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-8 w-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                    <svg class="h-4 w-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                  </div>
                  <div>
                    <div class="text-sm font-medium text-gray-900">
                      {{ item.auditorium_name || 'Не указана' }}
                    </div>
                    <div v-if="item.auditorium_floor" class="text-xs text-gray-500">
                      {{ item.auditorium_floor }}
                    </div>
                  </div>
                </div>
              </td>

              <!-- Комментарий -->
              <td class="px-6 py-4">
                <div class="text-sm text-gray-900">
                  {{ item.comment || 'Нет комментария' }}
                </div>
              </td>

              <!-- Действия -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center space-x-2">
                  <!-- Кнопка просмотра -->
                  <router-link :to="`/things/network/view/${item.id}`">
                    <button class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Просмотреть">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                      </svg>
                    </button>
                  </router-link>

                  <!-- Кнопка редактирования -->
                  <router-link :to="`/things/network/edit/${item.id}`">
                    <button class="p-2 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Редактировать">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                      </svg>
                    </button>
                  </router-link>

                  <!-- Кнопка удаления -->
                  <button
                      @click="confirmDelete(item)"
                      class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                      title="Удалить"
                  >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                  </button>
                </div>
              </td>
            </tr>
            </tbody>
          </table>
        </div>

        <!-- Пустое состояние -->
        <div v-if="!isLoading && filteredItems.length === 0" class="text-center py-12">
          <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <h3 class="mt-2 text-sm font-medium text-gray-900">Сетевые устройства не найдены</h3>
          <p class="mt-1 text-sm text-gray-500">Попробуйте изменить параметры поиска или добавьте новое устройство</p>
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
import axios from 'axios'
import { BACKEND_URL } from "@/router.js"

// Реактивные данные
const headers = ref([
  { key: 'ip_address', label: 'IP-адрес' },
  { key: 'phone_number', label: 'Телефон' },
  { key: 'type', label: 'Тип устройства' },
  { key: 'inv_number', label: 'Инвентарный номер' },
  { key: 'auditorium_name', label: 'Аудитория' },
  { key: 'comment', label: 'Комментарий' },
  { key: 'actions', label: 'Действия' }
])

const networkThings = ref([])
const networkTypes = ref({})
const auditoriums = ref([])
const isLoading = ref(false)
const error = ref(null)

const searchQuery = ref('')
const typeFilter = ref('')
const auditoriumFilter = ref('')
const sortField = ref('ip_address')
const sortKey = ref('ip_address')
const sortOrder = ref('asc')

// Пагинация
const currentPage = ref(1)
const itemsPerPage = ref(10)

// Загрузка данных
const loadData = async () => {
  try {
    isLoading.value = true
    error.value = null

    // Загружаем данные параллельно
    const [networkResponse, typesResponse, auditoriumsResponse] = await Promise.all([
      axios.get(BACKEND_URL + '/api/network-things'),
      axios.get(BACKEND_URL + '/api/info/thing-types'),
      axios.get(BACKEND_URL + '/api/auditoriums')
    ])

    // Сохраняем аудитории
    if (auditoriumsResponse.data.success) {
      auditoriums.value = auditoriumsResponse.data.data || []
    }

    if (networkResponse.data.success) {
      networkThings.value = networkResponse.data.data.map(item => {
        // Находим аудиторию по ID
        const auditorium = auditoriums.value.find(a => a.id === item.auditorium_id)
        const auditoriumName = auditorium ? auditorium.name : 'Не указана'
        const auditoriumFloor = auditorium ? getFloorText(auditorium.floor) : ''

        return {
          id: item.id,
          thing_id: item.thing_id,
          ip_address: item.ip_address,
          phone_number: item.phone_number,
          comment: item.comment,
          inv_number: item.inv_number,
          type: item.type,
          auditorium_id: item.auditorium_id,
          auditorium_name: auditoriumName,
          auditorium_floor: auditoriumFloor
        }
      })
    } else {
      throw new Error('Не удалось загрузить список сетевых устройств')
    }

    if (typesResponse.data.success) {
      networkTypes.value = typesResponse.data.types || {}
    }

  } catch (err) {
    error.value = err.message
  } finally {
    isLoading.value = false
  }
}

onMounted(() => {
  loadData()
})

// Вычисляемые свойства
const filteredItems = computed(() => {
  let filtered = networkThings.value

  // Фильтрация по поиску
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(item =>
        (item.ip_address && item.ip_address.toLowerCase().includes(query)) ||
        (item.phone_number && item.phone_number.toLowerCase().includes(query)) ||
        (item.inv_number && item.inv_number.toString().toLowerCase().includes(query)) ||
        (item.comment && item.comment.toLowerCase().includes(query)) ||
        (getNetworkTypeLabel(item.type) && getNetworkTypeLabel(item.type).toLowerCase().includes(query)) ||
        (item.auditorium_name && item.auditorium_name.toLowerCase().includes(query))
    )
  }

  // Фильтрация по типу устройства
  if (typeFilter.value !== '') {
    const typeId = parseInt(typeFilter.value)
    filtered = filtered.filter(item => item.type === typeId)
  }

  // Фильтрация по аудитории
  if (auditoriumFilter.value !== '') {
    const auditoriumId = parseInt(auditoriumFilter.value)
    filtered = filtered.filter(item => item.auditorium_id === auditoriumId)
  }

  // Сортировка
  filtered = [...filtered].sort((a, b) => {
    let aVal = a[sortKey.value]
    let bVal = b[sortKey.value]

    if (sortKey.value === 'ip_address') {
      // Сортировка IP-адресов
      const ipToNum = (ip) => {
        if (!ip) return 0
        return ip.split('.').reduce((acc, octet) => (acc << 8) + parseInt(octet), 0)
      }
      aVal = ipToNum(aVal)
      bVal = ipToNum(bVal)
    } else if (sortKey.value === 'type') {
      // Сортировка по типу устройства
      aVal = getNetworkTypeLabel(a.type) || ''
      bVal = getNetworkTypeLabel(b.type) || ''
    } else if (sortKey.value === 'inv_number') {
      // Сортировка по инвентарному номеру как числу
      aVal = parseInt(aVal) || 0
      bVal = parseInt(bVal) || 0
    } else if (sortKey.value === 'auditorium_name') {
      // Сортировка по аудитории
      aVal = a.auditorium_name || 'Я'
      bVal = b.auditorium_name || 'Я'
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
const getNetworkTypeLabel = (typeId) => {
  if (typeId === null || typeId === undefined) return 'Не указан'
  return networkTypes.value[typeId] || `Тип ${typeId}`
}

const getTypeColor = (typeId) => {
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
  return colors[index] || 'bg-gray-500'
}

// Форматируем текст для отображения этажа
const getFloorText = (floorNumber) => {
  if (!floorNumber && floorNumber !== 0) return ''

  // Правильное склонение для слова "этаж"
  const lastDigit = floorNumber % 10
  const lastTwoDigits = floorNumber % 100

  if (lastTwoDigits >= 11 && lastTwoDigits <= 19) {
    return `${floorNumber} этаж`
  }

  switch (lastDigit) {
    case 1:
      return `${floorNumber} этаж`
    case 2:
    case 3:
    case 4:
      return `${floorNumber} этажа`
    default:
      return `${floorNumber} этаж`
  }
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

const confirmDelete = async (item) => {
  if (confirm(`Вы уверены, что хотите удалить сетевое устройство ${item.ip_address || item.inv_number}?`)) {
    try {
      await axios.delete(`${BACKEND_URL}/api/network-things/${item.id}`)
      // Удаляем из локального списка
      const index = networkThings.value.findIndex(i => i.id === item.id)
      if (index !== -1) {
        networkThings.value.splice(index, 1)
      }
    } catch (err) {
      alert('Не удалось удалить устройство')
    }
  }
}

// Сброс пагинации при изменении фильтров
watch([searchQuery, typeFilter, auditoriumFilter], () => {
  currentPage.value = 1
})

watch([sortField], () => {
  sortKey.value = sortField.value
  sortOrder.value = 'asc'
})

watch(itemsPerPage, () => {
  currentPage.value = 1
})
</script>