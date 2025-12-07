<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-6">
    <div class="max-w-6xl mx-auto">
      <!-- Заголовок -->
      <div class="mb-12 text-center">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">
          Модуль управления материальными ценностями
        </h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
          Управляйте всеми типами активов организации. Выберите категорию для просмотра или редактирования
        </p>
      </div>

      <!-- Сетка категорий -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Техника и Электроника -->
        <div
            class="category-card group bg-gradient-to-br from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700"
            @click="navigateTo('/things/electronics')"
        >
          <div class="absolute top-6 right-6">
            <div class="bg-white/20 backdrop-blur-sm p-3">
              <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
              </svg>
            </div>
          </div>

          <div class="flex-1 flex flex-col justify-end">
            <h3 class="text-2xl font-bold text-white mb-3">
              Оборудование
            </h3>
            <p class="text-blue-100/90 text-sm leading-relaxed">
              Компьютеры, серверы, оргтехника, сетевое оборудование и другая электроника
            </p>
          </div>

          <div class="mt-8 flex items-center justify-between">
            <div class="bg-white/20 p-2 group-hover:bg-white/30 transition-colors">
              <svg class="w-5 h-5 text-white transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
              </svg>
            </div>
          </div>
        </div>

<!--        &lt;!&ndash; Мебель &ndash;&gt;-->
<!--        <div-->
<!--            class="category-card group bg-gradient-to-br from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700"-->
<!--            @click="navigateTo('/things/furniture')"-->
<!--        >-->
<!--          <div class="absolute top-6 right-6">-->
<!--            <div class="bg-white/20 backdrop-blur-sm p-3">-->
<!--              <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
<!--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />-->
<!--              </svg>-->
<!--            </div>-->
<!--          </div>-->

<!--          <div class="flex-1 flex flex-col justify-end">-->
<!--            <h3 class="text-2xl font-bold text-white mb-3">-->
<!--              Мебель-->
<!--            </h3>-->
<!--            <p class="text-emerald-100/90 text-sm leading-relaxed">-->
<!--              Офисные столы, кресла, шкафы, диваны и другая корпусная мебель-->
<!--            </p>-->
<!--          </div>-->

<!--          <div class="mt-8 flex items-center justify-between">-->
<!--            <div class="bg-white/20 p-2 group-hover:bg-white/30 transition-colors">-->
<!--              <svg class="w-5 h-5 text-white transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
<!--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />-->
<!--              </svg>-->
<!--            </div>-->
<!--          </div>-->
<!--        </div>-->

<!--        &lt;!&ndash; Расходные материалы &ndash;&gt;-->
<!--        <div-->
<!--            class="category-card group bg-gradient-to-br from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700"-->
<!--            @click="navigateTo('/things/resources')"-->
<!--        >-->
<!--          <div class="absolute top-6 right-6">-->
<!--            <div class="bg-white/20 backdrop-blur-sm p-3">-->
<!--              <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
<!--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />-->
<!--              </svg>-->
<!--            </div>-->
<!--          </div>-->

<!--          <div class="flex-1 flex flex-col justify-end">-->
<!--            <h3 class="text-2xl font-bold text-white mb-3">-->
<!--              Расходные материалы-->
<!--            </h3>-->
<!--            <p class="text-amber-100/90 text-sm leading-relaxed">-->
<!--              Канцелярия, бумага, картриджи, чистящие средства и прочие расходники-->
<!--            </p>-->
<!--          </div>-->

<!--          <div class="mt-8 flex items-center justify-between">-->
<!--            <div class="bg-white/20 p-2 group-hover:bg-white/30 transition-colors">-->
<!--              <svg class="w-5 h-5 text-white transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
<!--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />-->
<!--              </svg>-->
<!--            </div>-->
<!--          </div>-->
<!--        </div>-->

<!--        &lt;!&ndash; Прочее &ndash;&gt;-->
<!--        <div-->
<!--            class="category-card group bg-gradient-to-br from-purple-500 to-pink-600 hover:from-purple-600 hover:to-pink-700"-->
<!--            @click="navigateTo('/things/other')"-->
<!--        >-->
<!--          <div class="absolute top-6 right-6">-->
<!--            <div class="bg-white/20 backdrop-blur-sm p-3">-->
<!--              <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
<!--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />-->
<!--              </svg>-->
<!--            </div>-->
<!--          </div>-->

<!--          <div class="flex-1 flex flex-col justify-end">-->
<!--            <h3 class="text-2xl font-bold text-white mb-3">-->
<!--              Прочее-->
<!--            </h3>-->
<!--            <p class="text-purple-100/90 text-sm leading-relaxed">-->
<!--              Спецодежда, инструменты, оборудование и другие активы-->
<!--            </p>-->
<!--          </div>-->

<!--          <div class="mt-8 flex items-center justify-between">-->
<!--            <div class="bg-white/20 p-2 group-hover:bg-white/30 transition-colors">-->
<!--              <svg class="w-5 h-5 text-white transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
<!--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />-->
<!--              </svg>-->
<!--            </div>-->
<!--          </div>-->
<!--        </div>-->
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

// Моковые данные для демонстрации
const categories = ref({
  electronics: 42,
  furniture: 28,
  consumables: 156,
  other: 19
})

// Методы
const getCategoryCount = (category) => {
  return categories.value[category] || 0
}

const navigateTo = (path) => {
  router.push(path)
}
</script>

<style scoped>
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
  rgba(168, 85, 247, 0.2),
  rgba(236, 72, 153, 0.2));
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
}
</style>