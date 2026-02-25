<template>
  <div class="p-6 bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
      <!-- Уведомления -->
      <transition name="notification">
        <div v-if="notification.show" :class="['notification', notification.type]" class="mb-6">
          {{ notification.message }}
        </div>
      </transition>

      <!-- Заголовок -->
      <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
          <router-link to="/admin" class="text-gray-500 hover:text-gray-700 transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
          </router-link>
          <h1 class="text-3xl font-bold text-gray-900">Безопасность и токены доступа</h1>
        </div>
        <p class="text-gray-600">Управление вашими активными токенами</p>

        <!-- Панель поиска -->
        <div class="mt-6">
          <div class="relative max-w-md">
            <input
                v-model="searchQuery"
                type="text"
                placeholder="Поиск по имени пользователя или ID..."
                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm bg-white"
            >
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
              <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
            </div>
          </div>
        </div>
      </div>

      <!-- Статистика -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
          <div class="flex items-center gap-4">
            <div class="p-3 bg-blue-100 rounded-lg">
              <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
              </svg>
            </div>
            <div>
              <p class="text-sm text-gray-600">Всего токенов</p>
              <p class="text-2xl font-bold text-gray-900">{{ tokens.length }}</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
          <div class="flex items-center gap-4">
            <div class="p-3 bg-green-100 rounded-lg">
              <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <div>
              <p class="text-sm text-gray-600">Активные</p>
              <p class="text-2xl font-bold text-gray-900">{{ activeTokensCount }}</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
          <div class="flex items-center gap-4">
            <div class="p-3 bg-red-100 rounded-lg">
              <svg class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <div>
              <p class="text-sm text-gray-600">Отозванные</p>
              <p class="text-2xl font-bold text-gray-900">{{ revokedTokensCount }}</p>
            </div>
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

      <!-- Ошибка -->
      <div v-else-if="error" class="bg-gradient-to-r from-red-50 to-pink-50 border border-red-200 rounded-xl p-6 text-center shadow-sm">
        <svg class="mx-auto h-12 w-12 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z" />
        </svg>
        <h3 class="mt-2 text-sm font-medium text-red-800">Ошибка загрузки</h3>
        <p class="mt-1 text-sm text-red-600">{{ error }}</p>
        <button
            @click="loadData"
            class="mt-4 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors shadow-sm"
        >
          Попробовать снова
        </button>
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
                Статус
              </th>
              <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider">
                Действия
              </th>
            </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
            <tr
                v-for="token in paginatedItems"
                :key="token.id"
                class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-200 group"
                :class="{ 'opacity-75 bg-gray-50': token.is_revoked }"
            >
              <!-- ID -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-lg flex items-center justify-center shadow-sm">
                    <span class="text-sm font-bold text-indigo-700">#{{ token.id }}</span>
                  </div>
                  <div class="ml-4">
                    <div class="text-xs text-gray-500 font-medium">
                      ID токена
                    </div>
                    <div class="text-sm font-semibold text-gray-900">
                      {{ token.id }}
                    </div>
                  </div>
                </div>
              </td>

              <!-- Пользователь -->
              <td class="px-6 py-4">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-8 w-8 bg-gradient-to-r from-blue-100 to-indigo-100 rounded-lg flex items-center justify-center mr-3 shadow-sm">
                    <svg class="h-4 w-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                  </div>
                  <div>
                    <div class="text-lg font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors">
                      {{ token.username }}
                    </div>
                    <div class="text-xs text-gray-500">
                      ID: {{ token.user_id }}
                    </div>
                  </div>
                </div>
              </td>

              <!-- Срок действия -->
              <td class="px-6 py-4">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-8 w-8 bg-gradient-to-r from-amber-100 to-yellow-100 rounded-lg flex items-center justify-center mr-3 shadow-sm">
                    <svg class="h-4 w-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                  </div>
                  <div>
                    <div class="text-sm font-semibold text-gray-900">
                      {{ formatDate(token.expires_at) }}
                    </div>
                    <div class="text-xs" :class="getExpiryStatus(token.expires_at).class">
                      {{ getExpiryStatus(token.expires_at).text }}
                    </div>
                  </div>
                </div>
              </td>

              <!-- Информация об устройстве -->
              <td class="px-6 py-4">
                <div class="space-y-1">
                  <div class="flex items-center text-sm">
                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span class="text-gray-600">{{ token.user_agent || 'Не указан' }}</span>
                  </div>
                  <div class="flex items-center text-sm">
                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="text-gray-600">{{ token.ip_address || 'Не указан' }}</span>
                  </div>
                </div>
              </td>

              <!-- Статус -->
              <td class="px-6 py-4 whitespace-nowrap">
                <span
                    class="px-3 py-1 inline-flex items-center gap-1.5 text-xs font-medium rounded-full"
                    :class="token.is_revoked
                      ? 'bg-red-100 text-red-800 border border-red-200'
                      : 'bg-green-100 text-green-800 border border-green-200'"
                >
                  <span class="w-2 h-2 rounded-full" :class="token.is_revoked ? 'bg-red-500' : 'bg-green-500'"></span>
                  {{ token.is_revoked ? 'Отозван' : 'Активен' }}
                </span>
              </td>

              <!-- Действия -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center space-x-2">
                  <!-- Кнопка отзыва -->
                  <button
                      v-if="!token.is_revoked"
                      @click="openRevokeModal(token)"
                      class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                      title="Отозвать токен"
                  >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                    </svg>
                  </button>
                  <span v-else class="text-sm text-gray-400 italic">Нет действий</span>
                </div>
              </td>
            </tr>
            </tbody>
          </table>
        </div>

        <!-- Пустое состояние -->
        <div v-if="!isLoading && filteredTokens.length === 0" class="text-center py-12">
          <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
          </svg>
          <h3 class="mt-2 text-sm font-medium text-gray-900">Токены не найдены</h3>
          <p class="mt-1 text-sm text-gray-500">
            {{ searchQuery ? 'Попробуйте изменить параметры поиска' : 'Активных токенов нет' }}
          </p>
        </div>

        <!-- Пагинация -->
        <div v-if="!isLoading && filteredTokens.length > 0" class="px-6 py-4 border-t border-gray-200 bg-gray-50">
          <div class="flex items-center justify-between flex-wrap gap-4">
            <div class="text-sm text-gray-700">
              Показано с {{ startIndex }} по {{ endIndex }} из {{ filteredTokens.length }} записей
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

    <!-- Модальное окно отзыва токена -->
    <transition name="modal-fade">
      <div v-if="showRevokeModal" class="fixed inset-0 flex items-center justify-center p-4 z-50">
        <!-- Размытый фон -->
        <div class="absolute inset-0 backdrop-blur-sm bg-white/30" @click="closeRevokeModal"></div>

        <!-- Модальное окно -->
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-100">
          <div class="p-6">
            <div class="text-center">
              <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-gradient-to-br from-red-100 to-pink-100 mb-4">
                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
              </div>
              <h3 class="text-lg font-bold text-gray-900 mb-2">Отозвать токен</h3>
              <p class="text-gray-600 mb-6">
                Вы уверены, что хотите отозвать токен пользователя
                <span class="font-semibold text-gray-900">"{{ tokenToRevoke?.username }}"</span>?
                <br>После отзыва пользователь не сможет использовать этот токен для доступа.
              </p>
            </div>

            <div class="flex justify-end gap-3">
              <button
                  type="button"
                  @click="closeRevokeModal"
                  :disabled="isRevoking"
                  class="px-4 py-2.5 border border-gray-300 text-gray-700 hover:bg-gray-50 rounded-lg font-medium transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
              >
                Отмена
              </button>
              <button
                  type="button"
                  @click="confirmRevoke"
                  :disabled="isRevoking"
                  class="px-6 py-2.5 bg-gradient-to-r from-red-600 to-pink-600 text-white font-medium rounded-lg hover:from-red-700 hover:to-pink-700 disabled:opacity-50 disabled:cursor-not-allowed transition-all shadow-sm hover:shadow flex items-center gap-2"
              >
                <svg v-if="isRevoking" class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                {{ isRevoking ? 'Отзыв...' : 'Отозвать токен' }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref, computed, watch, onMounted } from 'vue'
import axios from 'axios'
import { BACKEND_URL } from '@/router.js'
import {useRoute, useRouter} from "vue-router";
const route = useRoute()
const router = useRouter()
// Реактивные данные
const headers = ref([
  { key: 'id', label: 'ID' },
  { key: 'username', label: 'Пользователь' },
  { key: 'expires_at', label: 'Срок действия' },
  { key: 'user_agent', label: 'Устройство' }
])

const tokens = ref([])
const isLoading = ref(false)
const error = ref(null)

// Поиск и сортировка
const searchQuery = ref('')
const sortKey = ref('id')
const sortOrder = ref('desc') // Сортируем по убыванию ID по умолчанию

// Пагинация
const currentPage = ref(1)
const itemsPerPage = ref(10)

// Модальные окна
const showRevokeModal = ref(false)
const tokenToRevoke = ref(null)
const isRevoking = ref(false)

// Уведомления
const notification = ref({
  show: false,
  message: '',
  type: 'success'
})

// Показать уведомление
const showNotification = (message, type = 'success') => {
  notification.value = {
    show: true,
    message,
    type
  }

  setTimeout(() => {
    notification.value.show = false
  }, 3000)
}

// Загрузка данных
const loadData = async () => {
  try {
    isLoading.value = true
    error.value = null
    const username = route.params.username
    const response = await axios.get(BACKEND_URL + '/api/tokens/' + username + '/all')

    if (response.data.success) {
      tokens.value = response.data.data || []
    } else {
      throw new Error(response.data.message || 'Не удалось загрузить список токенов')
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

// Вычисляемые свойства
const activeTokensCount = computed(() => {
  return tokens.value.filter(t => !t.is_revoked).length
})

const revokedTokensCount = computed(() => {
  return tokens.value.filter(t => t.is_revoked).length
})

const filteredTokens = computed(() => {
  let filtered = tokens.value

  // Фильтрация по поиску
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(token =>
        token.username?.toLowerCase().includes(query) ||
        token.user_id.toString().includes(query) ||
        token.ip_address?.toLowerCase().includes(query)
    )
  }

  // Сортировка
  filtered = [...filtered].sort((a, b) => {
    let aVal = a[sortKey.value]
    let bVal = b[sortKey.value]

    if (sortKey.value === 'expires_at') {
      aVal = new Date(aVal).getTime()
      bVal = new Date(bVal).getTime()
    }

    if (aVal < bVal) return sortOrder.value === 'asc' ? -1 : 1
    if (aVal > bVal) return sortOrder.value === 'asc' ? 1 : -1
    return 0
  })

  return filtered
})

// Пагинация
const totalPages = computed(() => Math.ceil(filteredTokens.value.length / itemsPerPage.value))

const paginatedItems = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return filteredTokens.value.slice(start, end)
})

const startIndex = computed(() => (currentPage.value - 1) * itemsPerPage.value + 1)
const endIndex = computed(() => Math.min(currentPage.value * itemsPerPage.value, filteredTokens.value.length))

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
const formatDate = (dateString) => {
  return new Date(dateString).toLocaleString('ru-RU', {
    year: 'numeric',
    month: '2-digit',
    day: '2-digit',
    hour: '2-digit',
    minute: '2-digit'
  })
}

const getExpiryStatus = (expiresAt) => {
  const now = new Date()
  const expiry = new Date(expiresAt)
  const daysUntilExpiry = Math.ceil((expiry - now) / (1000 * 60 * 60 * 24))

  if (daysUntilExpiry < 0) {
    return { text: 'Просрочен', class: 'text-red-600' }
  } else if (daysUntilExpiry <= 7) {
    return { text: `Истекает через ${daysUntilExpiry} дн.`, class: 'text-amber-600' }
  } else {
    return { text: 'Действителен', class: 'text-green-600' }
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

// Работа с модальным окном отзыва
const openRevokeModal = (token) => {
  tokenToRevoke.value = token
  showRevokeModal.value = true
}

const closeRevokeModal = () => {
  if (!isRevoking.value) {
    showRevokeModal.value = false
    tokenToRevoke.value = null
  }
}

// Отзыв токена
const confirmRevoke = async () => {
  if (!tokenToRevoke.value) return

  try {
    isRevoking.value = true

    const response = await axios.put(`${BACKEND_URL}/api/tokens/${tokenToRevoke.value.id}/revoke`)

    if (response.data.success) {
      showNotification('Токен успешно отозван')

      closeRevokeModal()

      await loadData()
    } else {
      throw new Error(response.data.message || 'Ошибка при отзыве токена')
    }
  } catch (err) {
    showNotification(
        err.response?.data?.message || err.message || 'Ошибка при отзыве токена',
        'error'
    )
  } finally {
    isRevoking.value = false
  }
}

watch([searchQuery], () => {
  currentPage.value = 1
})

watch(itemsPerPage, () => {
  currentPage.value = 1
})
</script>

<style scoped>
.modal-fade-enter-active,
.modal-fade-leave-active {
  transition: all 0.3s ease;
}

.modal-fade-enter-from,
.modal-fade-leave-to {
  opacity: 0;
}

.modal-fade-enter-from .bg-white,
.modal-fade-leave-to .bg-white {
  transform: scale(0.95);
}

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

tr:hover {
  transform: translateY(-1px);
  box-shadow: 0 4px 12px -2px rgba(59, 130, 246, 0.1);
}

thead tr:hover {
  transform: none;
  box-shadow: none;
}

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

<style>
.notification {
  padding: 1rem;
  border-radius: 0.75rem;
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
  font-weight: 500;
  transition: all 0.3s ease;
  animation: slideDown 0.3s ease;
}

.notification.success {
  background: linear-gradient(to right, #f0fdf4, #ecfdf5);
  border: 1px solid #bbf7d0;
  color: #065f46;
}

.notification.error {
  background: linear-gradient(to right, #fef2f2, #fdf2f8);
  border: 1px solid #fecaca;
  color: #991b1b;
}

@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.notification-enter-active,
.notification-leave-active {
  transition: all 0.3s ease;
}

.notification-enter-from,
.notification-leave-to {
  opacity: 0;
  transform: translateY(-20px);
}
</style>