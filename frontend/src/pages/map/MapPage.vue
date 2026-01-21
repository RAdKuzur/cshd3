<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-6">
    <div class="max-w-6xl mx-auto">
      <!-- Заголовок -->
      <div class="mb-12 text-center">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">
          План здания
        </h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
          Изучайте план здания Московского областного суда
        </p>
      </div>

      <!-- Контейнер с единственной карточкой -->
      <div class="flex flex-col items-center justify-center min-h-[50vh]">
        <!-- Карточка "Общая карта" -->
        <div
            class="category-card group bg-gradient-to-br from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 w-full max-w-md mx-auto"
            @click="navigateTo('/map/general')"
        >
          <div class="absolute top-6 right-6">
            <div class="bg-white/20 backdrop-blur-sm p-3 rounded-xl">
              <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498 4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 0 0-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0Z" />
                </svg>

<!--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />-->
              </svg>
            </div>
          </div>

          <div class="flex-1 flex flex-col justify-center text-center">
            <h3 class="text-2xl font-bold text-white mb-3">
              Общая карта
            </h3>
            <p class="text-blue-100/90 text-sm leading-relaxed">
              Визуализация размещения единиц учёта в реальном времени
            </p>
          </div>
        </div>

        <!-- Кнопка по центру экрана под карточкой -->
        <div class="mt-12">
          <button
              @click="navigateTo('/map/general')"
              class="group bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white px-8 py-4 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 flex items-center justify-center gap-3 transform hover:-translate-y-1"
          >
            <span class="text-lg font-semibold">Перейти к карте</span>
            <svg class="w-6 h-6 transform group-hover:translate-x-2 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
          </button>
        </div>
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
  padding: 3rem 2rem;
  display: flex;
  flex-direction: column;
  cursor: pointer;
  transition: all 0.3s;
  transform: translateY(0);
  min-height: 220px;
  box-shadow: 0 4px 20px rgba(59, 130, 246, 0.15);
  border-radius: 24px;
  overflow: hidden;
}

.category-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 30px rgba(59, 130, 246, 0.25);
}

.category-card::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.15), transparent);
  opacity: 0;
  transition: opacity 0.3s;
  border-radius: 24px;
}

.category-card:hover::before {
  opacity: 1;
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
  background: linear-gradient(45deg,
  rgba(59, 130, 246, 0.3),
  rgba(168, 85, 247, 0.3),
  rgba(236, 72, 153, 0.3));
  opacity: 0;
  transition: opacity 0.3s ease;
  border-radius: 24px;
  margin: -2px;
}

.category-card:hover::after {
  opacity: 1;
}

/* Анимация иконок */
.category-card svg {
  transition: all 0.3s ease;
}

.category-card:hover svg {
  transform: scale(1.1);
}

/* Стиль для иконки в правом верхнем углу */
.category-card > div:first-child > div {
  border-radius: 12px;
  transition: all 0.3s ease;
}

.category-card:hover > div:first-child > div {
  transform: scale(1.05);
  background-color: rgba(255, 255, 255, 0.25);
}

/* Адаптивность */
@media (max-width: 768px) {
  .category-card {
    min-height: 200px;
    padding: 2rem 1.5rem;
    border-radius: 20px;
  }

  .category-card::before,
  .category-card::after {
    border-radius: 20px;
  }

  button {
    padding: 0.75rem 1.5rem;
    font-size: 1rem;
  }
}
</style>