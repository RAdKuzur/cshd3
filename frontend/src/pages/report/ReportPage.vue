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
            Назад
          </router-link>
        </div>

        <!-- Карточки отчетов -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
          <!-- Отчет по объектам материального учёта -->
          <div
              class="relative overflow-hidden rounded-xl p-6 flex flex-col justify-between
           bg-gradient-to-br from-purple-500 to-indigo-600
           hover:from-purple-600 hover:to-indigo-700
           transition-all hover:shadow-lg hover:scale-[1.01]
           cursor-pointer group"
              @click="navigateTo('/reports/things')"
          >
            <!-- Иконка (аналогично первому примеру) -->
            <div class="absolute right-6 top-6">
              <div class="bg-white/20 backdrop-blur-sm p-3 rounded-xl">
                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
              </div>
            </div>

            <!-- Контент -->
            <div class="pr-16">
              <h3 class="text-xl font-semibold text-white mb-2">
                Объекты учёта
              </h3>
              <p class="text-sm text-purple-100 leading-relaxed">
                Детальная статистика по всем материальным объектам, их движению и состоянию
              </p>
            </div>

            <!-- Футер с кнопкой и форматом -->
            <div class="mt-6 flex items-center justify-between">
              <div class="flex items-center gap-2 text-white/80">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <span class="text-sm">Excel</span>
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
              class="relative overflow-hidden rounded-xl p-6 flex flex-col justify-between
           bg-gradient-to-br from-cyan-500 to-blue-600
           hover:from-cyan-600 hover:to-blue-700
           transition-all hover:shadow-lg hover:scale-[1.01]
           cursor-pointer group"
              @click="navigateTo('/reports/auditoriums')"
          >
            <div class="absolute right-6 top-6">
              <div class="bg-white/20 backdrop-blur-sm p-3 rounded-xl">
                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
              </div>
            </div>

            <div class="pr-16">
              <h3 class="text-xl font-semibold text-white mb-2">
                Помещения
              </h3>
              <p class="text-sm text-cyan-100 leading-relaxed">
                Анализ использования помещений, распределение активов и занятости кабинетов
              </p>
            </div>

            <div class="mt-6 flex items-center justify-between">
              <div class="flex items-center gap-2 text-white/80">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <span class="text-sm">Word</span>
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
              class="relative overflow-hidden rounded-xl p-6 flex flex-col justify-between
           bg-gradient-to-br from-rose-500 to-pink-600
           hover:from-rose-600 hover:to-pink-700
           transition-all hover:shadow-lg hover:scale-[1.01]
           cursor-pointer group"
              @click="navigateTo('/reports/arms')"
          >
            <div class="absolute right-6 top-6">
              <div class="bg-white/20 backdrop-blur-sm p-3 rounded-xl">
                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
              </div>
            </div>

            <div class="pr-16">
              <h3 class="text-xl font-semibold text-white mb-2">
                АРМ
              </h3>
              <p class="text-sm text-rose-100 leading-relaxed">
                Отчеты по автоматизированным рабочим местам, их техническому состоянию и использованию
              </p>
            </div>

            <div class="mt-6 flex items-center justify-between">
              <div class="flex items-center gap-2 text-white/80">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <span class="text-sm">Табличная форма</span>
              </div>
              <div class="bg-white/20 p-2 rounded-lg group-hover:bg-white/30 transition-colors">
                <svg class="w-5 h-5 text-white transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
              </div>
            </div>
          </div>

          <!-- Отчеты по формам (НОВАЯ КАРТОЧКА) -->
          <div
              class="relative overflow-hidden rounded-xl p-6 flex flex-col justify-between
           bg-gradient-to-br from-amber-500 to-orange-600
           hover:from-amber-600 hover:to-orange-700
           transition-all hover:shadow-lg hover:scale-[1.01]
           cursor-pointer group"
              @click="navigateTo('/reports/forms')"
          >
            <div class="absolute right-6 top-6">
              <div class="bg-white/20 backdrop-blur-sm p-3 rounded-xl">
                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
              </div>
            </div>

            <div class="pr-16">
              <h3 class="text-xl font-semibold text-white mb-2">
                Отчёты по формам
              </h3>
              <p class="text-sm text-amber-100 leading-relaxed">
              </p>
            </div>
            <div class="mt-6 flex items-center justify-between">
              <div class="flex items-center gap-2 text-white/80">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <span class="text-sm">Excel</span>
              </div>
              <div class="bg-white/20 p-2 rounded-lg group-hover:bg-white/30 transition-colors">
                <svg class="w-5 h-5 text-white transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
              </div>
            </div>
          </div>
        </div>

        <!-- Вторая строка карточек -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
          <!-- Общий отчет по отделам -->
          <div
              class="relative overflow-hidden rounded-xl p-6 flex flex-col justify-between
           bg-gradient-to-br from-emerald-500 to-teal-600
           hover:from-emerald-600 hover:to-teal-700
           transition-all hover:shadow-lg hover:scale-[1.01]
           cursor-pointer group"
              @click="navigateTo('/reports/general')"
          >
            <div class="absolute right-6 top-6">
              <div class="bg-white/20 backdrop-blur-sm p-3 rounded-xl">
                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
              </div>
            </div>

            <div class="pr-16">


              <h3 class="text-xl font-semibold text-white mb-2">
                Отчет по отделам
              </h3>
              <p class="text-sm text-emerald-100 leading-relaxed">
                Общая статистика по всем отделам, распределение ресурсов и активов по структурным подразделениям
              </p>
            </div>

            <!-- Бейдж для "Сводный" -->
            <div class="mt-3">
                <span class="inline-block text-white/80 text-xs font-medium px-3 py-1 bg-white/20 rounded-full">
                  Сводный
                </span>
            </div>

            <div class="mt-6 flex items-center justify-between">
              <div class="flex items-center gap-2 text-white/80">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <span class="text-sm">Таблица и графики</span>
              </div>
              <div class="bg-white/20 p-2 rounded-lg group-hover:bg-white/30 transition-colors">
                <svg class="w-5 h-5 text-white transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
              </div>
            </div>
          </div>
          <div class="md:col-span-3"></div>
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

const generateQuickReport = (type) => {
  const reports = {
    inventory: 'Инвентаризация',
    movement: 'Движение активов',
    depreciation: 'Амортизация'
  }

  alert(`Начинается генерация отчета "${reports[type]}"...`)
}

const exportAllReports = () => {
  alert('Запущен экспорт всех отчетов в выбранном формате')
}
</script>

<style scoped>
/* Стили остаются без изменений */
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

  .grid-cols-4 {
    grid-template-columns: repeat(1, minmax(0, 1fr));
  }
}

@media (min-width: 768px) and (max-width: 1024px) {
  .grid-cols-4 {
    grid-template-columns: repeat(2, minmax(0, 1fr));
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