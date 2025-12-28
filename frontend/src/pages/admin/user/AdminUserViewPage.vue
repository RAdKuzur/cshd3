<template>
  <div class="p-6 bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <div class="max-w-4xl mx-auto">
      <!-- Заголовок и навигация -->
      <div class="mb-8">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-4">
            <router-link
                to="/admin/users"
                class="text-gray-600 hover:text-gray-900 flex items-center gap-2 px-3 py-2 hover:bg-gray-100 transition-colors"
            >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
              </svg>
              Назад к списку
            </router-link>
            <div>
              <h1 class="text-3xl font-bold text-gray-900">Просмотр пользователя</h1>
              <p class="text-gray-600 mt-2">Пользователь #{{ user?.id }}</p>
            </div>
          </div>

          <div class="flex items-center gap-3">
            <button
                @click="handleEdit"
                class="px-4 py-2 bg-indigo-600 text-white font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors flex items-center gap-2"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
              </svg>
              Редактировать
            </button>
          </div>
        </div>
      </div>

      <!-- Индикатор загрузки -->
      <div v-if="isLoading" class="flex justify-center items-center h-64">
        <div class="text-gray-600">Загрузка данных...</div>
      </div>

      <div v-else-if="error" class="bg-red-50 border border-red-200 rounded-lg p-4">
        <div class="flex items-center">
          <svg class="w-5 h-5 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span class="text-red-800">{{ error }}</span>
        </div>
      </div>

      <!-- Основная информация -->
      <div v-if="!isLoading && user && !error" class="bg-white shadow-lg border border-gray-200 p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-6 pb-2 border-b border-gray-200">
          Основная информация
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Фамилия</div>
            <div class="text-lg font-semibold text-gray-900">{{ user?.surname || 'Не указана' }}</div>
          </div>

          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Имя</div>
            <div class="text-lg font-semibold text-gray-900">{{ user?.firstname || 'Не указано' }}</div>
          </div>

          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Отчество</div>
            <div class="text-lg text-gray-900">{{ user?.patronymic || 'Не указано' }}</div>
          </div>

          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Полное имя</div>
            <div class="text-lg font-semibold text-gray-900">{{ getFullName() }}</div>
          </div>
        </div>
      </div>

      <!-- Контактная информация -->
      <div v-if="!isLoading && user && !error" class="bg-white shadow-lg border border-gray-200 p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-6 pb-2 border-b border-gray-200">
          Контактная информация
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Имя пользователя</div>
            <div class="flex items-center gap-2">
              <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
              </div>
              <div class="text-lg font-mono text-gray-900">{{ user?.username || 'Не указано' }}</div>
            </div>
          </div>

          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Email</div>
            <div class="flex items-center gap-2">
              <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
              </div>
              <div class="text-lg text-gray-900">{{ user?.email || 'Не указан' }}</div>
            </div>
          </div>

          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Телефон</div>
            <div class="flex items-center gap-2">
              <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
              </div>
              <div class="text-lg text-gray-900">{{ user?.phone || 'Не указан' }}</div>
            </div>
          </div>

          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Дата рождения</div>
            <div class="flex items-center gap-2">
              <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
              </div>
              <div class="text-lg text-gray-900">{{ formatDate(user?.birthdate) || 'Не указана' }}</div>
              <div v-if="user?.birthdate" class="text-sm text-gray-500">
                ({{ calculateAge(user.birthdate) }} лет)
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Роль пользователя -->
      <div v-if="!isLoading && user && !error" class="bg-white shadow-lg border border-gray-200 p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-6 pb-2 border-b border-gray-200">
          Роль в системе
        </h2>

        <div class="flex items-center gap-4">
          <div class="w-12 h-12 rounded-full flex items-center justify-center"
               :class="getRoleColorClass(user?.role).bg">
            <svg class="w-6 h-6" :class="getRoleColorClass(user?.role).text" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
          </div>
          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Роль</div>
            <div class="flex items-center gap-3">
              <span class="text-2xl font-bold" :class="getRoleColorClass(user?.role).text">
                {{ getRoleName(user?.role) }}
              </span>
              <span class="text-sm px-3 py-1 rounded-full font-medium"
                    :class="getRoleBadgeClass(user?.role)">
                ID: {{ user?.role || 'Не указан' }}
              </span>
            </div>
<!--            <div class="text-sm text-gray-500 mt-2">-->
<!--              Определяет уровень доступа и возможности пользователя в системе-->
<!--            </div>-->
          </div>
        </div>
      </div>

      <!-- Расположение (кабинет и этаж) -->
      <div v-if="!isLoading && user && !error" class="bg-white shadow-lg border border-gray-200 p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-6 pb-2 border-b border-gray-200">
          Расположение
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Кабинет</div>
            <div class="flex items-center gap-2">
              <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
              </div>
              <div class="text-lg font-semibold text-gray-900">
                {{ getAuditoriumName(user?.auditorium_id) || 'Не указан' }}
              </div>
            </div>
          </div>

          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Этаж</div>
            <div class="flex items-center gap-2">
              <div class="w-8 h-8 bg-blue-50 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
              </div>
              <div class="text-lg text-gray-900">
                {{ getAuditoriumFloor(user?.auditorium_id) || 'Не указан' }}
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- О пользователе -->
      <div v-if="!isLoading && user && !error && user?.bio" class="bg-white shadow-lg border border-gray-200 p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">О пользователе</h2>

        <div>
          <div class="text-sm font-medium text-gray-500 mb-2">Информация</div>
          <div class="bg-gray-50 p-4 border border-gray-200 rounded-lg">
            <div class="text-gray-700 whitespace-pre-line">{{ user.bio }}</div>
          </div>
        </div>
      </div>

      <!-- Системная информация -->
      <div v-if="!isLoading && user && !error" class="bg-white shadow-lg border border-gray-200 p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Системная информация</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">ID пользователя</div>
            <div class="text-lg font-mono text-gray-900">{{ user?.id || 'Не указан' }}</div>
          </div>

          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Дата создания</div>
            <div class="text-lg text-gray-900">{{ formatDate(user?.created_at) || 'Не указана' }}</div>
          </div>

          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Последнее обновление</div>
            <div class="text-lg text-gray-900">{{ formatDate(user?.updated_at) || 'Не указана' }}</div>
          </div>
        </div>
      </div>

      <!-- Действия -->
      <div v-if="!isLoading && user && !error" class="mt-8 flex items-center justify-between bg-white shadow-lg border border-gray-200 p-6">
        <div class="text-sm text-gray-500">
          Статус: <span class="font-medium text-green-600">Активный</span>
        </div>

        <div class="flex items-center gap-3">
          <button
              @click="handlePrint"
              class="px-4 py-2 border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors flex items-center gap-2"
          >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Печать
          </button>

          <button
              @click="handleDelete"
              class="px-4 py-2 bg-red-600 text-white font-medium hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors flex items-center gap-2"
          >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
            Удалить
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'
import { BACKEND_URL } from "@/router.js"

const route = useRoute()
const router = useRouter()

// Данные
const user = ref(null)
const auditoriums = ref([])
const roles = ref({})
const isLoading = ref(true)
const error = ref(null)

// Загрузка данных при монтировании
onMounted(async () => {
  await Promise.all([
    loadUserData(),
    loadAuditoriums(),
    loadRoles()
  ])
})

// Загрузка данных пользователя
const loadUserData = async () => {
  try {
    isLoading.value = true
    error.value = null
    const userId = route.params.id

    const response = await axios.get(`${BACKEND_URL}/api/admin/users/${userId}`)
    const data = response.data

    if (data.success && data.data) {
      user.value = data.data
      console.log('Полученные данные пользователя:', user.value)
    } else {
      throw new Error(data.message || 'Данные не найдены')
    }

  } catch (err) {
    console.error('Ошибка загрузки данных:', err)

    if (err.response) {
      // Сервер ответил с ошибкой
      if (err.response.status === 404) {
        error.value = 'Пользователь не найден'
      } else {
        error.value = `Ошибка сервера: ${err.response.status}`
      }
    } else if (err.request) {
      // Запрос был сделан, но ответа не получено
      error.value = 'Нет ответа от сервера. Проверьте подключение.'
    } else {
      // Другая ошибка
      error.value = err.message || 'Не удалось загрузить данные пользователя.'
    }
  } finally {
    isLoading.value = false
  }
}

// Загрузка аудиторий
const loadAuditoriums = async () => {
  try {
    const response = await axios.get(`${BACKEND_URL}/api/auditoriums`)
    const data = response.data

    if (data.success && data.data) {
      auditoriums.value = data.data
      console.log('Загруженные аудитории:', auditoriums.value)
    }
  } catch (err) {
    console.error('Ошибка загрузки аудиторий:', err)
    auditoriums.value = []
  }
}

// Загрузка ролей
const loadRoles = async () => {
  try {
    const response = await axios.get(`${BACKEND_URL}/api/info/roles`)
    const data = response.data

    if (data.success && data.data) {
      roles.value = data.data
      console.log('Загруженные роли:', roles.value)
    }
  } catch (err) {
    console.error('Ошибка загрузки ролей:', err)
    roles.value = {}
  }
}

// Методы для работы с ролями
const getRoleName = (roleId) => {
  if (!roleId) return 'Не указана'
  return roles.value[roleId] || `Роль ${roleId}`
}

const getRoleColorClass = (roleId) => {
  const colorMap = {
    1: { bg: 'bg-red-100', text: 'text-red-600' }, // Администратор
    2: { bg: 'bg-purple-100', text: 'text-purple-600' }, // Директор
    3: { bg: 'bg-blue-100', text: 'text-blue-600' }, // Сотрудник
    4: { bg: 'bg-green-100', text: 'text-green-600' }, // Работник отдела кадров
    5: { bg: 'bg-yellow-100', text: 'text-yellow-600' } // Бухгалтер
  }

  return colorMap[roleId] || { bg: 'bg-gray-100', text: 'text-gray-600' }
}

const getRoleBadgeClass = (roleId) => {
  const colorMap = {
    1: 'bg-red-100 text-red-800', // Администратор
    2: 'bg-purple-100 text-purple-800', // Директор
    3: 'bg-blue-100 text-blue-800', // Сотрудник
    4: 'bg-green-100 text-green-800', // Работник отдел а кадров
    5: 'bg-yellow-100 text-yellow-800' // Бухгалтер
  }

  return colorMap[roleId] || 'bg-gray-100 text-gray-800'
}

// Получение названия кабинета по ID
const getAuditoriumName = (auditoriumId) => {
  if (!auditoriumId) return 'Не указан'

  const auditorium = auditoriums.value.find(a => a.id === auditoriumId)
  return auditorium ? auditorium.name : `ID: ${auditoriumId}`
}

// Получение этажа кабинета
const getAuditoriumFloor = (auditoriumId) => {
  if (!auditoriumId) return 'Не указан'

  const auditorium = auditoriums.value.find(a => a.id === auditoriumId)
  if (!auditorium || auditorium.floor === undefined || auditorium.floor === null) {
    return 'Не указан'
  }

  // Форматирование этажа с правильным склонением
  const floor = parseInt(auditorium.floor)
  const lastDigit = floor % 10
  const lastTwoDigits = floor % 100

  if (lastTwoDigits >= 11 && lastTwoDigits <= 19) {
    return `${floor} этаж`
  }

  switch (lastDigit) {
    case 1:
      return `${floor} этаж`
    case 2:
    case 3:
    case 4:
      return `${floor} этажа`
    default:
      return `${floor} этаж`
  }
}

// Получение полного имени
const getFullName = () => {
  if (!user.value) return ''

  const parts = []
  if (user.value.surname) parts.push(user.value.surname)
  if (user.value.firstname) parts.push(user.value.firstname)
  if (user.value.patronymic) parts.push(user.value.patronymic)

  return parts.join(' ') || 'Не указано'
}

// Методы форматирования
const formatDate = (dateString) => {
  if (!dateString) return ''
  try {
    return new Date(dateString).toLocaleDateString('ru-RU')
  } catch (e) {
    return dateString
  }
}

const calculateAge = (birthdate) => {
  if (!birthdate) return '?'
  try {
    const today = new Date()
    const birthDate = new Date(birthdate)
    let age = today.getFullYear() - birthDate.getFullYear()
    const monthDiff = today.getMonth() - birthDate.getMonth()

    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
      age--
    }

    return age
  } catch (e) {
    return '?'
  }
}

// Обработчики действий
const handleEdit = () => {
  router.push(`/admin/users/edit/${route.params.id}`)
}

const handlePrint = () => {
  window.print()
}

const handleDelete = async () => {
  if (!confirm('Вы уверены, что хотите удалить этого пользователя? Это действие нельзя отменить.')) {
    return
  }

  try {
    const userId = route.params.id
    const response = await axios.delete(`${BACKEND_URL}/api/admin/users/${userId}`, {
      headers: {
        'Content-Type': 'application/json',
      }
    })

    const data = response.data
    if (data.success) {
      alert('Пользователь успешно удален')
      router.push('/admin/users')
    } else {
      throw new Error(data.message || 'Ошибка при удалении')
    }
  } catch (err) {
    console.error('Ошибка удаления:', err)

    let errorMessage = 'Не удалось удалить пользователя'
    if (err.response) {
      errorMessage += `: ${err.response.status}`
      if (err.response.data?.message) {
        errorMessage += ` - ${err.response.data.message}`
      }
    } else if (err.message) {
      errorMessage += `: ${err.message}`
    }

    alert(errorMessage)
  }
}
</script>

<style scoped>
@media print {
  .bg-gradient-to-br,
  .bg-gray-50,
  .bg-blue-50,
  button {
    background: white !important;
  }

  .shadow-lg,
  .border,
  button {
    box-shadow: none !important;
    border: 1px solid #e5e7eb !important;
  }

  button {
    display: none !important;
  }
}
</style>