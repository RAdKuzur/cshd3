<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-4 md:p-6">
    <div class="max-w-6xl mx-auto">
      <!-- Заголовок и навигация -->
      <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
          <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Отчет по расходным материалам</h1>
            <p class="text-gray-600 mt-2">Учёт и статистика расходных материалов</p>
          </div>
          <router-link
              to="/reports"
              class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:text-blue-600 transition-colors"
          >
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Назад
          </router-link>
        </div>
      </div>

      <!-- Основной контент -->
      <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <!-- Информационный блок -->
        <div class="mb-8 bg-indigo-50 border border-indigo-100 rounded-lg p-4">
          <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-indigo-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
              <p class="text-indigo-800 text-sm">
                Формирование полного отчета по всем расходным материалам.
              </p>
            </div>
          </div>
        </div>
        <!-- Карточка отчета -->
        <div class="max-w-md mx-auto">
          <div class="bg-gradient-to-r from-violet-500 to-purple-600 text-white rounded-xl p-6 shadow-lg">
            <!-- Декоративный элемент -->
            <div class="absolute top-4 right-4 opacity-20">
              <svg class="w-16 h-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                      d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
              </svg>
            </div>

            <div class="relative z-10">
              <!-- Заголовок и иконка -->
              <div class="flex items-center gap-4 mb-6">
                <div class="bg-white/20 p-3 rounded-lg">
                  <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                  </svg>
                </div>
                <div>
                  <h2 class="text-2xl font-bold">Расходные материалы</h2>
                  <p class="text-violet-100/80 text-sm mt-1">Полный складской отчёт</p>
                </div>
              </div>

              <!-- Детали отчета -->
              <div class="mb-6">
                <div class="grid grid-cols-2 gap-4 mb-4">
                  <div class="bg-white/10 p-3 rounded-lg">
                    <div class="text-xs text-violet-100/70 mb-1">Формат</div>
                    <div class="font-medium">Excel</div>
                  </div>
                  <div class="bg-white/10 p-3 rounded-lg">
                    <div class="text-xs text-violet-100/70 mb-1">Обновление</div>
                    <div class="font-medium">В реальном времени</div>
                  </div>
                </div>

                <ul class="space-y-2 text-violet-100/90 text-sm">
                  <li class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Наименование и артикул
                  </li>
                  <li class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Текущее количество
                  </li>
                </ul>
              </div>

              <!-- Кнопка выгрузки -->
              <button
                  @click="generateResourcesReport"
                  :disabled="loading"
                  class="w-full bg-white text-violet-600 hover:bg-gray-100 font-semibold py-3 px-4 rounded-lg transition-all duration-300
                       flex items-center justify-center gap-3 disabled:opacity-50 disabled:cursor-not-allowed shadow-md"
              >
                <template v-if="loading">
                  <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  <span>Формирование отчета...</span>
                </template>
                <template v-else>
                  <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                  </svg>
                  <span>Выгрузить отчёт по расходным материалам</span>
                </template>
              </button>

              <!-- Информация под кнопкой -->
              <div class="mt-4 text-center text-violet-100/70 text-xs">
                <p>Отчет будет сформирован в формате Excel с текущими остатками</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

// Состояния
const loading = ref(false)
const stats = ref({
  total: null,
  inStock: null,
  lowStock: null,
  outOfStock: null
})

// Формирование отчета по расходным материалам
const generateResourcesReport = async () => {
  try {
    loading.value = true

    const response = await axios.get('/api/reports/resources', {
      responseType: 'blob'
    })

    // Проверяем, что ответ является blob
    if (!(response.data instanceof Blob)) {
      throw new Error('Некорректный формат ответа от сервера')
    }

    // Проверяем размер файла
    if (response.data.size === 0) {
      throw new Error('Получен пустой файл')
    }

    // Создаем ссылку для скачивания
    const url = window.URL.createObjectURL(response.data)
    const link = document.createElement('a')
    link.href = url

    // Получаем имя файла из заголовков
    let filename = 'consumables_report.xlsx'
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

    // Устанавливаем имя файла и скачиваем
    link.setAttribute('download', filename)
    document.body.appendChild(link)
    link.click()
    link.remove()

    // Освобождаем память
    setTimeout(() => {
      window.URL.revokeObjectURL(url)
    }, 100)

    // Показываем уведомление об успехе
    showNotification('Отчет по расходным материалам успешно сформирован', 'success')

  } catch (error) {
    let errorMessage = 'Ошибка при формировании отчета'

    if (error.response) {
      if (error.response.status === 404) {
        errorMessage = 'Эндпоинт отчетов не найден. Проверьте настройки сервера.'
      } else if (error.response.status === 500) {
        if (error.response.data instanceof Blob) {
          try {
            const text = await error.response.data.text()
            errorMessage = `Ошибка сервера: ${text.substring(0, 200)}`
          } catch {
            errorMessage = 'Ошибка сервера при формировании отчета.'
          }
        } else {
          errorMessage = 'Ошибка сервера при формировании отчета.'
        }
      } else {
        errorMessage = `Ошибка ${error.response.status}: ${error.response.statusText}`
      }
    } else if (error.request) {
      errorMessage = 'Ошибка сети. Проверьте подключение к интернету.'
    } else if (error.message.includes('Некорректный формат ответа')) {
      errorMessage = 'Сервер вернул некорректный формат данных.'
    } else if (error.message.includes('пустой файл')) {
      errorMessage = 'Сервер сформировал пустой отчет.'
    } else {
      errorMessage = `Ошибка: ${error.message}`
    }

    showNotification(errorMessage, 'error')
  } finally {
    loading.value = false
  }
}

// Функция для показа уведомлений
const showNotification = (message, type = 'info') => {
  if (type === 'error') {
    alert(`❌ ${message}`)
  } else {
    alert(`✅ ${message}`)
  }
}
</script>

<style scoped>
.animate-spin {
  animation: spin 1s linear infinite;
}

@keyframes spin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}

.shadow-md {
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.shadow-lg {
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.transition-all {
  transition-property: all;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  transition-duration: 300ms;
}
</style>