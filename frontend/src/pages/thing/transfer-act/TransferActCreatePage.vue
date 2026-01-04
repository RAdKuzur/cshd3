<template>
  <div class="p-6 bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <div class="max-w-6xl mx-auto">
      <!-- Заголовок -->
      <div class="mb-8">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-3xl font-bold text-gray-900">Создание нового акта</h1>
            <p class="text-gray-600 mt-2">Заполните все необходимые поля для добавления акта перемещения материальных средств</p>
          </div>
          <router-link
              to="/things/transfer-acts"
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
              <!-- Тип акта -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Тип акта *
                </label>
                <select
                    v-model.number="formData.type"
                    required
                    @change="onTypeChange"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                >
                  <option value="">Выберите тип</option>
                  <option
                      v-for="(name, id) in actTypes"
                      :key="id"
                      :value="id"
                  >
                    {{ name }}
                  </option>
                </select>
                <p class="mt-1 text-sm text-gray-500">
                  Тип перемещения материальных средств
                </p>
              </div>

              <!-- Дата акта -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Дата акта *
                </label>
                <input
                    v-model="formData.date"
                    type="date"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                />
                <p class="mt-1 text-sm text-gray-500">
                  Дата составления акта
                </p>
              </div>
            </div>
          </div>

          <!-- Стороны акта -->
          <div v-if="formData.type" class="mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-6 pb-2 border-b border-gray-200">
              Стороны акта
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- От кого (для типов 2 и 3) -->
              <div v-if="formData.type === 2 || formData.type === 3">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  От кого *
                </label>
                <select
                    v-model.number="formData.from"
                    required
                    @change="onFromChange"
                    :disabled="isLoadingPeople"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors disabled:bg-gray-100 disabled:cursor-not-allowed"
                >
                  <option value="">Выберите сотрудника</option>
                  <option
                      v-for="person in people"
                      :key="person.id"
                      :value="person.id"
                  >
                    {{ getPersonFullName(person) }}
                  </option>
                </select>
                <p class="mt-1 text-sm text-gray-500">
                  Сотрудник, передающий/списывающий средства
                </p>
                <div v-if="isLoadingPeople" class="mt-2 text-sm text-blue-600">
                  Загрузка сотрудников...
                </div>
              </div>

              <!-- Кому (для типов 1 и 2) -->
              <div v-if="formData.type === 1 || formData.type === 2">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Кому (принимает) *
                </label>
                <select
                    v-model.number="formData.to"
                    required
                    :disabled="!formData.type || isLoadingPeople || (formData.type === 2 && !formData.from)"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors disabled:bg-gray-100 disabled:cursor-not-allowed"
                >
                  <option value="">Выберите сотрудника</option>
                  <option
                      v-for="person in people"
                      :key="person.id"
                      :value="person.id"
                  >
                    {{ getPersonFullName(person) }}
                  </option>
                </select>
                <p class="mt-1 text-sm text-gray-500">
                  <template v-if="formData.type === 1">
                    Сотрудник, принимающий средства от учётного отдела
                  </template>
                  <template v-else-if="formData.type === 2">
                    Сотрудник, принимающий средства
                  </template>
                </p>
                <div v-if="isLoadingPeople" class="mt-2 text-sm text-blue-600">
                  Загрузка сотрудников...
                </div>
              </div>

              <!-- Для типа 3 показываем только от кого -->
<!--              <div v-if="formData.type === 3" class="md:col-span-2">-->
<!--                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">-->
<!--                  <div class="flex items-center gap-3">-->
<!--                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">-->
<!--                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />-->
<!--                    </svg>-->
<!--                    <p class="text-sm text-gray-600">-->
<!--                      При списании средства возвращаются в учётный отдел организации-->
<!--                    </p>-->
<!--                  </div>-->
<!--                </div>-->
<!--              </div>-->
            </div>
          </div>

          <!-- Материальные средства -->
          <div v-if="shouldShowThingsSection" class="mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-6 pb-2 border-b border-gray-200">
              Материальные средства
              <span class="text-sm font-normal text-gray-600 ml-2">
                ({{ getThingsSectionDescription() }})
              </span>
            </h2>

            <!-- Поиск и фильтрация -->
            <div v-if="!isLoadingThings && availableThings.length > 0" class="mb-6">
              <div class="flex flex-col md:flex-row gap-4 mb-4">
                <!-- Поиск по названию/инвентарному номеру -->
                <div class="flex-1">
                  <label class="block text-sm font-medium text-gray-700 mb-2">
                    Поиск средств
                  </label>
                  <div class="relative">
                    <input
                        v-model="searchQuery"
                        type="text"
                        placeholder="Поиск по названию или инвентарному номеру..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    />
                    <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                  </div>
                </div>

                <!-- Фильтр по типу -->
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">
                    Фильтр по типу
                  </label>
                  <select
                      v-model="typeFilter"
                      class="w-full md:w-48 px-3 py-2 border border-gray-300 rounded-lg"
                  >
                    <option value="">Все типы</option>
                    <option
                        v-for="(typeName, typeId) in thingTypes"
                        :key="typeId"
                        :value="typeId"
                    >
                      {{ typeName }}
                    </option>
                  </select>
                </div>
              </div>

              <!-- Статистика -->
              <div class="flex items-center justify-between mb-4">
                <div>
                  <span class="text-sm text-gray-600">
                    Найдено: {{ filteredThings.length }} из {{ availableThings.length }}
                  </span>
                  <span class="mx-2">•</span>
                  <span class="text-sm text-gray-600">
                    Выбрано: {{ selectedThingsCount }} шт.
                  </span>
                  <span class="mx-2">•</span>
                  <span class="text-sm font-medium text-indigo-600">
                    Общая стоимость: {{ formatPrice(totalSelectedPrice) }}
                  </span>
                </div>
                <button
                    type="button"
                    @click="toggleSelectAll"
                    class="text-sm px-3 py-1 border border-gray-300 rounded-lg hover:bg-gray-50"
                >
                  {{ selectAllLabel }}
                </button>
              </div>
            </div>

            <!-- Загрузка -->
            <div v-if="isLoadingThings" class="text-center py-12">
              <svg class="animate-spin h-12 w-12 text-indigo-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              <p class="mt-4 text-gray-600">Загрузка материальных средств...</p>
            </div>

            <!-- Пустой список -->
            <div v-else-if="availableThings.length === 0" class="text-center py-12 border-2 border-dashed border-gray-300 rounded-xl">
              <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
              </svg>
              <h3 class="text-lg font-medium text-gray-900 mb-2">Нет доступных средств</h3>
              <p class="text-gray-600 max-w-md mx-auto">
                <template v-if="formData.type === 1">
                  Все материальные средства уже закреплены за сотрудниками
                </template>
                <template v-else-if="formData.type === 2">
                  У выбранного сотрудника нет закрепленных средств для передачи
                </template>
                <template v-else-if="formData.type === 3">
                  У выбранного сотрудника нет средств для списания
                </template>
              </p>
            </div>

            <!-- Сетка материальных средств -->
            <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6 max-h-[500px] overflow-y-auto p-1">
              <div
                  v-for="thing in filteredThings"
                  :key="thing.id"
                  @click="toggleThingSelection(thing.id)"
                  :class="[
                    'border rounded-xl p-4 cursor-pointer transition-all duration-200',
                    isThingSelected(thing.id)
                      ? 'border-indigo-500 bg-indigo-50 ring-2 ring-indigo-200'
                      : 'border-gray-200 hover:border-gray-300 hover:bg-gray-50'
                  ]"
              >
                <div class="flex items-start gap-3">
                  <!-- Чекбокс -->
                  <div class="flex-shrink-0 mt-1">
                    <div :class="[
                      'w-5 h-5 rounded border flex items-center justify-center',
                      isThingSelected(thing.id)
                        ? 'bg-indigo-600 border-indigo-600'
                        : 'border-gray-300 bg-white'
                    ]">
                      <svg v-if="isThingSelected(thing.id)" class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                      </svg>
                    </div>
                  </div>

                  <!-- Информация о средстве -->
                  <div class="flex-1">
                    <h3 class="font-medium text-gray-900 mb-1 line-clamp-1">{{ thing.name }}</h3>
                    <div class="space-y-1.5">
                      <div class="flex items-center gap-2 text-sm">
                        <span class="text-gray-500">Инв. №:</span>
                        <span class="font-medium">{{ thing.inv_number }}</span>
                      </div>
                      <div class="flex items-center gap-2 text-sm">
                        <span class="text-gray-500">Тип:</span>
                        <span class="font-medium">{{ getThingTypeName(thing.thing_type_id) }}</span>
                      </div>
                      <div class="flex items-center gap-2 text-sm">
                        <span class="text-gray-500">Дата ввода:</span>
                        <span class="font-medium">{{ formatDate(thing.operation_date) }}</span>
                      </div>
                      <div class="flex items-center gap-2 text-sm">
                        <span class="text-gray-500">Стоимость:</span>
                        <span class="font-medium text-indigo-600">{{ formatPrice(thing.price) }}</span>
                      </div>
                      <div v-if="thing.serial_number" class="flex items-center gap-2 text-sm">
                        <span class="text-gray-500">Серийный №:</span>
                        <span class="font-medium font-mono">{{ thing.serial_number }}</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Список выбранных средств -->
            <div v-if="selectedThingsCount > 0" class="mt-8">
              <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Выбранные средства ({{ selectedThingsCount }})
              </h3>

              <div class="space-y-3 max-h-[300px] overflow-y-auto p-1">
                <div
                    v-for="selectedThing in selectedThings"
                    :key="selectedThing.id"
                    class="bg-gray-50 border border-gray-200 rounded-lg p-4"
                >
                  <div class="flex items-start justify-between">
                    <div class="flex-1">
                      <div class="flex items-center gap-3 mb-2">
                        <h4 class="font-medium text-gray-900">{{ selectedThing.name }}</h4>
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded">Инв. №: {{ selectedThing.inv_number }}</span>
                      </div>
                      <div class="grid grid-cols-2 gap-2 text-sm">
                        <div class="text-gray-600">Тип:</div>
                        <div class="font-medium">{{ getThingTypeName(selectedThing.thing_type_id) }}</div>

                        <div class="text-gray-600">Стоимость:</div>
                        <div class="font-medium text-indigo-600">{{ formatPrice(selectedThing.price) }}</div>
                      </div>
                    </div>

                    <!-- Кнопка удаления -->
                    <button
                        type="button"
                        @click.stop="removeSelectedThing(selectedThing.id)"
                        class="ml-4 p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition-colors"
                        title="Удалить из списка"
                    >
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                      </svg>
                    </button>
                  </div>
                </div>
              </div>

              <div class="mt-4 p-4 bg-indigo-50 border border-indigo-100 rounded-lg">
                <div class="flex items-center justify-between">
                  <div>
                    <span class="text-sm text-gray-600">Итого выбрано: </span>
                    <span class="font-medium text-gray-900">{{ selectedThingsCount }} шт.</span>
                    <span class="mx-4 text-gray-300">|</span>
                    <span class="text-sm text-gray-600">Общая стоимость: </span>
                    <span class="font-medium text-indigo-700">{{ formatPrice(totalSelectedPrice) }}</span>
                  </div>
                  <button
                      type="button"
                      @click="clearAllSelections"
                      class="text-sm px-3 py-1.5 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition-colors"
                  >
                    Очистить все
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Кнопки действий -->
          <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
            <router-link
                to="/things/transfer-acts"
                class="px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors"
            >
              Отмена
            </router-link>
            <button
                type="submit"
                :disabled="isSubmitting || isLoading || selectedThingsCount === 0 || !formData.type || !formData.date || (formData.type === 1 && !formData.to) || (formData.type === 2 && (!formData.from || !formData.to)) || (formData.type === 3 && !formData.from)"
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
                Создать акт
              </span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted, watch, computed } from 'vue'
import { useRouter } from 'vue-router'
import axios from "axios"
import {BACKEND_URL} from "@/router.js"

const router = useRouter()

// Данные формы
const formData = reactive({
  date: '',
  type: '',
  from: '',
  to: '',
  things: [] // будет содержать только массив ID выбранных вещей
})

// Динамические данные с сервера
const actTypes = ref({})
const people = ref([])
const availableThings = ref([])
const thingTypes = ref({})

// Состояние загрузки
const isLoading = ref(false)
const isLoadingPeople = ref(false)
const isLoadingThings = ref(false)
const isSubmitting = ref(false)

// Фильтры и поиск
const searchQuery = ref('')
const typeFilter = ref('')

// Выбранные средства (храним ID выбранных средств)
const selectedThingIds = ref(new Set())

// Вычисляемые свойства
const shouldShowThingsSection = computed(() => {
  // Для типа 1: показываем если выбран тип
  // Для типа 2: показываем если выбран тип и сотрудник "от кого"
  // Для типа 3: показываем если выбран тип и сотрудник "от кого"
  if (formData.type === 1) {
    return true
  } else if (formData.type === 2 || formData.type === 3) {
    return formData.from
  }
  return false
})

const filteredThings = computed(() => {
  let filtered = availableThings.value

  // Фильтрация по поисковому запросу
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(thing =>
        thing.name.toLowerCase().includes(query) ||
        thing.inv_number.toLowerCase().includes(query) ||
        (thing.serial_number && thing.serial_number.toLowerCase().includes(query))
    )
  }

  // Фильтрация по типу
  if (typeFilter.value) {
    filtered = filtered.filter(thing => thing.thing_type_id == typeFilter.value)
  }

  return filtered
})

const selectedThingsCount = computed(() => selectedThingIds.value.size)

const selectedThings = computed(() => {
  return availableThings.value
      .filter(thing => selectedThingIds.value.has(parseInt(thing.id)))
})

const totalSelectedPrice = computed(() => {
  return selectedThings.value.reduce((sum, thing) => sum + (parseFloat(thing.price) || 0), 0)
})

const selectAllLabel = computed(() => {
  const allFilteredSelected = filteredThings.value.every(thing =>
      selectedThingIds.value.has(parseInt(thing.id))
  )
  return allFilteredSelected ? 'Снять все' : 'Выбрать все'
})

// Загрузка данных при монтировании компонента
onMounted(async () => {
  const today = new Date().toISOString().split('T')[0]
  formData.date = today
  await loadActTypes()
})

// Загрузка типов актов
const loadActTypes = async () => {
  try {
    const response = await axios.get(BACKEND_URL + '/api/info/transfer-acts/types')
    if (response.data.success) {
      actTypes.value = response.data.data || {}
    }
  } catch (error) {
    console.error('Ошибка при загрузке типов актов:', error)
  }
}

// Загрузка списка людей
const loadPeople = async () => {
  try {
    isLoadingPeople.value = true
    const response = await axios.get(BACKEND_URL + '/api/people')
    if (response.data.success) {
      people.value = response.data.data || []
    }
  } catch (error) {
    console.error('Ошибка при загрузке сотрудников:', error)
  } finally {
    isLoadingPeople.value = false
  }
}

// Загрузка материальных средств
const loadAvailableThings = async () => {
  try {
    isLoadingThings.value = true
    selectedThingIds.value.clear()
    formData.things = [] // Очищаем массив ID

    let url = ''

    if (formData.type === 1) {
      // Тип 1: свободные средства
      url = BACKEND_URL + '/api/things/free'
    } else if (formData.type === 2 || formData.type === 3) {
      // Типы 2 и 3: средства сотрудника "от кого"
      if (!formData.from) {
        console.log('Не выбран сотрудник "От кого"')
        return
      }
      url = BACKEND_URL + `/api/things/person/${formData.from}`
    }

    const response = await axios.get(url)

    if (response.data.success && Array.isArray(response.data.data)) {
      availableThings.value = response.data.data
      await loadThingTypes()
    } else {
      availableThings.value = []
    }

  } catch (error) {
    console.error('Ошибка при загрузке материальных средств:', error)
    availableThings.value = []
  } finally {
    isLoadingThings.value = false
  }
}

// Загрузка типов материальных средств
const loadThingTypes = async () => {
  try {
    const response = await axios.get(BACKEND_URL + '/api/info/thing-types')
    if (response.data.success) {
      thingTypes.value = response.data.types || {}
    }
  } catch (error) {
    console.error('Ошибка при загрузке типов средств:', error)
  }
}

// Обработчик изменения типа акта
const onTypeChange = () => {
  // Сбрасываем все поля при изменении типа
  formData.from = ''
  formData.to = ''
  availableThings.value = []
  selectedThingIds.value.clear()
  formData.things = []
  searchQuery.value = ''
  typeFilter.value = ''

  if (formData.type) {
    loadPeople()
  }
}

// Обработчик изменения сотрудника "От кого"
const onFromChange = () => {
  if (formData.from && (formData.type === 2 || formData.type === 3)) {
    loadAvailableThings()
  }
}

// Получение описания секции средств
const getThingsSectionDescription = () => {
  if (formData.type === 1) {
    return 'Свободные средства для передачи сотруднику'
  } else if (formData.type === 2) {
    return 'Средства сотрудника для передачи другому сотруднику'
  } else if (formData.type === 3) {
    return 'Средства сотрудника для списания'
  }
  return ''
}

// Получение полного имени сотрудника
const getPersonFullName = (person) => {
  const parts = [person.surname, person.firstname, person.patronymic].filter(part => part)
  return parts.join(' ') || `Сотрудник #${person.id}`
}

// Получение названия типа средства
const getThingTypeName = (typeId) => {
  return thingTypes.value[typeId] || `Тип #${typeId}`
}

// Форматирование даты
const formatDate = (dateString) => {
  if (!dateString) return '—'
  const date = new Date(dateString)
  return date.toLocaleDateString('ru-RU')
}

// Форматирование цены
const formatPrice = (price) => {
  if (!price) return '0 ₽'
  return new Intl.NumberFormat('ru-RU', {
    style: 'currency',
    currency: 'RUB',
    minimumFractionDigits: 0
  }).format(price)
}

// Работа с выбором средств
const toggleThingSelection = (thingId) => {
  const id = parseInt(thingId)
  if (selectedThingIds.value.has(id)) {
    selectedThingIds.value.delete(id)
    // Удаляем ID из массива
    const index = formData.things.indexOf(id)
    if (index !== -1) {
      formData.things.splice(index, 1)
    }
  } else {
    selectedThingIds.value.add(id)
    // Добавляем ID в массив
    if (!formData.things.includes(id)) {
      formData.things.push(id)
    }
  }
}

const isThingSelected = (thingId) => {
  return selectedThingIds.value.has(parseInt(thingId))
}

const toggleSelectAll = () => {
  const allFilteredSelected = filteredThings.value.every(thing =>
      selectedThingIds.value.has(parseInt(thing.id))
  )

  if (allFilteredSelected) {
    // Снимаем выбор со всех отфильтрованных
    filteredThings.value.forEach(thing => {
      const id = parseInt(thing.id)
      selectedThingIds.value.delete(id)
      // Удаляем ID из массива
      const index = formData.things.indexOf(id)
      if (index !== -1) {
        formData.things.splice(index, 1)
      }
    })
  } else {
    // Выбираем все отфильтрованные
    filteredThings.value.forEach(thing => {
      const id = parseInt(thing.id)
      if (!selectedThingIds.value.has(id)) {
        selectedThingIds.value.add(id)
        // Добавляем ID в массив, если его там нет
        if (!formData.things.includes(id)) {
          formData.things.push(id)
        }
      }
    })
  }
}

const removeSelectedThing = (thingId) => {
  const id = parseInt(thingId)
  selectedThingIds.value.delete(id)
  // Удаляем ID из массива
  const index = formData.things.indexOf(id)
  if (index !== -1) {
    formData.things.splice(index, 1)
  }
}

const clearAllSelections = () => {
  selectedThingIds.value.clear()
  formData.things = []
}

// Наблюдатели
watch(() => formData.type, (newType) => {
  if (newType === 1 && people.value.length > 0) {
    // Для типа 1 загружаем средства сразу
    loadAvailableThings()
  }
})

watch(() => people.value, (newPeople) => {
  if (newPeople.length > 0 && formData.type === 1) {
    // Для типа 1 загружаем средства после загрузки людей
    loadAvailableThings()
  }
})

// Обработка отправки формы
const handleSubmit = async () => {
  try {
    isSubmitting.value = true

    // Валидация в зависимости от типа
    let isValid = true
    let errorMessage = ''

    if (!formData.date || !formData.type || formData.things.length === 0) {
      isValid = false
      errorMessage = 'Пожалуйста, заполните все обязательные поля'
    } else if (formData.type === 1 && !formData.to) {
      isValid = false
      errorMessage = 'Пожалуйста, укажите сотрудника, принимающего средства'
    } else if (formData.type === 2 && (!formData.from || !formData.to)) {
      isValid = false
      errorMessage = 'Пожалуйста, укажите сотрудника, передающего средства и сотрудника, принимающего средства'
    } else if (formData.type === 3 && !formData.from) {
      isValid = false
      errorMessage = 'Пожалуйста, укажите сотрудника, списывающего средства'
    }

    if (!isValid) {
      alert(errorMessage)
      return
    }

    // Подготовка данных для отправки
    const dataToSend = {
      date: formData.date,
      type: parseInt(formData.type),
      from: formData.type === 1 ? null : parseInt(formData.from),
      to: formData.type === 3 ? null : parseInt(formData.to), // Для типа 3 to = null
      things: formData.things // Просто массив ID
    }

    console.log('Отправляемые данные:', dataToSend)

    // Отправка данных на сервер
    const response = await axios.post(
        BACKEND_URL + '/api/transfer-acts',
        dataToSend,
        {
          headers: {
            'Content-Type': 'application/json',
          }
        }
    )

    if (response.data && response.data.success) {
      alert('Акт успешно создан!')
      router.push('/things/transfer-acts')
    } else {
      throw new Error(response.data?.message || 'Ошибка при создании акта')
    }

  } catch (error) {
    console.error('Ошибка при создании акта:', error)

    let errorMessage = 'Произошла ошибка при создании акта'

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
</script>

<style scoped>
.line-clamp-1 {
  overflow: hidden;
  display: -webkit-box;
  -webkit-box-orient: vertical;
  -webkit-line-clamp: 1;
}
</style>