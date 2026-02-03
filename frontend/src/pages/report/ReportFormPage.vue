<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-4 md:p-6">
    <div class="max-w-4xl mx-auto">
      <!-- Заголовок и навигация -->
      <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
          <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Отчеты по формам</h1>
            <p class="text-gray-600 mt-1 md:mt-2 text-sm md:text-base">
              Стандартные формы отчетов
            </p>
          </div>
          <router-link
              to="/reports"
              class="flex items-center gap-2 px-3 py-2 md:px-4 md:py-2 text-gray-700 hover:text-blue-600 transition-colors text-sm md:text-base"
          >
            <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span class="hidden md:inline">Назад</span>
            <span class="md:hidden">Назад</span>
          </router-link>
        </div>
      </div>

      <!-- Основной контент -->
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Информационный блок -->
        <div class="bg-gradient-to-r from-amber-50 to-orange-50 p-6 border-b border-amber-100">
          <div class="flex items-start gap-4">
            <div class="bg-amber-100 p-3 rounded-xl">
              <svg class="w-6 h-6 md:w-8 md:h-8 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
            </div>
            <div class="flex-1">
              <h2 class="text-lg md:text-xl font-semibold text-gray-800 mb-2">
                Формы отчетности
              </h2>
              <p class="text-gray-600 text-sm md:text-base">
                Сформируйте стандартные отчеты в форматах.
                Отчеты формируются на основе данных материального учета за выбранный год.
              </p>
            </div>
          </div>
        </div>

        <!-- Выбор года -->
        <div class="p-6 border-b border-gray-100">
          <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-3">
              Выберите отчетный год
              <span class="text-red-500 ml-1">*</span>
            </label>
            <div class="relative max-w-xs">
              <select
                  v-model="selectedYear"
                  :disabled="loading"
                  class="w-full appearance-none bg-white border border-gray-300 rounded-xl px-4 py-3 pr-12 text-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all disabled:bg-gray-50 disabled:cursor-not-allowed"
              >
                <option value="" disabled>Выберите год</option>
                <option v-for="year in availableYears" :key="year" :value="year">
                  {{ year }} год
                </option>
              </select>
              <svg
                  class="absolute right-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
              >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </div>
            <p class="mt-2 text-sm text-gray-500">
              Данные будут сформированы за период с 1 января по 31 декабря {{ selectedYear }} года
            </p>
          </div>

          <!-- Статус загрузки -->
          <div v-if="loading" class="mb-6">
            <div class="flex items-center gap-3 text-amber-600">
              <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
              </svg>
              <span>Формирование отчета...</span>
            </div>
          </div>

          <!-- Сообщение об ошибке -->
          <div v-if="error" class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
            <div class="flex items-start gap-3">
              <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <div>
                <p class="text-red-700 font-medium">Ошибка при формировании отчета</p>
                <p class="text-red-600 text-sm mt-1">{{ error }}</p>
              </div>
            </div>
          </div>

          <!-- Сообщение об успехе -->
          <div v-if="success" class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl">
            <div class="flex items-start gap-3">
              <svg class="w-5 h-5 text-emerald-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <div>
                <p class="text-emerald-700 font-medium">Отчет успешно сформирован</p>
                <p class="text-emerald-600 text-sm mt-1">
                  Файл будет автоматически загружен на ваше устройство
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Кнопки форм -->
        <div class="p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
            <!-- Форма (стандартная) -->
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl border border-blue-100 p-6 hover:border-blue-200 transition-all group">
              <div class="flex items-start justify-between mb-4">
                <div>
                  <div class="inline-flex items-center gap-2 bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-medium mb-3">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Стандартная форма
                  </div>
                  <h3 class="text-xl font-semibold text-gray-800 mb-2">
                    Основная отчетность
                  </h3>
                  <p class="text-gray-600 text-sm leading-relaxed mb-6">
                    Базовая форма отчетности по материальным ценностям организации. Содержит основные показатели и сводные данные за отчетный период.
                  </p>
                </div>
              </div>

              <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="text-sm text-gray-500">
                  <div class="flex items-center gap-2 mb-1">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    <span>Формат: Excel</span>
                  </div>
                </div>

                <button
                    @click="generateFormReport('standard')"
                    :disabled="!selectedYear || loading"
                    class="flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-xl hover:from-blue-600 hover:to-indigo-700 transition-all shadow-sm hover:shadow-md disabled:opacity-50 disabled:cursor-not-allowed group/btn"
                >
                  <svg v-if="!loadingStandard" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                  </svg>
                  <svg v-else class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
                  </svg>
                  <span>{{ loadingStandard ? 'Формирование...' : 'Сформировать отчёт' }}</span>
                </button>
              </div>
            </div>

            <!-- Расширенная форма -->
            <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-2xl border border-emerald-100 p-6 hover:border-emerald-200 transition-all group">
              <div class="flex items-start justify-between mb-4">
                <div>
                  <div class="inline-flex items-center gap-2 bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-sm font-medium mb-3">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Расширенная форма
                  </div>
                  <h3 class="text-xl font-semibold text-gray-800 mb-2">
                    Детализированная отчетность
                  </h3>
                  <p class="text-gray-600 text-sm leading-relaxed mb-6">
                    Расширенная форма с детализацией по всем категориям материальных ценностей. Включает дополнительные аналитические данные и приложения.
                  </p>
                </div>
              </div>

              <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="text-sm text-gray-500">
                  <div class="flex items-center gap-2 mb-1">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    <span>Формат: Excel</span>
                  </div>
                </div>

                <button
                    @click="generateFormReport('extended')"
                    :disabled="!selectedYear || loading"
                    class="flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-xl hover:from-emerald-600 hover:to-teal-700 transition-all shadow-sm hover:shadow-md disabled:opacity-50 disabled:cursor-not-allowed group/btn"
                >
                  <svg v-if="!loadingExtended" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                  </svg>
                  <svg v-else class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
                  </svg>
                  <span>{{ loadingExtended ? 'Формирование...' : 'Сформировать отчёт' }}</span>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Информационный блок внизу -->
      <div class="mt-8 bg-gradient-to-r from-amber-800 to-orange-800 rounded-2xl p-6 text-white">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
          <div class="flex items-center gap-4">
            <div class="bg-white/20 p-3 rounded-xl">
              <svg class="w-6 h-6 md:w-8 md:h-8 text-amber-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <div>
              <h4 class="font-bold text-base md:text-lg">Важная информация</h4>
              <p class="text-amber-100 text-sm md:text-base mt-1">
                Отчеты формируются на основе данных системы материального учета.
                Рекомендуется проверять актуальность данных перед формированием отчетов.
              </p>
            </div>
          </div>
        </div>
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

// Конфигурация

// Состояния
const selectedYear = ref('')
const loadingStandard = ref(false)
const loadingExtended = ref(false)
const error = ref('')
const success = ref(false)

// Вычисляемые свойства
const loading = computed(() => loadingStandard.value || loadingExtended.value)
const availableYears = computed(() => {
  const currentYear = new Date().getFullYear()
  const years = []
  for (let year = currentYear; year >= 2000; year--) {
    years.push(year)
  }
  return years
})

// Методы
const generateFormReport = async (formType) => {
  if (!selectedYear.value) {
    error.value = 'Пожалуйста, выберите год для формирования отчета'
    setTimeout(() => error.value = '', 3000)
    return
  }

  try {
    // Сброс состояний
    error.value = ''
    success.value = false

    // Установка флага загрузки для соответствующей формы
    if (formType === 'standard') {
      loadingStandard.value = true
    } else {
      loadingExtended.value = true
    }

    // Определяем endpoint в зависимости от типа формы
    let endpoint = ''
    if (formType === 'standard') {
      endpoint = `${BACKEND_URL}/api/reports/form/${selectedYear.value}`
    } else {
      endpoint = `${BACKEND_URL}/api/reports/form-extended/${selectedYear.value}`
    }

    // Отправка GET-запроса
    const response = await axios.get(endpoint, {
      responseType: 'blob' // Важно для скачивания файла
    })

    // Создание ссылки для скачивания файла
    const blob = new Blob([response.data], {
      type: response.headers['content-type']
    })
    const url = window.URL.createObjectURL(blob)
    const link = document.createElement('a')

    // Определение имени файла
    const contentDisposition = response.headers['content-disposition']
    let filename = `${formType === 'standard' ? 'form' : 'form-extended'}_${selectedYear.value}`

    if (contentDisposition) {
      const filenameMatch = contentDisposition.match(/filename="?(.+)"?/)
      if (filenameMatch && filenameMatch.length === 2) {
        filename = filenameMatch[1]
      }
    }

    // Добавляем расширение файла в зависимости от типа контента
    const contentType = response.headers['content-type']
    // if (contentType.includes('pdf') && !filename.endsWith('.pdf')) {
    //   filename += '.pdf'
    // } else if (contentType.includes('excel') || contentType.includes('spreadsheet') || contentType.includes('xls')) {
    //   if (!filename.endsWith('.xlsx') && !filename.endsWith('.xls')) {
    //     filename += '.xlsx'
    //   }
    // }

    // Скачивание файла
    link.href = url
    link.setAttribute('download', filename)
    document.body.appendChild(link)
    link.click()
    link.remove()

    // Освобождение URL
    window.URL.revokeObjectURL(url)

    // Показать сообщение об успехе
    success.value = true
    setTimeout(() => success.value = false, 5000)

  } catch (err) {
    console.error('Ошибка при формировании отчета:', err)

    if (err.response) {
      // Ошибка от сервера
      if (err.response.status === 404) {
        error.value = 'Отчет за выбранный год не найден'
      } else if (err.response.status === 400) {
        error.value = 'Некорректный запрос. Проверьте выбранный год'
      } else if (err.response.status === 500) {
        error.value = 'Внутренняя ошибка сервера. Попробуйте позже'
      } else {
        error.value = `Ошибка сервера: ${err.response.status}`
      }
    } else if (err.request) {
      // Ошибка сети
      error.value = 'Ошибка сети. Проверьте подключение к интернету'
    } else {
      // Другие ошибки
      error.value = 'Произошла ошибка при формировании отчета'
    }

    setTimeout(() => error.value = '', 5000)
  } finally {
    // Сброс флагов загрузки
    loadingStandard.value = false
    loadingExtended.value = false
  }
}

// Инициализация - устанавливаем текущий год по умолчанию
onMounted(() => {
  selectedYear.value = new Date().getFullYear()
})
</script>

<style scoped>
/* Анимации */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.fade-in {
  animation: fadeIn 0.3s ease-out;
}

/* Стили для select */
select:focus {
  box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
}

/* Стили для кнопок в состоянии hover */
.group:hover .group-hover\:border-blue-200 {
  border-color: #93c5fd;
}

.group:hover .group-hover\:border-emerald-200 {
  border-color: #a7f3d0;
}

/* Адаптивность */
@media (max-width: 640px) {
  .grid-cols-1 > * {
    min-width: 100%;
  }

  .flex-col > * {
    width: 100%;
  }
}

/* Плавные переходы */
button, select, .transition-all {
  transition-property: all;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  transition-duration: 150ms;
}

/* Кастомный скроллбар для select */
select::-webkit-scrollbar {
  width: 8px;
}

select::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 4px;
}

select::-webkit-scrollbar-thumb {
  background: #d1d5db;
  border-radius: 4px;
}

select::-webkit-scrollbar-thumb:hover {
  background: #9ca3af;
}
</style>