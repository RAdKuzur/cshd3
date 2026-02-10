<template>
  <div class="p-6 bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <div class="max-w-6xl mx-auto">
      <!-- Заголовок и навигация -->
      <div class="mb-8">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-4">
            <router-link
                to="/things/devices"
                class="text-gray-600 hover:text-gray-900 flex items-center gap-2 px-3 py-2 hover:bg-gray-100 transition-colors"
            >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
              </svg>
              Назад
            </router-link>
            <div>
              <h1 class="text-3xl font-bold text-gray-900">Просмотр устройства</h1>
              <p class="text-gray-600 mt-2">Подробная информация об устройстве</p>
            </div>
          </div>

          <div class="flex items-center gap-3">
            <router-link
                :to="`/things/devices/edit/${deviceId}`"
                class="px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium hover:from-blue-700 hover:to-indigo-700 transition-colors flex items-center gap-2 rounded-lg shadow-sm hover:shadow"
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
      <div v-if="isLoading" class="flex flex-col justify-center items-center h-64">
        <svg class="animate-spin h-8 w-8 text-indigo-600 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <div class="text-gray-600">Загрузка данных устройства...</div>
      </div>

      <!-- Ошибка -->
      <div v-else-if="error" class="bg-red-50 border border-red-200 rounded-xl p-6 mb-6">
        <div class="flex items-center">
          <svg class="w-5 h-5 text-red-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <div>
            <h3 class="text-sm font-medium text-red-800 mb-1">Ошибка загрузки</h3>
            <p class="text-sm text-red-700">{{ error }}</p>
            <button
                @click="loadDeviceData"
                class="mt-3 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm"
            >
              Попробовать снова
            </button>
          </div>
        </div>
      </div>

      <!-- Основная информация -->
      <div v-else-if="deviceData && thingData" class="space-y-6">
        <!-- Карточка устройства -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
          <div class="p-6">
            <!-- Заголовок карточки -->
            <div class="flex items-center justify-between mb-6">
              <div class="flex items-center gap-4">
                <div class="h-12 w-12 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-xl flex items-center justify-center shadow-sm">
                  <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                  </svg>
                </div>
                <div>
                  <h2 class="text-xl font-bold text-gray-900">{{ thingData.name }}</h2>
                </div>
              </div>
<!--              <div class="flex items-center gap-2">-->
<!--                <span :class="getConditionClass(thingData.condition)" class="px-3 py-1 text-xs font-semibold rounded-full">-->
<!--                  {{ getConditionLabel(thingData.condition) }}-->
<!--                </span>-->
<!--              </div>-->
            </div>

            <!-- Основная информация в сетке -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
              <!-- Модель устройства -->
              <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
                <div class="flex items-center gap-3 mb-3">
                  <div class="h-10 w-10 bg-gradient-to-r from-blue-100 to-indigo-100 rounded-lg flex items-center justify-center">
                    <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                  </div>
                  <div>
                    <div class="text-xs font-medium text-gray-500">Модель устройства</div>
                    <div class="font-semibold text-gray-900">{{ modelData?.name || 'Не указана' }}</div>
                  </div>
                </div>
                <div class="text-sm text-gray-600 mt-2">
                  Производитель: {{ companyData?.name || 'Не указан' }}
                </div>
              </div>

              <!-- Инвентарный номер -->
              <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
                <div class="flex items-center gap-3 mb-3">
                  <div class="h-10 w-10 bg-gradient-to-r from-green-100 to-emerald-100 rounded-lg flex items-center justify-center">
                    <svg class="h-5 w-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                  </div>
                  <div>
                    <div class="text-xs font-medium text-gray-500">Инвентарный номер</div>
                    <div class="font-mono font-semibold text-gray-900">{{ thingData.inv_number || 'Не указан' }}</div>
                  </div>
                </div>
              </div>

              <!-- Серийный номер -->
              <div v-if="thingData.serial_number" class="bg-gray-50 border border-gray-200 rounded-xl p-4">
                <div class="flex items-center gap-3 mb-3">
                  <div class="h-10 w-10 bg-gradient-to-r from-purple-100 to-pink-100 rounded-lg flex items-center justify-center">
                    <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                  </div>
                  <div>
                    <div class="text-xs font-medium text-gray-500">Серийный номер</div>
                    <div class="font-mono font-semibold text-gray-900">{{ thingData.serial_number }}</div>
                  </div>
                </div>
              </div>

              <!-- Тип устройства -->
              <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
                <div class="flex items-center gap-3 mb-3">
                  <div class="h-10 w-10 bg-gradient-to-r from-yellow-100 to-amber-100 rounded-lg flex items-center justify-center">
                    <svg class="h-5 w-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                  </div>
                  <div>
                    <div class="text-xs font-medium text-gray-500">Тип устройства</div>
                    <div class="font-semibold text-gray-900">{{ getTypeLabel(thingData.thing_type_id) }}</div>
                  </div>
                </div>
              </div>

              <!-- Цена -->
              <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
                <div class="flex items-center gap-3 mb-3">
                  <div class="h-10 w-10 bg-gradient-to-r from-red-100 to-orange-100 rounded-lg flex items-center justify-center">
                    <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                  </div>
                  <div>
                    <div class="text-xs font-medium text-gray-500">Стоимость</div>
                    <div class="font-semibold text-gray-900">{{ formatPrice(thingData.price) }}</div>
                  </div>
                </div>
                <div class="text-sm text-gray-600 mt-2">
                  Первоначальная стоимость
                </div>
              </div>

              <!-- Дата ввода -->
              <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
                <div class="flex items-center gap-3 mb-3">
                  <div class="h-10 w-10 bg-gradient-to-r from-teal-100 to-cyan-100 rounded-lg flex items-center justify-center">
                    <svg class="h-5 w-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                  </div>
                  <div>
                    <div class="text-xs font-medium text-gray-500">Дата ввода</div>
                    <div class="font-semibold text-gray-900">{{ formatDate(thingData.operation_date) }}</div>
                  </div>
                </div>
                <div class="text-sm text-gray-600 mt-2">
                  Дата начала эксплуатации
                </div>
              </div>

              <!-- Аудитория -->
              <div v-if="auditoriumData" class="bg-gray-50 border border-gray-200 rounded-xl p-4">
                <div class="flex items-center gap-3 mb-3">
                  <div class="h-10 w-10 bg-gradient-to-r from-indigo-100 to-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                  </div>
                  <div>
                    <div class="text-xs font-medium text-gray-500">Аудитория</div>
                    <div class="font-semibold text-gray-900">{{ auditoriumData.name }}</div>
                  </div>
                </div>
                <div class="text-sm text-gray-600 mt-2">
                  Этаж: {{ getFloorText(auditoriumData.floor) }}
                </div>
              </div>
            </div>

            <!-- Комментарий -->
            <div v-if="thingData.comment" class="mt-8 pt-6 border-t border-gray-200">
              <h3 class="text-sm font-medium text-gray-700 mb-3">Комментарий</h3>
              <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                <p class="text-gray-700 whitespace-pre-line">{{ thingData.comment }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Связь устройства -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
          <div class="p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Связь устройства</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Связь с моделью -->
              <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-100 rounded-xl p-4">
                <div class="flex items-center gap-3 mb-4">
                  <div class="h-12 w-12 bg-gradient-to-r from-blue-100 to-indigo-100 rounded-lg flex items-center justify-center shadow-sm">
                    <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                  </div>
                  <div>
                    <div class="text-sm font-medium text-gray-500">Связанная модель</div>
                    <div class="text-lg font-bold text-gray-900">{{ modelData?.name || 'Не указана' }}</div>
                  </div>
                </div>
                <div class="space-y-2 text-sm">
                  <div class="flex justify-between">
                    <span class="text-gray-600">Производитель:</span>
                    <span class="font-medium text-gray-900">{{ companyData?.name || 'Не указан' }}</span>
                  </div>
                </div>
              </div>

              <!-- Связь с вещью -->
              <div class="bg-gradient-to-br from-green-50 to-emerald-50 border border-green-100 rounded-xl p-4">
                <div class="flex items-center gap-3 mb-4">
                  <div class="h-12 w-12 bg-gradient-to-r from-green-100 to-emerald-100 rounded-lg flex items-center justify-center shadow-sm">
                    <svg class="h-6 w-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                    </svg>
                  </div>
                  <div>
                    <div class="text-sm font-medium text-gray-500">Связанная вещь</div>
                    <div class="text-lg font-bold text-gray-900">{{ thingData.name }}</div>
                  </div>
                </div>
                <div class="space-y-2 text-sm">
                  <div class="flex justify-between">
                    <span class="text-gray-600">Инв. номер:</span>
                    <span class="font-medium text-gray-900">{{ thingData.inv_number || 'Не указан' }}</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-gray-600">Тип устройства:</span>
                    <span class="font-medium text-gray-900">{{ getTypeLabel(thingData.thing_type_id) }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Кнопки действий -->
        <div class="flex items-center justify-between pt-6">
          <div>
            <router-link
                to="/things/devices"
                class="px-4 py-2 border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-colors flex items-center gap-2 rounded-lg"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
              </svg>
              Вернуться к списку
            </router-link>
          </div>

          <div class="flex items-center gap-3">
            <router-link
                :to="`/things/devices/edit/${deviceId}`"
                class="px-6 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium hover:from-blue-700 hover:to-indigo-700 transition-colors flex items-center gap-2 rounded-lg shadow-sm hover:shadow"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
              </svg>
              Редактировать устройство
            </router-link>

            <button
                @click="handleDelete"
                class="px-6 py-2 bg-gradient-to-r from-red-600 to-pink-600 text-white font-medium hover:from-red-700 hover:to-pink-700 transition-colors flex items-center gap-2 rounded-lg shadow-sm hover:shadow"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
              </svg>
              Удалить устройство
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'
import { BACKEND_URL } from "@/router.js"

const route = useRoute()
const router = useRouter()

const deviceId = route.params.id

// Данные
const deviceData = ref(null)
const thingData = ref(null)
const modelData = ref(null)
const companyData = ref(null)
const auditoriumData = ref(null)
const thingTypes = ref({})

// Состояние
const isLoading = ref(true)
const error = ref('')

// Загрузка данных при монтировании
onMounted(async () => {
  await loadDeviceData()
})

// Загрузка данных устройства
const loadDeviceData = async () => {
  try {
    isLoading.value = true
    error.value = ''

    // Загружаем основную связь устройства
    const deviceResponse = await axios.get(`${BACKEND_URL}/api/devices/${deviceId}`)
    const device = deviceResponse.data

    if (!device.success || !device.data) {
      throw new Error(device.message || 'Данные устройства не найдены')
    }

    deviceData.value = device.data

    // Загружаем данные параллельно
    await Promise.all([
      loadThingData(device.data.thing_id),
      loadModelData(device.data.model_id),
      loadThingTypes()
    ])

  } catch (err) {
    if (err.response) {
      if (err.response.status === 404) {
        error.value = 'Устройство не найдено'
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

// Загрузка информации о вещи
const loadThingData = async (thingId) => {
  try {
    const response = await axios.get(`${BACKEND_URL}/api/things/${thingId}`)
    const thing = response.data

    if (thing.success && thing.data) {
      thingData.value = thing.data
    }
  } catch (err) {
    console.error('Ошибка загрузки вещи:', err)
  }
}

// Загрузка информации о модели
const loadModelData = async (modelId) => {
  try {
    const response = await axios.get(`${BACKEND_URL}/api/models/${modelId}`)
    const model = response.data

    if (model.success && model.data) {
      modelData.value = model.data

      // Загружаем информацию о компании
      if (model.data.company_id) {
        await loadCompanyData(model.data.company_id)
      }
    }
  } catch (err) {
    console.error('Ошибка загрузки модели:', err)
  }
}

// Загрузка информации о компании
const loadCompanyData = async (companyId) => {
  try {
    const response = await axios.get(`${BACKEND_URL}/api/companies/${companyId}`)
    const company = response.data

    if (company.success && company.data) {
      companyData.value = company.data
    }
  } catch (err) {
    console.error('Ошибка загрузки компании:', err)
  }
}

// Загрузка информации об аудитории
const loadAuditoriumData = async (auditoriumId) => {
  try {
    const response = await axios.get(`${BACKEND_URL}/api/admin/auditoriums/${auditoriumId}`)
    const auditorium = response.data

    if (auditorium.success && auditorium.data) {
      auditoriumData.value = auditorium.data
    }
  } catch (err) {
    console.error('Ошибка загрузки аудитории:', err)
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
    console.error('Ошибка загрузки типов устройств:', err)
  }
}

// Вспомогательные функции
const getTypeLabel = (typeId) => {
  if (typeId === null || typeId === undefined) return 'Не указан'
  return thingTypes.value[typeId] || `Тип ${typeId}`
}

const getConditionLabel = (condition) => {
  if (!condition) return 'Не указано'
  return condition
}

const getConditionClass = (condition) => {
  if (!condition) return 'bg-gray-100 text-gray-800'

  const conditionLower = condition.toLowerCase()
  if (conditionLower.includes('рабоч') || conditionLower.includes('хорош')) {
    return 'bg-green-100 text-green-800'
  } else if (conditionLower.includes('ремонт') || conditionLower.includes('неисправ')) {
    return 'bg-yellow-100 text-yellow-800'
  } else if (conditionLower.includes('списан') || conditionLower.includes('утилиз')) {
    return 'bg-red-100 text-red-800'
  }
  return 'bg-gray-100 text-gray-800'
}

const formatPrice = (price) => {
  if (!price) return '0 ₽'
  return new Intl.NumberFormat('ru-RU', {
    style: 'currency',
    currency: 'RUB',
    minimumFractionDigits: 2
  }).format(price)
}

const formatDate = (dateString) => {
  if (!dateString) return 'Не указана'
  const date = new Date(dateString)
  return date.toLocaleDateString('ru-RU')
}

const formatDateTime = (dateTimeString) => {
  if (!dateTimeString) return 'Не указано'
  const date = new Date(dateTimeString)
  return date.toLocaleString('ru-RU')
}

const getFloorText = (floorNumber) => {
  if (!floorNumber && floorNumber !== 0) return ''

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

// Удаление устройства
const handleDelete = async () => {
  if (!confirm(`Вы уверены, что хотите удалить устройство "${thingData.value?.name}"? Это действие нельзя отменить.`)) {
    return
  }

  try {
    // Удаляем устройство и связанную вещь
    await axios.delete(`${BACKEND_URL}/api/devices/${deviceId}`)
    await axios.delete(`${BACKEND_URL}/api/things/${deviceData.value.thing_id}`)

    alert('Устройство успешно удалено')
    router.push('/things/devices')
  } catch (err) {
    if (err.response?.status === 404) {
      alert('Устройство уже удалено')
      router.push('/things/devices')
    } else {
      alert('Не удалось удалить устройство')
    }
  }
}
</script>