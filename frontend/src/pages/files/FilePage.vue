<template>
  <div class="p-6 bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
      <!-- Заголовок и элементы управления -->
      <div class="mb-8">
        <div class="flex justify-between items-center">
          <div class="flex items-center gap-4">
            <router-link
                to="/admin"
                class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:text-blue-600
             transition-colors border border-gray-300 rounded-lg hover:border-blue-400"
            >
              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
              </svg>
            </router-link>
            <div>
              <h1 class="text-3xl font-bold text-gray-900">Файлы системы</h1>
              <p class="text-gray-600 mt-2">Всего файлов: {{ filteredFiles.length }}</p>
            </div>
          </div>
          <button
              @click="openCreateModal"
              class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-semibold shadow-sm transition-colors"
          >
            + Добавить файл
          </button>
        </div>

        <!-- Панель поиска и фильтров -->
        <div class="mt-6 flex gap-4 flex-wrap">
          <div class="flex-1 min-w-[300px]">
            <div class="relative">
              <input
                  v-model="searchQuery"
                  type="text"
                  placeholder="Поиск по таблице, файлу, ID записи..."
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
                v-model="sortField"
                class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
            >
              <option value="table_name">Сортировка по таблице</option>
              <option value="row_id">По ID записи</option>
              <option value="filename">По имени файла</option>
              <option value="created_at">По дате создания</option>
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
                v-for="file in paginatedFiles"
                :key="file.id"
                class="hover:bg-gradient-to-r hover:from-indigo-50 hover:to-white transition-all duration-200 group"
            >
              <!-- ID файла -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-10 w-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                  </div>
                  <div class="ml-4">
                    <div class="text-sm font-semibold text-gray-900">
                      {{ file.file_id }}
                    </div>
                    <div class="text-xs text-gray-400">
                      ID: {{ file.id }}
                    </div>
                  </div>
                </div>
              </td>

              <!-- Таблица и запись -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-8 w-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                    <svg class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                  </div>
                  <div>
                    <div class="text-sm font-medium text-gray-900">{{ file.table_name }}</div>
                    <div class="text-xs text-gray-500">ID записи: {{ file.row_id }}</div>
                  </div>
                </div>
              </td>

              <!-- Информация о файле -->
              <td class="px-6 py-4">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-8 w-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                    <svg class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                  </div>
                  <div class="truncate max-w-xs">
                    <div class="text-sm font-semibold text-gray-900 truncate">
                      {{ file.filename }}
                    </div>
                    <div class="text-xs text-gray-500 truncate">
                      file_id: {{ file.file_id }}
                    </div>
                  </div>
                </div>
              </td>

              <!-- Дата создания -->
<!--              <td class="px-6 py-4 whitespace-nowrap">-->
<!--                <div class="flex items-center">-->
<!--                  <div class="flex-shrink-0 h-8 w-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">-->
<!--                    <svg class="h-4 w-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
<!--                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />-->
<!--                    </svg>-->
<!--                  </div>-->
<!--                  <div>-->
<!--                    <div class="text-sm text-gray-900">{{ formatDate(file.created_at) }}</div>-->
<!--                    <div v-if="file.updated_at" class="text-xs text-gray-500">-->
<!--                      обновлено: {{ formatDate(file.updated_at) }}-->
<!--                    </div>-->
<!--                  </div>-->
<!--                </div>-->
<!--              </td>-->

              <!-- Действия -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center space-x-2">
                  <!-- Кнопка удаления -->
                  <button
                      @click="confirmDelete(file)"
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
        <div v-if="!isLoading && filteredFiles.length === 0" class="text-center py-12">
          <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <h3 class="mt-2 text-sm font-medium text-gray-900">Файлы не найдены</h3>
          <p class="mt-1 text-sm text-gray-500">Попробуйте изменить параметры поиска</p>
        </div>

        <!-- Пагинация -->
        <div v-if="!isLoading && filteredFiles.length > 0" class="px-6 py-4 border-t border-gray-200 bg-gray-50">
          <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700">
              Показано с {{ startIndex }} по {{ endIndex }} из {{ filteredFiles.length }} записей
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

    <!-- Модальное окно подтверждения удаления -->
    <div v-if="showDeleteModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg p-6 max-w-md mx-4">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Подтверждение удаления</h3>
        <p class="text-sm text-gray-500 mb-6">
          Вы уверены, что хотите удалить файл
          <span class="font-semibold">{{ fileToDelete?.filename }}</span>?
          Это действие нельзя отменить.
        </p>
        <div class="flex justify-end space-x-3">
          <button
              @click="showDeleteModal = false"
              class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50"
          >
            Отмена
          </button>
          <button
              @click="deleteFile"
              class="px-4 py-2 bg-red-600 text-white rounded-md text-sm font-medium hover:bg-red-700"
          >
            Удалить
          </button>
        </div>
      </div>
    </div>

    <!-- Модальное окно создания файла -->
    <div v-if="showCreateModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Добавить новый файл</h3>

        <form @submit.prevent="createFile">
          <div class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                Таблица
              </label>
              <input
                  v-model="newFile.table_name"
                  type="text"
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                  placeholder="Например: users, posts, etc."
              >
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                ID записи
              </label>
              <input
                  v-model="newFile.row_id"
                  type="number"
                  required
                  min="1"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                  placeholder="ID записи в таблице"
              >
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                File ID
              </label>
              <input
                  v-model="newFile.file_id"
                  type="text"
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                  placeholder="Идентификатор файла"
              >
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                Имя файла
              </label>
              <input
                  v-model="newFile.filename"
                  type="text"
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                  placeholder="example.jpg"
              >
            </div>
          </div>

          <div class="mt-6 flex justify-end space-x-3">
            <button
                type="button"
                @click="showCreateModal = false"
                class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50"
            >
              Отмена
            </button>
            <button
                type="submit"
                :disabled="isCreating"
                class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-medium hover:bg-indigo-700 disabled:opacity-50"
            >
              {{ isCreating ? 'Создание...' : 'Создать' }}
            </button>
          </div>
        </form>
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
  { key: 'file_id', label: 'File ID' },
  { key: 'table_name', label: 'Таблица и запись' },
  { key: 'filename', label: 'Файл' },
  // { key: 'created_at', label: 'Дата создания' },
  { key: 'actions', label: 'Действия' }
])

const files = ref([])
const isLoading = ref(false)
const error = ref(null)

const searchQuery = ref('')
const sortField = ref('table_name')
const sortKey = ref('table_name')
const sortOrder = ref('asc')

// Пагинация
const currentPage = ref(1)
const itemsPerPage = ref(10)

// Модальные окна
const showDeleteModal = ref(false)
const showCreateModal = ref(false)
const fileToDelete = ref(null)

// Создание файла
const newFile = ref({
  table_name: '',
  row_id: '',
  file_id: '',
  filename: ''
})
const isCreating = ref(false)

// Загрузка данных
const loadData = async () => {
  try {
    isLoading.value = true
    error.value = null

    const response = await axios.get(`${BACKEND_URL}/api/files`)

    // Предполагаем, что ответ приходит в формате { data: [...] }
    if (response.data.data) {
      files.value = response.data.data.map(file => ({
        id: file.id,
        table_name: file.table_name,
        row_id: file.row_id,
        file_id: file.file_id,
        filename: file.filename,
        created_at: file.created_at || new Date().toISOString(),
        updated_at: file.updated_at || null
      }))
    } else {
      throw new Error('Не удалось загрузить список файлов')
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
const filteredFiles = computed(() => {
  let filtered = files.value

  // Фильтрация по поиску
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(file =>
        (file.table_name && file.table_name.toLowerCase().includes(query)) ||
        (file.row_id && file.row_id.toString().includes(query)) ||
        (file.filename && file.filename.toLowerCase().includes(query)) ||
        (file.file_id && file.file_id.toLowerCase().includes(query)) ||
        (file.id && file.id.toString().includes(query))
    )
  }

  // Сортировка
  filtered = [...filtered].sort((a, b) => {
    let aVal = a[sortKey.value]
    let bVal = b[sortKey.value]

    if (sortKey.value === 'created_at' || sortKey.value === 'updated_at') {
      aVal = new Date(aVal)
      bVal = new Date(bVal)
    } else if (sortKey.value === 'row_id') {
      aVal = parseInt(aVal)
      bVal = parseInt(bVal)
    }

    if (aVal < bVal) return sortOrder.value === 'asc' ? -1 : 1
    if (aVal > bVal) return sortOrder.value === 'asc' ? 1 : -1
    return 0
  })

  return filtered
})

// Пагинация
const totalPages = computed(() => Math.ceil(filteredFiles.value.length / itemsPerPage.value))

const paginatedFiles = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return filteredFiles.value.slice(start, end)
})

const startIndex = computed(() => (currentPage.value - 1) * itemsPerPage.value + 1)
const endIndex = computed(() => Math.min(currentPage.value * itemsPerPage.value, filteredFiles.value.length))

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

const formatDate = (dateString) => {
  if (!dateString) return 'Не указана'
  try {
    return new Date(dateString).toLocaleDateString('ru-RU', {
      year: 'numeric',
      month: 'long',
      day: 'numeric',
      hour: '2-digit',
      minute: '2-digit'
    })
  } catch (e) {
    return dateString
  }
}

// Действия с файлами
const confirmDelete = (file) => {
  fileToDelete.value = file
  showDeleteModal.value = true
}

const deleteFile = async () => {
  if (!fileToDelete.value) return

  try {
    isLoading.value = true
    await axios.delete(`${BACKEND_URL}/api/files/${fileToDelete.value.id}`)

    // Удаляем файл из списка
    files.value = files.value.filter(file => file.id !== fileToDelete.value.id)

    showDeleteModal.value = false
    fileToDelete.value = null

    alert('Файл успешно удален')
  } catch (err) {
    alert('Ошибка при удалении файла')
    console.error('Ошибка удаления:', err)
  } finally {
    isLoading.value = false
  }
}

const openCreateModal = () => {
  newFile.value = { table_name: '', row_id: '', file_id: '', filename: '' }
  showCreateModal.value = true
}

const createFile = async () => {
  try {
    isCreating.value = true

    const response = await axios.post(`${BACKEND_URL}/api/files`, {
      table_name: newFile.value.table_name,
      row_id: parseInt(newFile.value.row_id),
      file_id: newFile.value.file_id,
      filename: newFile.value.filename
    })

    if (response.data.success) {
      // Добавляем новый файл в список, если API возвращает созданную запись
      if (response.data.data) {
        files.value.unshift(response.data.data)
      } else {
        // Иначе перезагружаем список
        await loadData()
      }

      showCreateModal.value = false
      alert('Файл успешно добавлен')
    } else {
      throw new Error(response.data.message || 'Ошибка при создании файла')
    }
  } catch (err) {
    alert(err.response?.data?.message || 'Ошибка при создании файла')
    console.error('Ошибка создания:', err)
  } finally {
    isCreating.value = false
  }
}

// Сброс пагинации при изменении фильтров
watch([searchQuery], () => {
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