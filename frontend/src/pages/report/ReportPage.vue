<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-6">
    <div class="max-w-6xl mx-auto">
      <!-- Заголовок и навигация -->
      <div class="mb-12">
        <div class="flex items-center justify-between mb-8">
          <div>
            <h1 class="text-3xl font-bold text-gray-900">Отчеты системы</h1>
            <p class="text-gray-600 mt-2">Аналитика и статистика материальных ценностей</p>
          </div>
          <router-link
              to="/"
              class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:text-blue-600 transition-colors"
          >
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Назад к категориям
          </router-link>
        </div>

        <!-- Фильтры и период -->
        <div class="mb-10 bg-white rounded-xl p-6 shadow-sm border border-gray-100">
          <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
              <h3 class="text-lg font-semibold text-gray-800 mb-2">Параметры отчетов</h3>
              <p class="text-gray-500 text-sm">Выберите тип отчета и период для анализа</p>
            </div>
            <div class="flex items-center gap-4">
              <div class="relative">
                <select
                    v-model="selectedPeriod"
                    class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-10 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
                  <option value="month">За последний месяц</option>
                  <option value="quarter">За последний квартал</option>
                  <option value="year">За последний год</option>
                  <option value="all">За все время</option>
                </select>
                <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </div>
              <button
                  @click="exportAllReports"
                  class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all shadow-sm"
              >
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Экспорт всех
              </button>
            </div>
          </div>
        </div>

        <!-- Карточки отчетов -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <!-- Отчет по объектам материального учёта -->
          <div
              class="report-card group bg-gradient-to-br from-purple-500 to-indigo-600 hover:from-purple-600 hover:to-indigo-700"
              @click="navigateTo('/reports/things')"
          >
            <div class="absolute top-6 right-6">
              <div class="bg-white/20 backdrop-blur-sm p-3 rounded-xl">
                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
              </div>
            </div>

            <div class="flex-1 flex flex-col justify-end">
<!--              <div class="flex items-center gap-3 mb-4">-->
<!--                <span class="text-white/80 text-sm font-medium px-3 py-1 bg-white/20 rounded-full">-->
<!--                  {{ stats.things.count }} объектов-->
<!--                </span>-->
<!--                <span :class="`text-sm font-medium px-3 py-1 rounded-full ${stats.things.change >= 0 ? 'bg-green-500/20 text-green-100' : 'bg-red-500/20 text-red-100'}`">-->
<!--                  {{ stats.things.change >= 0 ? '+' : '' }}{{ stats.things.change }}%-->
<!--                </span>-->
<!--              </div>-->
              <h3 class="text-2xl font-bold text-white mb-3">
                Объекты учёта
              </h3>
              <p class="text-purple-100/90 text-sm leading-relaxed">
                Детальная статистика по всем материальным объектам, их движению и состоянию
              </p>
            </div>

            <div class="mt-8 flex items-center justify-between">
              <div class="flex items-center gap-2 text-white/80">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <span class="text-sm">PDF, Excel, CSV</span>
              </div>
              <div class="bg-white/20 p-2 rounded-lg group-hover:bg-white/30 transition-colors">
                <svg class="w-5 h-5 text-white transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
              </div>
            </div>
          </div>

          <!-- Отчет по кабинетам -->
          <div
              class="report-card group bg-gradient-to-br from-cyan-500 to-blue-600 hover:from-cyan-600 hover:to-blue-700"
              @click="navigateTo('/reports/auditoriums')"
          >
            <div class="absolute top-6 right-6">
              <div class="bg-white/20 backdrop-blur-sm p-3 rounded-xl">
                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
              </div>
            </div>

            <div class="flex-1 flex flex-col justify-end">
              <div class="flex items-center gap-3 mb-4">
<!--                <span class="text-white/80 text-sm font-medium px-3 py-1 bg-white/20 rounded-full">-->
<!--                  {{ stats.auditoriums.count }} помещений-->
<!--                </span>-->
<!--                <span class="text-sm font-medium px-3 py-1 bg-blue-500/20 text-blue-100 rounded-full">-->
<!--                  {{ stats.auditoriums.occupancy }}% заполнено-->
<!--                </span>-->
              </div>
              <h3 class="text-2xl font-bold text-white mb-3">
                Помещения
              </h3>
              <p class="text-cyan-100/90 text-sm leading-relaxed">
                Анализ использования помещений, распределение активов и занятости кабинетов
              </p>
            </div>

            <div class="mt-8 flex items-center justify-between">
              <div class="flex items-center gap-2 text-white/80">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <span class="text-sm">PDF, Excel, CSV</span>
              </div>
              <div class="bg-white/20 p-2 rounded-lg group-hover:bg-white/30 transition-colors">
                <svg class="w-5 h-5 text-white transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
              </div>
            </div>
          </div>

          <!-- Отчет по АРМ -->
          <div
              class="report-card group bg-gradient-to-br from-rose-500 to-pink-600 hover:from-rose-600 hover:to-pink-700"
              @click="navigateTo('/reports/workstations')"
          >
            <div class="absolute top-6 right-6">
              <div class="bg-white/20 backdrop-blur-sm p-3 rounded-xl">
                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
              </div>
            </div>

            <div class="flex-1 flex flex-col justify-end">
<!--              <div class="flex items-center gap-3 mb-4">-->
<!--                <span class="text-white/80 text-sm font-medium px-3 py-1 bg-white/20 rounded-full">-->
<!--                  {{ stats.workstations.count }} рабочих мест-->
<!--                </span>-->
<!--                <span :class="`text-sm font-medium px-3 py-1 rounded-full ${stats.workstations.active >= 80 ? 'bg-green-500/20 text-green-100' : 'bg-yellow-500/20 text-yellow-100'}`">-->
<!--                  {{ stats.workstations.active }}% активно-->
<!--                </span>-->
<!--              </div>-->
              <h3 class="text-2xl font-bold text-white mb-3">
                АРМ
              </h3>
              <p class="text-rose-100/90 text-sm leading-relaxed">
                Отчеты по автоматизированным рабочим местам, их техническому состоянию и использованию
              </p>
            </div>

            <div class="mt-8 flex items-center justify-between">
              <div class="flex items-center gap-2 text-white/80">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <span class="text-sm">PDF, Excel, CSV</span>
              </div>
              <div class="bg-white/20 p-2 rounded-lg group-hover:bg-white/30 transition-colors">
                <svg class="w-5 h-5 text-white transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
              </div>
            </div>
          </div>

          <!-- Быстрые отчеты -->
          <div class="md:col-span-2 lg:col-span-3 mt-8">
            <h3 class="text-xl font-bold text-gray-800 mb-6">Быстрые отчеты</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
              <button
                  @click="generateQuickReport('inventory')"
                  class="bg-white p-4 rounded-xl border border-gray-200 hover:border-blue-300 hover:shadow-md transition-all text-left group"
              >
                <div class="flex items-center justify-between mb-3">
                  <span class="text-sm font-medium text-gray-500">Инвентаризация</span>
                  <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                  </svg>
                </div>
                <h4 class="font-semibold text-gray-800 mb-2">Акт инвентаризации</h4>
                <p class="text-gray-500 text-sm">Сформировать акт инвентаризации на текущую дату</p>
              </button>

              <button
                  @click="generateQuickReport('movement')"
                  class="bg-white p-4 rounded-xl border border-gray-200 hover:border-blue-300 hover:shadow-md transition-all text-left group"
              >
                <div class="flex items-center justify-between mb-3">
                  <span class="text-sm font-medium text-gray-500">Движение</span>
                  <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                  </svg>
                </div>
                <h4 class="font-semibold text-gray-800 mb-2">Движение активов</h4>
                <p class="text-gray-500 text-sm">Отчет о перемещении объектов за период</p>
              </button>

              <button
                  @click="generateQuickReport('depreciation')"
                  class="bg-white p-4 rounded-xl border border-gray-200 hover:border-blue-300 hover:shadow-md transition-all text-left group"
              >
                <div class="flex items-center justify-between mb-3">
                  <span class="text-sm font-medium text-gray-500">Амортизация</span>
                  <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                  </svg>
                </div>
                <h4 class="font-semibold text-gray-800 mb-2">Амортизация ОС</h4>
                <p class="text-gray-500 text-sm">Расчет амортизации основных средств</p>
              </button>
            </div>
          </div>
        </div>

        <!-- Информационная панель -->
        <div class="mt-12 bg-gradient-to-r from-gray-800 to-gray-900 rounded-2xl p-6 text-white">
          <div class="flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-4">
              <div class="bg-blue-500/20 p-3 rounded-xl">
                <svg class="w-8 h-8 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div>
                <h4 class="font-bold text-lg">Отчеты обновляются автоматически</h4>
                <p class="text-gray-300 text-sm mt-1">Данные актуальны на {{ lastUpdate }}</p>
              </div>
            </div>
<!--            <button-->
<!--                @click="refreshReports"-->
<!--                class="flex items-center gap-2 px-5 py-3 bg-white/10 hover:bg-white/20 rounded-xl transition-colors"-->
<!--            >-->
<!--              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
<!--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />-->
<!--              </svg>-->
<!--              Обновить данные-->
<!--            </button>-->
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const selectedPeriod = ref('month')

// Моковые данные статистики
const stats = ref({
  things: {
    count: 1254,
    change: 12,
    lastUpdate: 'Сегодня, 10:30'
  },
  auditoriums: {
    count: 48,
    occupancy: 87,
    available: 6
  },
  workstations: {
    count: 156,
    active: 92,
    maintenance: 8
  }
})

// Вычисляемое свойство для даты обновления
const lastUpdate = computed(() => {
  const now = new Date()
  return now.toLocaleDateString('ru-RU', {
    day: 'numeric',
    month: 'long',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
})

const navigateTo = (path) => {
  router.push(path)
}

const refreshReports = () => {
  // Здесь будет логика обновления данных
  console.log('Обновление отчетов...')

  // Обновляем время последнего обновления
  stats.value.things.lastUpdate = 'Только что'

  // Можно добавить индикатор загрузки
  setTimeout(() => {
    console.log('Отчеты обновлены')
  }, 1000)
}

const generateQuickReport = (type) => {
  const reports = {
    inventory: 'Инвентаризация',
    movement: 'Движение активов',
    depreciation: 'Амортизация'
  }

  console.log(`Генерация отчета: ${reports[type]}`)

  // Здесь будет логика генерации быстрых отчетов
  alert(`Начинается генерация отчета "${reports[type]}"...`)
}

const exportAllReports = () => {
  console.log('Экспорт всех отчетов...')
  alert('Запущен экспорт всех отчетов в выбранном формате')
}
</script>

<style scoped>
.report-card {
  position: relative;
  padding: 1.5rem;
  display: flex;
  flex-direction: column;
  cursor: pointer;
  transition: all 0.3s;
  transform: translateY(0);
  min-height: 280px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  border-radius: 1rem;
  overflow: hidden;
}

.report-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
}

.report-card::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.1), transparent);
  opacity: 0;
  transition: opacity 0.3s;
}

.report-card:hover::before {
  opacity: 1;
}

.report-card svg {
  transition: all 0.3s ease;
}

.report-card:hover svg:not(.group-hover\:translate-x-1) {
  transform: scale(1.1);
}

.report-card {
  border: 2px solid transparent;
  background-clip: padding-box;
  position: relative;
}

.report-card::after {
  content: '';
  position: absolute;
  inset: 0;
  z-index: -1;
  background: linear-gradient(to right,
  rgba(255, 255, 255, 0.2),
  rgba(255, 255, 255, 0.1),
  transparent);
  opacity: 0;
  transition: opacity 0.3s ease;
  border-radius: inherit;
}

.report-card:hover::after {
  opacity: 1;
}

button.bg-white:hover {
  transform: translateY(-2px);
}

@media (max-width: 768px) {
  .report-card {
    min-height: 260px;
    padding: 1.25rem;
  }

  .md\:col-span-2 {
    grid-column: span 1;
  }
}

@keyframes spin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}

.animate-spin {
  animation: spin 1s linear infinite;
}
</style>