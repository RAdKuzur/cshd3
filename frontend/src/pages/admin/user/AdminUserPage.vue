<template>
  <div class="p-6 bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
      <!-- Заголовок и элементы управления -->
      <div class="mb-8">
        <div class="flex justify-between items-center">
          <div>
            <h1 class="text-3xl font-bold text-gray-900">Пользователи</h1>
            <p class="text-gray-600 mt-2">Всего пользователей: {{ filteredUsers.length }}</p>
          </div>
          <router-link to="/admin/users/create">
            <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-semibold shadow-sm transition-colors">
              + Добавить пользователя
            </button>
          </router-link>
        </div>

        <!-- Панель поиска и фильтров -->
        <div class="mt-6 flex gap-4 flex-wrap">
          <div class="flex-1 min-w-[300px]">
            <div class="relative">
              <input
                  v-model="searchQuery"
                  type="text"
                  placeholder="Поиск по имени, фамилии, email, телефону, имени пользователя, роли..."
                  class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
              >
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </div>
            </div>
          </div>

          <div class="flex gap-4 flex-wrap">
            <select
                v-model="sortField"
                class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
            >
              <option value="surname">Сортировка по фамилии</option>
              <option value="firstname">По имени</option>
              <option value="username">По имени пользователя</option>
              <option value="email">По email</option>
              <option value="birthdate">По дате рождения</option>
              <option value="auditorium_name">По аудитории</option>
              <option value="role">По роли</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Загрузка -->
      <div v-if="isLoading" class="text-center py-12">
        <svg class="animate-spin mx-auto h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <p class="mt-2 text-gray-600">Загрузка данных...</p>
      </div>

      <!-- Таблица -->
      <div v-else class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead class="bg-gradient-to-r from-indigo-500 to-purple-600">
            <tr>
              <th
                  v-for="header in headers"
                  :key="header.key"
                  class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider cursor-pointer"
                  @click="sortTable(header.key)"
              >
                <div class="flex items-center">
                  {{ header.label }}
                  <svg
                      v-if="sortKey === header.key"
                      class="w-4 h-4 ml-1"
                      :class="sortOrder === 'asc' ? 'rotate-180' : ''"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                  >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                  </svg>
                </div>
              </th>
            </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
            <tr
                v-for="user in paginatedUsers"
                :key="user.id"
                class="hover:bg-gradient-to-r hover:from-indigo-50 hover:to-white transition-all duration-200 group"
            >
              <!-- ФИО и контактная информация -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-10 w-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                  </div>
                  <div class="ml-4">
                    <router-link :to="`/admin/users/view/${user.id}`" class="block">
                      <div class="text-sm font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors hover:underline">
                        {{ user.fullName }}
                      </div>
                    </router-link>
                    <div class="text-sm text-gray-500">
                      {{ user.username }}
                    </div>
                    <div class="text-xs text-gray-400">
                      ID: {{ user.id }}
                    </div>
                  </div>
                </div>
              </td>

              <!-- Контактная информация -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-8 w-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                    <svg class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                  </div>
                  <div>
                    <div class="text-sm font-medium text-gray-900">{{ user.email }}</div>
                    <div class="text-xs text-gray-500">{{ user.phone || 'Телефон не указан' }}</div>
                  </div>
                </div>
              </td>

              <!-- Кабинет размещения -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-8 w-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                    <svg class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                  </div>
                  <div>
                    <div class="text-sm font-semibold text-gray-900">
                      {{ user.auditorium_name || 'Не указана' }}
                    </div>
                    <div v-if="user.auditorium_floor" class="text-xs text-gray-500">
                      {{ user.auditorium_floor }}
                    </div>
                  </div>
                </div>
              </td>

              <!-- Дата рождения -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900 font-medium">{{ formatDate(user.birthdate) }}</div>
                <div class="text-xs text-gray-500">{{ calculateAge(user.birthdate) }} лет</div>
              </td>

              <!-- Роль -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-8 w-8 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                    <svg class="h-4 w-4 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                  </div>
                  <div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                          :class="getRoleColorClass(user.role)">
                      {{ getRoleName(user.role) }}
                    </span>
                  </div>
                </div>
              </td>

              <!-- Информация -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-8 w-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                    <svg class="h-4 w-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                  </div>
                  <div>
                    <div class="text-sm font-medium text-gray-900 truncate max-w-xs">
                      {{ user.bio || 'Информация не указана' }}
                    </div>
                    <div class="text-xs text-gray-500">
                      О пользователе
                    </div>
                  </div>
                </div>
              </td>

              <!-- Действия -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center space-x-2">
                  <!-- Кнопка просмотра -->
                  <router-link :to="`/admin/users/view/${user.id}`">
                    <button class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Просмотреть">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                      </svg>
                    </button>
                  </router-link>

                  <!-- Кнопка редактирования -->
                  <router-link :to="`/admin/users/edit/${user.id}`">
                    <button class="p-2 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Редактировать">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                      </svg>
                    </button>
                  </router-link>

                  <!-- Кнопка удаления -->
                  <button
                      @click="confirmDelete(user)"
                      class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                      title="Удалить"
                  >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                  </button>
                </div>
              </td>
            </tr>
            </tbody>
          </table>
        </div>

        <!-- Пустое состояние -->
        <div v-if="!isLoading && filteredUsers.length === 0" class="text-center py-12">
          <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <h3 class="mt-2 text-sm font-medium text-gray-900">Пользователи не найдены</h3>
          <p class="mt-1 text-sm text-gray-500">Попробуйте изменить параметры поиска</p>
        </div>

        <!-- Пагинация -->
        <div v-if="!isLoading && filteredUsers.length > 0" class="px-6 py-4 border-t border-gray-200 bg-gray-50">
          <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700">
              Показано с {{ startIndex }} по {{ endIndex }} из {{ filteredUsers.length }} записей
            </div>
            <div class="flex items-center space-x-2">
              <button
                  @click="prevPage"
                  :disabled="currentPage === 1"
                  class="px-3 py-1 rounded-md border border-gray-300 text-sm font-medium"
                  :class="currentPage === 1 ? 'text-gray-400 cursor-not-allowed' : 'text-gray-700 hover:bg-gray-100'"
              >
                Назад
              </button>

              <div class="flex space-x-1">
                <button
                    v-for="page in visiblePages"
                    :key="page"
                    @click="goToPage(page)"
                    class="w-8 h-8 rounded-md text-sm font-medium"
                    :class="page === currentPage
                    ? 'bg-indigo-600 text-white'
                    : 'text-gray-700 hover:bg-gray-100'"
                >
                  {{ page }}
                </button>
                <span v-if="showEllipsis" class="px-2 py-1 text-gray-500">...</span>
              </div>

              <button
                  @click="nextPage"
                  :disabled="currentPage === totalPages"
                  class="px-3 py-1 rounded-md border border-gray-300 text-sm font-medium"
                  :class="currentPage === totalPages ? 'text-gray-400 cursor-not-allowed' : 'text-gray-700 hover:bg-gray-100'"
              >
                Вперед
              </button>
            </div>

            <select
                v-model="itemsPerPage"
                class="px-3 py-1 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
            >
              <option value="5">5 на странице</option>
              <option value="10">10 на странице</option>
              <option value="20">20 на странице</option>
              <option value="50">50 на странице</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <!-- Модальное окно подтверждения удаления -->
    <div v-if="showDeleteModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg p-6 max-w-md mx-4">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Подтверждение удаления</h3>
        <p class="text-sm text-gray-500 mb-6">
          Вы уверены, что хотите удалить пользователя
          <span class="font-semibold">{{ userToDelete?.fullName }}</span>?
          Это действие нельзя отменить.
        </p>
        <div class="flex justify-end space-x-3">
          <button
              @click="showDeleteModal = false"
              class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50"
          >
            Отмена
          </button>
          <button
              @click="deleteUser"
              class="px-4 py-2 bg-red-600 text-white rounded-md text-sm font-medium hover:bg-red-700"
          >
            Удалить
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
import { BACKEND_URL } from "@/router.js"

const router = useRouter()

// Реактивные данные
const headers = ref([
  { key: 'fullName', label: 'ФИО и имя пользователя' },
  { key: 'email', label: 'Контактная информация' },
  { key: 'auditorium_name', label: 'Кабинет' },
  { key: 'birthdate', label: 'Дата рождения' },
  { key: 'role', label: 'Роль' },
  { key: 'bio', label: 'Информация' },
  { key: 'actions', label: 'Действия' }
])

const users = ref([])
const auditoriums = ref([])
const roles = ref({})
const isLoading = ref(false)
const error = ref(null)

const searchQuery = ref('')
const sortField = ref('surname')
const sortKey = ref('surname')
const sortOrder = ref('asc')

// Пагинация
const currentPage = ref(1)
const itemsPerPage = ref(10)

// Удаление пользователя
const showDeleteModal = ref(false)
const userToDelete = ref(null)

// Загрузка данных
const loadData = async () => {
  try {
    isLoading.value = true
    error.value = null

    // Загружаем данные параллельно
    const [usersResponse, auditoriumsResponse, rolesResponse] = await Promise.all([
      axios.get(BACKEND_URL + '/api/admin/users'),
      axios.get(BACKEND_URL + '/api/auditoriums'),
      axios.get(BACKEND_URL + '/api/info/roles')
    ])

    // Сохраняем аудитории
    if (auditoriumsResponse.data.success) {
      auditoriums.value = auditoriumsResponse.data.data || []
    }

    // Сохраняем роли
    if (rolesResponse.data.success) {
      roles.value = rolesResponse.data.data || {}
    }

    if (usersResponse.data.success) {
      users.value = usersResponse.data.data.map(user => {
        // Находим аудиторию по ID
        const auditorium = auditoriums.value.find(a => a.id === user.auditorium_id)
        const auditoriumName = auditorium ? auditorium.name : 'Не указана'
        const auditoriumFloor = auditorium ? getFloorText(auditorium.floor) : ''

        // Получаем название роли
        const roleName = roles.value[user.role] || `Роль ${user.role}`

        // Формируем полное имя
        const fullName = `${user.surname} ${user.firstname} ${user.patronymic || ''}`.trim()

        return {
          id: user.id,
          firstname: user.firstname,
          surname: user.surname,
          patronymic: user.patronymic,
          fullName: fullName,
          username: user.username,
          email: user.email,
          phone: user.phone,
          birthdate: user.birthdate,
          role: user.role,
          role_name: roleName,
          auditorium_id: user.auditorium_id,
          auditorium_name: auditoriumName,
          auditorium_floor: auditoriumFloor,
          bio: user.bio
        }
      })
    } else {
      throw new Error('Не удалось загрузить список пользователей')
    }

  } catch (err) {
    console.error('Ошибка при загрузке данных:', err)
    error.value = err.message
  } finally {
    isLoading.value = false
  }
}

onMounted(() => {
  loadData()
})

// Методы для работы с ролями
const getRoleName = (roleId) => {
  return roles.value[roleId] || `Роль ${roleId}`
}

const getRoleColorClass = (roleId) => {
  const colorMap = {
    1: 'bg-red-100 text-red-800', // Администратор
    2: 'bg-purple-100 text-purple-800', // Директор
    3: 'bg-blue-100 text-blue-800', // Сотрудник
    4: 'bg-green-100 text-green-800', // Работник отдела кадров
    5: 'bg-yellow-100 text-yellow-800' // Бухгалтер
  }

  return colorMap[roleId] || 'bg-gray-100 text-gray-800'
}

// Вычисляемые свойства
const filteredUsers = computed(() => {
  let filtered = users.value

  // Фильтрация по поиску
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(user =>
        (user.firstname && user.firstname.toLowerCase().includes(query)) ||
        (user.surname && user.surname.toLowerCase().includes(query)) ||
        (user.patronymic && user.patronymic.toLowerCase().includes(query)) ||
        (user.fullName && user.fullName.toLowerCase().includes(query)) ||
        (user.username && user.username.toLowerCase().includes(query)) ||
        (user.email && user.email.toLowerCase().includes(query)) ||
        (user.phone && user.phone.toLowerCase().includes(query)) ||
        (user.auditorium_name && user.auditorium_name.toLowerCase().includes(query)) ||
        (user.role_name && user.role_name.toLowerCase().includes(query)) ||
        (user.bio && user.bio.toLowerCase().includes(query))
    )
  }

  // Сортировка
  filtered = [...filtered].sort((a, b) => {
    let aVal = a[sortKey.value]
    let bVal = b[sortKey.value]

    if (sortKey.value === 'birthdate') {
      aVal = new Date(aVal)
      bVal = new Date(bVal)
    } else if (sortKey.value === 'auditorium_name') {
      // Сортировка по аудитории
      aVal = a.auditorium_name || 'Я'
      bVal = b.auditorium_name || 'Я'
    } else if (sortKey.value === 'fullName') {
      // Сортировка по полному имени
      aVal = a.fullName.toLowerCase()
      bVal = b.fullName.toLowerCase()
    } else if (sortKey.value === 'role') {
      // Сортировка по роли (по названию роли)
      aVal = a.role_name.toLowerCase()
      bVal = b.role_name.toLowerCase()
    }

    if (aVal < bVal) return sortOrder.value === 'asc' ? -1 : 1
    if (aVal > bVal) return sortOrder.value === 'asc' ? 1 : -1
    return 0
  })

  return filtered
})

// Пагинация
const totalPages = computed(() => Math.ceil(filteredUsers.value.length / itemsPerPage.value))

const paginatedUsers = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return filteredUsers.value.slice(start, end)
})

const startIndex = computed(() => (currentPage.value - 1) * itemsPerPage.value + 1)
const endIndex = computed(() => Math.min(currentPage.value * itemsPerPage.value, filteredUsers.value.length))

const visiblePages = computed(() => {
  const pages = []
  const maxVisible = 5
  let start = Math.max(1, currentPage.value - Math.floor(maxVisible / 2))
  let end = Math.min(totalPages.value, start + maxVisible - 1)

  if (end - start + 1 < maxVisible) {
    start = Math.max(1, end - maxVisible + 1)
  }

  for (let i = start; i <= end; i++) {
    pages.push(i)
  }

  return pages
})

const showEllipsis = computed(() => totalPages.value > visiblePages.value.length)

// Методы
const getFloorText = (floorNumber) => {
  if (!floorNumber && floorNumber !== 0) return ''

  const lastDigit = floorNumber % 10
  const lastTwoDigits = floorNumber % 100

  if (lastTwoDigits >= 11 && lastTwoDigits <= 19) {
    return `${floorNumber} этаж`
  }

  switch (lastDigit) {
    case 1:
      return `${floorNumber} этаж`
    case 2:
    case 3:
    case 4:
      return `${floorNumber} этажа`
    default:
      return `${floorNumber} этаж`
  }
}

const sortTable = (key) => {
  if (sortKey.value === key) {
    sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc'
  } else {
    sortKey.value = key
    sortOrder.value = 'asc'
  }
}

const prevPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--
  }
}

const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++
  }
}

const goToPage = (page) => {
  currentPage.value = page
}

const formatDate = (dateString) => {
  if (!dateString) return 'Не указана'
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

// Управление пользователями
const confirmDelete = (user) => {
  userToDelete.value = user
  showDeleteModal.value = true
}

const deleteUser = async () => {
  if (!userToDelete.value) return

  try {
    isLoading.value = true
    await axios.delete(`${BACKEND_URL}/api/admin/users/${userToDelete.value.id}`)

    // Удаляем пользователя из списка
    users.value = users.value.filter(user => user.id !== userToDelete.value.id)

    showDeleteModal.value = false
    userToDelete.value = null

    // Показываем уведомление об успехе
    alert('Пользователь успешно удален')
  } catch (err) {
    console.error('Ошибка при удалении пользователя:', err)
    alert('Ошибка при удалении пользователя')
  } finally {
    isLoading.value = false
  }
}

// Сброс пагинации при изменении фильтров
watch([searchQuery], () => {
  currentPage.value = 1
})

watch([sortField], () => {
  sortKey.value = sortField.value
  sortOrder.value = 'asc'
})

watch(itemsPerPage, () => {
  currentPage.value = 1
})
</script>