<script setup>
import { ref } from 'vue'

// Данные пользователя
const user = ref({
  name: 'Алексей Петров',
  position: 'Senior Developer',
  department: 'IT Отдел',
  email: 'alexey@company.com',
  phone: '+7 (999) 123-45-67',
  bio: 'Full-stack разработчик с 5-летним опытом. Специализируюсь на Vue.js и Node.js. Увлекаюсь созданием масштабируемых веб-приложений и оптимизацией производительности.',
  avatar: '/person.jpg',
  skills: ['Коммуникабельность', 'Общество']
})

// Опыт работы
const workExperience = ref([
  {
    id: 1,
    position: 'Senior Frontend Developer',
    company: 'Tech Solutions Inc.',
    period: '2022 - настоящее время',
    description: 'Разработка и поддержка крупного SaaS-продукта. Руководство командой из 3 разработчиков. Внедрение микросервисной архитектуры.',
    technologies: ['Коммуникабельность', 'TypeScript', 'GraphQL', 'Jest', 'Docker']
  },
  {
    id: 2,
    position: 'Full-stack Developer',
    company: 'Digital Agency Pro',
    period: '2019 - 2022',
    description: 'Создание веб-приложений для клиентов из различных отраслей. Участие в полном цикле разработки от проектирования до деплоя.',
    technologies: ['Vue.js', 'React', 'Node.js', 'MongoDB', 'AWS']
  },
  {
    id: 3,
    position: 'Web Developer',
    company: 'StartUp Innovations',
    period: '2017 - 2019',
    description: 'Разработка MVP для стартапов. Быстрое прототипирование и итеративная разработка.',
    technologies: ['JavaScript', 'React', 'Firebase', 'REST API']
  }
])

// Образование
const education = ref([
  {
    id: 1,
    institution: 'Московский Государственный Технический Университет',
    degree: 'Магистр компьютерных наук',
    period: '2015 - 2017',
    description: 'Специализация в области распределенных систем и веб-технологий.'
  },
  {
    id: 2,
    institution: 'Санкт-Петербургский Политехнический Университет',
    degree: 'Бакалавр информатики',
    period: '2011 - 2015',
    description: 'Основы программирования, алгоритмы и структуры данных.'
  }
])

// Контакты
const contacts = ref([
  {
    type: 'email',
    value: 'petrov@company.com',
    icon: '📧'
  },
  {
    type: 'phone',
    value: '+7 (999) 123-45-67',
    icon: '📱'
  },
  {
    type: 'location',
    value: 'Москва, Россия',
    icon: '📍'
  },
  {
    type: 'linkedin',
    value: 'linkedin.com',
    icon: '💼'
  }
])

const sendEmail = () => {
  window.location.href = `mailto:${user.value.email}`
}
</script>

<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-6">
    <div class="max-w-6xl mx-auto">

      <!-- Заголовок -->
      <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Профиль сотрудника</h1>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

        <!-- Левая колонка - Профиль -->
        <div class="lg:col-span-1 space-y-6">

          <!-- Карточка профиля -->
          <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
            <div class="flex flex-col items-center text-center">
              <!-- Аватар -->
              <div class="relative mb-4">
                <img
                    :src="user.avatar"
                    class="w-32 h-32 rounded-full border-4 border-white shadow-lg"
                    alt="Аватар"
                >
                <div class="absolute bottom-2 right-2 w-6 h-6 bg-green-500 border-2 border-white rounded-full"></div>
              </div>

              <!-- Основная информация -->
              <h1 class="text-2xl font-bold text-gray-900 mb-1">{{ user.name }}</h1>
              <p class="text-lg text-indigo-600 font-semibold mb-2">{{ user.position }}</p>
              <p class="text-gray-600 mb-4">{{ user.department }}</p>

              <!-- Кнопка связи -->
              <button
                  @click="sendEmail"
                  class="w-full bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white py-3 px-4 rounded-lg font-semibold shadow-sm transition-all duration-200 transform hover:scale-105 mb-6"
              >
                📧 Связаться по почте
              </button>
            </div>

            <!-- Контакты -->
            <div class="border-t border-gray-200 pt-6">
              <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <span class="w-2 h-2 bg-indigo-500 rounded-full mr-2"></span>
                Контакты
              </h3>
              <div class="space-y-3">
                <div
                    v-for="contact in contacts"
                    :key="contact.type"
                    class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors"
                >
                  <span class="text-lg mr-3">{{ contact.icon }}</span>
                  <div>
                    <div class="text-sm text-gray-600 capitalize">{{ contact.type }}</div>
                    <div class="text-gray-900 font-medium">{{ contact.value }}</div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Навыки -->
            <div class="border-t border-gray-200 pt-6">
              <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                Навыки
              </h3>
              <div class="flex flex-wrap gap-2">
                <span
                    v-for="skill in user.skills"
                    :key="skill"
                    class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium hover:bg-blue-200 transition-colors cursor-pointer"
                >
                  {{ skill }}
                </span>
              </div>
            </div>
          </div>

          <!-- Статистика -->
          <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Статистика</h3>
            <div class="space-y-4">
              <div class="flex justify-between items-center">
                <span class="text-gray-600">Лет опыта</span>
                <span class="font-semibold text-gray-900">6+</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Правая колонка - Контент -->
        <div class="lg:col-span-3 space-y-6">

          <!-- О себе -->
          <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
              <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                <span class="w-3 h-3 bg-indigo-500 rounded-full mr-3"></span>
                О себе
              </h2>
            </div>
            <p class="text-gray-700 leading-relaxed text-lg">{{ user.bio }}</p>

            <!-- Достижения -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
              <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-4 rounded-lg border border-blue-200">
                <div class="text-2xl font-bold text-blue-600 mb-1">50+</div>
                <div class="text-sm text-blue-800">Успешных проектов</div>
              </div>
              <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-4 rounded-lg border border-green-200">
                <div class="text-2xl font-bold text-green-600 mb-1">99%</div>
                <div class="text-sm text-green-800">Довольных клиентов</div>
              </div>
              <div class="bg-gradient-to-br from-purple-50 to-pink-50 p-4 rounded-lg border border-purple-200">
                <div class="text-2xl font-bold text-purple-600 mb-1">15+</div>
                <div class="text-sm text-purple-800">Технологий освоено</div>
              </div>
            </div>
          </div>

          <!-- Опыт работы -->
          <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
              <span class="w-3 h-3 bg-green-500 rounded-full mr-3"></span>
              Опыт работы
            </h2>

            <div class="space-y-6">
              <div
                  v-for="exp in workExperience"
                  :key="exp.id"
                  class="border-l-4 border-indigo-500 pl-6 pb-6 relative"
              >
                <!-- Точка на временной линии -->
                <div class="absolute -left-2.5 top-0 w-5 h-5 bg-indigo-500 border-4 border-white rounded-full shadow"></div>

                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-3">
                  <div>
                    <h3 class="text-xl font-semibold text-gray-900">{{ exp.position }}</h3>
                    <p class="text-lg text-indigo-600 font-medium">{{ exp.company }}</p>
                  </div>
                  <span class="mt-2 sm:mt-0 px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm font-medium">
                    {{ exp.period }}
                  </span>
                </div>

                <p class="text-gray-700 mb-4 leading-relaxed">{{ exp.description }}</p>

                <!-- Технологии -->
                <div class="flex flex-wrap gap-2">
                  <span
                      v-for="tech in exp.technologies"
                      :key="tech"
                      class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm hover:bg-gray-200 transition-colors"
                  >
                    {{ tech }}
                  </span>
                </div>
              </div>
            </div>
          </div>

          <!-- Образование -->
          <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
              <span class="w-3 h-3 bg-purple-500 rounded-full mr-3"></span>
              Образование
            </h2>

            <div class="space-y-6">
              <div
                  v-for="edu in education"
                  :key="edu.id"
                  class="border-l-4 border-purple-500 pl-6 pb-6 relative last:pb-0"
              >
                <!-- Точка на временной линии -->
                <div class="absolute -left-2.5 top-0 w-5 h-5 bg-purple-500 border-4 border-white rounded-full shadow"></div>

                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-3">
                  <div>
                    <h3 class="text-xl font-semibold text-gray-900">{{ edu.institution }}</h3>
                    <p class="text-lg text-purple-600 font-medium">{{ edu.degree }}</p>
                  </div>
                  <span class="mt-2 sm:mt-0 px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-medium">
                    {{ edu.period }}
                  </span>
                </div>

                <p class="text-gray-700 leading-relaxed">{{ edu.description }}</p>
              </div>
            </div>
          </div>

          <!-- Сертификаты -->
          <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
              <span class="w-3 h-3 bg-yellow-500 rounded-full mr-3"></span>
              Сертификаты
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                <div class="flex items-center mb-3">
                  <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                    <span class="text-yellow-600 font-bold">V</span>
                  </div>
                  <div>
                    <h4 class="font-semibold text-gray-900">Vue.js Certified Developer</h4>
                    <p class="text-sm text-gray-500">Vue School • 2023</p>
                  </div>
                </div>
              </div>

              <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                <div class="flex items-center mb-3">
                  <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                    <span class="text-blue-600 font-bold">A</span>
                  </div>
                  <div>
                    <h4 class="font-semibold text-gray-900">AWS Solutions Architect</h4>
                    <p class="text-sm text-gray-500">Amazon • 2022</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.border-l-4 {
  border-left-width: 4px;
}

/* Анимация для точек на временной линии */
.absolute {
  transition: all 0.3s ease;
}

.absolute:hover {
  transform: scale(1.2);
}
</style>