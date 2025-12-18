<template>
  <div class="p-6 bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <div class="max-w-4xl mx-auto">
      <!-- Заголовок -->
      <div class="mb-8">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-3xl font-bold text-gray-900">Создание нового предмета</h1>
            <p class="text-gray-600 mt-2">Заполните все необходимые поля для добавления основного средства</p>
          </div>
          <router-link
              to="/things"
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
              <!-- Название ОС -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Название основного средства *
                </label>
                <input
                    v-model="formData.name"
                    type="text"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                    placeholder="Например: Ноутбук Dell Latitude 5420"
                />
                <p class="mt-1 text-sm text-gray-500">
                  Полное название основного средства
                </p>
              </div>

              <!-- Серийный номер -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Серийный номер *
                </label>
                <input
                    v-model="formData.serial_number"
                    type="text"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                    placeholder="Например: CN-0R3XX1-64180-2B9-016K"
                />
                <p class="mt-1 text-sm text-gray-500">
                  Уникальный номер производителя
                </p>
              </div>

              <!-- Инвентарный номер -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Инвентарный номер *
                </label>
                <input
                    v-model="formData.inv_number"
                    type="text"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                    placeholder="Например: INV-2024-001"
                />
                <p class="mt-1 text-sm text-gray-500">
                  Внутренний инвентарный номер организации
                </p>
              </div>

              <!-- Дата введения в эксплуатацию -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Дата введения в эксплуатацию *
                </label>
                <input
                    v-model="formData.operation_date"
                    type="date"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                />
                <p class="mt-1 text-sm text-gray-500">
                  Дата начала использования предмета
                </p>
              </div>
            </div>
          </div>

          <!-- Классификация и состояние -->
          <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-6 pb-2 border-b border-gray-200">
              Классификация и состояние
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Тип предмета -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Тип предмета *
                </label>
                <select
                    v-model.number="formData.thing_type_id"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                >
                  <option value="">Выберите тип</option>
                  <option
                      v-for="(name, id) in types"
                      :key="id"
                      :value="id"
                  >
                    {{ name }}
                  </option>
                </select>
                <p class="mt-1 text-sm text-gray-500">
                  Категория основного средства
                </p>
              </div>

              <!-- Переключатель составного предмета -->
              <div v-if="isArmType" class="md:col-span-2">
                <label class="flex items-center gap-3 cursor-pointer">
                  <input
                      type="checkbox"
                      v-model="formData.is_composite"
                      class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                  />
                  <span class="text-sm font-medium text-gray-700">
                    Составной предмет (АРМ)
                  </span>
                </label>
              </div>

              <!-- Характеристика учёта -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Характеристика учёта *
                </label>
                <select
                    v-model="formData.balance"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                >
                  <option value="">Выберите характеристику</option>
                  <option
                      v-for="(name, id) in balanceTypes"
                      :key="id"
                      :value="id"
                  >
                    {{ name }}
                  </option>
                </select>
                <p class="mt-1 text-sm text-gray-500">
                  Тип учёта основного средства
                </p>
              </div>

              <!-- Родительский предмет -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Родительский предмет (опционально)
                </label>
                <select
                    v-model="formData.thing_parent_id"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                >
                  <option value="">Не выбрано</option>
                  <option
                      v-for="item in parentThings"
                      :key="item.id"
                      :value="item.id"
                  >
                    {{ item.inv_number }}
                  </option>
                </select>
                <p class="mt-1 text-sm text-gray-500">
                  Если предмет является частью другого ОС
                </p>
              </div>

              <!-- Аудитория размещения -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Кабинет размещения
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
                  Кабинет, где находится предмет
                </p>
              </div>

              <!-- Состояние -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Состояние *
                </label>
                <select
                    v-model="formData.condition"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                >
                  <option value="">Выберите состояние</option>
                  <option
                      v-for="(label, key) in conditions"
                      :key="key"
                      :value="parseInt(key)"
                  >
                    {{ label }}
                  </option>
                </select>
                <p class="mt-1 text-sm text-gray-500">
                  Текущее состояние предмета
                </p>
              </div>

              <!-- Балансовая стоимость -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Балансовая стоимость *
                </label>
                <div class="relative">
                  <input
                      v-model.number="formData.price"
                      type="number"
                      min="0"
                      step="0.01"
                      class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                      placeholder="0.00"
                  />
                  <span class="absolute left-3 top-3.5 text-gray-500">₽</span>
                </div>
                <p class="mt-1 text-sm text-gray-500">
                  Стоимость на момент приобретения
                </p>
              </div>
            </div>
          </div>

          <!-- Комментарий -->
          <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">
              Дополнительная информация
            </h2>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Комментарий
              </label>
              <textarea
                  v-model="formData.comment"
                  rows="4"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                  placeholder="Введите дополнительную информацию о предмете..."
              ></textarea>
              <p class="mt-1 text-sm text-gray-500">
                Дополнительные заметки, особенности, история ремонта и т.д.
              </p>
            </div>
          </div>

          <!-- Составные элементы -->
          <div v-if="formData.is_composite" class="mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">
              Составные элементы
            </h2>

            <div class="space-y-4">
              <div
                  v-for="(child, index) in formData.children"
                  :key="index"
                  class="border border-gray-200 rounded-xl p-4 bg-gray-50"
              >
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                  <div>
                    <label class="text-sm font-medium text-gray-700">Название *</label>
                    <input
                        v-model="child.name"
                        type="text"
                        class="w-full px-3 py-2 border rounded-lg"
                    />
                  </div>

                  <div>
                    <label class="text-sm font-medium text-gray-700">Тип *</label>
                    <select
                        v-model="child.thing_type_id"
                        class="w-full px-3 py-2 border rounded-lg"
                    >
                      <option value="">Выберите тип</option>
                      <option
                          v-for="(name, id) in types"
                          :key="id"
                          :value="id"
                      >
                        {{ name }}
                      </option>
                    </select>
                  </div>

                  <div>
                    <label class="text-sm font-medium text-gray-700">Серийный номер</label>
                    <input
                        v-model="child.serial_number"
                        type="text"
                        class="w-full px-3 py-2 border rounded-lg"
                    />
                  </div>

                  <div>
                    <label class="text-sm font-medium text-gray-700">Инвентарный номер</label>
                    <input
                        v-model="child.inv_number"
                        type="text"
                        class="w-full px-3 py-2 border rounded-lg"
                    />
                  </div>

                  <div>
                    <label class="text-sm font-medium text-gray-700">Цена</label>
                    <input
                        v-model.number="child.price"
                        type="number"
                        step="0.01"
                        class="w-full px-3 py-2 border rounded-lg"
                    />
                  </div>

                  <div>
                    <label class="text-sm font-medium text-gray-700">Состояние</label>
                    <select
                        v-model="child.condition"
                        class="w-full px-3 py-2 border rounded-lg"
                    >
                      <option value="">—</option>
                      <option
                          v-for="(label, key) in conditions"
                          :key="key"
                          :value="parseInt(key)"
                      >
                        {{ label }}
                      </option>
                    </select>
                  </div>
                </div>

                <button
                    type="button"
                    @click="removeChild(index)"
                    class="mt-4 text-red-600 text-sm hover:underline"
                >
                  Удалить элемент
                </button>
              </div>
            </div>

            <button
                type="button"
                @click="addChild"
                class="mt-4 px-4 py-2 bg-indigo-100 text-indigo-700 rounded-lg hover:bg-indigo-200"
            >
              ➕ Добавить элемент
            </button>
          </div>


          <!-- Кнопки действий -->
          <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
            <router-link
                to="/things"
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
                Сохранение...
              </span>
              <span v-else>
                Создать предмет
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
            <div v-for="(value, key) in formData" :key="key" class="border-b border-gray-200 pb-2">
              <div class="text-sm text-gray-500 capitalize">{{ formatKey(key) }}</div>
              <div class="font-medium">
                <template v-if="key === 'thing_type_id' && Object.keys(types).length">
                  {{ getTypeName(value) || 'Не указано' }}
                </template>
                <template v-else-if="key === 'balance' && Object.keys(balanceTypes).length">
                  {{ getBalanceName(value) || 'Не указано' }}
                </template>
                <template v-else-if="key === 'thing_parent_id' && parentThings.length">
                  {{ getParentInvNumber(value) || 'Не указано' }}
                </template>
                <template v-else-if="key === 'auditorium_id' && auditoriums.length">
                  {{ getAuditoriumName(value) || 'Не указано' }}
                </template>
                <template v-else-if="key === 'condition'">
                  {{ getConditionLabel(value) || 'Не указано' }}
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
import { ref, reactive, onMounted, watch } from 'vue'
import { useRouter } from 'vue-router'
import {createSimpleThing, createCompositeThing} from '@/requests/thingRequest.js'
import axios from "axios"

import {BACKEND_URL} from "@/router.js";
import { computed } from 'vue'

const ARM_TYPE_ID = 11


const isArmType = computed(() => {
  return formData.thing_type_id === ARM_TYPE_ID
})

const router = useRouter()

// Данные формы

const formData = reactive({
  name: '',
  serial_number: '',
  inv_number: '',
  operation_date: '',
  thing_type_id: '',
  balance: '',
  thing_parent_id: '',
  auditorium_id: '',
  condition: '',
  price: 0,
  comment: '',

  is_composite: false,
  children: []
})


// Динамические данные с сервера
const types = ref({})
const conditions = ref({})
const balanceTypes = ref({}) // Изменяем на объект, как в types
const parentThings = ref([])
const auditoriums = ref([])
const isLoading = ref(false)
const isSubmitting = ref(false)
const showPreview = ref(false)

// Наблюдатель для предпросмотра
watch(formData, (newValue) => {
  console.log('Form data updated:', newValue)
  showPreview.value = Object.values(newValue).some(value => value !== '' && value !== 0)
}, { deep: true })

// Загрузка данных при монтировании компонента
onMounted(async () => {
  await loadFormData()

  // Автозаполнение текущей даты
  const today = new Date().toISOString().split('T')[0]
  formData.operation_date = today
})

// Загрузка типов, условий, родительских предметов, аудиторий и характеристик учёта с сервера
const loadFormData = async () => {
  try {
    isLoading.value = true

    // Загружаем все данные параллельно
    const [typesResponse, balanceResponse, parentsResponse, auditoriumsResponse] = await Promise.all([
      axios.get(BACKEND_URL + '/api/info/thing-types'),
      axios.get(BACKEND_URL + '/api/info/balance'), // Запрос характеристик учёта
      axios.get(BACKEND_URL + '/api/things/simple-electronics'),
      axios.get(BACKEND_URL + '/api/auditoriums/index')
    ])

    // Обработка типов и условий
    if (typesResponse.data.success) {
      types.value = typesResponse.data.types || {}
      conditions.value = typesResponse.data.conditions || {}
      console.log('Загруженные типы:', types.value)
      console.log('Загруженные условия:', conditions.value)
    } else {
      console.error('Ошибка загрузки типов и условий:', typesResponse.data)
      types.value = {}
      conditions.value = {}
    }

    // Обработка характеристик учёта
    if (balanceResponse.data.success) {
      balanceTypes.value = balanceResponse.data.types || {}
      console.log('Загруженные характеристики учёта:', balanceTypes.value)
    } else {
      console.error('Ошибка загрузки характеристик учёта:', balanceResponse.data)
      balanceTypes.value = {}
    }

    // Обработка родительских предметов
    if (parentsResponse.data.success) {
      parentThings.value = parentsResponse.data.data || []
      console.log('Загруженные родительские предметы:', parentThings.value)
    } else {
      console.error('Ошибка загрузки родительских предметов:', parentsResponse.data)
      parentThings.value = []
    }

    // Обработка аудиторий
    if (auditoriumsResponse.data.success) {
      auditoriums.value = auditoriumsResponse.data.data || []
      console.log('Загруженные аудитории:', auditoriums.value)
    } else {
      console.error('Ошибка загрузки аудиторий:', auditoriumsResponse.data)
      auditoriums.value = []
    }

  } catch (error) {
    console.error('Ошибка при загрузке данных формы:', error)
    types.value = {}
    conditions.value = {}
    balanceTypes.value = {}
    parentThings.value = []
    auditoriums.value = []
  } finally {
    isLoading.value = false
  }
}

// Получение названия типа по ID
const getTypeName = (typeId) => {
  if (!typeId) return ''
  return types.value[typeId] || ''
}

// Получение названия характеристики учёта по ID
const getBalanceName = (balanceId) => {
  if (!balanceId) return ''
  return balanceTypes.value[balanceId] || ''
}

// Получение инвентарного номера родительского предмета по ID
const getParentInvNumber = (parentId) => {
  if (!parentId) return ''
  const parent = parentThings.value.find(item => item.id == parentId)
  return parent ? `INV-${parent.inv_number}` : ''
}

// Получение названия аудитории по ID
const getAuditoriumName = (auditoriumId) => {
  if (!auditoriumId) return ''
  const auditorium = auditoriums.value.find(item => item.id == auditoriumId)
  return auditorium ? auditorium.name : ''
}

// Получение метки состояния по ID
const getConditionLabel = (conditionId) => {
  if (conditionId === '' || conditionId === null) return ''
  return conditions.value[conditionId] || ''
}


// Обработка отправки формы
const handleSubmit = async () => {
  try {
    isSubmitting.value = true

    if (!formData.name || !formData.thing_type_id ) {
      alert('Пожалуйста, заполните все обязательные поля')
      return
    }


    // Подготовка данных для отправки
    const dataToSend = {
      name: formData.name,
      serial_number: formData.serial_number,
      inv_number: formData.inv_number,
      operation_date: formData.operation_date,
      thing_type_id: parseInt(formData.thing_type_id),
      balance: parseInt(formData.balance), // Добавляем характеристику учёта
      thing_parent_id: formData.thing_parent_id ? parseInt(formData.thing_parent_id) : null,
      auditorium_id: formData.auditorium_id ? parseInt(formData.auditorium_id) : null,
      condition: parseInt(formData.condition),
      price: parseFloat(formData.price),
      comment: formData.comment || '',
      is_composite: formData.is_composite,
      children: formData.is_composite
          ? formData.children.map(child => ({
            ...child,
            thing_type_id: Number(child.thing_type_id)
          }))
          : []
    }

    console.log('Отправляемые данные:', dataToSend)

    const response = (formData.is_composite) ? await createCompositeThing(dataToSend) : await  createSimpleThing(dataToSend)

    // Отправка данных на сервер
    // const response = await axios.post(
    //     BACKEND_URL + '/api/things/store',
    //     dataToSend,
    //     {
    //       headers: {
    //         'Content-Type': 'application/json',
    //       }
    //     }
    // )


    if (response.data && response.data.success) {
      alert('Предмет успешно создан!')
      router.push('/things')
    } else {
      throw new Error(response.data?.message || 'Ошибка при создании предмета')
    }

  } catch (error) {
    console.error('Ошибка при создании предмета:', error)

    let errorMessage = 'Произошла ошибка при создании предмета'

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

const addChild = () => {
  formData.children.push({
    name: '',
    serial_number: '',
    inv_number: '',
    thing_type_id: '',
    price: null,
    condition: null
  })
}

const removeChild = (index) => {
  formData.children.splice(index, 1)
}

// Форматирование ключей для предпросмотра
const formatKey = (key) => {
  const translations = {
    name: 'Название',
    serial_number: 'Серийный номер',
    inv_number: 'Инвентарный номер',
    operation_date: 'Дата ввода в эксплуатацию',
    thing_type_id: 'Тип предмета',
    balance: 'Характеристика учёта', // Добавляем перевод
    thing_parent_id: 'Родительский предмет',
    auditorium_id: 'Кабинет размещения',
    condition: 'Состояние',
    price: 'Стоимость',
    comment: 'Комментарий'
  }
  return translations[key] || key
}
</script>