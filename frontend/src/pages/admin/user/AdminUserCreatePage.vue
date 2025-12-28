<template>
  <div class="p-6 bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <div class="max-w-4xl mx-auto">
      <!-- Заголовок -->
      <div class="mb-8">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-3xl font-bold text-gray-900">Создание нового пользователя</h1>
            <p class="text-gray-600 mt-2">Заполните все необходимые поля для добавления пользователя</p>
          </div>
          <router-link
              to="/admin/users"
              class="text-gray-600 hover:text-gray-900 flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-gray-100 transition-colors"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Назад к списку
          </router-link>
        </div>
      </div>

      <!-- Форма создания -->
      <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
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
                  <option value="">Не выбрано</option>
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

          <!-- Безопасность -->
          <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-6 pb-2 border-b border-gray-200">
              Безопасность и доступ
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Пароль -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Пароль *
                </label>
                <input
                    v-model="formData.password"
                    type="password"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                    placeholder="Введите пароль"
                />
                <p class="mt-1 text-sm text-gray-500">
                  Минимум 6 символов
                </p>
              </div>

              <!-- Подтверждение пароля -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Подтверждение пароля *
                </label>
                <input
                    v-model="formData.password_confirmation"
                    type="password"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                    placeholder="Повторите пароль"
                />
                <p class="mt-1 text-sm text-gray-500">
                  Введите пароль еще раз
                </p>
              </div>

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
                      :class="getRoleColorClass(roleId)"
                  >
                    {{ roleName }}
                  </option>
                </select>
                <p class="mt-1 text-sm text-gray-500">
                  Уровень доступа пользователя в системе
                </p>
              </div>

              <!-- Подсказка роли -->
<!--              <div v-if="formData.role" class="col-span-2">-->
<!--                <div class="p-3 rounded-lg" :class="getRoleInfoClass(formData.role)">-->
<!--                  <div class="flex items-start gap-2">-->
<!--                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" :class="getRoleIconColor(formData.role)" fill="none" stroke="currentColor" viewBox="0 0 24 24">-->
<!--                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />-->
<!--                    </svg>-->
<!--                    <div>-->
<!--                      <div class="font-medium" :class="getRoleTextColor(formData.role)">-->
<!--                        {{ getRoleDescription(formData.role) }}-->
<!--                      </div>-->
<!--                    </div>-->
<!--                  </div>-->
<!--                </div>-->
<!--              </div>-->
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
                to="/admin/users"
                class="px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors"
            >
              Отмена
            </router-link>
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
                Создание...
              </span>
              <span v-else>
                Создать пользователя
              </span>
            </button>
          </div>
        </form>
      </div>

      <!-- Предпросмотр -->
      <div v-if="showPreview" class="mt-8">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Предпросмотр данных</h2>
        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
          <div class="grid grid-cols-2 gap-4">
            <div v-for="(value, key) in previewData" :key="key" class="border-b border-gray-200 pb-2">
              <div class="text-sm text-gray-500 capitalize">{{ formatKey(key) }}</div>
              <div class="font-medium">
                <template v-if="key === 'auditorium_id' && auditoriums.length">
                  {{ getAuditoriumName(value) || 'Не указано' }}
                </template>
                <template v-else-if="key === 'password' || key === 'password_confirmation'">
                  ••••••••
                </template>
                <template v-else-if="key === 'role'">
                  <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium"
                        :class="getRoleBadgeClass(value)">
                    {{ getRoleName(value) }}
                  </span>
                </template>
                <template v-else>
                  {{ value || 'Не указано' }}
                </template>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted, watch, computed } from 'vue'
import { useRouter } from 'vue-router'
import axios from "axios"
import { BACKEND_URL } from "@/router.js"

const router = useRouter()

// Данные формы
const formData = reactive({
  surname: '',
  firstname: '',
  patronymic: '',
  username: '',
  email: '',
  phone: '',
  birthdate: '',
  auditorium_id: '',
  role: '',
  password: '',
  password_confirmation: '',
  bio: ''
})

// Данные с сервера
const auditoriums = ref([])
const roles = ref({})
const isLoading = ref(false)
const isSubmitting = ref(false)
const showPreview = ref(false)

// Вычисляемые данные для предпросмотра (без пароля)
const previewData = computed(() => {
  const { password, password_confirmation, ...data } = formData
  return data
})

// Наблюдатель для предпросмотра
watch(formData, (newValue) => {
  console.log('Form data updated:', newValue)
  showPreview.value = Object.values(newValue).some(value => value !== '' && value !== 0)
}, { deep: true })

// Загрузка данных при монтировании компонента
onMounted(async () => {
  await loadFormData()
})

// Загрузка аудиторий и ролей с сервера
const loadFormData = async () => {
  try {
    isLoading.value = true

    const [auditoriumsResponse, rolesResponse] = await Promise.all([
      axios.get(BACKEND_URL + '/api/auditoriums'),
      axios.get(BACKEND_URL + '/api/info/roles')
    ])

    if (auditoriumsResponse.data.success) {
      auditoriums.value = auditoriumsResponse.data.data || []
      console.log('Загруженные аудитории:', auditoriums.value)
    } else {
      console.error('Ошибка загрузки аудиторий:', auditoriumsResponse.data)
      auditoriums.value = []
    }

    if (rolesResponse.data.success) {
      roles.value = rolesResponse.data.data || {}
      console.log('Загруженные роли:', roles.value)
    } else {
      console.error('Ошибка загрузки ролей:', rolesResponse.data)
      roles.value = {}
    }

  } catch (error) {
    console.error('Ошибка при загрузке данных формы:', error)
    auditoriums.value = []
    roles.value = {}
  } finally {
    isLoading.value = false
  }
}

// Получение названия аудитории по ID
const getAuditoriumName = (auditoriumId) => {
  if (!auditoriumId) return ''
  const auditorium = auditoriums.value.find(item => item.id == auditoriumId)
  return auditorium ? auditorium.name : ''
}

// Методы для работы с ролями
const getRoleName = (roleId) => {
  if (!roleId) return 'Не указана'
  return roles.value[roleId] || `Роль ${roleId}`
}

const getRoleBadgeClass = (roleId) => {
  const colorMap = {
    1: 'bg-red-100 text-red-800', // Администратор
    2: 'bg-purple-100 text-purple-800', // Директор
    3: 'bg-blue-100 text-blue-800', // Сотрудник
    4: 'bg-green-100 text-green-800', // Работник отдела кадров
    5: 'bg-yellow-100 text-yellow-800' // Бухгалтер
  }

  return colorMap[roleId] || 'bg-gray-100 text-gray-800'
}

const getRoleColorClass = (roleId) => {
  const colorMap = {
    1: 'text-red-600', // Администратор
    2: 'text-purple-600', // Директор
    3: 'text-blue-600', // Сотрудник
    4: 'text-green-600', // Работник отдела кадров
    5: 'text-yellow-600' // Бухгалтер
  }

  return colorMap[roleId] || 'text-gray-600'
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

const getRoleIconColor = (roleId) => {
  const colorMap = {
    1: 'text-red-500', // Администратор
    2: 'text-purple-500', // Директор
    3: 'text-blue-500', // Сотрудник
    4: 'text-green-500', // Работник отдела кадров
    5: 'text-yellow-500' // Бухгалтер
  }

  return colorMap[roleId] || 'text-gray-500'
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

  return descriptions[roleId] || 'Выберите роль для отображения описания'
}

// Валидация формы
const validateForm = () => {
  const errors = []

  // Проверка обязательных полей
  if (!formData.surname) errors.push('Фамилия обязательна')
  if (!formData.firstname) errors.push('Имя обязательно')
  if (!formData.username) errors.push('Имя пользователя обязательно')
  if (!formData.email) errors.push('Email обязателен')
  if (!formData.password) errors.push('Пароль обязателен')
  if (!formData.password_confirmation) errors.push('Подтверждение пароля обязательно')
  if (!formData.role) errors.push('Роль пользователя обязательна')

  // Проверка email
  if (formData.email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(formData.email)) {
    errors.push('Некорректный email адрес')
  }

  // Проверка совпадения паролей
  if (formData.password && formData.password_confirmation && formData.password !== formData.password_confirmation) {
    errors.push('Пароли не совпадают')
  }

  // Проверка длины пароля
  if (formData.password && formData.password.length < 6) {
    errors.push('Пароль должен содержать минимум 6 символов')
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
      password: formData.password,
      password_confirmation: formData.password_confirmation,
      bio: formData.bio ? formData.bio.trim() : null
    }

    console.log('Отправляемые данные:', dataToSend)

    // Отправка данных на сервер
    const response = await axios.post(
        BACKEND_URL + '/api/admin/users',
        dataToSend,
        {
          headers: {
            'Content-Type': 'application/json',
          }
        }
    )

    if (response.data && response.data.success) {
      alert('Пользователь успешно создан!')
      router.push('/admin/users')
    } else {
      throw new Error(response.data?.message || 'Ошибка при создании пользователя')
    }

  } catch (error) {
    console.error('Ошибка при создании пользователя:', error)

    let errorMessage = 'Произошла ошибка при создании пользователя'

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

// Форматирование ключей для предпросмотра
const formatKey = (key) => {
  const translations = {
    surname: 'Фамилия',
    firstname: 'Имя',
    patronymic: 'Отчество',
    username: 'Имя пользователя',
    email: 'Email',
    phone: 'Телефон',
    birthdate: 'Дата рождения',
    auditorium_id: 'Кабинет',
    role: 'Роль',
    bio: 'О пользователе'
  }
  return translations[key] || key
}
</script>