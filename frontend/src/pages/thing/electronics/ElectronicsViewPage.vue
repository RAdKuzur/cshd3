<template>
  <div class="p-6 bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <div class="max-w-4xl mx-auto">
      <!-- Заголовок и навигация -->
      <div class="mb-8">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-4">
            <router-link
                to="/things"
                class="text-gray-600 hover:text-gray-900 flex items-center gap-2 px-3 py-2 hover:bg-gray-100 transition-colors"
            >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
              </svg>
              Назад
            </router-link>
            <div>
              <h1 class="text-3xl font-bold text-gray-900">Просмотр предмета</h1>
              <p class="text-gray-600 mt-2">Основное средство #{{ thing?.id }}</p>
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

      <!-- Основная информация -->
      <div class="bg-white shadow-lg border border-gray-200 p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-6 pb-2 border-b border-gray-200">
          Основная информация
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Название ОС</div>
            <div class="text-lg font-semibold text-gray-900">{{ thing?.name || 'Не указано' }}</div>
          </div>

          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Инвентарный номер</div>
            <div class="text-lg font-mono text-indigo-600 font-semibold">{{ thing?.inv_number || 'Не указан' }}</div>
          </div>

          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Серийный номер</div>
            <div class="text-lg font-mono text-gray-900">{{ thing?.serial_number || 'Не указан' }}</div>
          </div>

          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Дата ввода в эксплуатацию</div>
            <div class="text-lg text-gray-900">{{ formatDate(thing?.operation_date) || 'Не указана' }}</div>
            <div class="text-sm text-gray-500">{{ thing?.operation_date ? getYearsInUse(thing.operation_date) : '' }}</div>
          </div>
        </div>
      </div>

      <!-- Классификация и состояние -->
      <div class="bg-white shadow-lg border border-gray-200 p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-6 pb-2 border-b border-gray-200">
          Классификация и состояние
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Тип предмета</div>
            <div class="flex items-center gap-2">
              <div :class="getTypeColor(thing?.thing_type_id)" class="w-8 h-8 flex items-center justify-center text-white">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                </svg>
              </div>
              <div class="text-lg text-gray-900">{{ getTypeLabel(thing?.thing_type_id) || 'Не указан' }}</div>
            </div>
          </div>

          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Родительский предмет</div>
            <div class="text-lg text-gray-900">
              {{ thing?.thing_parent_id ? thing.thing_parent_id : 'Не указан' }}
            </div>
          </div>

          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Состояние</div>
            <div class="flex items-center gap-2">
              <div :class="getConditionColor(thing?.condition)" class="w-8 h-8 flex items-center justify-center text-white">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                </svg>
              </div>
              <div class="text-lg text-gray-900">{{ getConditionLabel(thing?.condition) || 'Не указано' }}</div>
            </div>
          </div>

          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Балансовая стоимость</div>
            <div class="text-2xl font-bold text-gray-900">{{ formatCurrency(thing?.price) || '0 ₽' }}</div>
          </div>
        </div>
      </div>

      <!-- Комментарий -->
      <div class="bg-white shadow-lg border border-gray-200 p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Дополнительная информация</h2>

        <div>
          <div class="text-sm font-medium text-gray-500 mb-2">Комментарий</div>
          <div v-if="thing?.comment" class="bg-gray-50 p-4 border border-gray-200">
            <div class="text-gray-700 whitespace-pre-line">{{ thing.comment }}</div>
          </div>
          <div v-else class="text-gray-500 italic">Нет комментария</div>
        </div>
      </div>

      <!-- Дополнительная информация -->
      <div class="bg-white shadow-lg border border-gray-200 p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Системная информация</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">ID предмета</div>
            <div class="text-lg font-mono text-gray-900">{{ thing?.id || 'Не указан' }}</div>
          </div>

          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Дата создания</div>
            <div class="text-lg text-gray-900">{{ formatDate(thing?.created_at) || 'Не указана' }}</div>
          </div>

          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Последнее обновление</div>
            <div class="text-lg text-gray-900">{{ formatDate(thing?.updated_at) || 'Не указана' }}</div>
          </div>
        </div>
      </div>

      <!-- Действия -->
      <div class="mt-8 flex items-center justify-between bg-white shadow-lg border border-gray-200 p-6">
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

const route = useRoute()
const router = useRouter()

// Данные предмета
const thing = ref(null)
const isLoading = ref(true)

// Загрузка данных при монтировании
onMounted(async () => {
  await loadThingData()
})

// Загрузка данных предмета
const loadThingData = async () => {
  try {
    isLoading.value = true
    const thingId = route.params.id

    // Здесь будет запрос к API
    // const response = await fetch(`/api/things/${thingId}`)
    // thing.value = await response.json()

    // Временные моковые данные
    thing.value = {
      id: thingId,
      name: 'Ноутбук Dell Latitude 5420',
      serial_number: 'CN-0R3XX1-64180-2B9-016K',
      inv_number: 'INV-2023-001',
      operation_date: '2023-01-15',
      thing_type_id: 'computer',
      thing_parent_id: '',
      condition: 'excellent',
      price: 125000,
      comment: 'Для руководителя отдела. Конфигурация: i7-1185G7, 16GB RAM, 512GB SSD',
      created_at: '2023-01-15T10:30:00Z',
      updated_at: '2023-12-01T14:20:00Z'
    }

  } catch (error) {
    console.error('Ошибка загрузки данных:', error)
    alert('Не удалось загрузить данные предмета')
  } finally {
    isLoading.value = false
  }
}

// Форматирование даты
const formatDate = (dateString) => {
  if (!dateString) return ''
  return new Date(dateString).toLocaleDateString('ru-RU')
}

// Форматирование валюты
const formatCurrency = (amount) => {
  if (!amount && amount !== 0) return ''
  return new Intl.NumberFormat('ru-RU', {
    style: 'currency',
    currency: 'RUB',
    minimumFractionDigits: 0
  }).format(amount)
}

// Сколько лет в использовании
const getYearsInUse = (dateString) => {
  if (!dateString) return ''
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

// Метки для состояния
const getConditionLabel = (condition) => {
  const labels = {
    'new': 'Новый',
    'excellent': 'Отличное',
    'good': 'Хорошее',
    'satisfactory': 'Удовлетворительное',
    'bad': 'Плохое',
    'broken': 'Сломан',
    'repair': 'В ремонте'
  }
  return labels[condition] || condition
}

// Цвета для состояния
const getConditionColor = (condition) => {
  const colors = {
    'new': 'bg-green-500',
    'excellent': 'bg-green-400',
    'good': 'bg-blue-400',
    'satisfactory': 'bg-yellow-400',
    'bad': 'bg-orange-400',
    'broken': 'bg-red-500',
    'repair': 'bg-purple-400'
  }
  return colors[condition] || 'bg-gray-400'
}

// Метки для типа
const getTypeLabel = (typeId) => {
  const labels = {
    'computer': 'Компьютерная техника',
    'furniture': 'Офисная мебель',
    'equipment': 'Оргтехника',
    'production': 'Производственное оборудование',
    'vehicle': 'Транспорт',
    'other': 'Другое'
  }
  return labels[typeId] || typeId
}

// Цвета для типа
const getTypeColor = (typeId) => {
  const colors = {
    'computer': 'bg-blue-500',
    'furniture': 'bg-emerald-500',
    'equipment': 'bg-purple-500',
    'production': 'bg-amber-500',
    'vehicle': 'bg-red-500',
    'other': 'bg-gray-500'
  }
  return colors[typeId] || 'bg-gray-400'
}

// Обработчики действий
const handleEdit = () => {
  router.push(`/thing/edit/${route.params.id}`)
}

const handlePrint = () => {
  window.print()
}

const handleDelete = async () => {
  if (!confirm('Вы уверены, что хотите удалить этот предмет? Это действие нельзя отменить.')) {
    return
  }

  try {
    // Здесь будет запрос на удаление
    // await fetch(`/api/things/${route.params.id}`, { method: 'DELETE' })

    alert('Предмет успешно удален')
    router.push('/things')
  } catch (error) {
    console.error('Ошибка удаления:', error)
    alert('Не удалось удалить предмет')
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