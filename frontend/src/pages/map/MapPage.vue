<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-6">
    <div class="max-w-7xl mx-auto">

      <!-- Заголовок -->
      <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">План здания</h1>
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
        <div v-else class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
          <div
              v-for="auditorium in filteredAuditoriums"
              :key="auditorium.auditorium_id"
              class="bg-gradient-to-br from-white to-gray-50 border-2 border-gray-300 rounded-xl cursor-pointer transition-all duration-300 hover:shadow-xl hover:scale-105 hover:border-indigo-400"
              :class="{ 'ring-4 ring-indigo-400 border-indigo-500 shadow-lg': selectedAuditorium?.auditorium_id === auditorium.auditorium_id }"
              @click="selectAuditorium(auditorium)"
          >
            <div class="p-5">
              <!-- Заголовок кабинета -->
              <div class="flex items-center justify-between mb-3">
                <h3 class="text-lg font-bold text-gray-900">{{ auditorium.auditorium_name }}</h3>
                <span class="px-2 py-1 bg-indigo-100 text-indigo-700 text-xs font-semibold rounded">
                  {{ getBuildingFromName(auditorium.auditorium_name) }}
                </span>
              </div>

              <!-- Информация о кабинете -->
              <div class="space-y-3">
                <div class="flex items-center">
                  <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                  </svg>
                  <span class="text-sm text-gray-600">{{ auditorium.floor }} этаж</span>
                </div>

                <div class="flex items-center">
                  <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  <span class="text-sm font-medium" :class="getThingsCountColor(auditorium.things.length)">
                    {{ getObjectsCountText(auditorium.things.length) }}
                  </span>
                </div>
              </div>

              <!-- Список объектов учёта -->
              <div v-if="auditorium.things.length > 0" class="mt-4 pt-3 border-t border-gray-200">
                <div class="text-xs text-gray-500 mb-2">Объекты учёта:</div>
                <div class="space-y-1">
                  <div
                      v-for="(thing, index) in auditorium.things.slice(0, 2)"
                      :key="index"
                      class="text-xs text-gray-700 truncate"
                      :title="thing.name"
                  >
                    • {{ thing.name || `Инв. ${thing.inv_number}` }}
                  </div>
                  <div v-if="auditorium.things.length > 2" class="text-xs text-indigo-600 font-medium">
                    +{{ auditorium.things.length - 2 }} ещё...
                  </div>
                </div>
              </div>

              <!-- Пустое состояние -->
              <div v-else class="mt-4 pt-3 border-t border-gray-200">
                <div class="text-xs text-gray-400 italic">Объекты учёта отсутствуют</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Информация о выбранном кабинете -->
      <div
          v-if="selectedAuditorium"
          class="mt-8 bg-white rounded-2xl shadow-xl border border-gray-200 p-8 transition-all duration-300 animate-fade-in"
      >
        <!-- Шапка -->
        <div class="flex items-center justify-between mb-6">
          <div class="flex items-center">
            <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center mr-4">
              <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
              </svg>
            </div>
            <div>
              <h2 class="text-2xl font-bold text-gray-900">{{ selectedAuditorium.auditorium_name }}</h2>
              <div class="flex items-center mt-1">
                <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full mr-2">
                  {{ selectedAuditorium.floor }} этаж
                </span>
                <span class="px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full">
                  {{ getBuildingFromName(selectedAuditorium.auditorium_name) }}
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

        <!-- Содержимое кабинета -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
          <!-- Список объектов учёта -->
          <div>
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Объекты учёта в кабинете</h3>

            <div v-if="selectedAuditorium.things.length === 0" class="bg-gray-50 rounded-xl p-6 text-center">
              <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <p class="text-gray-600">В кабинете нет объектов учёта</p>
            </div>

            <div v-else class="space-y-4">
              <div
                  v-for="thing in selectedAuditorium.things"
                  :key="thing.id"
                  class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition-colors cursor-pointer border border-gray-200"
                  @click="viewThing(thing.id)"
              >
                <div class="flex items-start justify-between">
                  <div>
                    <div class="flex items-center mb-2">
                      <div :class="getConditionColor(thing.condition)" class="w-3 h-3 rounded-full mr-2"></div>
                      <h4 class="font-medium text-gray-900">{{ thing.name || `Объект ${thing.id}` }}</h4>
                    </div>
                    <div class="text-sm text-gray-600 space-y-1">
                      <div class="flex items-center">
                        <span class="font-medium mr-2">Инв. №:</span>
                        <span class="font-mono">{{ thing.inv_number }}</span>
                      </div>
                      <div class="flex items-center">
                        <span class="font-medium mr-2">Сер. №:</span>
                        <span class="font-mono">{{ thing.serial_number }}</span>
                      </div>
                      <div class="flex items-center">
                        <span class="font-medium mr-2">Тип:</span>
                        <span>{{ getTypeName(thing.thing_type_id) }}</span>
                      </div>
                    </div>
                  </div>
                  <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                  </svg>
                </div>
              </div>
            </div>
          </div>

          <!-- Информация о кабинете -->
          <div>
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Информация о кабинете</h3>

            <div class="bg-blue-50 rounded-xl p-5 mb-6">
              <div class="flex items-center mb-3">
                <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h1m0-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-medium text-blue-800">Статистика кабинета</span>
              </div>

              <div class="grid grid-cols-2 gap-4">
                <div class="text-center">
                  <div class="text-2xl font-bold text-blue-700">{{ selectedAuditorium.things.length }}</div>
                  <div class="text-sm text-blue-600">Всего объектов учёта</div>
                </div>
                <div class="text-center">
                  <div class="text-2xl font-bold text-green-700">{{ workingThingsCount }}</div>
                  <div class="text-sm text-green-600">Исправно</div>
                </div>
              </div>
            </div>

            <!-- Краткая информация -->
            <div class="bg-gray-50 rounded-xl p-5">
              <div class="flex items-center mb-3">
                <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h1m0-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-medium text-gray-800">Краткая информация</span>
              </div>

              <div class="space-y-3">
                <div class="flex justify-between items-center">
                  <span class="text-sm text-gray-600">Корпус:</span>
                  <span class="font-medium">{{ getBuildingFromName(selectedAuditorium.auditorium_name) }}</span>
                </div>
                <div class="flex justify-between items-center">
                  <span class="text-sm text-gray-600">Этаж:</span>
                  <span class="font-medium">{{ selectedAuditorium.floor }}</span>
                </div>
                <div class="flex justify-between items-center">
                  <span class="text-sm text-gray-600">Кабинет:</span>
                  <span class="font-medium">{{ selectedAuditorium.auditorium_name }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Подсказка при отсутствии выбора -->
      <div
          v-if="!selectedAuditorium && !isLoading && !error && filteredAuditoriums.length > 0"
          class="mt-8 text-center py-12 bg-gradient-to-br from-gray-50 to-blue-50 rounded-2xl border-2 border-dashed border-gray-300"
      >
        <svg class="w-20 h-20 text-gray-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
        </svg>
        <h3 class="text-2xl font-semibold text-gray-600 mb-3">Выберите кабинет</h3>
        <p class="text-gray-500 text-lg">Нажмите на любой кабинет на плане для просмотра объектов учёта</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

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
const conditions = ref({})

// Загрузка данных
const loadData = async () => {
  try {
    isLoading.value = true
    error.value = null

    const [mapResponse, typesResponse] = await Promise.all([
      axios.get('http://127.0.0.1:8000/api/auditoriums/map'),
      axios.get('http://127.0.0.1:8000/api/things/info-type')
    ])

    if (mapResponse.data.success) {
      auditoriums.value = mapResponse.data.data
      console.log('Загруженные кабинеты:', auditoriums.value)
    } else {
      throw new Error('Ошибка загрузки данных кабинетов')
    }

    if (typesResponse.data.success) {
      types.value = typesResponse.data.types || {}
      conditions.value = typesResponse.data.conditions || {}
      console.log('Загруженные типы:', types.value)
      console.log('Загруженные условия:', conditions.value)
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

  // Фильтрация по этажу
  if (activeFloor.value) {
    filtered = filtered.filter(a => a.floor === activeFloor.value)
  }

  // Фильтрация по поиску
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(a =>
        a.auditorium_name.toLowerCase().includes(query) ||
        a.things.some(t =>
            (t.name && t.name.toLowerCase().includes(query)) ||
            t.inv_number.toLowerCase().includes(query) ||
            t.serial_number.toLowerCase().includes(query)
        )
    )
  }

  // Фильтрация по корпусу
  if (buildingFilter.value) {
    filtered = filtered.filter(a =>
        getBuildingFromName(a.auditorium_name) === buildingFilter.value
    )
  }

  // Фильтрация по этажу (дополнительная)
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
  if (!selectedAuditorium.value) return 0
  return selectedAuditorium.value.things.filter(t => t.condition === 0).length
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
  if (count === 0) return '0 объектов учёта'
  if (count === 1) return '1 объект учёта'
  if (count >= 2 && count <= 4) return `${count} объекта учёта`
  return `${count} объектов учёта`
}

const getConditionColor = (conditionId) => {
  const colorMap = {
    0: 'bg-green-500',  // Исправно работает
    1: 'bg-red-500',    // Сломано
    2: 'bg-yellow-500', // В ремонте
    3: 'bg-blue-500',   // Резерв
    4: 'bg-gray-500'    // Другое
  }
  return colorMap[conditionId] || 'bg-gray-400'
}

const getTypeName = (typeId) => {
  if (!typeId && typeId !== 0) return 'Не указан'
  return types.value[typeId] || `Тип ${typeId}`
}

const getConditionLabel = (conditionId) => {
  if (conditionId === null || conditionId === undefined) return 'Не указано'
  return conditions.value[conditionId] || `Состояние ${conditionId}`
}

const viewThing = (thingId) => {
  router.push(`/things/electronics/view/${thingId}`)
}
</script>

<style scoped>
.animate-fade-in {
  animation: fadeIn 0.5s ease-in-out;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>