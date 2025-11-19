<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-6">
    <div class="max-w-7xl mx-auto">

      <!-- Заголовок -->
      <div class="mb-8">
        <div class="flex justify-between items-center">
          <div>
            <h1 class="text-3xl font-bold text-gray-900">Документооборот</h1>
            <p class="text-gray-600 mt-2">Управление входящими и исходящими документами</p>
          </div>
          <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-semibold shadow-sm transition-colors">
            + Создать документ
          </button>
        </div>
      </div>

      <!-- Табы входящий/исходящий -->
      <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden mb-8">
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6">
          <div class="flex space-x-8">
            <button
                class="px-6 py-4 text-white font-semibold border-b-2 transition-all duration-200 tab-button relative"
                :class="{
                'border-white text-white': activeTab === 'incoming',
                'border-transparent text-indigo-100 hover:text-white': activeTab !== 'incoming'
              }"
                @click="setActiveTab('incoming')"
            >
              <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20" />
                </svg>
                Входящие документы
                <span class="ml-2 bg-white text-indigo-600 px-2 py-1 rounded-full text-xs font-bold">
                  {{ incomingDocuments.length }}
                </span>
              </div>
              <div
                  v-if="activeTab === 'incoming'"
                  class="absolute bottom-0 left-0 right-0 h-0.5 bg-white transform transition-transform duration-200"
              ></div>
            </button>
            <button
                class="px-6 py-4 text-white font-semibold border-b-2 transition-all duration-200 tab-button relative"
                :class="{
                'border-white text-white': activeTab === 'outgoing',
                'border-transparent text-indigo-100 hover:text-white': activeTab !== 'outgoing'
              }"
                @click="setActiveTab('outgoing')"
            >
              <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Исходящие документы
                <span class="ml-2 bg-white text-indigo-600 px-2 py-1 rounded-full text-xs font-bold">
                  {{ outgoingDocuments.length }}
                </span>
              </div>
              <div
                  v-if="activeTab === 'outgoing'"
                  class="absolute bottom-0 left-0 right-0 h-0.5 bg-white transform transition-transform duration-200"
              ></div>
            </button>
          </div>
        </div>

        <!-- Панель управления -->
        <div class="p-6 border-b border-gray-200 bg-gray-50">
          <div class="flex flex-col lg:flex-row gap-4 justify-between">
            <div class="flex flex-col sm:flex-row gap-4">
              <!-- Поиск -->
              <div class="relative">
                <input
                    v-model="searchQuery"
                    type="text"
                    placeholder="Поиск документов..."
                    class="w-full lg:w-80 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                >
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                  <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                  </svg>
                </div>
              </div>

              <!-- Фильтр по статусу -->
              <select
                  v-model="statusFilter"
                  class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
              >
                <option value="">Все статусы</option>
                <option value="new">Новый</option>
                <option value="in-progress">В работе</option>
                <option value="completed">Завершен</option>
                <option value="rejected">Отклонен</option>
              </select>
            </div>

            <!-- Период -->
            <div class="flex items-center space-x-4">
              <select
                  v-model="periodFilter"
                  class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
              >
                <option value="today">Сегодня</option>
                <option value="week">За неделю</option>
                <option value="month">За месяц</option>
                <option value="quarter">За квартал</option>
                <option value="all">Все время</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Таблица -->
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead class="bg-gray-100">
            <tr>
              <th
                  v-for="header in getHeaders()"
                  :key="header.key"
                  class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider cursor-pointer"
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
                v-for="document in paginatedDocuments"
                :key="document.id"
                class="hover:bg-gradient-to-r hover:from-indigo-50 hover:to-white transition-all duration-200 group"
            >
              <!-- Номер документа -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-10 w-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                  </div>
                  <div class="ml-4">
                    <div class="text-sm font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors">
                      {{ document.number }}
                    </div>
                    <div class="text-sm text-gray-500">
                      {{ document.type }}
                    </div>
                  </div>
                </div>
              </td>

              <!-- Дата -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900 font-medium">{{ formatDate(document.date) }}</div>
                <div class="text-xs text-gray-500">{{ formatTime(document.date) }}</div>
              </td>

              <!-- Контрагент/Получатель -->
              <td class="px-6 py-4">
                <div class="text-sm text-gray-900 font-medium">
                  {{ activeTab === 'incoming' ? document.sender : document.recipient }}
                </div>
                <div class="text-xs text-gray-500">
                  {{ activeTab === 'incoming' ? document.senderDepartment : document.recipientDepartment }}
                </div>
              </td>

              <!-- Тема -->
              <td class="px-6 py-4">
                <div class="text-sm text-gray-900 font-medium">{{ document.subject }}</div>
                <div class="text-xs text-gray-500 truncate max-w-xs">{{ document.description }}</div>
              </td>

              <!-- Статус -->
              <td class="px-6 py-4 whitespace-nowrap">
                  <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold shadow-sm"
                        :class="getStatusClass(document.status)">
                    <span class="w-2 h-2 rounded-full mr-2" :class="getStatusDotClass(document.status)"></span>
                    {{ getStatusText(document.status) }}
                  </span>
              </td>

              <!-- Срок исполнения -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900" :class="getDueDateClass(document.dueDate)">
                  {{ formatDate(document.dueDate) }}
                </div>
                <div class="text-xs text-gray-500">{{ getDueDateStatus(document.dueDate) }}</div>
              </td>

              <!-- Действия -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center space-x-2">
                  <button
                      class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors"
                      title="Просмотреть"
                  >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                  </button>
                  <button
                      class="p-2 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors"
                      title="Скачать"
                  >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                  </button>
                  <button
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
        <div v-if="filteredDocuments.length === 0" class="text-center py-12">
          <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
          <h3 class="mt-2 text-sm font-medium text-gray-900">Документы не найдены</h3>
          <p class="mt-1 text-sm text-gray-500">Попробуйте изменить параметры поиска или фильтры</p>
        </div>

        <!-- Пагинация -->
        <div v-if="filteredDocuments.length > 0" class="px-6 py-4 border-t border-gray-200 bg-gray-50">
          <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700">
              Показано с {{ startIndex }} по {{ endIndex }} из {{ filteredDocuments.length }} записей
            </div>
            <div class="flex items-center space-x-4">
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
            </select>
          </div>
        </div>
      </div>

      <!-- Статистика -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0 h-12 w-12 bg-blue-100 rounded-lg flex items-center justify-center">
              <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Всего документов</p>
              <p class="text-2xl font-bold text-gray-900">{{ totalDocuments }}</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0 h-12 w-12 bg-green-100 rounded-lg flex items-center justify-center">
              <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Завершено</p>
              <p class="text-2xl font-bold text-gray-900">{{ completedDocuments }}</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0 h-12 w-12 bg-yellow-100 rounded-lg flex items-center justify-center">
              <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">В работе</p>
              <p class="text-2xl font-bold text-gray-900">{{ inProgressDocuments }}</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0 h-12 w-12 bg-red-100 rounded-lg flex items-center justify-center">
              <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Просрочено</p>
              <p class="text-2xl font-bold text-gray-900">{{ overdueDocuments }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue'

const activeTab = ref('incoming')
const searchQuery = ref('')
const statusFilter = ref('')
const periodFilter = ref('month')
const sortKey = ref('date')
const sortOrder = ref('desc')

// Пагинация
const currentPage = ref(1)
const itemsPerPage = ref(10)

// Тестовые данные - Входящие документы
const incomingDocuments = ref([
  {
    id: 1,
    number: 'ВХ-2024-001',
    type: 'Письмо',
    date: '2024-01-15T10:30:00Z',
    sender: 'ООО "Контрагент"',
    senderDepartment: 'Отдел снабжения',
    subject: 'Поставка оборудования',
    description: 'Коммерческое предложение по поставке компьютерного оборудования',
    status: 'new',
    dueDate: '2024-01-25T18:00:00Z'
  },
  {
    id: 2,
    number: 'ВХ-2024-002',
    type: 'Договор',
    date: '2024-01-14T14:20:00Z',
    sender: 'ЗАО "Партнер+"',
    senderDepartment: 'Юридический отдел',
    subject: 'Договор оказания услуг',
    description: 'Проект договора на оказание консультационных услуг',
    status: 'in-progress',
    dueDate: '2024-01-20T18:00:00Z'
  },
  {
    id: 3,
    number: 'ВХ-2024-003',
    type: 'Счет',
    date: '2024-01-13T09:15:00Z',
    sender: 'ИП Сидоров А.В.',
    senderDepartment: 'Бухгалтерия',
    subject: 'Оплата услуг',
    description: 'Счет на оплату услуг за декабрь 2023 года',
    status: 'completed',
    dueDate: '2024-01-18T18:00:00Z'
  },
  {
    id: 4,
    number: 'ВХ-2024-004',
    type: 'Акт',
    date: '2024-01-12T16:45:00Z',
    sender: 'ООО "СтройТех"',
    senderDepartment: 'Отдел реализации',
    subject: 'Акт выполненных работ',
    description: 'Акт сдачи-приемки выполненных работ по ремонту офиса',
    status: 'completed',
    dueDate: '2024-01-15T18:00:00Z'
  },
  {
    id: 5,
    number: 'ВХ-2024-005',
    type: 'Рекламация',
    date: '2024-01-11T11:20:00Z',
    sender: 'ООО "КлиентСервис"',
    senderDepartment: 'Отдел контроля качества',
    subject: 'Рекламация по качеству',
    description: 'Претензия по качеству предоставленных услуг',
    status: 'rejected',
    dueDate: '2024-01-16T18:00:00Z'
  }
])

// Тестовые данные - Исходящие документы
const outgoingDocuments = ref([
  {
    id: 6,
    number: 'ИСХ-2024-001',
    type: 'Письмо',
    date: '2024-01-15T09:00:00Z',
    recipient: 'ООО "Поставщик"',
    recipientDepartment: 'Отдел закупок',
    subject: 'Запрос коммерческого предложения',
    description: 'Запрос КП на поставку оргтехники',
    status: 'completed',
    dueDate: '2024-01-22T18:00:00Z'
  },
  {
    id: 7,
    number: 'ИСХ-2024-002',
    type: 'Договор',
    date: '2024-01-14T15:30:00Z',
    recipient: 'ИП Петров И.С.',
    recipientDepartment: 'Дирекция',
    subject: 'Договор подряда',
    description: 'Проект договора на выполнение строительных работ',
    status: 'in-progress',
    dueDate: '2024-01-21T18:00:00Z'
  },
  {
    id: 8,
    number: 'ИСХ-2024-003',
    type: 'Счет',
    date: '2024-01-13T11:45:00Z',
    recipient: 'ООО "Заказчик"',
    recipientDepartment: 'Бухгалтерия',
    subject: 'Счет на оплату',
    description: 'Счет за оказанные услуги по технической поддержке',
    status: 'new',
    dueDate: '2024-01-23T18:00:00Z'
  },
  {
    id: 9,
    number: 'ИСХ-2024-004',
    type: 'Отчет',
    date: '2024-01-12T14:20:00Z',
    recipient: 'Министерство финансов',
    recipientDepartment: 'Отдел отчетности',
    subject: 'Квартальный отчет',
    description: 'Финансовый отчет за 4 квартал 2023 года',
    status: 'completed',
    dueDate: '2024-01-15T18:00:00Z'
  },
  {
    id: 10,
    number: 'ИСХ-2024-005',
    type: 'Запрос',
    date: '2024-01-11T10:15:00Z',
    recipient: 'ООО "Консультант"',
    recipientDepartment: 'Отдел аналитики',
    subject: 'Запрос информации',
    description: 'Запрос аналитической информации по рынку',
    status: 'in-progress',
    dueDate: '2024-01-19T18:00:00Z'
  }
])

// Заголовки таблицы
const getHeaders = () => {
  const baseHeaders = [
    { key: 'number', label: 'Номер документа' },
    { key: 'date', label: 'Дата' },
    { key: 'subject', label: 'Тема' },
    { key: 'status', label: 'Статус' },
    { key: 'dueDate', label: 'Срок исполнения' },
    { key: 'actions', label: 'Действия' }
  ]

  if (activeTab.value === 'incoming') {
    baseHeaders.splice(2, 0, { key: 'sender', label: 'Отправитель' })
  } else {
    baseHeaders.splice(2, 0, { key: 'recipient', label: 'Получатель' })
  }

  return baseHeaders
}

// Вычисляемые свойства
const currentDocuments = computed(() => {
  return activeTab.value === 'incoming' ? incomingDocuments.value : outgoingDocuments.value
})

const filteredDocuments = computed(() => {
  let filtered = currentDocuments.value

  // Фильтрация по поиску
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(doc =>
        doc.number.toLowerCase().includes(query) ||
        doc.subject.toLowerCase().includes(query) ||
        doc.description.toLowerCase().includes(query) ||
        (activeTab.value === 'incoming' ? doc.sender.toLowerCase().includes(query) : doc.recipient.toLowerCase().includes(query))
    )
  }

  // Фильтрация по статусу
  if (statusFilter.value) {
    filtered = filtered.filter(doc => doc.status === statusFilter.value)
  }

  // Сортировка
  filtered = [...filtered].sort((a, b) => {
    let aVal = a[sortKey.value]
    let bVal = b[sortKey.value]

    if (['date', 'dueDate'].includes(sortKey.value)) {
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
const totalPages = computed(() => Math.ceil(filteredDocuments.value.length / itemsPerPage.value))

const paginatedDocuments = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return filteredDocuments.value.slice(start, end)
})

const startIndex = computed(() => (currentPage.value - 1) * itemsPerPage.value + 1)
const endIndex = computed(() => Math.min(currentPage.value * itemsPerPage.value, filteredDocuments.value.length))

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

// Статистика
const totalDocuments = computed(() => currentDocuments.value.length)
const completedDocuments = computed(() => currentDocuments.value.filter(doc => doc.status === 'completed').length)
const inProgressDocuments = computed(() => currentDocuments.value.filter(doc => doc.status === 'in-progress').length)
const overdueDocuments = computed(() => currentDocuments.value.filter(doc => new Date(doc.dueDate) < new Date() && doc.status !== 'completed').length)

// Методы
const setActiveTab = (tab) => {
  activeTab.value = tab
  currentPage.value = 1
  searchQuery.value = ''
  statusFilter.value = ''
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

const getStatusClass = (status) => {
  const classes = {
    new: 'bg-blue-100 text-blue-800 border border-blue-200',
    'in-progress': 'bg-yellow-100 text-yellow-800 border border-yellow-200',
    completed: 'bg-green-100 text-green-800 border border-green-200',
    rejected: 'bg-red-100 text-red-800 border border-red-200'
  }
  return classes[status] || 'bg-gray-100 text-gray-800 border border-gray-200'
}

const getStatusDotClass = (status) => {
  const classes = {
    new: 'bg-blue-500',
    'in-progress': 'bg-yellow-500',
    completed: 'bg-green-500',
    rejected: 'bg-red-500'
  }
  return classes[status] || 'bg-gray-500'
}

const getStatusText = (status) => {
  const texts = {
    new: 'Новый',
    'in-progress': 'В работе',
    completed: 'Завершен',
    rejected: 'Отклонен'
  }
  return texts[status] || status
}

const getDueDateClass = (dueDate) => {
  const today = new Date()
  const due = new Date(dueDate)
  if (due < today) {
    return 'text-red-600 font-semibold'
  } else if ((due - today) / (1000 * 60 * 60 * 24) <= 2) {
    return 'text-yellow-600 font-semibold'
  }
  return ''
}

const getDueDateStatus = (dueDate) => {
  const today = new Date()
  const due = new Date(dueDate)
  const diffDays = Math.ceil((due - today) / (1000 * 60 * 60 * 24))

  if (diffDays < 0) return `Просрочено на ${Math.abs(diffDays)} дн.`
  if (diffDays === 0) return 'Сегодня'
  if (diffDays === 1) return 'Завтра'
  return `Осталось ${diffDays} дн.`
}

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('ru-RU')
}

const formatTime = (dateString) => {
  return new Date(dateString).toLocaleTimeString('ru-RU', {
    hour: '2-digit',
    minute: '2-digit'
  })
}

// Сброс пагинации при изменении фильтров
watch([searchQuery, statusFilter, activeTab], () => {
  currentPage.value = 1
})

watch(itemsPerPage, () => {
  currentPage.value = 1
})
</script>

<style scoped>
.tab-button {
  transition: all 0.3s ease;
}

.tab-button:hover {
  transform: translateY(-1px);
}
</style>