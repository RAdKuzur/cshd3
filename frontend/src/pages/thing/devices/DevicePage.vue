<template>
  <div class="p-6 bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <div class="max-w-8xl mx-auto">
      <!-- Заголовок и элементы управления -->
      <div class="mb-8">
        <div class="flex justify-between items-center">
          <div class="flex items-center gap-4">
            <router-link
                to="/things"
                class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:text-blue-600
             transition-colors border border-gray-300 rounded-lg hover:border-blue-400"
            >
              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
              </svg>
              Назад
            </router-link>
            <div>
              <h1 class="text-3xl font-bold text-gray-900">Устройства</h1>
              <p class="text-gray-600 mt-2">Всего устройств: {{ filteredItems.length }}</p>
            </div>
          </div>
          <router-link to="/things/devices/create">
            <button class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-6 py-3 rounded-lg font-semibold shadow-sm transition-all duration-200 flex items-center gap-2 hover:shadow-md">
              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
              </svg>
              Добавить устройство
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
                  placeholder="Поиск по названию, серийному номеру, модели..."
                  class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm bg-white"
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
                v-model="modelFilter"
                class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm bg-white"
            >
              <option value="">Все модели</option>
              <option v-for="model in models" :key="model.id" :value="model.id">
                {{ model.name }} ({{ getCompanyName(model.company_id) }})
              </option>
            </select>

            <select
                v-model="typeFilter"
                class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm bg-white"
            >
              <option value="">Все типы</option>
              <option v-for="(label, id) in thingTypes" :key="id" :value="parseInt(id)">
                {{ label }}
              </option>
            </select>

            <select
                v-model="sortField"
                class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm bg-white"
            >
              <option value="name">Сортировка по названию</option>
              <option value="serial_number">По серийному номеру</option>
              <option value="model_name">По модели</option>
              <option value="thing_type_id">По типу</option>
              <option value="price">По цене</option>
              <option value="operation_date">По дате ввода</option>
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
            <thead class="bg-gradient-to-r from-blue-500 to-indigo-600">
            <tr>
              <th
                  v-for="header in headers"
                  :key="header.key"
                  class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider cursor-pointer hover:bg-indigo-700 transition-colors"
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
              <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider">
                Действия
              </th>
            </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
            <tr
                v-for="item in paginatedItems"
                :key="item.id"
                class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-200 group"
            >
              <!-- Название устройства -->
              <td class="px-6 py-4">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-lg flex items-center justify-center shadow-sm">
                    <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                    </svg>
                  </div>
                  <div class="ml-4">
                    <div class="text-lg font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors">
                      {{ item.name }}
                    </div>
                    <div v-if="item.serial_number" class="text-xs text-gray-500">
                      S/N: {{ item.serial_number }}
                    </div>
                  </div>
                </div>
              </td>

              <!-- Модель и производитель -->
              <td class="px-6 py-4">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-8 w-8 bg-gradient-to-r from-green-100 to-emerald-100 rounded-lg flex items-center justify-center mr-3 shadow-sm">
                    <svg class="h-4 w-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                  </div>
                  <div>
                    <div class="text-sm font-semibold text-gray-900">
                      {{ item.model_name || 'Не указана' }}
                    </div>
                    <div class="text-xs text-gray-500">
                      {{ item.company_name || 'Производитель не указан' }}
                    </div>
                  </div>
                </div>
              </td>

              <!-- Тип устройства -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div :class="getTypeColor(item.thing_type_id)" class="flex-shrink-0 h-8 w-8 rounded-lg flex items-center justify-center mr-3 shadow-sm">
                    <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                  </div>
                  <div>
                    <div class="text-sm font-medium text-gray-900">
                      {{ getThingTypeLabel(item.thing_type_id) }}
                    </div>
                    <div class="text-xs text-gray-500">
                      Тип устройства
                    </div>
                  </div>
                </div>
              </td>

              <!-- Цена -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-semibold text-gray-900">
                  {{ formatPrice(item.price) }}
                </div>
                <div class="text-xs text-gray-500">
                  Цена
                </div>
              </td>

              <!-- Дата ввода -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">
                  {{ formatDate(item.operation_date) }}
                </div>
                <div class="text-xs text-gray-500">
                  Дата ввода
                </div>
              </td>

              <!-- Действия -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center space-x-2">
                  <!-- Кнопка просмотра -->
                  <router-link :to="`/things/devices/view/${item.device_id}`">
                    <button class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Просмотреть">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                      </svg>
                    </button>
                  </router-link>

                  <!-- Кнопка редактирования -->
                  <router-link :to="`/things/devices/edit/${item.device_id}`">
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
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
          </svg>
          <h3 class="mt-2 text-sm font-medium text-gray-900">Устройства не найдены</h3>
          <p class="mt-1 text-sm text-gray-500">
            {{ searchQuery ? 'Попробуйте изменить параметры поиска' : 'Добавьте первое устройство' }}
          </p>
        </div>

        <!-- Пагинация -->
        <div v-if="!isLoading && filteredItems.length > 0" class="px-6 py-4 border-t border-gray-200 bg-gray-50">
          <div class="flex items-center justify-between flex-wrap gap-4">
            <div class="text-sm text-gray-700">
              Показано с {{ startIndex }} по {{ endIndex }} из {{ filteredItems.length }} записей
            </div>
            <div class="flex items-center space-x-2">
              <button
                  @click="prevPage"
                  :disabled="currentPage === 1"
                  class="px-3 py-1 rounded-md border border-gray-300 text-sm font-medium transition-colors"
                  :class="currentPage === 1
                  ? 'text-gray-400 cursor-not-allowed bg-gray-100'
                  : 'text-gray-700 hover:bg-gray-100 hover:border-gray-400'"
              >
                Назад
              </button>

              <div class="flex space-x-1">
                <button
                    v-for="page in visiblePages"
                    :key="page"
                    @click="goToPage(page)"
                    class="w-8 h-8 rounded-md text-sm font-medium transition-all"
                    :class="page === currentPage
                    ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-sm'
                    : 'text-gray-700 hover:bg-gray-100 hover:shadow-sm'"
                >
                  {{ page }}
                </button>
                <span v-if="showEllipsis" class="px-2 py-1 text-gray-500">...</span>
              </div>

              <button
                  @click="nextPage"
                  :disabled="currentPage === totalPages"
                  class="px-3 py-1 rounded-md border border-gray-300 text-sm font-medium transition-colors"
                  :class="currentPage === totalPages
                  ? 'text-gray-400 cursor-not-allowed bg-gray-100'
                  : 'text-gray-700 hover:bg-gray-100 hover:border-gray-400'"
              >
                Вперед
              </button>
            </div>

            <select
                v-model="itemsPerPage"
                class="px-3 py-1 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white"
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
  { key: 'name', label: 'Название устройства' },
  { key: 'model_name', label: 'Модель и производитель' },
  { key: 'thing_type_id', label: 'Тип устройства' },
  { key: 'price', label: 'Цена' },
  { key: 'operation_date', label: 'Дата ввода' }
])

const devices = ref([])
const things = ref([])
const models = ref([])
const companies = ref([])
const thingTypes = ref({})
const auditoriums = ref([])
const isLoading = ref(false)
const error = ref(null)

// Фильтры и сортировка
const searchQuery = ref('')
const modelFilter = ref('')
const typeFilter = ref('')
const sortField = ref('name')
const sortKey = ref('name')
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
    const [
      devicesResponse,
      thingsResponse,
      modelsResponse,
      companiesResponse,
      typesResponse
    ] = await Promise.all([
      axios.get(BACKEND_URL + '/api/devices'),
      axios.get(BACKEND_URL + '/api/things'),
      axios.get(BACKEND_URL + '/api/models'),
      axios.get(BACKEND_URL + '/api/companies'),
      axios.get(BACKEND_URL + '/api/info/thing-types')
    ])

    // Сохраняем основные данные
    if (companiesResponse.data.success) {
      companies.value = companiesResponse.data.data || []
    }

    if (modelsResponse.data.success) {
      models.value = modelsResponse.data.data || []
    }

    if (typesResponse.data.success) {
      thingTypes.value = typesResponse.data.types || {}
    }

    // Объединяем данные устройств и вещей
    if (devicesResponse.data.success && thingsResponse.data.success) {
      const devicesData = devicesResponse.data.data || []
      const thingsData = thingsResponse.data.data || []

      devices.value = devicesData.map(device => {
        const thing = thingsData.find(t => t.id == device.thing_id)
        const model = models.value.find(m => m.id === device.model_id)

        return {
          device_id: device.id,
          id: device.id,
          thing_id: device.thing_id,
          model_id: device.model_id,
          model_name: model?.name || 'Не указана',
          company_name: model ? getCompanyName(model.company_id) : 'Не указан',
          ...thing
        }
      })
    } else {
      throw new Error('Не удалось загрузить данные устройств')
    }

  } catch (err) {
    error.value = err.response?.data?.message || err.message || 'Ошибка соединения'
  } finally {
    isLoading.value = false
  }
}

onMounted(() => {
  loadData()
})

// Вспомогательные функции
const getCompanyName = (companyId) => {
  const company = companies.value.find(c => c.id === companyId)
  return company ? company.name : null
}

const getThingTypeLabel = (typeId) => {
  if (typeId === null || typeId === undefined) return 'Не указан'
  return thingTypes.value[typeId] || `Тип ${typeId}`
}

const getTypeColor = (typeId) => {
  const colors = [
    'bg-gradient-to-r from-blue-500 to-indigo-500',
    'bg-gradient-to-r from-green-500 to-emerald-500',
    'bg-gradient-to-r from-purple-500 to-pink-500',
    'bg-gradient-to-r from-red-500 to-orange-500',
    'bg-gradient-to-r from-yellow-500 to-amber-500',
    'bg-gradient-to-r from-teal-500 to-cyan-500',
    'bg-gradient-to-r from-indigo-500 to-blue-500',
    'bg-gradient-to-r from-pink-500 to-rose-500',
    'bg-gradient-to-r from-emerald-500 to-green-500',
    'bg-gradient-to-r from-orange-500 to-red-500'
  ]
  const index = typeId % colors.length
  return colors[index] || 'bg-gradient-to-r from-gray-500 to-gray-600'
}

const formatDate = (dateString) => {
  if (!dateString) return 'Не указана'
  const date = new Date(dateString)
  return date.toLocaleDateString('ru-RU')
}

const formatPrice = (price) => {
  if (!price) return '0 ₽'
  return new Intl.NumberFormat('ru-RU', {
    style: 'currency',
    currency: 'RUB',
    minimumFractionDigits: 0
  }).format(price)
}

// Вычисляемые свойства
const filteredItems = computed(() => {
  let filtered = devices.value

  // Фильтрация по поиску
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(item =>
        (item.name && item.name.toLowerCase().includes(query)) ||
        (item.serial_number && item.serial_number.toLowerCase().includes(query)) ||
        (item.model_name && item.model_name.toLowerCase().includes(query)) ||
        (item.company_name && item.company_name.toLowerCase().includes(query)) ||
        (getThingTypeLabel(item.thing_type_id) && getThingTypeLabel(item.thing_type_id).toLowerCase().includes(query))
    )
  }

  // Фильтрация по модели
  if (modelFilter.value !== '') {
    const modelId = parseInt(modelFilter.value)
    filtered = filtered.filter(item => item.model_id === modelId)
  }

  // Фильтрация по типу
  if (typeFilter.value !== '') {
    const typeId = parseInt(typeFilter.value)
    filtered = filtered.filter(item => item.thing_type_id === typeId)
  }

  // Сортировка
  filtered = [...filtered].sort((a, b) => {
    let aVal = a[sortKey.value]
    let bVal = b[sortKey.value]

    if (sortKey.value === 'price') {
      aVal = aVal || 0
      bVal = bVal || 0
    } else if (sortKey.value === 'operation_date') {
      aVal = aVal ? new Date(aVal).getTime() : 0
      bVal = bVal ? new Date(bVal).getTime() : 0
    } else if (sortKey.value === 'model_name') {
      aVal = a.model_name || ''
      bVal = b.model_name || ''
    } else if (sortKey.value === 'thing_type_id') {
      aVal = getThingTypeLabel(a.thing_type_id) || ''
      bVal = getThingTypeLabel(b.thing_type_id) || ''
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
  if (confirm(`Вы уверены, что хотите удалить устройство "${item.name}"?`)) {
    try {
      // Удаляем устройство и связанную вещь
      await axios.delete(`${BACKEND_URL}/api/devices/${item.id}`)
      await axios.delete(`${BACKEND_URL}/api/things/${item.thing_id}`)

      // Удаляем из локального списка
      const index = devices.value.findIndex(i => i.id === item.id)
      if (index !== -1) {
        devices.value.splice(index, 1)
      }

      alert('Устройство успешно удалено')
    } catch (err) {
      alert('Не удалось удалить устройство')
    }
  }
}

// Сброс пагинации при изменении фильтров
watch([searchQuery, modelFilter, typeFilter], () => {
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

<style scoped>
/* Анимация строк таблицы */
tbody tr {
  animation: slideIn 0.3s ease forwards;
  opacity: 0;
  transform: translateY(10px);
}

@keyframes slideIn {
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

tbody tr:nth-child(1) { animation-delay: 0.05s; }
tbody tr:nth-child(2) { animation-delay: 0.1s; }
tbody tr:nth-child(3) { animation-delay: 0.15s; }
tbody tr:nth-child(4) { animation-delay: 0.2s; }
tbody tr:nth-child(5) { animation-delay: 0.25s; }
tbody tr:nth-child(6) { animation-delay: 0.3s; }
tbody tr:nth-child(7) { animation-delay: 0.35s; }
tbody tr:nth-child(8) { animation-delay: 0.4s; }
tbody tr:nth-child(9) { animation-delay: 0.45s; }
tbody tr:nth-child(10) { animation-delay: 0.5s; }

/* Улучшенные hover-эффекты */
tr:hover {
  transform: translateY(-1px);
  box-shadow: 0 4px 12px -2px rgba(59, 130, 246, 0.1);
}

thead tr:hover {
  transform: none;
  box-shadow: none;
}

/* Кастомный скроллбар для таблицы */
.overflow-x-auto::-webkit-scrollbar {
  height: 6px;
}

.overflow-x-auto::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 3px;
}

.overflow-x-auto::-webkit-scrollbar-thumb {
  background: #c1c1c1;
  border-radius: 3px;
}

.overflow-x-auto::-webkit-scrollbar-thumb:hover {
  background: #a1a1a1;
}
</style>