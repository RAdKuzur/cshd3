<script setup>
import {
  ScaleIcon,
  MapPinIcon,
  PhoneIcon,
  EnvelopeIcon,
  DocumentTextIcon,
  UserGroupIcon,
  BuildingOfficeIcon
} from '@heroicons/vue/24/outline'

// Данные контактов
const contacts = [
  {
    icon: MapPinIcon,
    text: 'Московская область, г. Красногорск, бульвар Строителей, д. 4, корп. 3',
    href: '#'
  },
  {
    icon: PhoneIcon,
    text: '+7 (498) 692-60-00',
    href: 'tel:+74986926000'
  },
  {
    icon: EnvelopeIcon,
    text: 'post@mosoblsud.ru',
    href: 'mailto:post@mosoblsud.ru'
  }
]

// Быстрые ссылки по модулям
const quickLinks = [
  {
    name: 'Основные средства',
    href: '/assets',
    icon: BuildingOfficeIcon
  },
  {
    name: 'Сотрудники',
    href: '/employees',
    icon: UserGroupIcon
  },
  {
    name: 'Документооборот',
    href: '/documents',
    icon: DocumentTextIcon
  },
  {
    name: 'Отчеты',
    href: '/reports',
    icon: DocumentTextIcon
  }
]

// Социальные сети
const socialLinks = [
  {
    name: 'Официальный сайт',
    href: 'https://mosoblsud.ru',
    icon: ScaleIcon
  }
]

const navigateTo = (route) => {
  // Навигация по маршруту
  console.log('Переход по:', route)
}

const subscribeToNewsletter = (event) => {
  event.preventDefault()
  const email = event.target.email.value
  console.log('Подписка на рассылку:', email)
  // Здесь можно добавить логику подписки
  event.target.reset()
}
</script>

<template>
  <footer class="bg-gradient-to-br from-gray-900 to-blue-900 text-white">
    <!-- Основной контент футера -->
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
      <div class="xl:grid xl:grid-cols-3 xl:gap-8">

        <!-- Левая колонка - Информация -->
        <div class="space-y-8 xl:col-span-1">
          <!-- Логотип и описание -->
          <div class="flex items-center">
            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center mr-4">
              <ScaleIcon class="w-7 h-7 text-white" />
            </div>
            <div>
              <h3 class="text-2xl font-bold">Мособлсуд</h3>
              <p class="text-gray-300 text-sm">Московский областной суд</p>
            </div>
          </div>

          <p class="text-gray-300 text-base leading-relaxed">
            Единая система управления и автоматизации деятельности
            Московского областного суда.
          </p>

          <!-- Контакты -->
          <div class="space-y-3">
            <h4 class="text-lg font-semibold text-white mb-4">Контакты</h4>
            <div
                v-for="contact in contacts"
                :key="contact.text"
                class="flex items-start space-x-3 group cursor-pointer"
            >
              <component
                  :is="contact.icon"
                  class="w-5 h-5 text-indigo-400 mt-0.5 flex-shrink-0 group-hover:text-indigo-300 transition-colors"
              />
              <a
                  :href="contact.href"
                  class="text-gray-300 hover:text-white transition-colors text-sm leading-relaxed"
              >
                {{ contact.text }}
              </a>
            </div>
          </div>
        </div>

        <!-- Центральная колонка - Быстрые ссылки -->
        <div class="mt-12 grid grid-cols-2 gap-8 xl:mt-0 xl:col-span-2">
          <div class="md:grid md:grid-cols-2 md:gap-8">
            <!-- Модули системы -->
            <div>
              <h4 class="text-lg font-semibold text-white mb-6 flex items-center">
                <span class="w-2 h-2 bg-indigo-500 rounded-full mr-2"></span>
                Модули системы
              </h4>
              <ul class="space-y-3">
                <li
                    v-for="link in quickLinks"
                    :key="link.name"
                >
                  <button
                      @click="navigateTo(link.href)"
                      class="flex items-center space-x-2 text-gray-300 hover:text-white transition-colors group"
                  >
                    <component
                        :is="link.icon"
                        class="w-4 h-4 text-indigo-400 group-hover:text-indigo-300 transition-colors"
                    />
                    <span class="text-sm">{{ link.name }}</span>
                  </button>
                </li>
              </ul>
            </div>

            <!-- Поддержка -->
            <div class="mt-12 md:mt-0">
              <h4 class="text-lg font-semibold text-white mb-6 flex items-center">
                <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                Поддержка
              </h4>
              <ul class="space-y-3">
                <li>
                  <button class="text-gray-300 hover:text-white transition-colors text-sm">
                    Техническая поддержка
                  </button>
                </li>
                <li>
                  <button class="text-gray-300 hover:text-white transition-colors text-sm">
                    Документация
                  </button>
                </li>
                <li>
                  <button class="text-gray-300 hover:text-white transition-colors text-sm">
                    Частые вопросы
                  </button>
                </li>
                <li>
                  <button class="text-gray-300 hover:text-white transition-colors text-sm">
                    Обучение
                  </button>
                </li>
              </ul>
            </div>
          </div>

          <!-- Правая колонка - Рассылка -->
          <div class="md:grid md:grid-cols-1 md:gap-8">
            <div>
              <h4 class="text-lg font-semibold text-white mb-6 flex items-center">
                <span class="w-2 h-2 bg-purple-500 rounded-full mr-2"></span>
                Рассылка новостей
              </h4>
              <p class="text-gray-300 text-sm mb-4 leading-relaxed">
                Подпишитесь на рассылку, чтобы получать актуальные новости
                о работе системы и обновлениях.
              </p>

              <form @submit="subscribeToNewsletter" class="space-y-3">
                <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-3">
                  <input
                      name="email"
                      type="email"
                      required
                      placeholder="your.email@example.com"
                      class="flex-1 px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                  >
                  <button
                      type="submit"
                      class="px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-medium rounded-lg shadow-sm transition-all duration-200 transform hover:scale-105"
                  >
                    Подписаться
                  </button>
                </div>
                <p class="text-gray-400 text-xs">
                  Подписываясь, вы соглашаетесь с нашей политикой конфиденциальности
                </p>
              </form>

              <!-- Социальные сети -->
              <div class="mt-8">
                <h5 class="text-sm font-semibold text-white mb-4">Официальные ресурсы</h5>
                <div class="flex space-x-4">
                  <a
                      v-for="social in socialLinks"
                      :key="social.name"
                      :href="social.href"
                      target="_blank"
                      class="flex items-center space-x-2 text-gray-300 hover:text-white transition-colors group"
                  >
                    <component
                        :is="social.icon"
                        class="w-5 h-5 text-indigo-400 group-hover:text-indigo-300 transition-colors"
                    />
                    <span class="text-sm">{{ social.name }}</span>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Нижняя часть футера -->
      <div class="mt-12 pt-8 border-t border-gray-700">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
          <div class="flex items-center space-x-6">
            <p class="text-gray-400 text-sm">
              © 2025 Московский областной суд. Все права защищены.
            </p>
          </div>

          <div class="flex space-x-6">
            <button class="text-gray-400 hover:text-white transition-colors text-sm">
              Политика конфиденциальности
            </button>
            <button class="text-gray-400 hover:text-white transition-colors text-sm">
              Условия использования
            </button>
            <button class="text-gray-400 hover:text-white transition-colors text-sm">
              Карта сайта
            </button>
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>

<style scoped>
/* Дополнительные стили для плавных переходов */
.footer {
  background: linear-gradient(135deg, #1f2937 0%, #1e3a8a 100%);
}

/* Анимация для инпутов */
input:focus {
  box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}
</style>