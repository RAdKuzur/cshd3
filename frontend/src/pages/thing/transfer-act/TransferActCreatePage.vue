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
              <span class="ml-1 text-gray-700 font-medium">
                {{ isEditMode ? `Редактирование акта №${actId}` : 'Создание акта' }}
              </span>
            </li>
          </ol>
        </nav>
      </div>

      <!-- Заголовок -->
      <div class="mb-8">
        <div class="flex justify-between items-start">
          <div>
            <h1 class="text-3xl font-bold text-gray-900">
              {{ isEditMode ? 'Редактирование акта передачи' : 'Создание акта передачи' }}
            </h1>
            <p class="text-gray-600 mt-2">
              {{ isEditMode ? `Акт №${actId}` : 'Новый документ' }}
            </p>
          </div>

          <button
              @click="goBack"
              class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50"
          >
            Назад
          </button>
        </div>
      </div>

      <!-- Форма -->
      <div class="bg-white rounded-2xl shadow-lg border overflow-hidden">
        <form @submit.prevent="submitForm">
          <div class="p-8 space-y-6">

            <!-- Основные поля -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- От кого -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  От кого *
                </label>
                <select
                    v-model="formData.from"
                    required
                    class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500"
                >
                  <option value="">Выберите сотрудника</option>
                  <option
                      v-for="person in peopleList"
                      :key="person.id"
                      :value="person.id"
                  >
                    {{ person.surname }} {{ person.firstname }}
                  </option>
                </select>
                <p v-if="formErrors.from" class="mt-1 text-sm text-red-600">
                  {{ formErrors.from }}
                </p>
              </div>

              <!-- Кому -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Кому *
                </label>
                <select
                    v-model="formData.to"
                    required
                    class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500"
                >
                  <option value="">Выберите сотрудника</option>
                  <option
                      v-for="person in peopleList"
                      :key="person.id"
                      :value="person.id"
                  >
                    {{ person.surname }} {{ person.firstname }}
                  </option>
                </select>
                <p v-if="formErrors.to" class="mt-1 text-sm text-red-600">
                  {{ formErrors.to }}
                </p>
              </div>
            </div>

            <!-- Тип акта -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Тип акта *
              </label>
              <select
                  v-model="formData.type"
                  required
                  class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500"
              >
                <option value="">Выберите тип акта</option>
                <option
                    v-for="(label, id) in actTypes"
                    :key="id"
                    :value="id"
                >
                  {{ label }}
                </option>
              </select>
              <p v-if="formErrors.type" class="mt-1 text-sm text-red-600">
                {{ formErrors.type }}
              </p>
            </div>

            <!-- Статус подтверждения -->
            <div v-if="isEditMode">
              <label class="flex items-center space-x-3">
                <input
                    v-model="formData.confirmed"
                    type="checkbox"
                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                >
                <span class="text-sm font-medium text-gray-700">
                  Акт подтверждён
                </span>
              </label>
            </div>

            <!-- Дата (только для просмотра при редактировании) -->
            <div v-if="isEditMode && formData.time">
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Дата создания
              </label>
              <p class="text-gray-900">
                {{ formatDateTime(formData.time) }}
              </p>
            </div>

            <!-- Описание/комментарий -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Комментарий
              </label>
              <textarea
                  v-model="formData.comment"
                  rows="3"
                  class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500"
                  placeholder="Дополнительная информация..."
              ></textarea>
            </div>
          </div>

          <!-- Кнопки действий -->
          <div class="px-8 py-4 bg-gray-50 border-t flex justify-between items-center">
            <div class="text-sm text-gray-500">
              * — обязательные поля
            </div>

            <div class="flex gap-3">
              <button
                  type="button"
                  @click="goBack"
                  class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50"
              >
                Отмена
              </button>

              <button
                  type="submit"
                  :disabled="isSubmitting"
                  class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed flex items-center"
              >
                <svg
                    v-if="isSubmitting"
                    class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                >
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                </svg>
                {{ isEditMode ? 'Сохранить изменения' : 'Создать акт' }}
              </button>
            </div>
          </div>
        </form>
      </div>

      <!-- Сообщения об ошибках/успехе -->
      <div v-if="successMessage" class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg">
        <div class="flex items-center">
          <svg class="w-5 h-5 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
          </svg>
          <span class="text-green-700">{{ successMessage }}</span>
        </div>
      </div>

      <div v-if="errorMessage" class="mt-4 p-4 bg-red-50 border border-red-200 rounded-lg">
        <div class="flex items-center">
          <svg class="w-5 h-5 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          <span class="text-red-700">{{ errorMessage }}</span>
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

const isEditMode = computed(() => route.name === 'TransferActEdit')
const actId = route.params.id

// Данные формы
const formData = ref({
  from: '',
  to: '',
  type: '',
  confirmed: false,
  comment: '',
  time: ''
})

const formErrors = ref({})
const successMessage = ref('')
const errorMessage = ref('')
const isSubmitting = ref(false)

// Справочные данные
const peopleList = ref([])
const actTypes = ref({})

// Загрузка справочных данных
const loadReferenceData = async () => {
  try {
    const [peopleRes, typesRes] = await Promise.all([
      axios.get(BACKEND_URL + '/api/people/index'),
      axios.get(BACKEND_URL + '/api/info/transfer-acts/types')
    ])

    if (peopleRes.data.success) {
      peopleList.value = peopleRes.data.data
    }

    if (typesRes.data.success) {
      actTypes.value = typesRes.data.data
    }
  } catch (error) {
    console.error('Ошибка загрузки справочных данных:', error)
    errorMessage.value = 'Ошибка загрузки справочных данных'
  }
}

// Загрузка данных акта для редактирования
const loadActData = async () => {
  if (!isEditMode.value) return

  try {
    const response = await axios.get(BACKEND_URL + `/api/things/transfer-acts/view/${actId}`)

    if (response.data.success) {
      const actData = response.data.data
      formData.value = {
        from: actData.from || '',
        to: actData.to || '',
        type: actData.type || '',
        confirmed: Boolean(actData.confirmed),
        comment: actData.comment || '',
        time: actData.time
      }
    }
  } catch (error) {
    console.error('Ошибка загрузки данных акта:', error)
    errorMessage.value = 'Ошибка загрузки данных акта'
  }
}

// Отправка формы
const submitForm = async () => {
  isSubmitting.value = true
  formErrors.value = {}
  successMessage.value = ''
  errorMessage.value = ''

  try {
    // Валидация
    if (!formData.value.from) {
      formErrors.value.from = 'Выберите отправителя'
    }
    if (!formData.value.to) {
      formErrors.value.to = 'Выберите получателя'
    }
    if (!formData.value.type) {
      formErrors.value.type = 'Выберите тип акта'
    }
    if (formData.value.from === formData.value.to) {
      errorMessage.value = 'Отправитель и получатель не могут быть одним и тем же лицом'
      isSubmitting.value = false
      return
    }

    if (Object.keys(formErrors.value).length > 0) {
      isSubmitting.value = false
      return
    }

    // Подготовка данных для отправки
    const payload = {
      from: formData.value.from,
      to: formData.value.to,
      type: formData.value.type,
      confirmed: formData.value.confirmed ? 1 : 0,
      comment: formData.value.comment || ''
    }

    let response
    if (isEditMode.value) {
      // Редактирование существующего акта
      response = await axios.put(
          BACKEND_URL + `/api/things/transfer-acts/update/${actId}`,
          payload
      )
    } else {
      // Создание нового акта
      response = await axios.post(
          BACKEND_URL + '/api/things/transfer-acts/create',
          payload
      )
    }

    if (response.data.success) {
      successMessage.value = isEditMode.value
          ? 'Акт успешно обновлён'
          : 'Акт успешно создан'

      // Перенаправление через 1.5 секунды
      setTimeout(() => {
        router.push('/things/transfer-acts')
      }, 1500)
    } else {
      errorMessage.value = response.data.message || 'Ошибка при сохранении'
    }
  } catch (error) {
    console.error('Ошибка сохранения:', error)
    errorMessage.value = error.response?.data?.message || 'Ошибка при сохранении акта'
  } finally {
    isSubmitting.value = false
  }
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
onMounted(async () => {
  await loadReferenceData()
  if (isEditMode.value) {
    await loadActData()
  }
})
</script>