<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-6">
    <div class="max-w-6xl mx-auto">
      <!-- Заголовок -->
      <div class="mb-12 text-center">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">
          Модуль управления кадрами
        </h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
          Управляйте персоналом организации. Просматривайте список сотрудников и историю кадровых изменений
        </p>
      </div>

      <!-- Сетка карточек (2 карточки, центрированные) -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-3xl mx-auto">
        <!-- Все сотрудники -->
        <div
            class="relative overflow-hidden rounded-xl p-8 flex flex-col justify-between
           bg-gradient-to-br from-blue-500 to-indigo-600
           hover:from-blue-600 hover:to-indigo-700
           transition-all hover:shadow-lg hover:scale-[1.01]
           cursor-pointer group min-h-[280px]"
            @click="navigateTo('/staff/all')"
        >
          <UsersIcon
              class="absolute right-6 top-6 h-16 w-16 text-white/25 pointer-events-none"
          />

          <div class="pr-20">
            <h3 class="text-2xl font-semibold text-white mb-3">
              Все сотрудники
            </h3>
            <p class="text-base text-blue-100 leading-relaxed">
              Полный список сотрудников организации
            </p>
          </div>

          <div class="mt-8 flex items-center justify-between">
            <ArrowRightIcon
                class="h-6 w-6 text-white transition-transform group-hover:translate-x-1"
            />
          </div>
        </div>

        <!-- Панель кадровика -->
        <div
            class="relative overflow-hidden rounded-xl p-8 flex flex-col justify-between
           bg-gradient-to-br from-emerald-500 to-teal-600
           hover:from-emerald-600 hover:to-teal-700
           transition-all hover:shadow-lg hover:scale-[1.01]
           cursor-pointer group min-h-[280px]"
            @click="navigateTo('/staff/history')"
        >
          <ClockIcon
              class="absolute right-6 top-6 h-16 w-16 text-white/25 pointer-events-none"
          />

          <div class="pr-20">
            <h3 class="text-2xl font-semibold text-white mb-3">
              Панель Кадры
            </h3>
            <p class="text-base text-emerald-100 leading-relaxed">
              История приёмов, увольнений, переводов
            </p>
          </div>

          <div class="mt-8 flex items-center justify-between">
            <ArrowRightIcon
                class="h-6 w-6 text-white transition-transform group-hover:translate-x-1"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import {ref, computed} from 'vue'
import {useRouter} from 'vue-router'
import {
  UsersIcon,
  ClockIcon,
  ArrowRightIcon,
} from '@heroicons/vue/24/outline'

const router = useRouter()

// Моковые данные для демонстрации
const employees = ref({
  total: 128,
  active: 118,
  newThisMonth: 5,
  departments: 12,
  historyEvents: 345
})

// Вычисляемые свойства для отображения
const getEmployeeCount = computed(() => {
  return employees.value.total
})

const getHistoryCount = computed(() => {
  return employees.value.historyEvents
})

const getActiveEmployees = computed(() => {
  return employees.value.active
})

const getNewThisMonth = computed(() => {
  return employees.value.newThisMonth
})

const getDepartments = computed(() => {
  return employees.value.departments
})

// Методы
const navigateTo = (path) => {
  router.push(path)
}
</script>

<style scoped>
/* Стили оставлены идентичными оригиналу */
.category-card {
  position: relative;
  padding: 1.5rem;
  display: flex;
  flex-direction: column;
  cursor: pointer;
  transition: all 0.3s;
  transform: translateY(0);
  min-height: 250px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.category-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
}

.category-card::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.1), transparent);
  opacity: 0;
  transition: opacity 0.3s;
}

.category-card:hover::before {
  opacity: 1;
}

/* Анимация иконок */
.category-card svg {
  transition: all 0.3s ease;
}

.category-card:hover svg {
  transform: scale(1.1);
}

/* Градиентные границы */
.category-card {
  border: 2px solid transparent;
  background-clip: padding-box;
  position: relative;
}

.category-card::after {
  content: '';
  position: absolute;
  inset: 0;
  z-index: -1;
  background: linear-gradient(to right,
  rgba(59, 130, 246, 0.2),
  rgba(16, 185, 129, 0.2),
  rgba(245, 158, 11, 0.2));
  opacity: 0;
  transition: opacity 0.3s ease;
}

.category-card:hover::after {
  opacity: 1;
}

/* Адаптивность */
@media (max-width: 768px) {
  .category-card {
    min-height: 220px;
    padding: 1.5rem;
  }

  .grid {
    gap: 1rem;
  }
}
</style>