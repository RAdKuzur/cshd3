<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-6">
    <div class="max-w-7xl mx-auto">
      <!-- Заголовок и навигация -->
      <div class="mb-12">
        <div class="flex items-center justify-between mb-8">
          <div>
            <h1 class="text-3xl font-bold text-gray-900">Административная панель</h1>
            <p class="text-gray-600 mt-2">Управление системой материальных ценностей</p>
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

        <!-- Карточки управления -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
          <!-- Должности -->
          <div
              class="relative overflow-hidden rounded-xl p-6 flex flex-col justify-between
           bg-gradient-to-br from-blue-500 to-indigo-600
           hover:from-blue-600 hover:to-indigo-700
           transition-all hover:shadow-lg hover:scale-[1.01]
           cursor-pointer group"
              @click="navigateTo('/admin/positions')"
          >
            <!-- Иконка -->
            <div class="absolute right-6 top-6">
              <div class="bg-white/20 backdrop-blur-sm p-3 rounded-xl">
                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
              </div>
            </div>

            <!-- Контент с отступом для иконки -->
            <div class="pr-16">
              <h3 class="text-xl font-semibold text-white mb-2">
                Должности
              </h3>
              <p class="text-sm text-blue-100 leading-relaxed">
                Управление должностями сотрудников, правами доступа и ролями в системе
              </p>
            </div>

            <!-- Стрелка -->
            <div class="mt-6 flex justify-end">
              <div class="bg-white/20 p-2 rounded-lg group-hover:bg-white/30 transition-colors">
                <svg class="w-5 h-5 text-white transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
              </div>
            </div>
          </div>

          <!-- Пользователи -->
          <div
              class="relative overflow-hidden rounded-xl p-6 flex flex-col justify-between
           bg-gradient-to-br from-emerald-500 to-teal-600
           hover:from-emerald-600 hover:to-teal-700
           transition-all hover:shadow-lg hover:scale-[1.01]
           cursor-pointer group"
              @click="navigateTo('/admin/users')"
          >
            <div class="absolute right-6 top-6">
              <div class="bg-white/20 backdrop-blur-sm p-3 rounded-xl">
                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
              </div>
            </div>

            <div class="pr-16">
              <h3 class="text-xl font-semibold text-white mb-2">
                Пользователи
              </h3>
              <p class="text-sm text-emerald-100 leading-relaxed">
                Управление учетными записями сотрудников, их профилями и активностью
              </p>
            </div>

            <div class="mt-6 flex justify-end">
              <div class="bg-white/20 p-2 rounded-lg group-hover:bg-white/30 transition-colors">
                <svg class="w-5 h-5 text-white transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
              </div>
            </div>
          </div>

          <!-- Отделы -->
          <div
              class="relative overflow-hidden rounded-xl p-6 flex flex-col justify-between
           bg-gradient-to-br from-purple-500 to-violet-600
           hover:from-purple-600 hover:to-violet-700
           transition-all hover:shadow-lg hover:scale-[1.01]
           cursor-pointer group"
              @click="navigateTo('/admin/branches')"
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
                Отделы
              </h3>
              <p class="text-sm text-purple-100 leading-relaxed">
                Управление структурными подразделениями компании и организационной иерархией
              </p>
            </div>

            <div class="mt-6 flex justify-end">
              <div class="bg-white/20 p-2 rounded-lg group-hover:bg-white/30 transition-colors">
                <svg class="w-5 h-5 text-white transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
              </div>
            </div>
          </div>

          <!-- Помещения -->
          <div
              class="relative overflow-hidden rounded-xl p-6 flex flex-col justify-between
           bg-gradient-to-br from-amber-500 to-orange-600
           hover:from-amber-600 hover:to-orange-700
           transition-all hover:shadow-lg hover:scale-[1.01]
           cursor-pointer group"
              @click="navigateTo('/admin/auditoriums')"
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
              <p class="text-sm text-amber-100 leading-relaxed">
                Управление офисными помещениями, кабинетами и местами расположения активов
              </p>
            </div>

            <div class="mt-6 flex justify-end">
              <div class="bg-white/20 p-2 rounded-lg group-hover:bg-white/30 transition-colors">
                <svg class="w-5 h-5 text-white transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
              </div>
            </div>
          </div>

          <!-- Файловая система -->
          <div
              class="relative overflow-hidden rounded-xl p-6 flex flex-col justify-between
           bg-gradient-to-br from-pink-500 to-rose-600
           hover:from-pink-600 hover:to-rose-700
           transition-all hover:shadow-lg hover:scale-[1.01]
           cursor-pointer group"
              @click="navigateTo('/admin/files')"
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
                Файловая система
              </h3>
              <p class="text-sm text-pink-100 leading-relaxed">
                Управление файлами и документами, хранение сканов и прочей документации
              </p>
            </div>

            <div class="mt-6 flex justify-end">
              <div class="bg-white/20 p-2 rounded-lg group-hover:bg-white/30 transition-colors">
                <svg class="w-5 h-5 text-white transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

// Моковые данные статистики
const stats = ref({
  positions: 15,
  users: 42,
  auditoriums: 28,
  branches: 10,
  activeSessions: 8,
  dailyActivity: '142',
  lastUpdate: '2 мин назад'
})

// Метод навигации
const navigateTo = (path) => {
  router.push(path)
}
</script>

<style scoped>
.admin-card {
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

.admin-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
}

.admin-card::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.1), transparent);
  opacity: 0;
  transition: opacity 0.3s;
}

.admin-card:hover::before {
  opacity: 1;
}

/* Анимация иконок */
.admin-card svg {
  transition: all 0.3s ease;
}

.admin-card:hover svg:not(.group-hover\:translate-x-1) {
  transform: scale(1.1);
}

/* Градиентные границы */
.admin-card {
  border: 2px solid transparent;
  background-clip: padding-box;
  position: relative;
}

.admin-card::after {
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

.admin-card:hover::after {
  opacity: 1;
}

/* Адаптивность */
@media (max-width: 640px) {
  .admin-card {
    min-height: 240px;
    padding: 1.25rem;
  }

  .grid {
    grid-template-columns: 1fr;
  }
}

@media (min-width: 641px) and (max-width: 768px) {
  .grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (min-width: 769px) and (max-width: 1024px) {
  .grid {
    grid-template-columns: repeat(3, 1fr);
  }
}

@media (min-width: 1025px) and (max-width: 1280px) {
  .grid {
    grid-template-columns: repeat(4, 1fr);
  }
}

@media (min-width: 1281px) {
  .grid {
    grid-template-columns: repeat(5, 1fr);
  }
}
</style>