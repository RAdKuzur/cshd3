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
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        <!-- Оборудование -->
        <div
            class="relative overflow-hidden rounded-xl p-6 flex flex-col justify-between
           bg-gradient-to-br from-blue-500 to-indigo-600
           hover:from-blue-600 hover:to-indigo-700
           transition-all hover:shadow-lg hover:scale-[1.01]
           cursor-pointer group"
            @click="navigateTo('/things/electronics')"
        >
          <ComputerDesktopIcon
              class="absolute right-6 top-6 h-12 w-12 text-white/25 pointer-events-none"
          />

          <div class="pr-16">
            <h3 class="text-xl font-semibold text-white mb-2">
              Оборудование
            </h3>
            <p class="text-sm text-blue-100 leading-relaxed">
              Компьютеры, серверы, оргтехника и сетевое оборудование
            </p>
          </div>

          <div class="mt-6 flex justify-end">
            <ArrowRightIcon
                class="h-5 w-5 text-white transition-transform group-hover:translate-x-1"
            />
          </div>
        </div>

        <!-- Устройства -->
        <div
            class="relative overflow-hidden rounded-xl p-6 flex flex-col justify-between
           bg-gradient-to-br from-violet-500 to-purple-600
           hover:from-violet-600 hover:to-purple-700
           transition-all hover:shadow-lg hover:scale-[1.01]
           cursor-pointer group"
            @click="navigateTo('/things/devices')"
        >
          <DevicePhoneMobileIcon
              class="absolute right-6 top-6 h-12 w-12 text-white/25 pointer-events-none"
          />

          <div class="pr-16">
            <h3 class="text-xl font-semibold text-white mb-2">
              Устройства
            </h3>
            <p class="text-sm text-violet-100 leading-relaxed">
              Телефоны, камеры, периферия, компьютеры, печатающие устройства
            </p>
          </div>

          <div class="mt-6 flex justify-end">
            <ArrowRightIcon
                class="h-5 w-5 text-white transition-transform group-hover:translate-x-1"
            />
          </div>
        </div>

        <!-- Сетевые устройства -->
        <div
            class="relative overflow-hidden rounded-xl p-6 flex flex-col justify-between
           bg-gradient-to-br from-cyan-500 to-blue-500
           hover:from-cyan-600 hover:to-blue-600
           transition-all hover:shadow-lg hover:scale-[1.01]
           cursor-pointer group"
            @click="navigateTo('/things/network')"
        >
          <CommandLineIcon
              class="absolute right-6 top-6 h-12 w-12 text-white/25 pointer-events-none"
          />

          <div class="pr-16">
            <h3 class="text-xl font-semibold text-white mb-2">
              Сетевые устройства
            </h3>
            <p class="text-sm text-cyan-100 leading-relaxed">
              Маршрутизаторы, коммутаторы, точки доступа и серверы
            </p>
          </div>

          <div class="mt-6 flex justify-end">
            <ArrowRightIcon
                class="h-5 w-5 text-white transition-transform group-hover:translate-x-1"
            />
          </div>
        </div>

        <!-- Расходные материалы -->
        <div
            class="relative overflow-hidden rounded-xl p-6 flex flex-col justify-between
           bg-gradient-to-br from-amber-500 to-orange-600
           hover:from-amber-600 hover:to-orange-700
           transition-all hover:shadow-lg hover:scale-[1.01]
           cursor-pointer group"
            @click="navigateTo('/things/resources')"
        >
          <ArchiveBoxIcon
              class="absolute right-6 top-6 h-12 w-12 text-white/25 pointer-events-none"
          />

          <div class="pr-16">
            <h3 class="text-xl font-semibold text-white mb-2">
              Расходные материалы
            </h3>
            <p class="text-sm text-amber-100 leading-relaxed">
              Бумага, картриджи, канцелярия и прочие расходники
            </p>
          </div>

          <div class="mt-6 flex justify-end">
            <ArrowRightIcon
                class="h-5 w-5 text-white transition-transform group-hover:translate-x-1"
            />
          </div>
        </div>

        <!-- История перемещений расходных материалов (новая карточка) -->
        <div
            class="relative overflow-hidden rounded-xl p-6 flex flex-col justify-between
           bg-gradient-to-br from-teal-500 to-green-600
           hover:from-teal-600 hover:to-green-700
           transition-all hover:shadow-lg hover:scale-[1.01]
           cursor-pointer group"
            @click="navigateTo('/things/history/resources')"
        >
          <ClockIcon
              class="absolute right-6 top-6 h-12 w-12 text-white/25 pointer-events-none"
          />

          <div class="pr-16">
            <h3 class="text-xl font-semibold text-white mb-2">
              История перемещений
            </h3>
            <p class="text-sm text-teal-100 leading-relaxed">
              Отслеживание перемещений расходных материалов между складами и сотрудниками
            </p>
          </div>

          <div class="mt-6 flex justify-end">
            <ArrowRightIcon
                class="h-5 w-5 text-white transition-transform group-hover:translate-x-1"
            />
          </div>
        </div>

        <!-- Акты -->
        <div
            class="relative overflow-hidden rounded-xl p-6 flex flex-col justify-between
           bg-gradient-to-br from-rose-500 to-red-600
           hover:from-rose-600 hover:to-red-700
           transition-all hover:shadow-lg hover:scale-[1.01]
           cursor-pointer group"
            @click="navigateTo('/things/transfer-acts')"
        >
          <DocumentTextIcon
              class="absolute right-6 top-6 h-12 w-12 text-white/25 pointer-events-none"
          />

          <div class="pr-16">
            <h3 class="text-xl font-semibold text-white mb-2">
              Акты
            </h3>
            <p class="text-sm text-rose-100 leading-relaxed">
              Акты списания, передачи и приёма материальных ценностей
            </p>
          </div>

          <div class="mt-6 flex justify-end">
            <ArrowRightIcon
                class="h-5 w-5 text-white transition-transform group-hover:translate-x-1"
            />
          </div>
        </div>

        <!-- Мебель -->
        <div
            class="relative overflow-hidden rounded-xl p-6 flex flex-col justify-between
           bg-gradient-to-br from-emerald-500 to-teal-600
           hover:from-emerald-600 hover:to-teal-700
           transition-all hover:shadow-lg hover:scale-[1.01]
           cursor-pointer group"
            @click="navigateTo('/things/furniture')"
        >
          <CubeIcon
              class="absolute right-6 top-6 h-12 w-12 text-white/25 pointer-events-none"
          />

          <div class="pr-16">
            <h3 class="text-xl font-semibold text-white mb-2">
              Мебель
            </h3>
            <p class="text-sm text-emerald-100 leading-relaxed">
              Офисные столы, кресла, шкафы и корпусная мебель
            </p>
          </div>

          <div class="mt-6 flex justify-end">
            <ArrowRightIcon
                class="h-5 w-5 text-white transition-transform group-hover:translate-x-1"
            />
          </div>
        </div>
      </div>

    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import {
  ComputerDesktopIcon,
  CommandLineIcon,
  DocumentTextIcon,
  CubeIcon,
  ArrowRightIcon,
  DevicePhoneMobileIcon,
  ArchiveBoxIcon,
  ClockIcon, // Новая иконка для истории перемещений
} from '@heroicons/vue/24/outline'

const router = useRouter()

// Моковые данные для демонстрации
const categories = ref({
  electronics: 42,
  devices: 38,
  furniture: 28,
  resources: 156,
  resourcesHistory: 245, // Добавлено для истории перемещений (количество операций)
  other: 19,
  acts: 15,
  network: 25
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