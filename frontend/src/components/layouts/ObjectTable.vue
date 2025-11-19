<template>
  <div class="p-6 bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
      <!-- Заголовок и элементы управления -->
      <div class="mb-8">
        <div class="flex justify-between items-center">
          <div>
            <h1 class="text-3xl font-bold text-gray-900">Учет основных средств</h1>
            <p class="text-gray-600 mt-2">Всего предметов: {{ filteredItems.length }}</p>
          </div>
          <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-semibold shadow-sm transition-colors">
            + Добавить предмет
          </button>
        </div>

        <!-- Панель поиска и фильтров -->
        <div class="mt-6 flex gap-4">
          <div class="flex-1">
            <div class="relative">
              <input
                  v-model="searchQuery"
                  type="text"
                  placeholder="Поиск по инвентарному номеру или типу..."
                  class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
              >
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </div>
            </div>
          </div>

          <select
              v-model="typeFilter"
              class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
          >
            <option value="">Все типы</option>
            <option value="Компьютерная техника">Компьютерная техника</option>
            <option value="Офисная мебель">Офисная мебель</option>
            <option value="Оргтехника">Оргтехника</option>
            <option value="Производственное оборудование">Производственное оборудование</option>
            <option value="Транспорт">Транспорт</option>
          </select>
        </div>
      </div>

      <!-- Таблица -->
      <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
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
                v-for="item in paginatedItems"
                :key="item.id"
                class="hover:bg-gradient-to-r hover:from-indigo-50 hover:to-white transition-all duration-200 group"
            >
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-10 w-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                    </svg>
                  </div>
                  <div class="ml-4">
                    <div class="text-sm font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors">
                      {{ item.inventoryNumber }}
                    </div>
                    <div class="text-sm text-gray-500">
                      ID: {{ item.id }}
                    </div>
                  </div>
                </div>
              </td>

              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                    <svg class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                    </svg>
                  </div>
                  <div>
                    <div class="text-sm font-medium text-gray-900">{{ item.type }}</div>
                    <div class="text-xs text-gray-500">{{ item.subType }}</div>
                  </div>
                </div>
              </td>

              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900 font-medium">{{ formatDate(item.commissioningDate) }}</div>
                <div class="text-xs text-gray-500">{{ getYearsInUse(item.commissioningDate) }} в использовании</div>
              </td>

              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-semibold text-gray-900">
                  {{ formatCurrency(item.bookValue) }}
                </div>
                <div class="text-xs text-gray-500">
                  Остаточная: {{ formatCurrency(item.residualValue) }}
                </div>
              </td>

              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center space-x-2">
                  <button class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                  </button>
                  <button class="p-2 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                  </button>
                  <button class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
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
        <div v-if="filteredItems.length === 0" class="text-center py-12">
          <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <h3 class="mt-2 text-sm font-medium text-gray-900">Предметы не найдены</h3>
          <p class="mt-1 text-sm text-gray-500">Попробуйте изменить параметры поиска</p>
        </div>

        <!-- Пагинация -->
        <div v-if="filteredItems.length > 0" class="px-6 py-4 border-t border-gray-200 bg-gray-50">
          <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700">
              Показано с {{ startIndex }} по {{ endIndex }} из {{ filteredItems.length }} записей
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
  </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue'

// Реактивные данные
const headers = ref([
  { key: 'inventoryNumber', label: 'Инвентарный номер' },
  { key: 'type', label: 'Тип предмета' },
  { key: 'commissioningDate', label: 'Дата введения в эксплуатацию' },
  { key: 'bookValue', label: 'Балансовая стоимость' },
  { key: 'actions', label: 'Действия' }
])

// Тестовые данные
const items = ref([
  {
    id: 1,
    inventoryNumber: 'INV-2023-001',
    type: 'Компьютерная техника',
    subType: 'Ноутбук',
    commissioningDate: '2023-01-15',
    bookValue: 125000,
    residualValue: 98000
  },
  {
    id: 2,
    inventoryNumber: 'INV-2022-045',
    type: 'Офисная мебель',
    subType: 'Рабочий стол',
    commissioningDate: '2022-03-20',
    bookValue: 45000,
    residualValue: 32000
  },
  {
    id: 3,
    inventoryNumber: 'INV-2023-078',
    type: 'Оргтехника',
    subType: 'МФУ',
    commissioningDate: '2023-02-10',
    bookValue: 89000,
    residualValue: 75000
  },
  {
    id: 4,
    inventoryNumber: 'INV-2021-123',
    type: 'Производственное оборудование',
    subType: 'Станок',
    commissioningDate: '2021-11-05',
    bookValue: 450000,
    residualValue: 280000
  },
  {
    id: 5,
    inventoryNumber: 'INV-2023-156',
    type: 'Компьютерная техника',
    subType: 'Монитор',
    commissioningDate: '2023-03-25',
    bookValue: 35000,
    residualValue: 32000
  },
  {
    id: 6,
    inventoryNumber: 'INV-2020-089',
    type: 'Транспорт',
    subType: 'Легковой автомобиль',
    commissioningDate: '2020-07-12',
    bookValue: 1200000,
    residualValue: 850000
  },
  {
    id: 7,
    inventoryNumber: 'INV-2023-201',
    type: 'Офисная мебель',
    subType: 'Офисное кресло',
    commissioningDate: '2023-04-18',
    bookValue: 25000,
    residualValue: 22000
  },
  {
    id: 8,
    inventoryNumber: 'INV-2022-167',
    type: 'Оргтехника',
    subType: 'Принтер',
    commissioningDate: '2022-09-30',
    bookValue: 42000,
    residualValue: 31000
  },
  {
    id: 9,
    inventoryNumber: 'INV-2023-045',
    type: 'Компьютерная техника',
    subType: 'Системный блок',
    commissioningDate: '2023-01-08',
    bookValue: 78000,
    residualValue: 65000
  },
  {
    id: 10,
    inventoryNumber: 'INV-2021-234',
    type: 'Производственное оборудование',
    subType: 'Компрессор',
    commissioningDate: '2021-05-22',
    bookValue: 320000,
    residualValue: 210000
  },
  {
    id: 11,
    inventoryNumber: 'INV-2023-189',
    type: 'Офисная мебель',
    subType: 'Шкаф',
    commissioningDate: '2023-06-14',
    bookValue: 68000,
    residualValue: 62000
  },
  {
    id: 12,
    inventoryNumber: 'INV-2022-278',
    type: 'Транспорт',
    subType: 'Грузовой автомобиль',
    commissioningDate: '2022-12-03',
    bookValue: 2500000,
    residualValue: 1900000
  }
])

const searchQuery = ref('')
const typeFilter = ref('')
const sortKey = ref('commissioningDate')
const sortOrder = ref('desc')

// Пагинация
const currentPage = ref(1)
const itemsPerPage = ref(10)

// Вычисляемые свойства
const filteredItems = computed(() => {
  let filtered = items.value

  // Фильтрация по поиску
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(item =>
        item.inventoryNumber.toLowerCase().includes(query) ||
        item.type.toLowerCase().includes(query) ||
        item.subType.toLowerCase().includes(query)
    )
  }

  // Фильтрация по типу
  if (typeFilter.value) {
    filtered = filtered.filter(item => item.type === typeFilter.value)
  }

  // Сортировка
  filtered = [...filtered].sort((a, b) => {
    let aVal = a[sortKey.value]
    let bVal = b[sortKey.value]

    if (sortKey.value === 'commissioningDate') {
      aVal = new Date(aVal)
      bVal = new Date(bVal)
    }

    if (aVal < bVal) return sortOrder.value === 'asc' ? -1 : 1
    if (aVal > bVal) return sortOrder.value === 'asc' ? 1 : -1
    return 0
  })

  return filtered
})

// Пагинация
const totalPages = computed(() => Math.ceil(filteredItems.value.length / itemsPerPage.value))

const paginatedItems = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return filteredItems.value.slice(start, end)
})

const startIndex = computed(() => (currentPage.value - 1) * itemsPerPage.value + 1)
const endIndex = computed(() => Math.min(currentPage.value * itemsPerPage.value, filteredItems.value.length))

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
  return new Date(dateString).toLocaleDateString('ru-RU')
}

const formatCurrency = (amount) => {
  return new Intl.NumberFormat('ru-RU', {
    style: 'currency',
    currency: 'RUB',
    minimumFractionDigits: 0
  }).format(amount)
}

const getYearsInUse = (dateString) => {
  const now = new Date()
  const date = new Date(dateString)
  const years = now.getFullYear() - date.getFullYear()
  return years === 0 ? '<1 года' : `${years} ${getYearsText(years)}`
}

const getYearsText = (years) => {
  if (years % 10 === 1 && years % 100 !== 11) return 'год'
  if ([2, 3, 4].includes(years % 10) && ![12, 13, 14].includes(years % 100)) return 'года'
  return 'лет'
}

// Сброс пагинации при изменении фильтров
watch([searchQuery, typeFilter], () => {
  currentPage.value = 1
})

watch(itemsPerPage, () => {
  currentPage.value = 1
})
</script>