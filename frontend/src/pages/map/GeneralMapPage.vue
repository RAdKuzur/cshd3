<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-4 md:p-6">
    <div class="max-w-7xl mx-auto relative">
      <!-- Слайдборд -->
      <div
          class="slideboard"
          :class="{ 'slideboard-open': selectedAuditorium }"
      >
        <div class="slideboard-content">
          <!-- Шапка слайдборда -->
          <div class="sticky top-0 z-10 bg-white border-b border-gray-200 px-6 py-4">
            <div class="flex items-center justify-between">
              <div class="flex items-center">
                <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center mr-3">
                  <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                  </svg>
                </div>
                <div>
                  <h2 class="text-xl font-bold text-gray-900">{{ selectedAuditorium?.auditorium_name }}</h2>
                  <div class="flex items-center mt-1">
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full mr-2">
                      {{ selectedAuditorium?.floor }} этаж
                    </span>
                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                      {{ getBuildingFromName(selectedAuditorium?.auditorium_name) }}
                    </span>
                  </div>
                </div>
              </div>
              <button
                  @click="selectedAuditorium = null"
                  class="text-gray-400 hover:text-gray-600 transition-colors p-2 hover:bg-gray-100 rounded-lg"
              >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
          </div>

          <!-- Содержимое слайдборда -->
          <div class="p-6 overflow-y-auto h-[calc(100vh-200px)]">
            <!-- Статистика -->
            <div class="grid grid-cols-3 gap-4 mb-6">
              <div class="bg-blue-50 rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-blue-700">{{ selectedAuditorium?.things?.length || 0 }}</div>
                <div class="text-sm text-blue-600 mt-1">Всего объектов</div>
              </div>
              <div class="bg-green-50 rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-green-700">{{ workingThingsCount }}</div>
                <div class="text-sm text-green-600 mt-1">Исправно</div>
              </div>
              <div class="bg-amber-50 rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-amber-700">{{ selectedAuditorium?.things?.length - workingThingsCount }}</div>
                <div class="text-sm text-amber-600 mt-1">Требует внимания</div>
              </div>
            </div>

            <!-- Список объектов -->
            <div class="mb-8">
              <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Объекты учёта
              </h3>

              <div v-if="!selectedAuditorium?.things?.length" class="bg-gray-50 rounded-xl p-6 text-center">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-gray-600">В кабинете нет объектов учёта</p>
              </div>

              <div v-else class="space-y-3">
                <div
                    v-for="thing in selectedAuditorium.things"
                    :key="thing.id"
                    class="group bg-white border border-gray-200 rounded-lg p-4 hover:border-blue-300 hover:shadow-sm transition-all cursor-pointer"
                    @click="viewThing(thing.id)"
                >
                  <div class="flex items-start justify-between">
                    <div class="flex-1">
                      <div class="flex items-center mb-2">
                        <div :class="getConditionColor(thing.condition)" class="w-2 h-2 rounded-full mr-2"></div>
                        <h4 class="font-medium text-gray-900">{{ thing.name || `Объект ${thing.id}` }}</h4>
                      </div>
                      <div class="grid grid-cols-2 gap-2 text-sm text-gray-600">
                        <div class="flex items-center">
                          <span class="font-medium mr-1">Инв. №:</span>
                          <span class="font-mono text-xs">{{ thing.inv_number }}</span>
                        </div>
                        <div class="flex items-center">
                          <span class="font-medium mr-1">Сер. №:</span>
                          <span class="font-mono text-xs">{{ thing.serial_number }}</span>
                        </div>
                        <div class="flex items-center">
                          <span class="font-medium mr-1">Тип:</span>
                          <span>{{ getTypeName(thing.thing_type_id) }}</span>
                        </div>
                        <!-- Добавляем характеристику учёта -->
                        <div class="flex items-center">
                          <span class="font-medium mr-1">Учёт:</span>
                          <span class="text-indigo-600 font-medium">{{ getBalanceLabel(thing.balance) }}</span>
                        </div>
                      </div>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                  </div>
                </div>
              </div>
            </div>

            <!-- Детали кабинета -->
            <div>
              <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h1m0-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Информация о кабинете
              </h3>

              <div class="bg-gray-50 rounded-xl p-5">
                <div class="space-y-4">
                  <div class="grid grid-cols-2 gap-4">
                    <div>
                      <div class="text-sm text-gray-500 mb-1">Корпус</div>
                      <div class="font-medium">{{ getBuildingFromName(selectedAuditorium?.auditorium_name) }}</div>
                    </div>
                    <div>
                      <div class="text-sm text-gray-500 mb-1">Этаж</div>
                      <div class="font-medium">{{ selectedAuditorium?.floor }}</div>
                    </div>
                  </div>
                  <div>
                    <div class="text-sm text-gray-500 mb-1">Название кабинета</div>
                    <div class="font-medium">{{ selectedAuditorium?.auditorium_name }}</div>
                  </div>
                  <div>
                    <div class="text-sm text-gray-500 mb-1">Всего объектов учёта</div>
                    <div class="font-medium">{{ selectedAuditorium?.things?.length || 0 }} единиц</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Оверлей при открытом слайдборде -->
      <div
          v-if="selectedAuditorium"
          class="slideboard-overlay"
          @click="selectedAuditorium = null"
      ></div>

      <!-- Заголовок -->
      <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Интерактивный план здания</h1>
        <p class="text-xl text-gray-600">Нажмите на кабинет для просмотра информации</p>
      </div>

      <!-- Панель управления -->
      <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 mb-8">
        <div class="flex flex-col lg:flex-row items-center justify-between gap-6">
          <!-- Поиск -->
          <div class="w-full lg:w-auto">
            <div class="relative max-w-md">
              <input
                  v-model="searchQuery"
                  type="text"
                  placeholder="Поиск..."
                  class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white shadow-sm"
              >
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </div>
            </div>
          </div>

          <!-- Фильтры -->
          <div class="flex flex-wrap gap-3">
            <select
                v-model="buildingFilter"
                class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
            >
              <option value="">Все корпуса</option>
              <option v-for="building in buildings" :key="building" :value="building">
                {{ building }}
              </option>
            </select>

            <select
                v-model="floorFilter"
                class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
            >
              <option value="">Все этажи</option>
              <option v-for="floor in floors" :key="floor" :value="floor">
                {{ floor }} этаж
              </option>
            </select>
          </div>
        </div>
      </div>

      <!-- Индикатор загрузки -->
      <div v-if="isLoading" class="flex justify-center items-center h-64">
        <div class="text-center">
          <svg class="animate-spin mx-auto h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          <p class="mt-2 text-gray-600">Загрузка данных...</p>
        </div>
      </div>

      <!-- Ошибка -->
      <div v-else-if="error" class="bg-red-50 border border-red-200 rounded-lg p-6 mb-8">
        <div class="flex items-center">
          <svg class="w-5 h-5 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span class="text-red-800">{{ error }}</span>
        </div>
      </div>

      <!-- Карта здания -->
      <div v-else class="bg-white rounded-2xl shadow-xl border border-gray-200 p-8">
        <!-- Табы этажей -->
        <div class="mb-8">
          <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg p-1">
            <div class="flex overflow-x-auto">
              <button
                  v-for="floor in uniqueFloors"
                  :key="floor"
                  class="flex-1 min-w-[120px] px-4 py-3 font-semibold rounded-md transition-all duration-200 whitespace-nowrap"
                  :class="{
                    'bg-indigo-100 text-indigo-800 shadow-lg': activeFloor === floor,
                    'text-white hover:text-indigo-100': activeFloor !== floor
                  }"
                  @click="setActiveFloor(floor)"
              >
                <div class="flex items-center justify-center">
                  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                  </svg>
                  {{ floor }} этаж
                </div>
              </button>
            </div>
          </div>
        </div>

        <!-- Сообщение при отсутствии кабинетов -->
        <div v-if="filteredAuditoriums.length === 0" class="text-center py-16">
          <svg class="w-24 h-24 text-gray-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <h3 class="text-2xl font-semibold text-gray-600 mb-3">Кабинеты не найдены</h3>
          <p class="text-gray-500 text-lg">Попробуйте изменить параметры поиска или выберите другой этаж</p>
        </div>

        <!-- Сетка кабинетов -->
        <div v-else class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
          <div
              v-for="auditorium in filteredAuditoriums"
              :key="auditorium.auditorium_id"
              class="auditorium-card group"
              :class="{ 'auditorium-card-active': selectedAuditorium?.auditorium_id === auditorium.auditorium_id }"
              @click="selectAuditorium(auditorium)"
          >
            <!-- Индикатор выбора -->
            <div
                v-if="selectedAuditorium?.auditorium_id === auditorium.auditorium_id"
                class="absolute top-2 right-2"
            >
              <div class="bg-indigo-600 text-white p-1 rounded-full">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
              </div>
            </div>

            <!-- Заголовок кабинета -->
            <div class="flex items-center justify-between mb-3">
              <h3 class="text-lg font-bold text-gray-900">{{ auditorium.auditorium_name }}</h3>
              <span class="px-2 py-1 bg-indigo-100 text-indigo-700 text-xs font-semibold rounded">
                {{ getBuildingFromName(auditorium.auditorium_name) }}
              </span>
            </div>

            <!-- Информация о кабинете -->
            <div class="space-y-2">
              <div class="flex items-center">
                <svg class="w-3 h-3 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span class="text-xs text-gray-600">{{ auditorium.floor }} этаж</span>
              </div>

              <div class="flex items-center">
                <svg class="w-3 h-3 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-xs font-medium" :class="getThingsCountColor(auditorium.things.length)">
                  {{ getObjectsCountText(auditorium.things.length) }}
                </span>
              </div>
            </div>

            <!-- Быстрый просмотр объектов -->
            <div v-if="auditorium.things.length > 0" class="mt-3 pt-3 border-t border-gray-200">
              <div class="text-xs text-gray-500 mb-1">Объекты учёта:</div>
              <div class="flex flex-wrap gap-1">
                <div
                    v-for="(thing, index) in auditorium.things.slice(0, 3)"
                    :key="index"
                    class="inline-flex items-center"
                    :title="thing.name || `Инв. ${thing.inv_number}`"
                >
                  <div :class="getConditionColor(thing.condition)" class="w-1.5 h-1.5 rounded-full mr-1"></div>
                  <span class="text-xs text-gray-700 truncate max-w-[80px]">
                    {{ thing.name || thing.inv_number }}
                  </span>
                </div>
                <div v-if="auditorium.things.length > 3" class="text-xs text-indigo-600 font-medium ml-1">
                  +{{ auditorium.things.length - 3 }}
                </div>
              </div>
            </div>

            <!-- Пустое состояние -->
            <div v-else class="mt-3 pt-3 border-t border-gray-200">
              <div class="text-xs text-gray-400 italic">Нет объектов</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Подсказка при отсутствии выбора -->
      <div
          v-if="!selectedAuditorium && !isLoading && !error && filteredAuditoriums.length > 0"
          class="mt-8 text-center py-8 bg-gradient-to-br from-gray-50 to-blue-50 rounded-2xl border-2 border-dashed border-gray-300"
      >
        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
        </svg>
        <h3 class="text-xl font-semibold text-gray-600 mb-2">Выберите кабинет</h3>
        <p class="text-gray-500">Нажмите на любой кабинет на плане для просмотра объектов учёта</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
import {BACKEND_URL} from "@/router.js";

const router = useRouter()

// Данные
const auditoriums = ref([])
const selectedAuditorium = ref(null)
const searchQuery = ref('')
const buildingFilter = ref('')
const floorFilter = ref('')
const activeFloor = ref(1)
const isLoading = ref(false)
const error = ref(null)
const types = ref({})
const balanceTypes = ref({}) // Добавляем характеристики учёта

// Загрузка данных
const loadData = async () => {
  try {
    isLoading.value = true
    error.value = null

    const [mapResponse, typesResponse, balanceResponse] = await Promise.all([
      axios.get(BACKEND_URL + '/api/auditoriums/map'),
      axios.get(BACKEND_URL + '/api/info/thing-types'),
      axios.get(BACKEND_URL + '/api/info/balance') // Загружаем характеристики учёта
    ])

    if (mapResponse.data.success) {
      auditoriums.value = mapResponse.data.data
    } else {
      throw new Error('Ошибка загрузки данных кабинетов')
    }

    if (typesResponse.data.success) {
      types.value = typesResponse.data.types || {}
    }

    // Загружаем характеристики учёта
    if (balanceResponse.data.success) {
      balanceTypes.value = balanceResponse.data.types || {}
      console.log('Загруженные характеристики учёта:', balanceTypes.value)
    }

  } catch (err) {
    console.error('Ошибка при загрузке данных:', err)
    error.value = 'Не удалось загрузить данные. Проверьте соединение с сервером.'
  } finally {
    isLoading.value = false
  }
}

onMounted(() => {
  loadData()
})

// Вычисляемые свойства
const filteredAuditoriums = computed(() => {
  let filtered = auditoriums.value

  if (activeFloor.value) {
    filtered = filtered.filter(a => a.floor === activeFloor.value)
  }

  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(a =>
        a.auditorium_name.toLowerCase().includes(query) ||
        a.things.some(t =>
            (t.name && t.name.toLowerCase().includes(query)) ||
            t.inv_number.toLowerCase().includes(query) ||
            t.serial_number.toLowerCase().includes(query) ||
            (getBalanceLabel(t.balance) && getBalanceLabel(t.balance).toLowerCase().includes(query)) // Добавляем поиск по характеристике учёта
        )
    )
  }

  if (buildingFilter.value) {
    filtered = filtered.filter(a =>
        getBuildingFromName(a.auditorium_name) === buildingFilter.value
    )
  }

  if (floorFilter.value) {
    filtered = filtered.filter(a => a.floor === parseInt(floorFilter.value))
  }

  return filtered
})

const uniqueFloors = computed(() => {
  const floors = new Set(auditoriums.value.map(a => a.floor))
  return Array.from(floors).sort((a, b) => a - b)
})

const buildings = computed(() => {
  const buildingsSet = new Set()
  auditoriums.value.forEach(a => {
    const building = getBuildingFromName(a.auditorium_name)
    if (building) buildingsSet.add(building)
  })
  return Array.from(buildingsSet).sort()
})

const floors = computed(() => {
  const floorsSet = new Set(auditoriums.value.map(a => a.floor))
  return Array.from(floorsSet).sort((a, b) => a - b)
})

const workingThingsCount = computed(() => {
  if (!selectedAuditorium.value?.things) return 0
  return selectedAuditorium.value.things.filter(t => t.condition === 1).length
})

// Методы
const setActiveFloor = (floor) => {
  activeFloor.value = floor
  selectedAuditorium.value = null
}

const selectAuditorium = (auditorium) => {
  selectedAuditorium.value = auditorium
}

const getBuildingFromName = (name) => {
  if (!name) return ''
  const building = name.match(/^[A-Za-zА-Яа-я]/)
  return building ? building[0] : ''
}

const getThingsCountColor = (count) => {
  if (count === 0) return 'text-gray-500'
  if (count <= 5) return 'text-green-600'
  if (count <= 10) return 'text-blue-600'
  return 'text-orange-600'
}

const getObjectsCountText = (count) => {
  if (count === 0) return '0 объектов'
  if (count === 1) return '1 объект'
  if (count >= 2 && count <= 4) return `${count} объекта`
  return `${count} объектов`
}

const getConditionColor = (conditionId) => {
  const colorMap = {
    1: 'bg-green-500',  // Исправно работает
    2: 'bg-red-500',    // Сломано
    3: 'bg-yellow-500', // В ремонте
    4: 'bg-blue-500',   // Резерв
    5: 'bg-gray-500'    // Другое
  }
  return colorMap[conditionId] || 'bg-gray-400'
}

const getTypeName = (typeId) => {
  if (!typeId && typeId !== 0) return 'Не указан'
  return types.value[typeId] || `Тип ${typeId}`
}

// Получение метки характеристики учёта
const getBalanceLabel = (balanceId) => {
  if (balanceId === null || balanceId === undefined) return 'Не указано'

  if (Object.keys(balanceTypes.value).length > 0) {
    return balanceTypes.value[balanceId] || `Характеристика ${balanceId}`
  }

  // Запасной вариант, если не успели загрузить
  const staticBalances = {
    1: 'Основное средство',
    2: 'За балансом'
  }
  return staticBalances[balanceId] || `Характеристика ${balanceId}`
}

const viewThing = (thingId) => {
  // router.push(`/things/electronics/view/${thingId}`)
}
</script>

<style scoped>
/* Стили для слайдборда */
.slideboard {
  position: fixed;
  top: 0;
  right: -500px;
  width: 500px;
  height: 100vh;
  z-index: 1000;
  transition: right 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  box-shadow: -10px 0 30px rgba(0, 0, 0, 0.1);
}

.slideboard-open {
  right: 0;
}

.slideboard-content {
  height: 100%;
  background: white;
  display: flex;
  flex-direction: column;
}

.slideboard-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  z-index: 999;
  animation: fadeIn 0.2s ease-out;
}

/* Стили для карточек кабинетов */
.auditorium-card {
  background: white;
  border: 2px solid #e5e7eb;
  border-radius: 12px;
  padding: 16px;
  cursor: pointer;
  transition: all 0.2s ease;
  position: relative;
}

.auditorium-card:hover {
  border-color: #6366f1;
  transform: translateY(-2px);
  box-shadow: 0 10px 20px rgba(99, 102, 241, 0.1);
}

.auditorium-card-active {
  border-color: #6366f1;
  background: linear-gradient(135deg, #f8fafc 0%, #f0f9ff 100%);
  box-shadow: 0 10px 25px rgba(99, 102, 241, 0.15);
}

/* Анимации */
@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

/* Адаптивность */
@media (max-width: 768px) {
  .slideboard {
    width: 100%;
    right: -100%;
  }

  .auditorium-card {
    padding: 12px;
  }
}

/* Кастомный скроллбар */
::-webkit-scrollbar {
  width: 6px;
}

::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 3px;
}

::-webkit-scrollbar-thumb {
  background: #c1c1c1;
  border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
  background: #a1a1a1;
}
</style>