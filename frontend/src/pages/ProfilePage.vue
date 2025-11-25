<script setup>
import {onMounted, ref} from 'vue'
import axios from 'axios'
import { useRoute } from 'vue-router'

const user = ref({})
const workExperience = ref({})
const contacts = ref({})
const education = ref({})
const fetchUserData = async () => {
  try {
    const route = useRoute()
    const username = route.params.username
    console.log("http://localhost:8000/api/profile/" + username)
    const response = await axios.get("http://localhost:8000/api/profile/" + username)
    user.value = response.data.data.user;
    contacts.value = response.data.data.contacts
    workExperience.value = response.data.data.workExperience
    education.value = response.data.data.education
  } catch (err) {
    console.error('Ошибка при загрузке данных:', err)
  }
}
onMounted(() => {
  fetchUserData()
})
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
            <!-- МЕСТО ДЛЯ ДОСТИЖЕНИЙ -->
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

          <!-- МЕСТО ДЛЯ СЕРТИФИКАТОВ -->
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