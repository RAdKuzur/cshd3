<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-4 md:p-6">
    <div class="max-w-6xl mx-auto">
      <!-- Заголовок и навигация -->
      <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
          <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Отчеты по кабинетам</h1>
            <p class="text-gray-600 mt-2">Формирование отчетов по помещениям и их оснащению</p>
          </div>
          <router-link
              to="/reports"
              class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:text-blue-600 transition-colors"
          >
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Назад к отчетам
          </router-link>
        </div>
      </div>

      <!-- Основной контент -->
      <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <!-- Информационный блок -->
        <div class="mb-8 bg-blue-50 border border-blue-100 rounded-lg p-4">
          <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
              <p class="text-blue-800 text-sm">
                Выберите тип отчета для формирования. Отчет доступен для скачивания в формате Word.
              </p>
            </div>
          </div>
        </div>

        <!-- Кнопки отчетов -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-2xl mx-auto">
          <!-- Отчет по всем кабинетам -->
          <button
              @click="generateAllAuditoriumsReport"
              :disabled="loading.all"
              class="group relative overflow-hidden bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-xl p-6 transition-all duration-300 hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
          >
            <div class="absolute top-4 right-4 opacity-20">
              <svg class="w-16 h-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
            </div>

            <div class="relative z-10">
              <div class="flex items-center gap-3 mb-4">
                <div class="bg-white/20 p-2 rounded-lg">
                  <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                  </svg>
                </div>
                <span v-if="loading.all" class="text-sm font-medium bg-white/30 px-3 py-1 rounded-full">
                  Формирование...
                </span>
              </div>

              <h3 class="text-xl font-bold mb-2">Отчет по всем кабинетам</h3>
              <p class="text-blue-100/80 text-sm mb-4">
                Полный отчет по всем помещениям с информацией об оборудовании и оснащении
              </p>

              <div class="flex items-center justify-between">
                <div class="flex items-center gap-2 text-blue-100/70 text-sm">
                  <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                  </svg>
                  Word
                </div>
                <div class="bg-white/20 p-2 rounded-lg group-hover:bg-white/30 transition-colors">
                  <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                  </svg>
                </div>
              </div>
            </div>
          </button>

          <!-- Отчет по конкретному кабинету -->
          <button
              @click="showAuditoriumModal = true"
              class="group relative overflow-hidden bg-gradient-to-r from-cyan-500 to-cyan-600 hover:from-cyan-600 hover:to-cyan-700 text-white rounded-xl p-6 transition-all duration-300 hover:shadow-lg"
          >
            <div class="absolute top-4 right-4 opacity-20">
              <svg class="w-16 h-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
            </div>

            <div class="relative z-10">
              <div class="flex items-center gap-3 mb-4">
                <div class="bg-white/20 p-2 rounded-lg">
                  <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                  </svg>
                </div>
              </div>

              <h3 class="text-xl font-bold mb-2">Отчет по кабинету</h3>
              <p class="text-cyan-100/80 text-sm mb-4">
                Детальный отчет по выбранному помещению с полным списком оборудования
              </p>

              <div class="flex items-center justify-between">
                <div class="flex items-center gap-2 text-cyan-100/70 text-sm">
                  <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                  </svg>
                  Word
                </div>
                <div class="bg-white/20 p-2 rounded-lg group-hover:bg-white/30 transition-colors">
                  <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                  </svg>
                </div>
              </div>
            </div>
          </button>
        </div>
      </div>

      <!-- Модальное окно выбора кабинета -->
      <div v-if="showAuditoriumModal" class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md">
          <!-- Заголовок модального окна -->
          <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
              <h3 class="text-lg font-semibold text-gray-800">Выберите кабинет</h3>
              <button
                  @click="closeModal"
                  class="text-gray-400 hover:text-gray-600 transition-colors"
              >
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
            <p class="text-gray-500 text-sm mt-1">Выберите кабинет для формирования отчета</p>
          </div>

          <!-- Тело модального окна -->
          <div class="p-6">
            <!-- Поле поиска -->
            <div class="mb-4">
              <div class="relative">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input
                    v-model="searchQuery"
                    type="text"
                    placeholder="Поиск кабинета..."
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500"
                >
              </div>
            </div>

            <!-- Список кабинетов -->
            <div class="max-h-64 overflow-y-auto border border-gray-200 rounded-lg">
              <div v-if="loading.auditoriums" class="p-4 text-center text-gray-500">
                <div class="flex items-center justify-center gap-2">
                  <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  Загрузка кабинетов...
                </div>
              </div>
              <div v-else-if="filteredAuditoriums.length === 0" class="p-4 text-center text-gray-500">
                Кабинеты не найдены
              </div>
              <div v-else>
                <div
                    v-for="auditorium in filteredAuditoriums"
                    :key="auditorium.id"
                    @click="selectAuditorium(auditorium)"
                    class="p-3 border-b border-gray-100 last:border-b-0 hover:bg-gray-50 cursor-pointer transition-colors"
                    :class="{ 'bg-cyan-50': selectedAuditorium?.id === auditorium.id }"
                >
                  <div class="flex items-center justify-between">
                    <div>
                      <div class="font-medium text-gray-800">{{ auditorium.name }}</div>
                      <div class="text-sm text-gray-500 mt-1">
                        <span class="flex items-center gap-2">
                          <span>Этаж {{ auditorium.floor }}</span>
                          <span>•</span>
                          <span>№ {{ auditorium.number }}</span>
                        </span>
                      </div>
                      <div v-if="auditorium.comment" class="text-xs text-gray-400 mt-1 truncate">
                        {{ auditorium.comment }}
                      </div>
                    </div>
                    <div v-if="selectedAuditorium?.id === auditorium.id" class="text-cyan-600">
                      <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                      </svg>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Выбранный кабинет -->
            <div v-if="selectedAuditorium" class="mt-4 p-3 bg-cyan-50 border border-cyan-100 rounded-lg">
              <div class="flex items-center justify-between">
                <div>
                  <div class="font-medium text-gray-800">Выбран кабинет:</div>
                  <div class="text-sm text-gray-600 mt-1">{{ selectedAuditorium.name }} ({{ selectedAuditorium.number }})</div>
                </div>
                <button
                    @click="selectedAuditorium = null"
                    class="text-gray-400 hover:text-gray-600"
                >
                  <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>
              </div>
            </div>
          </div>

          <!-- Футер модального окна -->
          <div class="p-6 border-t border-gray-100 flex items-center justify-end gap-3">
            <button
                @click="closeModal"
                class="px-4 py-2 text-gray-700 hover:text-gray-900 transition-colors"
            >
              Отмена
            </button>
            <button
                @click="generateAuditoriumReport"
                :disabled="!selectedAuditorium || loading.single"
                class="px-4 py-2 bg-gradient-to-r from-cyan-500 to-cyan-600 hover:from-cyan-600 hover:to-cyan-700 text-white rounded-lg transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2"
            >
              <svg v-if="loading.single" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              <span v-else>Выгрузить отчёт</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'

// Состояния
const showAuditoriumModal = ref(false)
const selectedAuditorium = ref(null)
const searchQuery = ref('')
const auditoriums = ref([])

// Состояния загрузки
const loading = ref({
  all: false,
  single: false,
  auditoriums: false
})

// Фильтрация кабинетов по поисковому запросу
const filteredAuditoriums = computed(() => {
  if (!searchQuery.value) return auditoriums.value

  const query = searchQuery.value.toLowerCase()
  return auditoriums.value.filter(auditorium =>
      auditorium.name.toLowerCase().includes(query) ||
      auditorium.number.toLowerCase().includes(query) ||
      (auditorium.comment && auditorium.comment.toLowerCase().includes(query))
  )
})

// Закрытие модального окна
const closeModal = () => {
  showAuditoriumModal.value = false
  selectedAuditorium.value = null
  searchQuery.value = ''
}

// Выбор кабинета
const selectAuditorium = (auditorium) => {
  selectedAuditorium.value = auditorium
}

// Загрузка списка кабинетов
const loadAuditoriums = async () => {
  try {
    loading.value.auditoriums = true
    const response = await axios.get('/api/auditoriums/index')

    if (response.data.success && response.data.data) {
      auditoriums.value = response.data.data
    } else {
      console.error('Ошибка загрузки кабинетов:', response.data)
      throw new Error('Не удалось загрузить кабинеты')
    }
  } catch (error) {
    console.error('Ошибка загрузки кабинетов:', error)

    // Мокаем данные для демонстрации, если API недоступно
    auditoriums.value = [
      { id: 1, name: "D6066", floor: 6, number: "6066", comment: "Помощники руководителей" },
      { id: 2, name: "D7076", floor: 7, number: "7076", comment: "Аппарат суда" },
      { id: 3, name: "D7063", floor: 7, number: "7063", comment: "Аппарат суда" },
      { id: 4, name: "D7062", floor: 7, number: "7062", comment: "Аппарат суда" },
      { id: 5, name: "D7061", floor: 7, number: "7061", comment: "Аппарат суда" },
      { id: 6, name: "D7001", floor: 7, number: "7001", comment: "Архив" },
      { id: 7, name: "D7056", floor: 7, number: "7056", comment: "Аппарат суда" },
      { id: 8, name: "D7055", floor: 7, number: "7055", comment: "Аппарат суда" },
      { id: 9, name: "D7057", floor: 7, number: "7057", comment: "Аппарат суда" },
      { id: 10, name: "C1034", floor: 1, number: "1034", comment: "Аппарат суда" },
    ]

    // Если нужно показать ошибку пользователю:
    // alert('Не удалось загрузить список кабинетов. Используются демонстрационные данные.')
  } finally {
    loading.value.auditoriums = false
  }
}

// Формирование отчета по всем кабинетам
const generateAllAuditoriumsReport = async () => {
  try {
    loading.value.all = true

    const response = await axios.get('/api/reports/auditoriums', {
      responseType: 'blob'
    })

    // Проверяем, что ответ действительно является blob
    if (!(response.data instanceof Blob)) {
      throw new Error('Некорректный формат ответа от сервера')
    }

    // Создаем ссылку для скачивания
    const url = window.URL.createObjectURL(response.data)
    const link = document.createElement('a')
    link.href = url

    // Получаем имя файла из заголовков Content-Disposition
    let filename = 'general_report.docx'
    const contentDisposition = response.headers['content-disposition']

    if (contentDisposition) {
      const filenameMatch = contentDisposition.match(/filename\*?=(?:UTF-8'')?([^;]+)/i)
      if (filenameMatch && filenameMatch[1]) {
        filename = decodeURIComponent(filenameMatch[1].trim())
      } else {
        const filenameMatchSimple = contentDisposition.match(/filename="([^"]+)"/i)
        if (filenameMatchSimple && filenameMatchSimple[1]) {
          filename = filenameMatchSimple[1]
        }
      }
    }

    link.setAttribute('download', filename)
    document.body.appendChild(link)
    link.click()
    link.remove()

    // Освобождаем память
    setTimeout(() => {
      window.URL.revokeObjectURL(url)
    }, 100)

  } catch (error) {
    console.error('Ошибка формирования отчета:', error)

    // Показываем более информативное сообщение об ошибке
    let errorMessage = 'Ошибка при формировании отчета'

    if (error.response) {
      if (error.response.status === 404) {
        errorMessage = 'Эндпоинт отчетов не найден. Проверьте настройки сервера.'
      } else if (error.response.status === 500) {
        // Попробуем прочитать текст ошибки из blob
        if (error.response.data instanceof Blob) {
          const text = await error.response.data.text()
          errorMessage = `Ошибка сервера: ${text.substring(0, 200)}`
        } else {
          errorMessage = 'Ошибка сервера при формировании отчета.'
        }
      } else {
        errorMessage = `Ошибка ${error.response.status}: ${error.response.statusText}`
      }
    } else if (error.request) {
      errorMessage = 'Ошибка сети. Проверьте подключение к интернету.'
    } else if (error.message.includes('Некорректный формат ответа')) {
      errorMessage = 'Сервер вернул некорректный формат данных. Возможно, возникла ошибка при формировании документа.'
    } else {
      errorMessage = `Ошибка: ${error.message}`
    }

    alert(errorMessage)
  } finally {
    loading.value.all = false
  }
}

// Формирование отчета по конкретному кабинету
const generateAuditoriumReport = async () => {
  if (!selectedAuditorium.value) return

  try {
    loading.value.single = true

    // Запрос на формирование отчета по конкретному кабинету
    const response = await axios.get(`/api/reports/auditorium/${selectedAuditorium.value.id}`, {
      responseType: 'blob' // Важно для скачивания файлов
    })

    // Создаем ссылку для скачивания файла
    const url = window.URL.createObjectURL(new Blob([response.data]))
    const link = document.createElement('a')
    link.href = url

    // Получаем имя файла из заголовков или используем дефолтное
    const filename = response.headers['content-disposition']
        ? response.headers['content-disposition'].split('filename=')[1].replace(/"/g, '')
        : `Отчет_кабинет_${selectedAuditorium.value.name}_${new Date().toISOString().split('T')[0]}.xlsx`

    link.setAttribute('download', filename)
    document.body.appendChild(link)
    link.click()
    link.remove()
    window.URL.revokeObjectURL(url)

    // Закрываем модальное окно после успешной выгрузки
    closeModal()

  } catch (error) {
    console.error('Ошибка формирования отчета:', error)

    // Обработка разных типов ошибок
    if (error.response) {
      // Ошибка от сервера
      if (error.response.status === 404) {
        alert('Эндпоинт отчета по кабинету не найден.')
      } else if (error.response.status === 500) {
        alert('Ошибка сервера при формировании отчета.')
      } else {
        alert(`Ошибка ${error.response.status}: ${error.response.statusText}`)
      }
    } else if (error.request) {
      // Ошибка сети
      alert('Ошибка сети. Проверьте подключение к интернету.')
    } else {
      // Другие ошибки
      alert('Ошибка при формировании отчета.')
    }
  } finally {
    loading.value.single = false
  }
}

// При открытии модального окна загружаем кабинеты
const openModal = () => {
  showAuditoriumModal.value = true
  if (auditoriums.value.length === 0) {
    loadAuditoriums()
  }
}

// Инициализация
onMounted(() => {
  // Предзагрузка кабинетов при загрузке страницы
  loadAuditoriums()
})

// Можно также добавить обработку глобальных настроек axios
// Например, базовый URL или заголовки по умолчанию
// axios.defaults.baseURL = 'http://ваш-домен/api'
// axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
</script>

<style scoped>
.animate-spin {
  animation: spin 1s linear infinite;
}

@keyframes spin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}

/* Стили для скроллбара */
::-webkit-scrollbar {
  width: 6px;
}

::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 3px;
}

::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
  background: #94a3b8;
}
</style>