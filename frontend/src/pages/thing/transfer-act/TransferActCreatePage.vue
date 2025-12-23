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

            <!-- Тип акта -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Тип акта *
              </label>
              <select
                  v-model="formData.type"
                  required
                  @change="onTypeChange"
                  class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500"
                  :disabled="isEditMode"
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

            <!-- Поля с людьми -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- От кого - показываем для актов приёма и передачи -->
              <div v-if="showFromField">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  {{ fromFieldLabel }} *
                </label>
                <select
                    v-model="formData.from"
                    required
                    :disabled="isEditMode || isThingsLoading"
                    @change="onPersonChange('from')"
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
                <div v-if="isThingsLoading && formData.from" class="mt-2">
                  <div class="flex items-center text-gray-500">
                    <svg class="animate-spin h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                    </svg>
                    Загрузка материальных ценностей...
                  </div>
                </div>
              </div>

              <!-- Кому - показываем для актов передачи и списания -->
              <div v-if="showToField">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  {{ toFieldLabel }} *
                </label>
                <select
                    v-model="formData.to"
                    required
                    :disabled="isEditMode"
                    @change="onPersonChange('to')"
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

            <!-- Материальные ценности -->
            <div v-if="showThingsSection && formData.type">
              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Материальные ценности *
                </label>

                <!-- Поиск по инвентарному номеру -->
                <div class="mb-4">
                  <input
                      type="text"
                      v-model="searchQuery"
                      @input="filterThings"
                      placeholder="Поиск по инвентарному номеру или названию..."
                      class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500"
                  />
                </div>

                <div v-if="filteredThings.length === 0" class="text-gray-500 italic">
                  {{ isThingsLoading ? 'Загрузка...' : 'Нет доступных материальных ценностей' }}
                </div>

                <!-- Выбор материальных ценностей -->
                <div v-else class="space-y-3 max-h-96 overflow-y-auto pr-2">
                  <div v-for="thing in filteredThings" :key="thing.id" class="flex items-center p-3 border rounded-lg hover:bg-gray-50">
                    <input
                        type="checkbox"
                        :id="`thing-${thing.id}`"
                        :value="thing.id"
                        v-model="selectedThings"
                        class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                    />
                    <label :for="`thing-${thing.id}`" class="ml-3 flex-1 cursor-pointer">
                      <div class="flex justify-between items-start">
                        <div>
                          <span class="font-medium text-gray-900">{{ thing.name }}</span>
                          <div class="text-sm text-gray-500 mt-1 space-y-1">
                            <div>Инв. номер: {{ thing.inv_number }}</div>
                            <div>Серийный номер: {{ thing.serial_number }}</div>
                            <div>Цена: {{ thing.price }} руб.</div>
                            <div v-if="thing.auditorium_id">Аудитория: {{ thing.auditorium_id }}</div>
                          </div>
                        </div>
                      </div>
                    </label>
                  </div>
                </div>

                <p v-if="formErrors.things" class="mt-1 text-sm text-red-600">
                  {{ formErrors.things }}
                </p>
              </div>

              <!-- Выбранные материальные ценности -->
              <div v-if="selectedThings.length > 0" class="mt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-3">Выбранные материальные ценности</h3>
                <div class="space-y-3">
                  <div v-for="thingId in selectedThings" :key="thingId" class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                      <span class="font-medium text-gray-900">
                        {{ getThingById(thingId)?.name || 'Неизвестный объект' }}
                      </span>
                      <div class="text-sm text-gray-500 mt-1">
                        Инв. номер: {{ getThingById(thingId)?.inv_number || '-' }}
                      </div>
                    </div>
                    <button
                        type="button"
                        @click="removeThing(thingId)"
                        class="text-red-600 hover:text-red-800 p-1"
                    >
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                      </svg>
                    </button>
                  </div>
                </div>
              </div>
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
import { ref, onMounted, computed, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'
import { BACKEND_URL } from '@/router.js'

const route = useRoute()
const router = useRouter()

const isEditMode = computed(() => route.name === 'TransferActEdit')
const actId = route.params.id

// Данные формы
const formData = ref({
  type: '',
  from: '',
  to: '',
  confirmed: false,
  time: ''
})

const selectedThings = ref([]) // Выбранные материальные ценности
const availableThings = ref([]) // Доступные материальные ценности
const filteredThings = ref([]) // Отфильтрованные материальные ценности
const thingsMap = ref({}) // Карта материальных ценностей для быстрого поиска
const searchQuery = ref('') // Поисковый запрос

const formErrors = ref({})
const successMessage = ref('')
const errorMessage = ref('')
const isSubmitting = ref(false)
const isThingsLoading = ref(false)

// Справочные данные
const peopleList = ref([])
const actTypes = ref({})

// Вычисляемые свойства для отображения полей
const showFromField = computed(() => {
  // Показываем поле "От кого" для актов приёма (1) и передачи (2)
  return formData.value.type === '3' || formData.value.type === '2'
})

const showToField = computed(() => {
  // Показываем поле "Кому" для актов передачи (2) и списания (3)
  return formData.value.type === '2' || formData.value.type === '1'
})

const fromFieldLabel = computed(() => {
  if (formData.value.type === '3') return 'МОЛ списания'
  if (formData.value.type === '2') return 'От кого'
  return ''
})

const toFieldLabel = computed(() => {
  if (formData.value.type === '2') return 'Кому'
  if (formData.value.type === '1') return 'МОЛ зачисления'
  return ''
})

const showThingsSection = computed(() => {
  // Для типа 1 (прием) - показываем вещи сразу после выбора типа
  // Для типа 2 и 3 - показываем после выбора человека
  if (formData.value.type === '1') {
    return true
  } else if (formData.value.type === '2' || formData.value.type === '3') {
    return formData.value.from !== ''
  }
  return false
})

// Загрузка справочных данных
const loadReferenceData = async () => {
  try {
    const [peopleRes, typesRes] = await Promise.all([
      axios.get(BACKEND_URL + '/api/people'),
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

// Загрузка материальных ценностей
const loadThings = async () => {
  if (!formData.value.type) {
    availableThings.value = []
    filteredThings.value = []
    thingsMap.value = {}
    return
  }

  isThingsLoading.value = true
  availableThings.value = []
  filteredThings.value = []
  thingsMap.value = {}
  searchQuery.value = ''

  try {
    let response

    if (formData.value.type === '1') {
      // Для акта приёма - свободные материальные ценности
      response = await axios.get(BACKEND_URL + '/api/things/free')
    } else if (formData.value.type === '2' || formData.value.type === '3') {
      // Для актов передачи и списания - материальные ценности у выбранного человека
      if (!formData.value.from) {
        console.log('Ожидание выбора человека для типа', formData.value.type)
        return
      }
      response = await axios.get(BACKEND_URL + `/api/things/person/${formData.value.from}`)
    } else {
      return
    }

    console.log('Загрузка вещей для типа:', formData.value.type, 'Ответ:', response.data)

    if (response.data.success) {
      availableThings.value = response.data.data || []
      filteredThings.value = [...availableThings.value]

      // Создаем карту для быстрого поиска по ID
      response.data.data.forEach(thing => {
        thingsMap.value[thing.id] = thing
      })
    }
  } catch (error) {
    console.error('Ошибка загрузки материальных ценностей:', error)
    errorMessage.value = 'Ошибка загрузки материальных ценностей'
  } finally {
    isThingsLoading.value = false
  }
}

// Фильтрация вещей по поисковому запросу
const filterThings = () => {
  if (!searchQuery.value.trim()) {
    filteredThings.value = [...availableThings.value]
    return
  }

  const query = searchQuery.value.toLowerCase().trim()
  filteredThings.value = availableThings.value.filter(thing => {
    return (
        thing.inv_number?.toLowerCase().includes(query) ||
        thing.name?.toLowerCase().includes(query) ||
        thing.serial_number?.toLowerCase().includes(query)
    )
  })
}

// Получение информации о материальной ценности по ID
const getThingById = (id) => {
  return thingsMap.value[id]
}

// Удаление выбранной материальной ценности
const removeThing = (thingId) => {
  selectedThings.value = selectedThings.value.filter(id => id !== thingId)
}

// Обработчик изменения типа акта
const onTypeChange = async () => {
  // Сбрасываем поля людей и выбранные материальные ценности
  formData.value.from = ''
  formData.value.to = ''
  selectedThings.value = []
  availableThings.value = []
  filteredThings.value = []
  thingsMap.value = {}
  searchQuery.value = ''

  // Сбрасываем ошибки
  formErrors.value = {}
  errorMessage.value = ''

  // Если выбран тип 1 (прием), сразу загружаем вещи
  if (formData.value.type === '1') {
    await loadThings()
  }
}

// Обработчик изменения выбранного человека
const onPersonChange = async (field) => {
  if (field === 'from' && (formData.value.type === '2' || formData.value.type === '3')) {
    // Для актов передачи и списания при изменении "от кого" загружаем материальные ценности
    await loadThings()
  }

  // Сбрасываем выбранные материальные ценности
  selectedThings.value = []
}

// Загрузка данных акта для редактирования
const loadActData = async () => {
  if (!isEditMode.value) return

  try {
    const response = await axios.get(BACKEND_URL + `/api/transfer-acts/${actId}`)

    if (response.data.success) {
      const actData = response.data.data
      formData.value = {
        type: actData.type?.toString() || '',
        from: actData.from || '',
        to: actData.to || '',
        confirmed: Boolean(actData.confirmed),
        time: actData.time
      }

      // Загружаем вещи после установки типа
      if (formData.value.type) {
        await loadThings()

        // Если есть данные о связанных материальных ценностях
        if (actData.things && Array.isArray(actData.things)) {
          selectedThings.value = actData.things.map(thing => thing.id)
        }
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
    if (!formData.value.type) {
      formErrors.value.type = 'Выберите тип акта'
    }

    if (showFromField.value && !formData.value.from) {
      formErrors.value.from = `Выберите ${fromFieldLabel.value.toLowerCase()}`
    }

    if (showToField.value && !formData.value.to) {
      formErrors.value.to = `Выберите ${toFieldLabel.value.toLowerCase()}`
    }

    // Проверка, что выбран хотя бы один материальный объект
    if (selectedThings.value.length === 0) {
      formErrors.value.things = 'Выберите хотя бы одну материальную ценность'
    }

    // Для акта передачи проверяем, что отправитель и получатель не совпадают
    if (formData.value.type === '2' && formData.value.from === formData.value.to) {
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
      type: parseInt(formData.value.type),
      from: formData.value.from || null,
      to: formData.value.to || null,
      things: selectedThings.value
    }

    console.log('Отправка данных:', payload)

    let response
    if (isEditMode.value) {
      response = await axios.put(
          BACKEND_URL + `/api/transfer-acts/${actId}`,
          payload
      )
    } else {
      // Создание нового акта
      response = await axios.post(
          BACKEND_URL + 'api/transfer-acts',
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

// Наблюдатель за изменениями типа акта
watch(() => formData.value.type, async (newType) => {
  if (newType) {
    // Для типа 1 сразу загружаем вещи
    if (newType === '1') {
      await loadThings()
    }
  }
})

// Наблюдатель за изменением человека "от кого" для загрузки материальных ценностей
watch(() => formData.value.from, async (newFrom) => {
  if (newFrom && (formData.value.type === '2' || formData.value.type === '3')) {
    await loadThings()
  }
})

// Загружаем данные при монтировании компонента
onMounted(async () => {
  await loadReferenceData()
  if (isEditMode.value) {
    await loadActData()
  }
})
</script>