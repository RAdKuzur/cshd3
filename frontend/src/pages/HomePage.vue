<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50">

    <!-- Hero секция -->
    <div class="relative bg-white">
      <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-2xl py-24 sm:py-32 lg:py-40">
          <div class="text-center">
            <!-- Логотип и название -->
            <div class="flex items-center justify-center mb-8">
              <div class="w-16 h-16 bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl flex items-center justify-center mr-4">
                <ScaleIcon class="w-8 h-8 text-white" />
              </div>
              <div class="text-left">
                <h1 class="text-2xl font-bold text-gray-900">Мособлсуд</h1>
                <p class="text-gray-600">Московский областной суд</p>
              </div>
            </div>

            <h2 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">
              Единая система управления
            </h2>
            <p class="mt-6 text-lg leading-8 text-gray-600">
              Комплексное решение для автоматизации учета основных средств,
              управления кадрами и документооборота Московского областного суда
            </p>
            <div class="mt-10 flex items-center justify-center gap-x-6">
              <button
                  @click="navigateToDashboard"
                  class="rounded-md bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
              >
                Перейти в систему
              </button>
              <button
                  @click="scrollToFeatures"
                  class="text-sm font-semibold leading-6 text-gray-900 flex items-center"
              >
                Узнать больше
                <ChevronDownIcon class="w-4 h-4 ml-1" />
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Статистика -->
    <div class="bg-white py-16">
      <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
          <div
              v-for="stat in statistics"
              :key="stat.name"
              class="text-center"
          >
            <div class="text-3xl font-bold text-indigo-600">{{ stat.value }}</div>
            <div class="text-sm text-gray-600 mt-2">{{ stat.name }}</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Основные модули -->
    <div id="features" class="py-24 sm:py-32">
      <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-2xl lg:text-center">
          <h2 class="text-base/7 font-semibold text-indigo-600">Системные модули</h2>
          <p class="mt-2 text-4xl font-semibold tracking-tight text-pretty text-gray-900 sm:text-5xl lg:text-balance">
            Комплексное управление судебной деятельностью
          </p>
          <p class="mt-6 text-lg/8 text-gray-700">
            Современная платформа для автоматизации ключевых процессов Московского областного суда,
            обеспечивающая эффективное управление ресурсами и документацией
          </p>
        </div>
        <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-4xl">
          <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-10 lg:max-w-none lg:grid-cols-2 lg:gap-y-16">
            <div
                v-for="feature in features"
                :key="feature.name"
                class="relative pl-16 cursor-pointer group"
                @click="navigateToModule(feature.route)"
            >
              <dt class="text-base/7 font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors">
                <div class="absolute top-0 left-0 flex size-10 items-center justify-center rounded-lg bg-indigo-600 group-hover:bg-indigo-700 transition-colors">
                  <component :is="feature.icon" class="size-6 text-white" aria-hidden="true" />
                </div>
                {{ feature.name }}
              </dt>
              <dd class="mt-2 text-base/7 text-gray-600">{{ feature.description }}</dd>
            </div>
          </dl>
        </div>
      </div>
    </div>

    <!-- Баннер документооборота -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-700">
      <div class="mx-auto max-w-7xl px-6 py-16 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
          <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
            Электронный документооборот
          </h2>
          <p class="mx-auto mt-6 max-w-xl text-lg leading-8 text-indigo-100">
            Полностью автоматизированная система обработки судебных документов
            с соблюдением требований законодательства
          </p>
          <div class="mt-10 flex items-center justify-center gap-x-6">
            <button
                @click="navigateToDocuments"
                class="rounded-md bg-white px-6 py-3 text-sm font-semibold text-indigo-600 shadow-sm hover:bg-gray-100 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"
            >
              Перейти к документам
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Преимущества -->
    <div class="bg-white py-24 sm:py-32">
      <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-2xl lg:text-center">
          <h2 class="text-base/7 font-semibold text-indigo-600">Преимущества системы</h2>
          <p class="mt-2 text-4xl font-semibold tracking-tight text-pretty text-gray-900 sm:text-5xl lg:text-balance">
            Почему выбирают нашу систему
          </p>
        </div>
        <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-none">
          <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-16 lg:max-w-none lg:grid-cols-3">
            <div
                v-for="benefit in benefits"
                :key="benefit.name"
                class="flex flex-col text-center"
            >
              <dt class="text-base/7 font-semibold text-gray-900">
                <div class="mx-auto flex size-16 items-center justify-center rounded-full bg-indigo-100 mb-4">
                  <component :is="benefit.icon" class="size-8 text-indigo-600" aria-hidden="true" />
                </div>
                {{ benefit.name }}
              </dt>
              <dd class="mt-2 flex flex-auto flex-col text-base/7 text-gray-600">
                <p class="flex-auto">{{ benefit.description }}</p>
              </dd>
            </div>
          </dl>
        </div>
      </div>
    </div>

    <!-- CTA секция -->
    <div class="bg-white">
      <div class="mx-auto max-w-7xl px-6 py-16 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
          <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
            Начните работу с системой сегодня
          </h2>
          <p class="mx-auto mt-6 max-w-xl text-lg leading-8 text-gray-600">
            Получите доступ ко всем модулям системы управления Московского областного суда
          </p>
          <div class="mt-10 flex items-center justify-center gap-x-6">
            <button
                @click="navigateToDashboard"
                class="rounded-md bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
            >
              Войти в систему
            </button>
            <button
                @click="contactSupport"
                class="text-sm font-semibold leading-6 text-gray-900"
            >
              Связаться с поддержкой <span aria-hidden="true">→</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import {
  ScaleIcon,
  ChevronDownIcon,
  BuildingOfficeIcon,
  UserGroupIcon,
  DocumentTextIcon,
  CogIcon,
  ShieldCheckIcon,
  ClockIcon,
  ChartBarIcon
} from '@heroicons/vue/24/outline'

// Статистика
const statistics = [
  { name: 'Основных средств на учете', value: '1,248' },
  { name: 'Сотрудников в системе', value: '856' },
  { name: 'Документов в месяц', value: '12,458' },
  { name: 'Судебных дел', value: '3,742' }
]

// Основные модули
const features = [
  {
    name: 'Учет основных средств',
    description: 'Полный цикл управления материально-техническими ресурсами суда: от постановки на баланс до списания',
    icon: BuildingOfficeIcon,
    route: '/assets'
  },
  {
    name: 'Кадровый учет',
    description: 'Комплексное управление персоналом: от приема на работу до ведения личных дел сотрудников',
    icon: UserGroupIcon,
    route: '/employees'
  },
  {
    name: 'Документооборот',
    description: 'Электронный оборот судебных и организационных документов с системой согласования',
    icon: DocumentTextIcon,
    route: '/documents'
  },
  {
    name: 'Администрирование',
    description: 'Управление доступом, настройками системы и технической поддержкой пользователей',
    icon: CogIcon,
    route: '/admin'
  }
]

// Преимущества
const benefits = [
  {
    name: 'Безопасность',
    description: 'Соответствие требованиям ФСТЭК России и ФСБ России по защите информации',
    icon: ShieldCheckIcon
  },
  {
    name: 'Эффективность',
    description: 'Сокращение времени обработки документов и повышение производительности труда',
    icon: ClockIcon
  },
  {
    name: 'Аналитика',
    description: 'Мощные инструменты отчетности и аналитики для принятия управленческих решений',
    icon: ChartBarIcon
  }
]

// Футер модули
const footerModules = [
  { name: 'Основные средства', route: '/assets' },
  { name: 'Сотрудники', route: '/employees' },
  { name: 'Документы', route: '/documents' },
  { name: 'Отчеты', route: '/reports' }
]

// Методы навигации
const navigateToDashboard = () => {
  // Навигация в дашборд
  console.log('Переход в дашборд')
}

const navigateToModule = (route) => {
  // Навигация в модуль
  console.log('Переход в модуль:', route)
}

const navigateToDocuments = () => {
  navigateToModule('/documents')
}

const scrollToFeatures = () => {
  const featuresSection = document.getElementById('features')
  featuresSection?.scrollIntoView({ behavior: 'smooth' })
}

const contactSupport = () => {
  // Открытие формы связи с поддержкой
  console.log('Связь с поддержкой')
}
</script>

<style scoped>
/* Дополнительные стили для плавных переходов */
.group {
  transition: all 0.3s ease;
}
</style>