<template>
  <div class="p-6 bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <div class="max-w-6xl mx-auto">
      <!-- Заголовок и навигация -->
      <div class="mb-8">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-4">
            <router-link
                to="/things/resources"
                class="text-gray-600 hover:text-gray-900 flex items-center gap-2 px-3 py-2 hover:bg-gray-100 transition-colors"
            >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
              </svg>
              Назад
            </router-link>
            <div>
              <h1 class="text-3xl font-bold text-gray-900">Просмотр расходного материала</h1>
              <p class="text-gray-600 mt-2">Подробная информация о материале</p>
            </div>
          </div>

          <div class="flex items-center gap-3">
            <router-link
                :to="`/things/resources/edit/${resourceId}`"
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
        <div class="text-gray-600">Загрузка данных материала...</div>
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
                @click="loadResourceData"
                class="mt-3 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm"
            >
              Попробовать снова
            </button>
          </div>
        </div>
      </div>

      <!-- Основная информация -->
      <div v-else-if="resourceData" class="space-y-6">
        <!-- Карточка материала -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
          <div class="p-6">
            <!-- Заголовок карточки -->
            <div class="flex items-center justify-between mb-6">
              <div class="flex items-center gap-4">
                <div class="h-12 w-12 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-xl flex items-center justify-center shadow-sm">
                  <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                  </svg>
                </div>
                <div>
                  <h2 class="text-xl font-bold text-gray-900">{{ resourceData.name }}</h2>
                  <p class="text-gray-600">Расходный материал</p>
                </div>
              </div>
              <div class="flex items-center gap-2">
                <span :class="getStockStatusClass(resourceData.amount)" class="px-3 py-1 text-xs font-semibold rounded-full">
                  {{ getStockStatusLabel(resourceData.amount) }}
                </span>
              </div>
            </div>

            <!-- Основная информация в сетке -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
              <!-- Количество -->
              <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
                <div class="flex items-center gap-3 mb-3">
                  <div class="h-10 w-10 bg-gradient-to-r from-green-100 to-emerald-100 rounded-lg flex items-center justify-center">
                    <svg class="h-5 w-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                  </div>
                  <div>
                    <div class="text-xs font-medium text-gray-500">Количество на складе</div>
                    <div class="text-3xl font-bold text-gray-900" :class="getAmountColorClass(resourceData.amount)">
                      {{ resourceData.amount }}
                    </div>
                  </div>
                </div>
                <div class="text-sm text-gray-600 mt-2">
                  Единиц в наличии
                </div>
              </div>

              <!-- Тип материала -->
              <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
                <div class="flex items-center gap-3 mb-3">
                  <div :class="getTypeColor(resourceData.type)" class="h-10 w-10 rounded-lg flex items-center justify-center">
                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                  </div>
                  <div>
                    <div class="text-xs font-medium text-gray-500">Тип материала</div>
                    <div class="font-semibold text-gray-900">{{ getResourceTypeLabel(resourceData.type) }}</div>
                  </div>
                </div>
              </div>

              <!-- ID материала -->
            </div>

            <!-- Статистика запасов -->
            <div class="mt-8 pt-6 border-t border-gray-200">
              <h3 class="text-sm font-medium text-gray-700 mb-3">Статистика запасов</h3>
              <div class="space-y-4">
                <!-- Прогресс-бар запасов -->
                <div>
                  <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600">Уровень запасов</span>
                    <span class="font-medium text-gray-900">{{ getStockPercentage() }}%</span>
                  </div>
                  <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div
                        :class="getStockBarColor()"
                        class="h-2.5 rounded-full transition-all duration-300"
                        :style="{ width: getStockPercentage() + '%' }"
                    ></div>
                  </div>
                </div>

                <!-- Легенда статусов -->
                <div class="flex flex-wrap gap-3">
                  <div class="flex items-center">
                    <div class="w-3 h-3 rounded-full bg-emerald-500 mr-2"></div>
                    <span class="text-xs text-gray-600">В избытке (≥50)</span>
                  </div>
                  <div class="flex items-center">
                    <div class="w-3 h-3 rounded-full bg-green-500 mr-2"></div>
                    <span class="text-xs text-gray-600">Достаточно (20-49)</span>
                  </div>
                  <div class="flex items-center">
                    <div class="w-3 h-3 rounded-full bg-yellow-500 mr-2"></div>
                    <span class="text-xs text-gray-600">Мало (10-19)</span>
                  </div>
                  <div class="flex items-center">
                    <div class="w-3 h-3 rounded-full bg-orange-500 mr-2"></div>
                    <span class="text-xs text-gray-600">Критически мало (1-9)</span>
                  </div>
                  <div class="flex items-center">
                    <div class="w-3 h-3 rounded-full bg-red-500 mr-2"></div>
                    <span class="text-xs text-gray-600">Нет в наличии (0)</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- История операций (можно добавить позже) -->
<!--        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">-->
<!--          <div class="p-6">-->
<!--            <h3 class="text-lg font-bold text-gray-900 mb-4">Информация об использовании</h3>-->
<!--            <div class="text-center py-8 text-gray-500">-->
<!--              <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
<!--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />-->
<!--              </svg>-->
<!--              <p class="mt-2">История операций с материалом пока недоступна</p>-->
<!--              <p class="text-sm mt-1">В будущем здесь будет отображаться информация о списаниях и пополнениях</p>-->
<!--            </div>-->
<!--          </div>-->
<!--        </div>-->

        <!-- Кнопки действий -->
        <div class="flex items-center justify-between pt-6">
          <div>
            <router-link
                to="/things/resources"
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
                :to="`/things/resources/edit/${resourceId}`"
                class="px-6 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium hover:from-blue-700 hover:to-indigo-700 transition-colors flex items-center gap-2 rounded-lg shadow-sm hover:shadow"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
              </svg>
              Редактировать материал
            </router-link>

            <button
                @click="handleDelete"
                class="px-6 py-2 bg-gradient-to-r from-red-600 to-pink-600 text-white font-medium hover:from-red-700 hover:to-pink-700 transition-colors flex items-center gap-2 rounded-lg shadow-sm hover:shadow"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
              </svg>
              Удалить материал
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

const resourceId = route.params.id

// Данные
const resourceData = ref(null)
const resourceTypes = ref({})

// Состояние
const isLoading = ref(true)
const error = ref('')

// Загрузка данных при монтировании
onMounted(async () => {
  await loadResourceData()
})

// Загрузка данных материала
const loadResourceData = async () => {
  try {
    isLoading.value = true
    error.value = ''

    // Загружаем данные параллельно
    const [resourceResponse, typesResponse] = await Promise.all([
      axios.get(`${BACKEND_URL}/api/resources/${resourceId}`),
      axios.get(`${BACKEND_URL}/api/info/resource-types`)
    ])

    const resource = resourceResponse.data
    const types = typesResponse.data

    if (!resource.success || !resource.data) {
      throw new Error(resource.message || 'Данные материала не найдены')
    }

    resourceData.value = resource.data

    if (types.success) {
      resourceTypes.value = types.data || {}
    }

  } catch (err) {
    if (err.response) {
      if (err.response.status === 404) {
        error.value = 'Материал не найден'
      } else {
        error.value = `Ошибка сервера: ${err.response.status}`
      }
    } else if (err.request) {
      error.value = 'Нет ответа от сервера. Проверьте подключение.'
    } else {
      error.value = err.message || 'Не удалось загрузить данные материала.'
    }
  } finally {
    isLoading.value = false
  }
}

// Вспомогательные функции
const getResourceTypeLabel = (typeId) => {
  if (typeId === null || typeId === undefined) return 'Не указан'
  return resourceTypes.value[typeId] || `Тип ${typeId}`
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

// Цвет количества в зависимости от значения
const getAmountColorClass = (amount) => {
  if (amount >= 50) return 'text-emerald-600'
  if (amount >= 20) return 'text-green-600'
  if (amount >= 10) return 'text-yellow-600'
  if (amount >= 1) return 'text-orange-600'
  return 'text-red-600'
}

// Цвет прогресс-бара
const getStockBarColor = () => {
  const amount = resourceData.value?.amount || 0
  if (amount >= 50) return 'bg-emerald-500'
  if (amount >= 20) return 'bg-green-500'
  if (amount >= 10) return 'bg-yellow-500'
  if (amount >= 1) return 'bg-orange-500'
  return 'bg-red-500'
}

// Процент запасов (максимум 100 для визуализации)
const getStockPercentage = () => {
  const amount = resourceData.value?.amount || 0
  // Логика: считаем, что 100 единиц = 100%
  const maxAmount = 100
  const percentage = (amount / maxAmount) * 100
  return Math.min(Math.round(percentage), 100)
}

// Статус запасов
const getStockStatusLabel = (amount) => {
  if (amount >= 50) return 'В избытке'
  if (amount >= 20) return 'Достаточно'
  if (amount >= 10) return 'Мало'
  if (amount >= 1) return 'Критически мало'
  return 'Нет в наличии'
}

const getStockStatusClass = (amount) => {
  if (amount >= 50) return 'bg-emerald-100 text-emerald-800'
  if (amount >= 20) return 'bg-green-100 text-green-800'
  if (amount >= 10) return 'bg-yellow-100 text-yellow-800'
  if (amount >= 1) return 'bg-orange-100 text-orange-800'
  return 'bg-red-100 text-red-800'
}

// Удаление материала
const handleDelete = async () => {
  if (!confirm(`Вы уверены, что хотите удалить материал "${resourceData.value?.name}"? Это действие нельзя отменить.`)) {
    return
  }

  try {
    await axios.delete(`${BACKEND_URL}/api/resources/${resourceId}`)

    alert('Материал успешно удален')
    router.push('/things/resources')
  } catch (err) {
    if (err.response?.status === 404) {
      alert('Материал уже удален')
      router.push('/things/resources')
    } else {
      alert('Не удалось удалить материал')
    }
  }
}
</script>