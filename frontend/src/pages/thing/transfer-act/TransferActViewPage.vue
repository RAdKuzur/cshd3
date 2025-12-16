<template>
  <div class="p-6 bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <div class="max-w-4xl mx-auto">

      <!-- Хлебные крошки -->
      <div class="mb-6">
        <nav class="flex" aria-label="Breadcrumb">
          <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li>
              <router-link
                  to="/things/transfer-acts"
                  class="text-gray-500 hover:text-gray-700"
              >
                Акты передачи
              </router-link>
            </li>
            <li class="flex items-center">
              <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
              </svg>
              <span class="ml-1 text-gray-700 font-medium">Акт №{{ act.id }}</span>
            </li>
          </ol>
        </nav>
      </div>

      <!-- Заголовок -->
      <div class="mb-8">
        <div class="flex justify-between items-start">
          <div>
            <h1 class="text-3xl font-bold text-gray-900">
              Акт передачи материальных ценностей №{{ act.id }}
            </h1>
            <p class="text-gray-600 mt-2">
              {{ act.typeLabel }}
            </p>
          </div>

          <!-- Статус -->
          <div class="flex items-center gap-4">
            <span
                :class="act.confirmed
                ? 'bg-green-100 text-green-700'
                : 'bg-yellow-100 text-yellow-700'"
                class="px-4 py-2 rounded-full text-sm font-medium"
            >
              {{ act.confirmed ? 'Подтверждён' : 'Не подтверждён' }}
            </span>

            <button
                @click="goBack"
                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50"
            >
              Назад
            </button>
          </div>
        </div>
      </div>

      <!-- Загрузка -->
      <div v-if="isLoading" class="text-center py-12">
        <svg class="animate-spin mx-auto h-8 w-8 text-indigo-600"
             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10"
                  stroke="currentColor" stroke-width="4" />
          <path class="opacity-75" fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
        </svg>
        <p class="mt-2 text-gray-600">Загрузка данных...</p>
      </div>

      <!-- Основная информация -->
      <div v-else class="bg-white rounded-2xl shadow-lg border overflow-hidden">
        <div class="p-8">
          <!-- Карточка с информацией -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Сторона "От кого" -->
            <div class="space-y-4">
              <div>
                <h3 class="text-sm font-medium text-gray-500 mb-1">От кого</h3>
                <p class="text-lg">
                  {{ act.fromName || 'Не указано' }}
                  <span v-if="!act.from" class="text-gray-400 text-sm ml-2">(ID не указан)</span>
                </p>
              </div>

              <!-- Если есть ID, можно добавить кнопку просмотра сотрудника -->
              <div v-if="act.from">
                <router-link
                    :to="`/people/view/${act.from}`"
                    class="inline-flex items-center text-indigo-600 hover:text-indigo-800"
                >
                  <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                  </svg>
                  Просмотреть сотрудника
                </router-link>
              </div>
            </div>

            <!-- Сторона "Кому" -->
            <div class="space-y-4">
              <div>
                <h3 class="text-sm font-medium text-gray-500 mb-1">Кому</h3>
                <p class="text-lg">
                  {{ act.toName || 'Не указано' }}
                  <span v-if="!act.to" class="text-gray-400 text-sm ml-2">(ID не указан)</span>
                </p>
              </div>

              <div v-if="act.to">
                <router-link
                    :to="`/people/view/${act.to}`"
                    class="inline-flex items-center text-indigo-600 hover:text-indigo-800"
                >
                  <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                  </svg>
                  Просмотреть сотрудника
                </router-link>
              </div>
            </div>
          </div>

          <!-- Разделитель -->
          <hr class="my-8">

          <!-- Дополнительная информация -->
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Тип акта -->
            <div>
              <h3 class="text-sm font-medium text-gray-500 mb-1">Тип акта</h3>
              <p class="text-lg font-medium">{{ act.typeLabel }}</p>
              <p class="text-sm text-gray-500 mt-1">Код: {{ act.type }}</p>
            </div>

            <!-- Дата создания -->
            <div>
              <h3 class="text-sm font-medium text-gray-500 mb-1">Дата создания</h3>
              <p class="text-lg">{{ formatDateTime(act.time) }}</p>
            </div>

            <!-- ID акта -->
            <div>
              <h3 class="text-sm font-medium text-gray-500 mb-1">Идентификатор</h3>
              <p class="text-lg font-mono">#{{ act.id }}</p>
            </div>
          </div>

          <!-- Место для дополнительных деталей -->
          <div v-if="additionalData" class="mt-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Дополнительные данные</h3>
            <pre class="bg-gray-50 p-4 rounded-lg text-sm">{{ JSON.stringify(additionalData, null, 2) }}</pre>
          </div>
        </div>

        <!-- Нижняя панель с действиями -->
        <div class="px-8 py-4 bg-gray-50 border-t flex justify-between items-center">
          <div class="text-sm text-gray-500">
            ID: {{ act.id }}
          </div>

          <div class="flex gap-3">
            <!-- Кнопка печати -->
            <button
                @click="printAct"
                class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 flex items-center"
            >
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
              </svg>
              Печать
            </button>

            <!-- Кнопка подтверждения/отмены -->
            <button
                v-if="!act.confirmed"
                @click="confirmAct"
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 flex items-center"
            >
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
              </svg>
              Подтвердить акт
            </button>

            <button
                v-else
                @click="unconfirmAct"
                class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 flex items-center"
            >
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
              Отменить подтверждение
            </button>
          </div>
        </div>
      </div>

      <!-- Сообщение об ошибке -->
      <div v-if="error" class="mt-4 p-4 bg-red-50 border border-red-200 rounded-lg">
        <div class="flex items-center">
          <svg class="w-5 h-5 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          <span class="text-red-700">{{ error }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'
import { BACKEND_URL } from '@/router.js'

const route = useRoute()
const router = useRouter()

const isLoading = ref(false)
const error = ref('')
const act = ref({
  id: '',
  from: null,
  to: null,
  fromName: '',
  toName: '',
  type: '',
  typeLabel: '',
  confirmed: false,
  time: ''
})
const people = ref({})
const actTypes = ref({})
const additionalData = ref(null)

// Загрузка данных акта
const loadActData = async () => {
  const actId = route.params.id
  if (!actId) {
    error.value = 'ID акта не указан'
    return
  }

  isLoading.value = true
  error.value = ''

  try {
    // Загружаем данные параллельно
    const [actRes, peopleRes, typesRes] = await Promise.all([
      axios.get(BACKEND_URL + `/api/things/transfer-acts/view/${actId}`),
      axios.get(BACKEND_URL + '/api/people/index'),
      axios.get(BACKEND_URL + '/api/info/transfer-acts/types')
    ])

    // Обработка ответов
    if (!actRes.data.success) {
      throw new Error('Акт не найден')
    }

    // Сохраняем данные сотрудников
    if (peopleRes.data.success) {
      people.value = Object.fromEntries(
          peopleRes.data.data.map(p => [
            p.id,
            `${p.surname} ${p.firstname}`
          ])
      )
    }

    // Сохраняем типы актов
    if (typesRes.data.success) {
      actTypes.value = typesRes.data.data
    }

    // Формируем данные акта
    const actData = actRes.data.data
    act.value = {
      id: actData.id,
      from: actData.from,
      to: actData.to,
      fromName: actData.from ? people.value[actData.from] || 'Неизвестно' : 'Не указано',
      toName: actData.to ? people.value[actData.to] || 'Неизвестно' : 'Не указано',
      type: actData.type,
      typeLabel: actTypes.value[actData.type] || `Тип ${actData.type}`,
      confirmed: Boolean(actData.confirmed),
      time: actData.time
    }

  } catch (err) {
    error.value = err.response?.data?.message || err.message || 'Ошибка загрузки данных'
    console.error('Ошибка загрузки акта:', err)
  } finally {
    isLoading.value = false
  }
}

// Подтверждение акта
const confirmAct = async () => {
  if (!confirm('Вы уверены, что хотите подтвердить этот акт?')) return

  try {
    const response = await axios.post(
        BACKEND_URL + `/api/things/transfer-acts/confirm/${act.value.id}`,
        { confirmed: 1 }
    )

    if (response.data.success) {
      act.value.confirmed = true
      alert('Акт успешно подтверждён')
    }
  } catch (err) {
    error.value = err.response?.data?.message || 'Ошибка подтверждения акта'
  }
}

// Отмена подтверждения
const unconfirmAct = async () => {
  if (!confirm('Вы уверены, что хотите отменить подтверждение акта?')) return

  try {
    const response = await axios.post(
        BACKEND_URL + `/api/things/transfer-acts/confirm/${act.value.id}`,
        { confirmed: 0 }
    )

    if (response.data.success) {
      act.value.confirmed = false
      alert('Подтверждение акта отменено')
    }
  } catch (err) {
    error.value = err.response?.data?.message || 'Ошибка отмены подтверждения'
  }
}

// Печать акта
const printAct = () => {
  window.print()
}

// Назад к списку
const goBack = () => {
  router.push('/things/transfer-acts')
}

// Форматирование даты
const formatDateTime = (dateString) => {
  if (!dateString) return '—'
  const date = new Date(dateString)
  return date.toLocaleString('ru-RU', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

// Загружаем данные при монтировании компонента
onMounted(() => {
  loadActData()
})

// Наблюдаем за изменением ID в маршруте
import { watch } from 'vue'
watch(() => route.params.id, () => {
  loadActData()
})
</script>

<style scoped>
/* Стили для печати */
@media print {
  .bg-gradient-to-br,
  .shadow-lg,
  button {
    display: none !important;
  }

  body {
    background: white !important;
  }

  .bg-white {
    box-shadow: none !important;
    border: 1px solid #000 !important;
  }
}
</style>