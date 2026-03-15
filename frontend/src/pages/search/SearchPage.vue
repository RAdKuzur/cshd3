<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-indigo-50 flex flex-col">
    <!-- Навигация -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex items-center">
            <div class="flex-shrink-0 flex items-center">
              <svg class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
              <span class="ml-2 text-xl font-bold text-gray-900">Поисковая система</span>
            </div>
          </div>
          <div class="flex items-center">
            <router-link
                to="/"
                class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium"
            >
              На главную
            </router-link>
          </div>
        </div>
      </div>
    </nav>

    <!-- Основной контент -->
    <main class="flex-grow px-4 py-8">
      <div class="max-w-4xl mx-auto">
        <!-- Заголовок -->
        <div class="text-center mb-12">
          <h1 class="text-4xl font-bold text-gray-900 mb-4">Поиск по системе</h1>
          <p class="text-lg text-gray-600">
            Введите поисковый запрос для поиска информации
          </p>
        </div>

        <!-- Поисковая форма -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
          <!-- Поле ввода -->
          <div class="mb-8">
            <label for="search-input" class="block text-sm font-medium text-gray-700 mb-2">
              Поисковый запрос
            </label>
            <div class="relative rounded-lg shadow-sm">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </div>
              <input
                  id="search-input"
                  v-model="searchQuery"
                  type="text"
                  placeholder="Введите ваш запрос..."
                  class="block w-full pl-10 pr-4 py-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-lg"
                  @keyup.enter="performSearch"
              />
            </div>
            <p class="mt-2 text-sm text-gray-500">
              Можно искать по названию, номеру, описанию или другим параметрам
            </p>
          </div>

          <!-- Кнопка поиска -->
          <div class="flex justify-center">
            <button
                @click="performSearch"
                :disabled="isSearching || !searchQuery.trim()"
                class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-lg shadow-md hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
            >
              <svg
                  v-if="isSearching"
                  class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
              >
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              <svg
                  v-else
                  class="-ml-1 mr-3 h-5 w-5 text-white"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
              >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
              {{ isSearching ? 'Идет поиск...' : 'Поиск' }}
            </button>
          </div>
        </div>

        <!-- Состояние загрузки -->
        <div v-if="isSearching" class="text-center py-12">
          <div class="inline-flex items-center px-6 py-4 bg-white rounded-xl shadow-md">
            <svg class="animate-spin h-5 w-5 text-indigo-600 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-gray-700">Выполняется поиск...</span>
          </div>
        </div>

        <!-- Результаты поиска -->
        <div v-if="paginatedResults.length > 0" class="bg-white rounded-2xl shadow-xl p-8">
          <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">
              Найдено результатов: {{ searchResults.length }}
            </h2>
            <button
                @click="clearSearch"
                class="text-sm text-gray-500 hover:text-gray-700 flex items-center"
            >
              <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
              Очистить результаты
            </button>
          </div>

          <div class="space-y-6">
            <div
                v-for="(result, index) in paginatedResults"
                :key="result.link"
                class="border border-gray-200 rounded-lg hover:shadow-md transition-shadow overflow-hidden"
            >
              <!-- Заголовок результата с ID и ссылкой -->
              <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-8 w-8 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                    <span class="text-indigo-600 font-semibold text-sm">{{ getResultNumber(index) }}</span>
                  </div>
                  <div>
                    <div class="text-sm text-gray-500">
                      ID элемента
                    </div>
                    <div class="font-medium text-gray-900">
                      {{ extractIdFromLink(result.link) }}
                    </div>
                  </div>
                </div>

                <a
                    :href="result.link"
                    target="_blank"
                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-medium rounded-lg shadow-sm hover:from-indigo-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200"
                >
                  <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                  </svg>
                  Перейти
                </a>
              </div>

              <!-- Атрибуты -->
              <div class="px-6 py-4">
                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3">
                  Атрибуты элемента
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div
                      v-for="(value, key) in result.attributes"
                      :key="key"
                      class="bg-gray-50 rounded-lg p-3 border border-gray-100"
                  >
                    <div class="text-xs font-medium text-gray-500 mb-1">{{ key }}</div>
                    <div class="text-sm text-gray-900 break-words">
                      {{ formatAttributeValue(value) }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Пагинация -->
          <div v-if="totalPages > 1" class="mt-8 flex justify-center">
            <nav class="flex items-center space-x-2" aria-label="Pagination">
              <!-- Кнопка "Предыдущая" -->
              <button
                  @click="changePage(currentPage - 1)"
                  :disabled="currentPage === 1"
                  class="relative inline-flex items-center px-3 py-2 rounded-lg border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-white transition-colors"
              >
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                <span class="ml-1">Предыдущая</span>
              </button>

              <!-- Номера страниц -->
              <div class="hidden md:flex items-center space-x-1">
                <button
                    v-for="page in displayedPages"
                    :key="page"
                    @click="changePage(page)"
                    :class="[
                      'relative inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors',
                      currentPage === page
                        ? 'z-10 bg-indigo-600 text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500'
                        : 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-50'
                    ]"
                >
                  {{ page }}
                </button>
              </div>

              <!-- Выпадающий список для мобильных -->
              <div class="md:hidden">
                <select
                    v-model="currentPage"
                    @change="changePage(currentPage)"
                    class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-lg"
                >
                  <option v-for="page in totalPages" :key="page" :value="page">
                    Страница {{ page }} из {{ totalPages }}
                  </option>
                </select>
              </div>

              <!-- Кнопка "Следующая" -->
              <button
                  @click="changePage(currentPage + 1)"
                  :disabled="currentPage === totalPages"
                  class="relative inline-flex items-center px-3 py-2 rounded-lg border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-white transition-colors"
              >
                <span class="mr-1">Следующая</span>
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
              </button>
            </nav>
          </div>

          <!-- Информация о пагинации -->
          <div v-if="totalPages > 1" class="mt-4 text-center text-sm text-gray-500">
            Показаны {{ (currentPage - 1) * itemsPerPage + 1 }} -
            {{ Math.min(currentPage * itemsPerPage, searchResults.length) }}
            из {{ searchResults.length }} результатов
          </div>
        </div>

        <!-- Пустой результат -->
        <div v-if="searchResults && searchResults.length === 0 && !isSearching && searchQuery" class="text-center py-12 bg-white rounded-2xl shadow-xl">
          <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <h3 class="mt-4 text-lg font-medium text-gray-900">Ничего не найдено</h3>
          <p class="mt-2 text-gray-600 max-w-md mx-auto">
            По запросу "{{ searchQuery }}" ничего не найдено. Попробуйте изменить формулировку или использовать другие ключевые слова.
          </p>
          <button
              @click="clearSearch"
              class="mt-6 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >
            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            Очистить поиск
          </button>
        </div>

        <!-- История поиска -->
        <div v-if="searchHistory.length > 0 && !searchResults && !isSearching" class="mt-8 bg-white rounded-2xl shadow-xl p-8">
          <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-medium text-gray-900">История поиска</h3>
            <button
                @click="clearHistory"
                class="text-sm text-gray-500 hover:text-gray-700 flex items-center"
            >
              <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
              </svg>
              Очистить историю
            </button>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
            <button
                v-for="(query, index) in searchHistory"
                :key="index"
                @click="useHistoryQuery(query)"
                class="inline-flex items-center justify-between px-4 py-3 rounded-lg border border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 text-gray-700 transition-all duration-200 group"
            >
              <div class="flex items-center truncate">
                <svg class="flex-shrink-0 w-4 h-4 mr-3 text-gray-400 group-hover:text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <span class="truncate text-left">{{ query }}</span>
              </div>
              <button
                  @click.stop="removeFromHistory(index)"
                  class="ml-2 text-gray-400 hover:text-red-500 opacity-0 group-hover:opacity-100 transition-opacity"
                  title="Удалить из истории"
              >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </button>
          </div>
        </div>

        <!-- Ошибка -->
        <div v-if="error && !isSearching" class="mt-8 bg-red-50 border border-red-200 rounded-2xl p-8">
          <div class="flex">
            <svg class="h-6 w-6 text-red-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
              <h3 class="text-lg font-medium text-red-800">Ошибка при выполнении поиска</h3>
              <p class="mt-2 text-red-700">{{ error }}</p>
              <button
                  @click="error = null"
                  class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
              >
                Закрыть
              </button>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue'
import axios from 'axios'
import { BACKEND_URL } from '@/router.js'

// Реактивные данные
const searchQuery = ref('')
const searchResults = ref(null)
const isSearching = ref(false)
const searchHistory = ref([])
const error = ref(null)

// Параметры пагинации
const currentPage = ref(1)
const itemsPerPage = ref(5) // Количество результатов на странице

// Загружаем историю поиска из localStorage
onMounted(() => {
  const savedHistory = localStorage.getItem('searchHistory')
  if (savedHistory) {
    searchHistory.value = JSON.parse(savedHistory)
  }
})

// Вычисляемые свойства для пагинации
const paginatedResults = computed(() => {
  if (!searchResults.value) return []

  const start = (currentPage.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return searchResults.value.slice(start, end)
})

const totalPages = computed(() => {
  if (!searchResults.value) return 0
  return Math.ceil(searchResults.value.length / itemsPerPage.value)
})

// Вычисляемые страницы для отображения
const displayedPages = computed(() => {
  const delta = 2 // Количество страниц слева и справа от текущей
  const range = []
  const rangeWithDots = []
  let l

  for (let i = 1; i <= totalPages.value; i++) {
    if (i === 1 || i === totalPages.value || (i >= currentPage.value - delta && i <= currentPage.value + delta)) {
      range.push(i)
    }
  }

  range.forEach((i) => {
    if (l) {
      if (i - l === 2) {
        rangeWithDots.push(l + 1)
      } else if (i - l !== 1) {
        rangeWithDots.push('...')
      }
    }
    rangeWithDots.push(i)
    l = i
  })

  return rangeWithDots
})

// Сбрасываем страницу при новом поиске
watch(searchResults, () => {
  currentPage.value = 1
})

// Функция поиска
const performSearch = async () => {
  const query = searchQuery.value.trim()

  if (!query) {
    return
  }

  try {
    isSearching.value = true
    error.value = null
    searchResults.value = null

    // Добавляем запрос в историю
    addToHistory(query)

    // Отправляем POST запрос
    const response = await axios.post(
        `${BACKEND_URL}/api/search`,
        {
          text: query,
          timestamp: new Date().toISOString()
        },
        {
          headers: {
            'Content-Type': 'application/json'
          }
        }
    )

    // Обрабатываем ответ
    if (response.data.success) {
      searchResults.value = response.data.data || []
    } else {
      throw new Error(response.data.message || 'Ошибка при выполнении поиска')
    }

  } catch (err) {
    console.error('Search error:', err)
    error.value = err.response?.data?.message || err.message || 'Произошла ошибка при поиске'
  } finally {
    isSearching.value = false
  }
}

// Изменение страницы
const changePage = (page) => {
  if (page >= 1 && page <= totalPages.value) {
    currentPage.value = page
    // Плавный скролл к результатам
    document.querySelector('.bg-white.rounded-2xl.shadow-xl.p-8')?.scrollIntoView({
      behavior: 'smooth',
      block: 'start'
    })
  }
}

// Получение номера результата с учетом пагинации
const getResultNumber = (index) => {
  return (currentPage.value - 1) * itemsPerPage.value + index + 1
}

// Извлечение ID из ссылки
const extractIdFromLink = (link) => {
  try {
    const url = new URL(link)
    const pathSegments = url.pathname.split('/')
    return pathSegments[pathSegments.length - 1] || link
  } catch {
    // Если не удалось распарсить как URL, возвращаем как есть
    return link
  }
}

// Форматирование значения атрибута
const formatAttributeValue = (value) => {
  if (value === null || value === undefined) {
    return '—'
  }
  if (typeof value === 'string' && value.trim() === '') {
    return '—'
  }
  return value
}

// Добавление в историю
const addToHistory = (query) => {
  // Удаляем дубликаты
  searchHistory.value = searchHistory.value.filter(item => item !== query)

  // Добавляем в начало
  searchHistory.value.unshift(query)

  // Ограничиваем историю 10 последними запросами
  if (searchHistory.value.length > 10) {
    searchHistory.value = searchHistory.value.slice(0, 10)
  }

  // Сохраняем в localStorage
  localStorage.setItem('searchHistory', JSON.stringify(searchHistory.value))
}

// Использование запроса из истории
const useHistoryQuery = (query) => {
  searchQuery.value = query
  performSearch()
}

// Удаление из истории
const removeFromHistory = (index) => {
  searchHistory.value.splice(index, 1)
  localStorage.setItem('searchHistory', JSON.stringify(searchHistory.value))
}

// Очистка истории
const clearHistory = () => {
  searchHistory.value = []
  localStorage.removeItem('searchHistory')
}

// Очистка поиска
const clearSearch = () => {
  searchQuery.value = ''
  searchResults.value = null
  error.value = null
  currentPage.value = 1
}
</script>

<style scoped>
/* Стили для обрезки длинного текста */
.truncate {
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

/* Анимация для появления результатов */
.border-gray-200 {
  transition: all 0.2s ease-in-out;
}

.border-gray-200:hover {
  transform: translateY(-2px);
}

/* Стили для пагинации */
button:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

/* Стили для выпадающего списка на мобильных */
select {
  background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
  background-position: right 0.5rem center;
  background-repeat: no-repeat;
  background-size: 1.5em 1.5em;
  padding-right: 2.5rem;
  -webkit-print-color-adjust: exact;
  print-color-adjust: exact;
  appearance: none;
}
</style>