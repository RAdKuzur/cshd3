<script setup>
import {onMounted, ref, computed} from 'vue'
import axios from 'axios'
import { useRoute } from 'vue-router'
import {BACKEND_URL, FILES_URL} from "@/router.js";
import {createFile, createFilePHP, DeleteFile, DeleteFilePHP, GetFilesListPHP} from "@/requests/FilesRequest.js";

const route = useRoute()
const user = ref({})
const avatarFile = ref(null) // Связанный файл аватара
const isLoading = ref(false)
const error = ref('')
const successMessage = ref('')

// Добавляем ссылку на input
const fileInput = ref(null)

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

// URL аватара с fallback
const avatarUrl = computed(() => {
  if (avatarFile.value) {
    return getFileUrl(avatarFile.value.file_id)
  }
  return '/default-avatar.jpg'
})

// Загрузка аватара пользователя
const loadAvatar = async () => {
  try {
    const username = route.params.username

    // Получаем список всех файлов пользователя
    const filesRes = await GetFilesListPHP('users', user.value.id)

    if (filesRes.data && filesRes.data.success) {
      // Ищем файл с пометкой avatar (можно добавить поле type в БД)
      // Пока просто берем первый файл или можно добавить специальное поле
      const avatar = filesRes.data.data.find(f => f.is_avatar) || filesRes.data.data[0]
      avatarFile.value = avatar || null
    }
  } catch (err) {
    console.error('Ошибка загрузки аватара:', err)
  }
}

// Загрузка данных пользователя
const fetchUserData = async () => {
  try {
    isLoading.value = true
    const username = route.params.username
    const response = await axios.get(BACKEND_URL + "/api/profile/" + username)
    user.value = response.data.data.user;

    // После получения user.id загружаем аватар
    if (user.value.id) {
      await loadAvatar()
    }
  } catch (err) {
    error.value = 'Ошибка при загрузке данных'
    console.error('Ошибка при загрузке данных:', err);
  } finally {
    isLoading.value = false
  }
}

// Триггер выбора файла
const triggerFileSelect = () => {
  fileInput.value.click()
}

// Обработка выбора файла
const handleFileUpload = async (event) => {
  const file = event.target.files[0]
  if (!file) return

  // Проверка типа файла
  if (!file.type.startsWith('image/')) {
    error.value = 'Пожалуйста, выберите изображение'
    return
  }

  // Проверка размера (например, 5MB)
  if (file.size > 5 * 1024 * 1024) {
    error.value = 'Размер файла не должен превышать 5MB'
    return
  }

  isLoading.value = true
  error.value = ''
  successMessage.value = ''

  try {
    // 1. Загружаем файл на CDN
    const formData = new FormData()
    formData.append('file', file)

    const goRes = await createFile(formData)

    // 2. Если был старый аватар - удаляем его
    if (avatarFile.value) {
      await DeleteFilePHP(avatarFile.value.id)
      await DeleteFile(avatarFile.value.file_id)
    }

    // 3. Создаем связь с пользователем и помечаем как аватар
    await createFilePHP({
      table_name: 'users',
      row_id: user.value.id,
      file_id: goRes.data.data.file_id,
      filename: goRes.data.data.original_name,
      is_avatar: true // Добавьте это поле в вашу таблицу files
    })

    // 4. Перезагружаем аватар
    await loadAvatar()

    successMessage.value = 'Аватар успешно обновлен'

  } catch (err) {
    console.error(err)
    error.value = 'Ошибка загрузки аватара'
  } finally {
    isLoading.value = false
    // Очищаем input
    event.target.value = ''
  }
}

// Удаление аватара
const deleteAvatar = async () => {
  if (!avatarFile.value) return

  if (!confirm('Удалить аватар?')) return

  isLoading.value = true
  error.value = ''
  successMessage.value = ''

  try {
    // Удаляем связь в PHP
    await DeleteFilePHP(avatarFile.value.id)

    // Удаляем физически из Go-сервиса
    await DeleteFile(avatarFile.value.file_id)

    avatarFile.value = null
    successMessage.value = 'Аватар удален'

  } catch (err) {
    console.error(err)
    error.value = 'Ошибка удаления аватара'
  } finally {
    isLoading.value = false
  }
}

const getFileUrl = (fileId) => {
  return FILES_URL + '/' + fileId
}

onMounted(() => {
  fetchUserData()
})

</script>

<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-blue-50">
    <!-- Индикатор загрузки -->
    <div v-if="isLoading" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg p-4 flex items-center gap-3">
        <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-indigo-600"></div>
        <span>Загрузка...</span>
      </div>
    </div>

    <!-- Уведомления -->
    <div v-if="successMessage" class="fixed top-4 right-4 z-50 bg-green-50 border border-green-200 rounded-lg p-4 max-w-md">
      <div class="flex items-center">
        <svg class="w-5 h-5 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        <span class="text-green-700">{{ successMessage }}</span>
      </div>
    </div>

    <div v-if="error" class="fixed top-4 right-4 z-50 bg-red-50 border border-red-200 rounded-lg p-4 max-w-md">
      <div class="flex items-center">
        <svg class="w-5 h-5 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span class="text-red-700">{{ error }}</span>
      </div>
    </div>

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

              <!-- Аватар с анимацией и управлением -->
              <div class="flex flex-col items-center text-center">
                <div class="relative mb-6">
                  <div class="absolute -inset-1 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-full opacity-75 blur-lg group-hover:opacity-100 transition duration-300"></div>
                  <div class="relative">
                    <img
                        :src="avatarUrl"
                        class="w-32 h-32 rounded-full border-4 border-white shadow-xl object-cover transform group-hover:scale-105 transition duration-300"
                        alt="Аватар"
                    >

                    <!-- Индикатор онлайн (опционально) -->
                    <div class="absolute bottom-2 right-2 w-6 h-6 bg-green-500 border-2 border-white rounded-full animate-pulse"></div>

                    <!-- Кнопки управления аватаром -->
                    <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                      <!-- Кнопка загрузки -->
                      <button
                          @click="triggerFileSelect"
                          class="bg-indigo-600 text-white p-2 rounded-full hover:bg-indigo-700 shadow-lg transition"
                          title="Загрузить аватар"
                      >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                      </button>

                      <!-- Кнопка удаления (показываем только если есть аватар) -->
                      <button
                          v-if="avatarFile"
                          @click="deleteAvatar"
                          class="bg-red-600 text-white p-2 rounded-full hover:bg-red-700 shadow-lg transition"
                          title="Удалить аватар"
                      >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                      </button>
                    </div>
                  </div>
                </div>

                <!-- Скрытый input для выбора файла -->
                <input
                    ref="fileInput"
                    type="file"
                    class="hidden"
                    accept="image/*"
                    @change="handleFileUpload"
                />

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