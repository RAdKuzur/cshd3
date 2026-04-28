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
              Назад
            </router-link>
            <div>
              <h1 class="text-3xl font-bold text-gray-900">Сетевое устройство</h1>
              <!--              <p class="text-gray-600 mt-2">Устройство #{{ networkThing?.id }}</p>-->
            </div>
          </div>

          <div class="flex items-center gap-3">
            <router-link
                :to="`/things/network/edit/${networkThing?.id}`"
                class="px-4 py-2 bg-indigo-600 text-white font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors flex items-center gap-2"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
              </svg>
              Редактировать
            </router-link>
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

      <!-- Сетевая информация -->
      <div v-if="!isLoading && networkThing && !error" class="bg-white shadow-lg border border-gray-200 p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-6 pb-2 border-b border-gray-200">
          Сетевая информация
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">IP-адрес</div>
            <div class="flex items-center gap-2">
              <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3" />
                </svg>
              </div>
              <div class="text-lg font-mono font-semibold text-gray-900">
                {{ networkThing?.ip_address || 'Не указан' }}
              </div>
            </div>
          </div>

          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Домен</div>
            <div class="flex items-center gap-2">
              <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                </svg>
              </div>
              <div class="text-lg font-mono text-gray-900">
                {{ networkThing?.domain || 'Не указан' }}
              </div>
            </div>
          </div>

          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Номер телефона</div>
            <div class="flex items-center gap-2">
              <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
              </div>
              <div class="text-lg text-gray-900">
                {{ networkThing?.phone_number || 'Не указан' }}
              </div>
            </div>
          </div>

          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Инвентарный номер</div>
            <div class="text-lg font-mono text-indigo-600 font-semibold">{{ networkThing?.inv_number || 'Не указан' }}</div>
          </div>

          <!--          <div>-->
          <!--            <div class="text-sm font-medium text-gray-500 mb-1">ID основного устройства</div>-->
          <!--            <div class="text-lg font-mono text-gray-900">{{ networkThing?.thing_id || 'Не указан' }}</div>-->
          <!--          </div>-->
        </div>
      </div>

      <!-- Классификация и местоположение -->
      <div v-if="!isLoading && networkThing && !error" class="bg-white shadow-lg border border-gray-200 p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-6 pb-2 border-b border-gray-200">
          Классификация и местоположение
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Тип устройства</div>
            <div class="flex items-center gap-2">
              <div :class="getTypeColor(networkThing?.type)" class="w-8 h-8 rounded-full flex items-center justify-center text-white">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                </svg>
              </div>
              <div class="text-lg text-gray-900">{{ getNetworkTypeLabel(networkThing?.type) || 'Не указан' }}</div>
            </div>
          </div>

          <!-- Аудитория -->
          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Аудитория размещения</div>
            <div class="flex items-center gap-2">
              <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
              </div>
              <div class="text-lg font-semibold text-gray-900">
                {{ getAuditoriumName(networkThing?.auditorium_id) || 'Не указана' }}
              </div>
            </div>
          </div>

          <!-- Этаж -->
          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Этаж</div>
            <div class="flex items-center gap-2">
              <div class="w-8 h-8 bg-blue-50 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
              </div>
              <div class="text-lg text-gray-900">
                {{ getAuditoriumFloor(networkThing?.auditorium_id) || 'Не указан' }}
              </div>
            </div>
          </div>

          <!-- Отдел -->
          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Отдел</div>
            <div class="flex items-center gap-2">
              <div :class="getBranchColor(currentAuditorium?.branch_id)" class="w-8 h-8 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
              </div>
              <div class="text-lg text-gray-900">
                {{ getBranchName(currentAuditorium?.branch_id) || 'Не указан' }}
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Комментарий -->
      <div v-if="!isLoading && networkThing && !error && networkThing?.comment" class="bg-white shadow-lg border border-gray-200 p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Комментарий</h2>

        <div>
          <div class="text-sm font-medium text-gray-500 mb-2">Описание устройства</div>
          <div class="bg-gray-50 p-4 border border-gray-200 rounded-lg">
            <div class="text-gray-700 whitespace-pre-line">{{ networkThing.comment }}</div>
          </div>
        </div>
      </div>

      <!-- Системная информация -->
      <!--      <div v-if="!isLoading && networkThing && !error" class="bg-white shadow-lg border border-gray-200 p-6">-->
      <!--        <h2 class="text-xl font-semibold text-gray-900 mb-4">Системная информация</h2>-->

      <!--        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">-->
      <!--          <div>-->
      <!--            <div class="text-sm font-medium text-gray-500 mb-1">ID сетевого устройства</div>-->
      <!--            <div class="text-lg font-mono text-gray-900">{{ networkThing?.id || 'Не указан' }}</div>-->
      <!--          </div>-->

      <!--          <div>-->
      <!--            <div class="text-sm font-medium text-gray-500 mb-1">ID связанного предмета</div>-->
      <!--            <div class="text-lg font-mono text-gray-900">-->
      <!--              <router-link-->
      <!--                  v-if="networkThing?.thing_id"-->
      <!--                  :to="`/things/view/${networkThing.thing_id}`"-->
      <!--                  class="text-indigo-600 hover:text-indigo-800 hover:underline"-->
      <!--              >-->
      <!--                {{ networkThing.thing_id }}-->
      <!--              </router-link>-->
      <!--              <span v-else>Не указан</span>-->
      <!--            </div>-->
      <!--          </div>-->
      <!--        </div>-->
      <!--      </div>-->

      <!-- Действия -->
      <div v-if="!isLoading && networkThing && !error" class="mt-8 flex items-center justify-between bg-white shadow-lg border border-gray-200 p-6">
        <div class="text-sm text-gray-500">
          <!--          Статус: <span class="font-medium text-green-600">Активный</span>-->
        </div>

        <div class="flex items-center gap-3">
          <!--          <button-->
          <!--              @click="handlePrint"-->
          <!--              class="px-4 py-2 border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors flex items-center gap-2"-->
          <!--          >-->
          <!--            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">-->
          <!--              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />-->
          <!--            </svg>-->
          <!--            Печать-->
          <!--          </button>-->

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
import { ref, computed, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'
import { BACKEND_URL } from "@/router.js"

const route = useRoute()
const router = useRouter()

// Данные
const networkThing = ref(null)
const auditoriums = ref([])
const branches = ref({})
const networkTypes = ref({})
const isLoading = ref(true)
const error = ref(null)

// Вычисляемое свойство для текущей аудитории
const currentAuditorium = computed(() => {
  if (!networkThing.value?.auditorium_id) return null
  return auditoriums.value.find(a => a.id === networkThing.value.auditorium_id)
})

// Загрузка данных при монтировании
onMounted(async () => {
  await Promise.all([
    loadNetworkThingData(),
    loadAuditoriums(),
    loadBranches(),
    loadNetworkTypes()
  ])
})

// Загрузка данных сетевого устройства
const loadNetworkThingData = async () => {
  try {
    isLoading.value = true
    error.value = null
    const networkThingId = route.params.id

    const response = await axios.get(`${BACKEND_URL}/api/network-things/${networkThingId}`)
    const data = response.data

    if (data.success && data.data) {
      networkThing.value = data.data
    } else {
      throw new Error(data.message || 'Данные не найдены')
    }

  } catch (err) {

    if (err.response) {
      if (err.response.status === 404) {
        error.value = 'Сетевое устройство не найдено'
      } else {
        error.value = `Ошибка сервера: ${err.response.status}`
      }
    } else if (err.request) {
      error.value = 'Нет ответа от сервера. Проверьте подключение.'
    } else {
      error.value = err.message || 'Не удалось загрузить данные устройства.'
    }
  } finally {
    isLoading.value = false
  }
}

// Загрузка аудиторий
const loadAuditoriums = async () => {
  try {
    const response = await axios.get(`${BACKEND_URL}/api/auditoriums`)
    const data = response.data

    if (data.success && data.data) {
      auditoriums.value = data.data
    }
  } catch (err) {
    auditoriums.value = []
  }
}

// Загрузка отделов
const loadBranches = async () => {
  try {
    const response = await axios.get(`${BACKEND_URL}/api/info/branches`)
    const data = response.data

    if (data.success) {
      const branchesData = {}
      data.data.forEach(branch => {
        branchesData[branch.id] = branch.name
      })
      branches.value = branchesData
    }
  } catch (err) {
    branches.value = {}
  }
}

// Загрузка типов сетевых устройств
const loadNetworkTypes = async () => {
  try {
    const response = await axios.get(`${BACKEND_URL}/api/info/thing-types`)
    const data = response.data

    if (data.success) {
      networkTypes.value = data.types || {}

    }
  } catch (err) {
    networkTypes.value = {}
  }
}

// Получение названия кабинета по ID
const getAuditoriumName = (auditoriumId) => {
  if (!auditoriumId) return 'Не указана'

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

// Получение названия отдела
const getBranchName = (branchId) => {
  if (!branchId) return 'Не указан'
  return branches.value[branchId] || `Отдел ${branchId}`
}

// Цвет для отдела
const getBranchColor = (branchId) => {
  if (!branchId) return 'bg-gray-400'

  const branchColors = {
    1: 'bg-gradient-to-br from-purple-500 to-purple-600',
    2: 'bg-gradient-to-br from-green-500 to-green-600',
    3: 'bg-gradient-to-br from-blue-500 to-blue-600',
    4: 'bg-gradient-to-br from-red-500 to-red-600',
    5: 'bg-gradient-to-br from-orange-500 to-orange-600',
    6: 'bg-gradient-to-br from-teal-500 to-teal-600',
    7: 'bg-gradient-to-br from-cyan-500 to-cyan-600',
    8: 'bg-gradient-to-br from-pink-500 to-pink-600',
    9: 'bg-gradient-to-br from-yellow-500 to-yellow-600',
    10: 'bg-gradient-to-br from-indigo-500 to-indigo-600',
    11: 'bg-gradient-to-br from-gray-500 to-gray-600',
    12: 'bg-gradient-to-br from-purple-500 to-purple-600',
    13: 'bg-gradient-to-br from-purple-500 to-purple-600',
    14: 'bg-gradient-to-br from-purple-500 to-purple-600',
    15: 'bg-gradient-to-br from-lime-500 to-lime-600',
    16: 'bg-gradient-to-br from-emerald-500 to-emerald-600',
    17: 'bg-gradient-to-br from-purple-500 to-purple-600',
    18: 'bg-gradient-to-br from-violet-500 to-violet-600',
    19: 'bg-gradient-to-br from-amber-500 to-amber-600',
    20: 'bg-gradient-to-br from-rose-500 to-rose-600'
  }

  return branchColors[branchId] || 'bg-gradient-to-br from-gray-400 to-gray-500'
}

// Получение метки типа сетевого устройства
const getNetworkTypeLabel = (typeId) => {
  if (typeId === null || typeId === undefined) return 'Не указан'

  if (Object.keys(networkTypes.value).length > 0) {
    return networkTypes.value[typeId] || `Тип ${typeId}`
  }

  // Дефолтные значения для сетевых устройств
  const staticNetworkTypes = {
    1: 'Маршрутизатор',
    2: 'Коммутатор',
    3: 'Точка доступа',
    4: 'Межсетевой экран',
    5: 'Модем',
    6: 'Сервер',
    7: 'Медиаконвертер',
    8: 'Патч-панель',
    16: 'Маршрутизатор Wi-Fi',
    17: 'Мост',
    19: 'Шлюз'
  }

  return staticNetworkTypes[typeId] || `Тип ${typeId}`
}

// Цвет для типа устройства
const getTypeColor = (typeId) => {
  if (typeId === null || typeId === undefined) return 'bg-gray-400'

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
  return colors[index] || 'bg-gray-400'
}

// Обработчики действий
const handlePrint = () => {
  window.print()
}

const handleDelete = async () => {
  if (!confirm('Вы уверены, что хотите удалить это сетевое устройство? Это действие нельзя отменить.')) {
    return
  }

  try {
    const networkThingId = route.params.id
    const response = await axios.delete(`${BACKEND_URL}/api/network-things/${networkThingId}`, {
      headers: {
        'Content-Type': 'application/json',
      }
    })

    const data = response.data
    if (data.success) {
      alert('Сетевое устройство успешно удалено')
      router.push('/things/network')
    } else {
      throw new Error(data.message || 'Ошибка при удалении')
    }
  } catch (err) {

    let errorMessage = 'Не удалось удалить сетевое устройство'
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