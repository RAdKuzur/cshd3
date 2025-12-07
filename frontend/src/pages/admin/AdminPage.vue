<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-6">
    <div class="max-w-6xl mx-auto">
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
            Назад к категориям
          </router-link>
        </div>

        <!-- Карточки управления -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <!-- Должности -->
          <div
              class="admin-card group bg-gradient-to-br from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700"
              @click="navigateTo('/admin/positions')"
          >
            <div class="absolute top-6 right-6">
              <div class="bg-white/20 backdrop-blur-sm p-3">
                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
              </div>
            </div>

            <div class="flex-1 flex flex-col justify-end">
              <h3 class="text-2xl font-bold text-white mb-3">
                Должности
              </h3>
              <p class="text-blue-100/90 text-sm leading-relaxed">
                Управление должностями сотрудников, правами доступа и ролями в системе
              </p>
            </div>

            <div class="mt-8 flex items-center justify-between">
              <span class="text-white text-sm font-medium px-3 py-1 bg-white/20 rounded-full">
                Управление
              </span>
              <div class="bg-white/20 p-2 group-hover:bg-white/30 transition-colors">
                <svg class="w-5 h-5 text-white transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
              </div>
            </div>
          </div>

          <!-- Пользователи -->
          <div
              class="admin-card group bg-gradient-to-br from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700"
              @click="navigateTo('/admin/users')"
          >
            <div class="absolute top-6 right-6">
              <div class="bg-white/20 backdrop-blur-sm p-3">
                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 0c-.281.023-.562.045-.844.064A23.91 23.91 0 0115 17a8 8 0 01-8-8 24 24 0 01.345-3.868A7.962 7.962 0 013 9c0 1.93.784 3.683 2.05 4.95A7.96 7.96 0 019 17c.868 0 1.718-.126 2.533-.364" />
                </svg>
              </div>
            </div>

            <div class="flex-1 flex flex-col justify-end">
              <h3 class="text-2xl font-bold text-white mb-3">
                Пользователи
              </h3>
              <p class="text-emerald-100/90 text-sm leading-relaxed">
                Управление учетными записями сотрудников, их профилями и активностью
              </p>
            </div>

            <div class="mt-8 flex items-center justify-between">
              <span class="text-white text-sm font-medium px-3 py-1 bg-white/20 rounded-full">
                Администрирование
              </span>
              <div class="bg-white/20 p-2 group-hover:bg-white/30 transition-colors">
                <svg class="w-5 h-5 text-white transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
              </div>
            </div>
          </div>

          <!-- Помещения -->
          <div
              class="admin-card group bg-gradient-to-br from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700"
              @click="navigateTo('/admin/auditoriums')"
          >
            <div class="absolute top-6 right-6">
              <div class="bg-white/20 backdrop-blur-sm p-3">
                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
              </div>
            </div>

            <div class="flex-1 flex flex-col justify-end">
              <h3 class="text-2xl font-bold text-white mb-3">
                Помещения
              </h3>
              <p class="text-amber-100/90 text-sm leading-relaxed">
                Управление офисными помещениями, кабинетами и местами расположения активов
              </p>
            </div>

            <div class="mt-8 flex items-center justify-between">
              <span class="text-white text-sm font-medium px-3 py-1 bg-white/20 rounded-full">
                Управление
              </span>
              <div class="bg-white/20 p-2 group-hover:bg-white/30 transition-colors">
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
@media (max-width: 768px) {
  .admin-card {
    min-height: 240px;
    padding: 1.25rem;
  }
}
</style>