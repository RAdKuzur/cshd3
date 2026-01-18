<template>
  <div class="p-6 bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <div class="max-w-6xl mx-auto">
      <!-- Заголовок -->
      <div class="mb-8">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-3xl font-bold text-gray-900">Редактирование акта #{{ actId }}</h1>
            <p class="text-gray-600 mt-2">Внесите изменения в состав материальных средств акта</p>
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

      <!-- Загрузка -->
      <div v-if="isLoading" class="text-center py-12">
        <svg class="animate-spin h-12 w-12 text-indigo-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <p class="mt-4 text-gray-600">Загрузка данных...</p>
      </div>

      <!-- Форма редактирования -->
      <div v-else class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
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
          <div class="mb-8">
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
                    :required="formData.type === 2 || formData.type === 3"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
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
              </div>

              <!-- Кому (для типов 1 и 2) -->
              <div v-if="(formData.type === 1 || formData.type === 4 || formData.type === 5 ) || formData.type === 2">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Кому (принимает) *
                </label>
                <select
                    v-model.number="formData.to"
                    :required="(formData.type === 1 || formData.type === 4 || formData.type === 5 ) || formData.type === 2"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
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
                  <template v-if="(formData.type === 1 || formData.type === 4 || formData.type === 5 )">
                    Сотрудник, принимающий средства от учётного отдела
                  </template>
                  <template v-else-if="formData.type === 2">
                    Сотрудник, принимающий средства
                  </template>
                </p>
              </div>
            </div>
          </div>

          <!-- Материальные средства -->
          <div v-if="shouldShowThingsSection && !isLoadingThings" class="mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-6 pb-2 border-b border-gray-200">
              Материальные средства
              <span class="text-sm font-normal text-gray-600 ml-2">
                ({{ getThingsSectionDescription() }})
              </span>
            </h2>

            <!-- Поиск и фильтрация -->
            <div v-if="availableThings.length > 0" class="mb-6">
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
                    <span class="text-green-600">Выбрано: {{ selectedThingsCount }} шт.</span>
                    <span v-if="originallySelectedCount > 0" class="ml-2">
                      (было: {{ originallySelectedCount }})
                    </span>
                  </span>
                  <span class="mx-2">•</span>
                  <span class="text-sm text-gray-600">
                    <span class="text-red-600">Удалено: {{ deletedThingsCount }} шт.</span>
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

            <!-- Загрузка средств -->
            <div v-if="isLoadingThings" class="text-center py-12">
              <svg class="animate-spin h-8 w-8 text-indigo-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              <p class="mt-2 text-gray-600">Загрузка материальных средств...</p>
            </div>

            <!-- Пустой список -->
            <div v-else-if="availableThings.length === 0" class="text-center py-12 border-2 border-dashed border-gray-300 rounded-xl">
              <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
              </svg>
              <h3 class="text-lg font-medium text-gray-900 mb-2">Нет доступных средств</h3>
              <p class="text-gray-600 max-w-md mx-auto">
                <template v-if="(formData.type === 1 || formData.type === 4 || formData.type === 5 )">
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
                    'border rounded-xl p-4 cursor-pointer transition-all duration-200 relative',
                    getThingSelectionStatus(thing.id) === 'selected'
                      ? 'border-indigo-500 bg-indigo-50 ring-2 ring-indigo-200'
                      : getThingSelectionStatus(thing.id) === 'originally-selected'
                      ? 'border-green-500 bg-green-50 ring-1 ring-green-200'
                      : 'border-gray-200 hover:border-gray-300 hover:bg-gray-50'
                  ]"
              >
                <!-- Индикатор статуса -->
                <div v-if="getThingSelectionStatus(thing.id) === 'originally-selected'"
                     class="absolute -top-2 -right-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full">
                  Было
                </div>
                <div v-if="getThingSelectionStatus(thing.id) === 'deleted'"
                     class="absolute -top-2 -right-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                  Удалено
                </div>

                <div class="flex items-start gap-3">
                  <!-- Чекбокс -->
                  <div class="flex-shrink-0 mt-1">
                    <div :class="[
                      'w-5 h-5 rounded border flex items-center justify-center',
                      getThingSelectionStatus(thing.id) === 'selected' || getThingSelectionStatus(thing.id) === 'originally-selected'
                        ? 'bg-indigo-600 border-indigo-600'
                        : 'border-gray-300 bg-white'
                    ]">
                      <svg v-if="getThingSelectionStatus(thing.id) === 'selected' || getThingSelectionStatus(thing.id) === 'originally-selected'"
                           class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                      </svg>
                    </div>
                  </div>

                  <!-- Информация о средстве -->
                  <div class="flex-1">
                    <h3 class="font-medium text-gray-900 mb-1 line-clamp-1">{{ getThingName(thing) }}</h3>
                    <div class="space-y-1.5">
                      <div class="flex items-center gap-2 text-sm">
                        <span class="text-gray-500">Инв. №:</span>
                        <span class="font-medium">{{ getThingInvNumber(thing) }}</span>
                      </div>
                      <div class="flex items-center gap-2 text-sm">
                        <span class="text-gray-500">Тип:</span>
                        <span class="font-medium">{{ getThingTypeName(thing.thing_type_id || thing.type) }}</span>
                      </div>
                      <div class="flex items-center gap-2 text-sm">
                        <span class="text-gray-500">Дата ввода:</span>
                        <span class="font-medium">{{ formatDate(thing.operation_date) }}</span>
                      </div>
                      <div class="flex items-center gap-2 text-sm">
                        <span class="text-gray-500">Стоимость:</span>
                        <span class="font-medium text-indigo-600">{{ formatPrice(thing.price) }}</span>
                      </div>
                      <div v-if="getThingSerialNumber(thing)" class="flex items-center gap-2 text-sm">
                        <span class="text-gray-500">Серийный №:</span>
                        <span class="font-medium font-mono">{{ getThingSerialNumber(thing) }}</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Предупреждение о пустом акте -->
            <div v-if="selectedThingsCount === 0" class="mt-6 p-4 bg-red-50 border border-red-200 rounded-lg">
              <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.342 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
                <div>
                  <p class="text-sm font-medium text-red-800">Внимание: акт будет сохранен без материальных средств.</p>
                  <p class="mt-1 text-sm text-red-700">Все средства, которые были в акте, будут удалены.</p>
                </div>
              </div>
            </div>

            <!-- Статус изменений -->
            <div v-if="hasChanges && selectedThingsCount > 0" class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
              <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.342 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
                <div>
                  <p class="text-sm font-medium text-yellow-800">Есть несохранённые изменения:</p>
                  <ul class="mt-1 text-sm text-yellow-700 space-y-1">
                    <li v-if="newSelectedThingsCount > 0">• Добавлено новых средств: {{ newSelectedThingsCount }}</li>
                    <li v-if="deletedThingsCount > 0">• Удалено средств: {{ deletedThingsCount }}</li>
                  </ul>
                </div>
              </div>
            </div>

            <!-- Сводка изменений -->
            <div v-if="hasChanges && selectedThingsCount > 0" class="mt-6 space-y-4">
              <!-- Новые выбранные средства -->
              <div v-if="newSelectedThingsCount > 0">
                <h3 class="text-lg font-medium text-gray-900 mb-3 flex items-center gap-2">
                  <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                  </svg>
                  Новые средства для добавления ({{ newSelectedThingsCount }})
                </h3>
                <div class="space-y-2 max-h-[200px] overflow-y-auto">
                  <div
                      v-for="thing in newSelectedThings"
                      :key="thing.id"
                      class="bg-green-50 border border-green-200 rounded-lg p-3"
                  >
                    <div class="flex items-center justify-between">
                      <div>
                        <span class="font-medium text-gray-900">{{ getThingName(thing) }}</span>
                        <span class="text-sm text-gray-600 ml-2">(Инв. №: {{ getThingInvNumber(thing) }})</span>
                      </div>
                      <button
                          type="button"
                          @click="removeSelectedThing(thing.id)"
                          class="text-red-600 hover:text-red-800"
                          title="Отменить добавление"
                      >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Удалённые средства -->
              <div v-if="deletedThingsCount > 0">
                <h3 class="text-lg font-medium text-gray-900 mb-3 flex items-center gap-2">
                  <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                  Средства для удаления ({{ deletedThingsCount }})
                </h3>
                <div class="space-y-2 max-h-[200px] overflow-y-auto">
                  <div
                      v-for="thing in deletedThings"
                      :key="thing.id"
                      class="bg-red-50 border border-red-200 rounded-lg p-3"
                  >
                    <div class="flex items-center justify-between">
                      <div>
                        <span class="font-medium text-gray-900">{{ getThingName(thing) }}</span>
                        <span class="text-sm text-gray-600 ml-2">(Инв. №: {{ getThingInvNumber(thing) }})</span>
                      </div>
                      <button
                          type="button"
                          @click="restoreDeletedThing(thing.id)"
                          class="text-green-600 hover:text-green-800"
                          title="Восстановить"
                      >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                        </svg>
                      </button>
                    </div>
                  </div>
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
                type="button"
                @click="resetChanges"
                :disabled="!hasChanges"
                class="px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
            >
              Сбросить изменения
            </button>
            <button
                type="submit"
                :disabled="isSubmitting || isLoading || !formData.type || !formData.date || ((formData.type === 1 || formData.type === 4 || formData.type === 5 ) && !formData.to) || (formData.type === 2 && (!formData.from || !formData.to)) || (formData.type === 3 && !formData.from)"
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
                Сохранить изменения
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
import { useRouter, useRoute } from 'vue-router'
import axios from "axios"
import {BACKEND_URL} from "@/router.js"

const router = useRouter()
const route = useRoute()
const actId = route.params.id

// Данные формы
const formData = reactive({
  date: '',
  type: '',
  from: null,
  to: null,
  things: [] // будет содержать только массив ID выбранных вещей
})

// Массив всех вещей акта (полученные с /api/transfer-acts/things/{id})
const actThings = ref([])

// Динамические данные с сервера
const actTypes = ref({})
const people = ref([])
const availableThings = ref([]) // Все доступные средства для данного типа акта
const thingTypes = ref({})
const actDetails = ref(null)

// Состояние загрузки
const isLoading = ref(true)
const isLoadingPeople = ref(false)
const isLoadingThings = ref(false)
const isSubmitting = ref(false)

// Фильтры и поиск
const searchQuery = ref('')
const typeFilter = ref('')

// Вычисляемые свойства
const shouldShowThingsSection = computed(() => {
  if ((formData.type === 1 || formData.type === 4 || formData.type === 5 )) {
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
    filtered = filtered.filter(thing => {
      const name = getThingName(thing).toLowerCase()
      const invNumber = getThingInvNumber(thing).toLowerCase()
      const serialNumber = getThingSerialNumber(thing) || ''
      return name.includes(query) || invNumber.includes(query) || serialNumber.toLowerCase().includes(query)
    })
  }

  // Фильтрация по типу
  if (typeFilter.value) {
    filtered = filtered.filter(thing => {
      const type = thing.thing_type_id || thing.type
      return type == typeFilter.value
    })
  }

  return filtered
})

// Текущие выбранные средства
const selectedThingIds = computed(() => {
  return new Set(formData.things.map(id => parseInt(id)))
})

// Средства, которые уже были в акте изначально
const originalActThingIds = computed(() => {
  return new Set(actThings.value.map(thing => parseInt(thing.id)))
})

const selectedThingsCount = computed(() => selectedThingIds.value.size)

const originallySelectedCount = computed(() => originalActThingIds.value.size)

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

// Новые выбранные средства (которые не были в акте изначально)
const newSelectedThings = computed(() => {
  return selectedThings.value.filter(thing =>
      !originalActThingIds.value.has(parseInt(thing.id))
  )
})

const newSelectedThingsCount = computed(() => newSelectedThings.value.length)

// Удалённые средства (которые были в акте изначально, но теперь удалены)
const deletedThings = computed(() => {
  return actThings.value
      .filter(thing => !selectedThingIds.value.has(parseInt(thing.id)))
})

const deletedThingsCount = computed(() => deletedThings.value.length)

const hasChanges = computed(() => {
  // Если количество выбранных не равно количеству исходных - есть изменения
  if (selectedThingIds.value.size !== originalActThingIds.value.size) {
    return true
  }

  // Проверяем, что все ID совпадают
  const selectedArray = Array.from(selectedThingIds.value).sort()
  const originalArray = Array.from(originalActThingIds.value).sort()

  return JSON.stringify(selectedArray) !== JSON.stringify(originalArray)
})

// Загрузка данных при монтировании компонента
onMounted(async () => {
  await loadInitialData()
})

// Загрузка начальных данных
const loadInitialData = async () => {
  try {
    isLoading.value = true

    // 1. Сначала загружаем данные акта и его вещи
    await Promise.all([
      loadActData(),
      loadActThings()
    ])

    // 2. Затем загружаем все справочники
    await Promise.all([
      loadActTypes(),
      loadPeople(),
      loadThingTypes()
    ])

    // 3. Затем загружаем доступные средства
    await loadAvailableThings()

  } catch (error) {
    alert('Не удалось загрузить данные')
    router.push('/things/transfer-acts')
  } finally {
    isLoading.value = false
  }
}

// Загрузка данных акта
const loadActData = async () => {
  try {
    // Загружаем данные акта
    const response = await axios.get(`${BACKEND_URL}/api/transfer-acts/${actId}`)

    if (response.data && response.data.success) {
      actDetails.value = response.data.data

      // Заполняем форму данными акта
      formData.date = actDetails.value.date.split('T')[0] // Форматируем дату
      formData.type = parseInt(actDetails.value.type)

      // Обрабатываем from
      if (actDetails.value.from && typeof actDetails.value.from === 'object') {
        formData.from = parseInt(actDetails.value.from.id)
      } else {
        formData.from = actDetails.value.from ? parseInt(actDetails.value.from) : null
      }

      // Обрабатываем to
      if (actDetails.value.to && typeof actDetails.value.to === 'object') {
        formData.to = parseInt(actDetails.value.to.id)
      } else {
        formData.to = actDetails.value.to ? parseInt(actDetails.value.to) : null
      }

      // Инициализируем things пустым массивом - теперь они будут из actThings
      formData.things = []

    } else {
      throw new Error('Не удалось загрузить данные акта')
    }
  } catch (error) {
    alert('Не удалось загрузить данные акта')
    router.push('/things/transfer-acts')
  }
}

// Загрузка вещей акта
const loadActThings = async () => {
  try {
    const response = await axios.get(`${BACKEND_URL}/api/transfer-acts/things/${actId}`)

    if (response.data && response.data.success && Array.isArray(response.data.data)) {
      actThings.value = response.data.data

      // Заполняем formData.things ID вещей из акта
      formData.things = actThings.value.map(thing => parseInt(thing.id))

    } else {
      actThings.value = []
    }
  } catch (error) {
    actThings.value = []
  }
}

// Загрузка типов актов
const loadActTypes = async () => {
  try {
    const response = await axios.get(BACKEND_URL + '/api/info/transfer-acts/types')
    if (response.data.success) {
      actTypes.value = response.data.data || {}
    }
  } catch (error) {
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
  } finally {
    isLoadingPeople.value = false
  }
}

// Загрузка материальных средств
const loadAvailableThings = async () => {
  try {
    isLoadingThings.value = true

    let url = ''
    let thingsFromServer = []

    if ((formData.type === 1 || formData.type === 4 || formData.type === 5 )) {
      // Тип 1: свободные средства
      url = BACKEND_URL + '/api/things/free'
    } else if (formData.type === 2 || formData.type === 3) {
      // Типы 2 и 3: средства сотрудника "от кого"
      if (!formData.from) {
        availableThings.value = []
        return
      }
      url = BACKEND_URL + `/api/things/person/${formData.from}`
    }

    if (url) {
      const response = await axios.get(url)

      if (response.data.success && Array.isArray(response.data.data)) {
        thingsFromServer = response.data.data
      }
    }

    // Объединяем вещи из акта и доступные вещи
    const allThingsMap = new Map()

    // Сначала добавляем вещи из акта (важно сохранить их приоритет)
    actThings.value.forEach(thing => {
      allThingsMap.set(parseInt(thing.id), thing)
    })

    // Затем добавляем доступные вещи (если их еще нет в акте)
    thingsFromServer.forEach(thing => {
      const thingId = parseInt(thing.id)
      if (!allThingsMap.has(thingId)) {
        allThingsMap.set(thingId, thing)
      }
    })

    availableThings.value = Array.from(allThingsMap.values())

  } catch (error) {
    // В случае ошибки показываем хотя бы вещи из акта
    availableThings.value = [...actThings.value]
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
  }
}

// Получение описания секции средств
const getThingsSectionDescription = () => {
  if ((formData.type === 1 || formData.type === 4 || formData.type === 5 )) {
    return 'Свободные средства для передачи сотруднику'
  } else if (formData.type === 2) {
    return 'Средства сотрудника для передачи другому сотруднику'
  } else if (formData.type === 3) {
    return 'Средства сотрудника для списания'
  }
  return ''
}

// Универсальные геттеры для вещей
const getThingName = (thing) => {
  return thing.name || `Вещь #${thing.id}`
}

const getThingInvNumber = (thing) => {
  return thing.inv_number || `INV-${thing.id}`
}

const getThingSerialNumber = (thing) => {
  return thing.serial_number || null
}

// Получение названия типа акта
const getActTypeName = (typeId) => {
  return actTypes.value[typeId] || `Тип #${typeId}`
}

// Получение имени сотрудника по ID
const getPersonNameById = (personId) => {
  if (!personId) return '—'
  const person = people.value.find(p => parseInt(p.id) === parseInt(personId))
  return person ? getPersonFullName(person) : `Сотрудник #${personId}`
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

// Получение статуса выбора средства
const getThingSelectionStatus = (thingId) => {
  const id = parseInt(thingId)
  const isSelected = selectedThingIds.value.has(id)
  const wasInOriginalAct = originalActThingIds.value.has(id)

  if (isSelected && wasInOriginalAct) {
    return 'originally-selected' // Было в акте и осталось выбранным
  } else if (isSelected && !wasInOriginalAct) {
    return 'selected' // Новое выбранное
  } else if (!isSelected && wasInOriginalAct) {
    return 'deleted' // Было в акте, но теперь удалено
  }
  return 'none' // Не выбрано и не было в акте
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
    // Удаляем из текущих выбранных
    const index = formData.things.indexOf(id)
    if (index !== -1) {
      formData.things.splice(index, 1)
    }
  } else {
    // Добавляем в текущие выбранные
    if (!formData.things.includes(id)) {
      formData.things.push(id)
    }
  }
}

const toggleSelectAll = () => {
  const allFilteredSelected = filteredThings.value.every(thing =>
      selectedThingIds.value.has(parseInt(thing.id))
  )

  if (allFilteredSelected) {
    // Снимаем выбор со всех отфильтрованных
    filteredThings.value.forEach(thing => {
      const id = parseInt(thing.id)
      const index = formData.things.indexOf(id)
      if (index !== -1) {
        formData.things.splice(index, 1)
      }
    })
  } else {
    // Выбираем все отфильтрованные
    filteredThings.value.forEach(thing => {
      const id = parseInt(thing.id)
      if (!formData.things.includes(id)) {
        formData.things.push(id)
      }
    })
  }
}

const removeSelectedThing = (thingId) => {
  const id = parseInt(thingId)
  const index = formData.things.indexOf(id)
  if (index !== -1) {
    formData.things.splice(index, 1)
  }
}

const restoreDeletedThing = (thingId) => {
  const id = parseInt(thingId)
  if (!formData.things.includes(id)) {
    formData.things.push(id)
  }
}

const resetChanges = () => {
  // Восстанавливаем исходное состояние - все вещи из акта
  // Если акт изначально был пустой, делаем тоже пустой
  formData.things = [...originalActThingIds.value].map(id => id)
}

// Обработка отправки формы
const handleSubmit = async () => {
  try {
    isSubmitting.value = true

    // Валидация в зависимости от типа
    let isValid = true
    let errorMessage = ''

    // Убираем проверку formData.things.length === 0, так как можно сохранить пустой акт
    if (!formData.date || !formData.type) {
      isValid = false
      errorMessage = 'Пожалуйста, укажите дату и тип акта'
    } else if ((formData.type === 1 || formData.type === 4 || formData.type === 5 ) && !formData.to) {
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
    // Если акт пустой (ничего не выбрано), отправляем пустые массивы
    const newThings = selectedThingsCount.value === 0
        ? []
        : Array.from(selectedThingIds.value)
            .filter(id => !originalActThingIds.value.has(id))
            .map(id => parseInt(id))

    const deletedThings = selectedThingsCount.value === 0
        ? Array.from(originalActThingIds.value).map(id => parseInt(id)) // Удаляем все вещи из акта
        : Array.from(originalActThingIds.value)
            .filter(id => !selectedThingIds.value.has(id))
            .map(id => parseInt(id))

    // Формируем данные для PUT запроса
    const dataToSend = {
      date: formData.date,
      type: parseInt(formData.type),
      from: (formData.type === 1 || formData.type === 4 || formData.type === 5 ) ? null : parseInt(formData.from),
      to: formData.type === 3 ? null : parseInt(formData.to),
      things: newThings, // Новые выбранные средства
      deletedThings: deletedThings // Средства для удаления
    }


    // Отправка PUT запроса
    const response = await axios.put(
        `${BACKEND_URL}/api/transfer-acts/${actId}`,
        dataToSend,
        {
          headers: {
            'Content-Type': 'application/json',
          }
        }
    )

    if (response.data && response.data.success) {
      alert('Акт успешно обновлён!')
      router.push('/things/transfer-acts')
    } else {
      throw new Error(response.data?.message || 'Ошибка при обновлении акта')
    }

  } catch (error) {

    let errorMessage = 'Произошла ошибка при обновлении акта'

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

// Наблюдатели
watch(() => formData.type, (newType) => {
  if (newType && (newType === 2 || newType === 3)) {
    // Для типов 2 и 3 сбрасываем выбранные средства при изменении типа
    formData.things = []
    searchQuery.value = ''
    typeFilter.value = ''
  }
})

watch(() => formData.from, (newFrom) => {
  if (formData.type === 2 || formData.type === 3) {
    // При изменении "от кого" загружаем доступные средства
    loadAvailableThings()
  }
})
</script>

<style scoped>
.line-clamp-1 {
  overflow: hidden;
  display: -webkit-box;
  -webkit-box-orient: vertical;
  -webkit-line-clamp: 1;
}
</style>