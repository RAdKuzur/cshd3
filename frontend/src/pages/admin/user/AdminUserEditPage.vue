<template>
  <div class="p-6 bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <div class="max-w-4xl mx-auto">
      <!-- Заголовок -->
      <div class="mb-8">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-3xl font-bold text-gray-900">Редактирование пользователя</h1>
            <p class="text-gray-600 mt-2">Редактирование пользователя #{{ userId }}</p>
          </div>
          <router-link
              :to="`/admin/users/view/${userId}`"
              class="text-gray-600 hover:text-gray-900 flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-gray-100 transition-colors"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Назад к просмотру
          </router-link>
        </div>
      </div>

      <!-- Форма редактирования -->
      <div v-if="!isLoading && user" class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
        <form @submit.prevent="handleSubmit">
          <!-- Основная информация -->
          <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-6 pb-2 border-b border-gray-200">
              Основная информация
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Фамилия -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Фамилия *
                </label>
                <input
                    v-model="formData.surname"
                    type="text"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                    placeholder="Например: Иванов"
                />
                <p class="mt-1 text-sm text-gray-500">
                  Фамилия пользователя
                </p>
              </div>

              <!-- Имя -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Имя *
                </label>
                <input
                    v-model="formData.firstname"
                    type="text"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                    placeholder="Например: Иван"
                />
                <p class="mt-1 text-sm text-gray-500">
                  Имя пользователя
                </p>
              </div>

              <!-- Отчество -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Отчество
                </label>
                <input
                    v-model="formData.patronymic"
                    type="text"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                    placeholder="Например: Иванович"
                />
                <p class="mt-1 text-sm text-gray-500">
                  Отчество пользователя (необязательно)
                </p>
              </div>

              <!-- Дата рождения -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Дата рождения
                </label>
                <input
                    v-model="formData.birthdate"
                    type="date"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                />
                <p class="mt-1 text-sm text-gray-500">
                  Дата рождения пользователя
                </p>
              </div>
            </div>
          </div>

          <!-- Контактная информация -->
          <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-6 pb-2 border-b border-gray-200">
              Контактная информация
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Имя пользователя -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Имя пользователя (логин) *
                </label>
                <input
                    v-model="formData.username"
                    type="text"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                    placeholder="Например: iivanov"
                    :disabled="isUpdatingUsername"
                />
                <p class="mt-1 text-sm text-gray-500">
                  Уникальное имя для входа в систему
                </p>
              </div>

              <!-- Email -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Email *
                </label>
                <input
                    v-model="formData.email"
                    type="email"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                    placeholder="Например: i.ivanov@example.com"
                />
                <p class="mt-1 text-sm text-gray-500">
                  Электронная почта пользователя
                </p>
              </div>

              <!-- Телефон -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Телефон
                </label>
                <input
                    v-model="formData.phone"
                    type="tel"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                    placeholder="Например: +7 (999) 123-45-67"
                />
                <p class="mt-1 text-sm text-gray-500">
                  Номер телефона пользователя
                </p>
              </div>

              <!-- Кабинет -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Кабинет
                </label>
                <select
                    v-model="formData.auditorium_id"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                >
                  <option :value="null">Не выбрано</option>
                  <option
                      v-for="auditorium in auditoriums"
                      :key="auditorium.id"
                      :value="auditorium.id"
                  >
                    {{ auditorium.name }}
                  </option>
                </select>
                <p class="mt-1 text-sm text-gray-500">
                  Кабинет пользователя
                </p>
              </div>
            </div>
          </div>

          <!-- Роль и доступ -->
          <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-6 pb-2 border-b border-gray-200">
              Роль и доступ
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Роль пользователя -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Роль пользователя *
                </label>
                <select
                    v-model="formData.role"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                >
                  <option value="">Выберите роль</option>
                  <option
                      v-for="(roleName, roleId) in roles"
                      :key="roleId"
                      :value="roleId"
                  >
                    {{ roleName }}
                  </option>
                </select>
                <p class="mt-1 text-sm text-gray-500">
                  Уровень доступа пользователя в системе
                </p>
              </div>

              <!-- Текущая роль -->
              <div v-if="formData.role" class="col-span-2">
                <div class="p-4 rounded-lg" :class="getRoleInfoClass(formData.role)">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center"
                         :class="getRoleColorClass(formData.role).bg">
                      <svg class="w-5 h-5" :class="getRoleColorClass(formData.role).text" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                      </svg>
                    </div>
                    <div>
                      <div class="font-medium" :class="getRoleTextColor(formData.role)">
                        Текущая роль: <span class="font-bold">{{ getRoleName(formData.role) }}</span>
                      </div>
<!--                      <div class="text-sm" :class="getRoleTextColor(formData.role) + ' opacity-80'">-->
<!--                        {{ getRoleDescription(formData.role) }}-->
<!--                      </div>-->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Смена пароля (опционально) -->
          <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-6 pb-2 border-b border-gray-200">
              Смена пароля (оставьте пустым, если не нужно менять)
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Новый пароль -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Новый пароль
                </label>
                <input
                    v-model="formData.password"
                    type="password"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                    placeholder="Введите новый пароль"
                />
                <p class="mt-1 text-sm text-gray-500">
                  Минимум 6 символов
                </p>
              </div>

              <!-- Подтверждение пароля -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Подтверждение пароля
                </label>
                <input
                    v-model="formData.password_confirmation"
                    type="password"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                    placeholder="Повторите новый пароль"
                />
                <p class="mt-1 text-sm text-gray-500">
                  Введите пароль еще раз
                </p>
              </div>
            </div>
          </div>

          <!-- О пользователе -->
          <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">
              Дополнительная информация
            </h2>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                О пользователе
              </label>
              <textarea
                  v-model="formData.bio"
                  rows="4"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                  placeholder="Введите информацию о пользователе..."
              ></textarea>
              <p class="mt-1 text-sm text-gray-500">
                Дополнительная информация, биография, должность и т.д.
              </p>
            </div>
          </div>

          <!-- Кнопки действий -->
          <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
            <router-link
                :to="`/admin/users/view/${userId}`"
                class="px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors"
            >
              Отмена
            </router-link>
            <button
                type="button"
                @click="handleDelete"
                class="px-6 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors"
            >
              Удалить
            </button>
            <button
                type="submit"
                :disabled="isSubmitting || isLoading"
                class="px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
            >
              <span v-if="isSubmitting">
                <svg class="animate-spin h-5 w-5 inline-block mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Сохранение...
              </span>
              <span v-else>
                Сохранить изменения
              </span>
            </button>
          </div>
        </form>
      </div>

      <!-- Индикатор загрузки -->
      <div v-if="isLoading" class="flex justify-center items-center h-64">
        <div class="text-gray-600">Загрузка данных пользователя...</div>
      </div>

      <!-- Сообщение об ошибке -->
      <div v-if="error && !isLoading" class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
        <div class="flex items-center">
          <svg class="w-5 h-5 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span class="text-red-800">{{ error }}</span>
        </div>
        <button
            @click="loadUserData"
            class="mt-2 text-sm text-red-600 hover:text-red-800 underline"
        >
          Попробовать снова
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted, watch, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from "axios"
import { BACKEND_URL } from "@/router.js"

const route = useRoute()
const router = useRouter()

const userId = route.params.id

// Данные
const user = ref(null)
const formData = reactive({
  surname: '',
  firstname: '',
  patronymic: '',
  username: '',
  email: '',
  phone: '',
  birthdate: '',
  auditorium_id: null,
  role: '',
  password: '',
  password_confirmation: '',
  bio: ''
})
const auditoriums = ref([])
const roles = ref({})
const isLoading = ref(true)
const isSubmitting = ref(false)
const error = ref(null)
const isUpdatingUsername = ref(false)

// Загрузка данных при монтировании компонента
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

    const response = await axios.get(`${BACKEND_URL}/api/admin/users/${userId}`)
    const data = response.data

    if (data.success && data.data) {
      user.value = data.data

      // Заполняем форму данными пользователя
      formData.surname = user.value.surname || ''
      formData.firstname = user.value.firstname || ''
      formData.patronymic = user.value.patronymic || ''
      formData.username = user.value.username || ''
      formData.email = user.value.email || ''
      formData.phone = user.value.phone || ''
      formData.birthdate = user.value.birthdate ? formatDateForInput(user.value.birthdate) : ''
      formData.auditorium_id = user.value.auditorium_id || null
      formData.role = user.value.role || ''
      formData.bio = user.value.bio || ''

      // Пароли оставляем пустыми для безопасности
      formData.password = ''
      formData.password_confirmation = ''

      console.log('Загруженные данные пользователя:', user.value)
    } else {
      throw new Error(data.message || 'Данные не найдены')
    }

  } catch (err) {
    console.error('Ошибка загрузки данных пользователя:', err)
    error.value = err.message || 'Не удалось загрузить данные пользователя'
  } finally {
    isLoading.value = false
  }
}

// Загрузка аудиторий
const loadAuditoriums = async () => {
  try {
    const response = await axios.get(BACKEND_URL + '/api/auditoriums')

    if (response.data.success) {
      auditoriums.value = response.data.data || []
      console.log('Загруженные аудитории:', auditoriums.value)
    } else {
      console.error('Ошибка загрузки аудиторий:', response.data)
      auditoriums.value = []
    }

  } catch (error) {
    console.error('Ошибка при загрузке аудиторий:', error)
    auditoriums.value = []
  }
}

// Загрузка ролей
const loadRoles = async () => {
  try {
    const response = await axios.get(BACKEND_URL + '/api/info/roles')
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

const getRoleInfoClass = (roleId) => {
  const colorMap = {
    1: 'bg-red-50 border border-red-100', // Администратор
    2: 'bg-purple-50 border border-purple-100', // Директор
    3: 'bg-blue-50 border border-blue-100', // Сотрудник
    4: 'bg-green-50 border border-green-100', // Работник отдела кадров
    5: 'bg-yellow-50 border border-yellow-100' // Бухгалтер
  }

  return colorMap[roleId] || 'bg-gray-50 border border-gray-100'
}

const getRoleTextColor = (roleId) => {
  const colorMap = {
    1: 'text-red-700', // Администратор
    2: 'text-purple-700', // Директор
    3: 'text-blue-700', // Сотрудник
    4: 'text-green-700', // Работник отдела кадров
    5: 'text-yellow-700' // Бухгалтер
  }

  return colorMap[roleId] || 'text-gray-700'
}

const getRoleDescription = (roleId) => {
  const descriptions = {
    1: 'Администратор имеет полный доступ ко всем функциям системы',
    2: 'Директор имеет доступ к управлению сотрудниками и отчетности',
    3: 'Сотрудник имеет базовый доступ к системе',
    4: 'Работник отдела кадров имеет доступ к управлению персоналом',
    5: 'Бухгалтер имеет доступ к финансовым данным и отчетности'
  }

  return descriptions[roleId] || 'Роль определяет уровень доступа пользователя'
}

// Форматирование даты для input[type="date"]
const formatDateForInput = (dateString) => {
  if (!dateString) return ''
  try {
    const date = new Date(dateString)
    return date.toISOString().split('T')[0]
  } catch (e) {
    return dateString
  }
}

// Валидация формы
const validateForm = () => {
  const errors = []

  // Проверка обязательных полей
  if (!formData.surname) errors.push('Фамилия обязательна')
  if (!formData.firstname) errors.push('Имя обязательно')
  if (!formData.username) errors.push('Имя пользователя обязательно')
  if (!formData.email) errors.push('Email обязателен')
  if (!formData.role) errors.push('Роль пользователя обязательна')

  // Проверка email
  if (formData.email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(formData.email)) {
    errors.push('Некорректный email адрес')
  }

  // Если пароль указан, проверяем его
  if (formData.password) {
    // Проверка совпадения паролей
    if (formData.password !== formData.password_confirmation) {
      errors.push('Пароли не совпадают')
    }

    // Проверка длины пароля
    if (formData.password.length < 6) {
      errors.push('Пароль должен содержать минимум 6 символов')
    }
  }

  return errors
}

// Обработка отправки формы
const handleSubmit = async () => {
  try {
    isSubmitting.value = true

    // Валидация
    const errors = validateForm()
    if (errors.length > 0) {
      alert('Пожалуйста, исправьте ошибки:\n\n' + errors.join('\n'))
      return
    }

    // Подготовка данных для отправки
    const dataToSend = {
      surname: formData.surname.trim(),
      firstname: formData.firstname.trim(),
      patronymic: formData.patronymic ? formData.patronymic.trim() : null,
      username: formData.username.trim(),
      email: formData.email.trim(),
      phone_number: formData.phone ? formData.phone.trim() : null,
      birthdate: formData.birthdate || null,
      auditorium_id: formData.auditorium_id ? parseInt(formData.auditorium_id) : null,
      role: formData.role,
      bio: formData.bio ? formData.bio.trim() : null
    }

    // Добавляем пароль только если он указан
    if (formData.password) {
      dataToSend.password = formData.password
      dataToSend.password_confirmation = formData.password_confirmation
    }

    console.log('Отправляемые данные:', dataToSend)

    // Отправка данных на сервер
    const response = await axios.put(
        `${BACKEND_URL}/api/admin/users/${userId}`,
        dataToSend,
        {
          headers: {
            'Content-Type': 'application/json',
          }
        }
    )

    if (response.data && response.data.success) {
      alert('Данные пользователя успешно обновлены!')
      router.push(`/admin/users/view/${userId}`)
    } else {
      throw new Error(response.data?.message || 'Ошибка при обновлении пользователя')
    }

  } catch (error) {
    console.error('Ошибка при обновлении пользователя:', error)

    let errorMessage = 'Произошла ошибка при обновлении пользователя'

    if (error.response) {
      if (error.response.data && error.response.data.message) {
        errorMessage = error.response.data.message
      } else if (error.response.status === 422) {
        const validationErrors = error.response.data.errors
        errorMessage = 'Ошибки валидации:\n'
        for (const field in validationErrors) {
          errorMessage += `• ${validationErrors[field].join(', ')}\n`
        }
      } else if (error.response.data && error.response.data.error) {
        errorMessage = error.response.data.error
      }
    } else if (error.request) {
      errorMessage = 'Не удалось получить ответ от сервера. Проверьте подключение к интернету.'
    }

    alert(errorMessage)
  } finally {
    isSubmitting.value = false
  }
}

// Удаление пользователя
const handleDelete = async () => {
  if (!confirm('Вы уверены, что хотите удалить этого пользователя? Это действие нельзя отменить.')) {
    return
  }

  try {
    const response = await axios.delete(`${BACKEND_URL}/api/admin/users/${userId}`)

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