<script setup>
import {onMounted, ref, computed} from 'vue'
import axios from 'axios'
import { useRoute } from 'vue-router'
import {BACKEND_URL} from "@/router.js";

const user = ref({})

const formattedContacts = computed(() => {
  const contactsList = [];

  if (user.value.email) {
    contactsList.push({
      type: 'email',
      icon: '✉️',
      value: user.value.email,
      bgColor: 'from-blue-500 to-blue-600',
      lightBg: 'bg-blue-50'
    });
  }

  if (user.value.phone) {
    contactsList.push({
      type: 'телефон',
      icon: '📞',
      value: user.value.phone,
      bgColor: 'from-green-500 to-green-600',
      lightBg: 'bg-green-50'
    });
  }

  return contactsList;
});

const fetchUserData = async () => {
  try {
    const route = useRoute()
    const username = route.params.username
    const response = await axios.get(BACKEND_URL + "/api/profile/" + username)
    user.value = response.data.data.user;
  } catch (err) {
    console.error('Ошибка при загрузке данных:', err);
  }
}

onMounted(() => {
  fetchUserData()
})

</script>

<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-blue-50">
    <!-- Декоративный фон -->
    <div class="absolute inset-0 bg-grid-slate-100 [mask-image:linear-gradient(0deg,transparent,black)] pointer-events-none"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
      <!-- Заголовок с градиентом -->
      <div class="text-center mb-10">
        <div class="inline-block">
          <h1 class="text-5xl lg:text-6xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent mb-3">
            Профиль сотрудника
          </h1>
          <div class="h-1 w-24 bg-gradient-to-r from-indigo-600 to-purple-600 mx-auto rounded-full"></div>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        <!-- Левая колонка - Профиль -->
        <div class="lg:col-span-4 space-y-6">

          <!-- Карточка профиля с эффектом стекла -->
          <div class="group relative">
            <!-- Фоновый градиент -->
            <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl opacity-0 group-hover:opacity-100 transition duration-300 blur"></div>

            <div class="relative bg-white/90 backdrop-blur-xl rounded-2xl shadow-xl border border-gray-200 p-6 hover:border-transparent transition-all duration-300">

              <!-- Аватар с анимацией -->
              <div class="flex flex-col items-center text-center">
                <div class="relative mb-6">
                  <div class="absolute -inset-1 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-full opacity-75 blur-lg group-hover:opacity-100 transition duration-300"></div>
                  <div class="relative">
                    <img
                        :src="user.avatar || '/default-avatar.jpg'"
                        class="w-32 h-32 rounded-full border-4 border-white shadow-xl object-cover transform group-hover:scale-105 transition duration-300"
                        alt="Аватар"
                    >
                    <div class="absolute bottom-2 right-2 w-6 h-6 bg-green-500 border-2 border-white rounded-full animate-pulse"></div>
                  </div>
                </div>

                <!-- Основная информация -->
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ user.name || 'Имя не указано' }}</h1>
                <div class="flex items-center justify-center space-x-2 mb-2">
                  <span class="px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-medium">
                    {{ user.position || 'Должность не указана' }}
                  </span>
                </div>
                <p class="text-gray-600 mb-6 flex items-center justify-center">
                  <span class="w-2 h-2 bg-indigo-500 rounded-full mr-2"></span>
                  {{ user.department || 'Отдел не указан' }}
                </p>
              </div>

              <!-- Контакты с новым дизайном -->
              <div class="border-t border-gray-200 pt-6" v-if="formattedContacts.length > 0">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                  <span class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                    <span class="text-indigo-600">📱</span>
                  </span>
                  Контактная информация
                </h3>
                <div class="space-y-3">
                  <div
                      v-for="contact in formattedContacts"
                      :key="contact.type"
                      class="group/contact relative overflow-hidden"
                  >
                    <!-- Фоновый эффект при наведении -->
                    <div class="absolute inset-0 bg-gradient-to-r opacity-0 group-hover/contact:opacity-100 transition-opacity duration-300"
                         :class="contact.bgColor"></div>

                    <div class="relative flex items-center p-4 bg-gray-50 rounded-xl hover:bg-transparent transition-all duration-300">
                      <div class="w-10 h-10 rounded-lg flex items-center justify-center text-xl mr-3"
                           :class="contact.lightBg">
                        {{ contact.icon }}
                      </div>
                      <div>
                        <div class="text-xs uppercase tracking-wider text-gray-500 mb-0.5">{{ contact.type }}</div>
                        <div class="text-gray-900 font-medium break-all group-hover/contact:text-white transition-colors">
                          <template v-if="contact.type === 'email'">
                            <a :href="'mailto:' + contact.value" class="hover:underline">
                              {{ contact.value }}
                            </a>
                          </template>
                          <template v-else-if="contact.type === 'телефон'">
                            <a :href="'tel:' + contact.value" class="hover:underline">
                              {{ contact.value }}
                            </a>
                          </template>
                          <template v-else>
                            {{ contact.value }}
                          </template>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Сообщение, если контактов нет -->
              <div v-else class="border-t border-gray-200 pt-6">
                <div class="bg-gray-50 rounded-xl p-8 text-center">
                  <span class="text-4xl mb-3 block">📭</span>
                  <p class="text-gray-500">Контакты не указаны</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Правая колонка - Контент -->
        <div class="lg:col-span-8 space-y-6">

          <!-- Карточка "О себе" с улучшенным дизайном -->
          <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden transform hover:shadow-2xl transition-shadow duration-300">
            <!-- Градиентный заголовок -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-5">
              <div class="flex items-center">
                <span class="w-10 h-10 bg-white/20 backdrop-blur rounded-lg flex items-center justify-center text-white text-xl mr-4">
                  👤
                </span>
                <h2 class="text-2xl font-bold text-white">О себе</h2>
              </div>
            </div>

            <!-- Контент -->
            <div class="p-8">
              <div v-if="user.about" class="relative">
                <!-- Декоративные кавычки -->
                <span class="absolute -top-4 -left-2 text-6xl text-indigo-200 opacity-50">"</span>
                <p class="text-gray-700 leading-relaxed text-lg relative z-10 pl-6">
                  {{ user.about }}
                </p>
                <span class="absolute -bottom-12 -right-2 text-6xl text-indigo-200 opacity-50 transform rotate-180">"</span>
              </div>
              <div v-else class="text-center py-12">
                <span class="text-5xl mb-4 block text-gray-300">📝</span>
                <p class="text-gray-500 text-lg">Информация отсутствует</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.bg-grid-slate-100 {
  background-image:
      linear-gradient(to right, rgb(241 245 249 / 0.4) 1px, transparent 1px),
      linear-gradient(to bottom, rgb(241 245 249 / 0.4) 1px, transparent 1px);
  background-size: 50px 50px;
}

@keyframes float {
  0%, 100% { transform: translateY(0px); }
  50% { transform: translateY(-10px); }
}

.animate-float {
  animation: float 3s ease-in-out infinite;
}

/* Анимация для статистики */
.group:hover .group-hover\:w-full {
  width: 100%;
}

/* Стили для скроллбара */
::-webkit-scrollbar {
  width: 8px;
}

::-webkit-scrollbar-track {
  background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
  background: linear-gradient(to bottom, #4f46e5, #9333ea);
  border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
  background: linear-gradient(to bottom, #4338ca, #7e22ce);
}
</style>