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

      <!-- Индикатор загрузки -->
      <div v-if="isLoading" class="flex justify-center items-center h-64">
        <div class="text-gray-600">Загрузка данных...</div>
      </div>

      <div v-else-if="error" class="bg-red-50 border border-red-200 rounded-lg p-4">
        <div class="flex items-center">
          <svg class="w-5 h-5 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span class="text-red-800">{{ error }}</span>
        </div>
      </div>

      <!-- Основная информация -->
      <div v-if="!isLoading && thing && !error" class="bg-white shadow-lg border border-gray-200 p-6 mb-6">
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
      <div v-if="!isLoading && thing && !error" class="bg-white shadow-lg border border-gray-200 p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-6 pb-2 border-b border-gray-200">
          Классификация и состояние
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Тип предмета</div>
            <div class="flex items-center gap-2">
              <div :class="getTypeColor(thing?.thing_type_id)" class="w-8 h-8 rounded-full flex items-center justify-center text-white">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                </svg>
              </div>
              <div class="text-lg text-gray-900">{{ getTypeLabel(thing?.thing_type_id) || 'Не указан' }}</div>
            </div>
          </div>

          <!-- Характеристика учёта -->
          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Характеристика учёта</div>
            <div class="flex items-center gap-2">
              <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
              </div>
              <div class="text-lg text-gray-900">{{ getBalanceLabel(thing?.balance) || 'Не указано' }}</div>
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
              <div :class="getConditionColor(thing?.condition)" class="w-8 h-8 rounded-full flex items-center justify-center text-white">
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

      <!-- Расположение (кабинет и этаж) -->
      <div v-if="!isLoading && thing && !error" class="bg-white shadow-lg border border-gray-200 p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-6 pb-2 border-b border-gray-200">
          Расположение
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Кабинет размещения</div>
            <div class="flex items-center gap-2">
              <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
              </div>
              <div class="text-lg font-semibold text-gray-900">
                {{ getAuditoriumName(thing?.auditorium_id) || 'Не указан' }}
              </div>
            </div>
          </div>

          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Этаж</div>
            <div class="flex items-center gap-2">
              <div class="w-8 h-8 bg-blue-50 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
              </div>
              <div class="text-lg text-gray-900">
                {{ getAuditoriumFloor(thing?.auditorium_id) || 'Не указан' }}
              </div>
            </div>
          </div>

          <!-- Отдел кабинета -->
          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Отдел</div>
            <div class="flex items-center gap-2">
              <div :class="getBranchColor(currentAuditorium?.branch_id)" class="w-8 h-8 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
              </div>
              <div class="text-lg text-gray-900">
                {{ getBranchName(currentAuditorium?.branch_id) || 'Не указан' }}
              </div>
            </div>
          </div>

          <!-- Назначение кабинета -->
          <div>
            <div class="text-sm font-medium text-gray-500 mb-1">Назначение кабинета</div>
            <div class="flex items-center gap-2">
              <div class="w-8 h-8 bg-teal-100 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                </svg>
              </div>
              <div class="text-lg text-gray-900">
                {{ getAuditoriumComment(thing?.auditorium_id) || 'Не указано' }}
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- История перемещений -->
      <div v-if="!isLoading && thing && !error" class="bg-white shadow-lg border border-gray-200 p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-6 pb-2 border-b border-gray-200 flex items-center justify-between">
          <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            История перемещений
          </div>
          <span v-if="historyLoading" class="text-sm text-gray-500">Загрузка...</span>
        </h2>

        <!-- Индикатор загрузки истории -->
        <div v-if="historyLoading" class="flex justify-center items-center py-8">
          <div class="text-gray-600">Загрузка истории...</div>
        </div>

        <!-- Сообщение об ошибке загрузки истории -->
        <div v-else-if="historyError" class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
          <div class="flex items-center">
            <svg class="w-5 h-5 text-yellow-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-yellow-800">{{ historyError }}</span>
          </div>
        </div>

        <!-- Таблица истории -->
        <div v-else-if="historyItems.length > 0" class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Дата
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                От кого
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Кому
              </th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="(item, index) in historyItems" :key="item.id"
                :class="{ 'bg-gray-50': index % 2 === 0 }">
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                {{ formatDate(item.date) }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                <div v-if="item.from">
                  <div class="font-medium">{{ getPersonName(item.from) }}</div>
                </div>
                <span v-else class="text-gray-400 italic">-</span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                <div v-if="item.to">
                  <div class="font-medium">{{ getPersonName(item.to) }}</div>

                </div>
                <span v-else class="text-gray-400 italic">-</span>
              </td>
            </tr>
            </tbody>
          </table>
        </div>

        <!-- Пустая история -->
        <div v-else class="text-center py-8 text-gray-500">
          <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <p>История перемещений отсутствует</p>
        </div>
      </div>

      <!-- Комментарий -->
      <div v-if="!isLoading && thing && !error && thing?.comment" class="bg-white shadow-lg border border-gray-200 p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Дополнительная информация</h2>

        <div>
          <div class="text-sm font-medium text-gray-500 mb-2">Комментарий</div>
          <div class="bg-gray-50 p-4 border border-gray-200 rounded-lg">
            <div class="text-gray-700 whitespace-pre-line">{{ thing.comment }}</div>
          </div>
        </div>
      </div>

      <!-- Файлы -->
      <!-- Файлы -->
      <!-- Файлы -->
      <div class="bg-white rounded-2xl shadow-lg border overflow-hidden">
        <div class="p-6">

          <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-900">Файлы</h2>

            <div class="flex items-center gap-4">

              <input
                  ref="fileInput"
                  type="file"
                  class="hidden"
                  @change="handleFileUpload"
              />

              <button
                  @click="triggerFileSelect"
                  class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition"
              >
                Выбрать файл
              </button>

              <span v-if="selectedFileName" class="text-sm text-gray-600 truncate max-w-xs">
          {{ selectedFileName }}
        </span>

            </div>
          </div>


          <div v-if="files.length === 0" class="text-gray-500">
            Файлы отсутствуют
          </div>


          <!-- ИЗОБРАЖЕНИЯ -->

          <div v-if="images.length" class="mb-8">

            <h3 class="text-lg font-semibold text-gray-800 mb-4">
              Изображения
            </h3>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">

              <div
                  v-for="file in images"
                  :key="file.id"
                  class="relative group border rounded-lg overflow-hidden bg-gray-50"
              >

                <a
                    :href="getFileUrl(file.file_id)"
                    :download="file.filename"
                >
                  <img
                      :src="getFileUrl(file.file_id)"
                      class="w-full h-32 object-cover transition group-hover:scale-105"
                  />
                </a>

                <div class="p-2 text-xs text-gray-600 truncate">
                  {{ file.filename }}
                </div>

                <button
                    @click="deleteFile(file)"
                    class="absolute top-2 right-2 bg-white/90 text-red-600 hover:text-red-800 text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition"
                >
                  Удалить
                </button>

              </div>

            </div>

          </div>


          <!-- ДОКУМЕНТЫ -->

          <div v-if="documents.length">

            <h3 class="text-lg font-semibold text-gray-800 mb-4">
              Документы
            </h3>

            <div class="space-y-3">

              <div
                  v-for="file in documents"
                  :key="file.id"
                  class="flex items-center justify-between border rounded-lg p-3 hover:bg-gray-50 transition"
              >

                <a
                    :href="getFileUrl(file.file_id)"
                    target="_blank"
                    class="text-blue-600 hover:underline truncate"
                >
                  {{ file.filename }}
                </a>

                <button
                    @click="deleteFile(file)"
                    class="text-red-600 hover:text-red-800"
                >
                  Удалить
                </button>

              </div>

            </div>

          </div>

        </div>

        <div v-if="successMessage" class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg">
          <div class="flex items-center">
            <svg class="w-5 h-5 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span class="text-green-700">{{ successMessage }}</span>
          </div>
        </div>

      </div>
      <!-- Файлы -->
      <!-- Файлы -->
      <!-- Файлы -->

      <!-- Действия -->
      <div v-if="!isLoading && thing && !error" class="mt-8 flex items-center justify-between bg-white shadow-lg border border-gray-200 p-6">
        <div class="text-sm text-gray-500">
        </div>

        <div class="flex items-center gap-3">
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
import { ref, computed, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'
import { BACKEND_URL, FILES_URL } from '@/router.js'
import {createFile, createFilePHP, DeleteFile, DeleteFilePHP, GetFilesListPHP} from "@/requests/FilesRequest.js";

const route = useRoute()
const router = useRouter()

// Данные
const thing = ref(null)
const auditoriums = ref([])
const branches = ref({})
const people = ref({}) // Словарь для хранения информации о людях
const isLoading = ref(true)

const successMessage = ref('')
const error = ref(null)
const conditionsMap = ref({})
const typeMap = ref({})
const balanceTypes = ref({})

// Данные истории
const historyItems = ref([])
const historyLoading = ref(false)
const historyError = ref(null)

// Данные Файлов
const files = ref([])

const images = computed(() => {
  return files.value.filter(f => isImage(f.filename))
})

const documents = computed(() => {
  return files.value.filter(f => !isImage(f.filename))
})

// Вычисляемое свойство для текущей аудитории
const currentAuditorium = computed(() => {
  if (!thing.value?.auditorium_id) return null
  return auditoriums.value.find(a => a.id === thing.value.auditorium_id)
})

// Загрузка данных при монтировании
onMounted(async () => {
  await Promise.all([
    loadThingData(),
    loadConditions(),
    loadAuditoriums(),
    loadBalanceTypes(),
    loadBranches(),
    loadHistory(),// Загружаем историю
    loadFiles()
  ])
})

// Загрузка данных о файлах связанных с предметом
const loadFiles = async () => {
  const actId = route.params.id
  try {
    const filesRes = await GetFilesListPHP('things', actId)

    if (filesRes.data && filesRes.data.success) {
      files.value = filesRes.data.data
    } else {
      files.value = []
    }
  } catch (err) {
    files.value = []
    // Пробрасываем ошибку дальше, чтобы вызывающий код мог среагировать
    throw err
  }
}


// Загрузка данных предмета
const loadThingData = async () => {
  try {
    isLoading.value = true
    error.value = null
    const thingId = route.params.id

    const response = await axios.get(`${BACKEND_URL}/api/things/${thingId}`)
    const data = response.data

    if (data.success && data.data) {
      thing.value = data.data
    } else {
      throw new Error(data.message || 'Данные не найдены')
    }

  } catch (err) {
    if (err.response) {
      if (err.response.status === 404) {
        error.value = 'Предмет не найден'
      } else {
        error.value = `Ошибка сервера: ${err.response.status}`
      }
    } else if (err.request) {
      error.value = 'Нет ответа от сервера. Проверьте подключение.'
    } else {
      error.value = err.message || 'Не удалось загрузить данные предмета.'
    }
  } finally {
    isLoading.value = false
  }


}


const fileInput = ref(null)
const selectedFileName = ref('')

const triggerFileSelect = () => {
  fileInput.value.click()
}

const handleFileUpload = async (event) => {
  const file = event.target.files[0]
  if (!file) return

  selectedFileName.value = file.name

  try {
    const formData = new FormData()
    formData.append('file', file)

    const goRes = await createFile(formData)

    await createFilePHP({
      table_name: 'things',
      row_id: thing.value.id,
      file_id: goRes.data.data.file_id,
      filename: goRes.data.data.original_name
    })

    successMessage.value = 'Файл загружен'
    await loadFiles()

  } catch (err) {
    console.log(err)
    error.value = 'Ошибка загрузки файла'
  }
}

const deleteFile = async (file) => {
  if (!confirm('Удалить файл?')) return

  try {
    // 1. удаляем связь в PHP
    await DeleteFilePHP(file.id)

    // 2. удаляем физически из Go-сервиса
    await DeleteFile(file.file_id)

    successMessage.value = 'Файл удалён'
    await loadFiles()

  } catch {
    error.value = 'Ошибка удаления файла'
  }
}

const isImage = (filename) => {
  return /\.(jpg|jpeg|png|gif|webp)$/i.test(filename)
}

const getFileUrl = (fileId) => {
  return FILES_URL + '/' + fileId
}


// Загрузка истории перемещений
const loadHistory = async () => {
  try {
    historyLoading.value = true
    historyError.value = null
    const thingId = route.params.id

    const response = await axios.get(`${BACKEND_URL}/api/things/${thingId}/history`)
    const data = response.data

    if (data.success && data.data) {
      historyItems.value = data.data.sort((a, b) => new Date(b.date) - new Date(a.date))

      // Собираем все ID людей из истории
      const personIds = new Set()
      historyItems.value.forEach(item => {
        if (item.from) personIds.add(item.from)
        if (item.to) personIds.add(item.to)
      })

      // Загружаем информацию о людях
      await loadPeople([...personIds])
    } else {
      historyItems.value = []
    }
  } catch (err) {
    if (err.response?.status === 404) {
      historyItems.value = []
    } else {
      historyError.value = 'Не удалось загрузить историю перемещений'
    }
  } finally {
    historyLoading.value = false
  }
}

// Загрузка информации о людях
const loadPeople = async (personIds) => {
  if (!personIds.length) return

  try {
    // Загружаем весь список людей
    const response = await axios.get(`${BACKEND_URL}/api/people`)
    const data = response.data

    if (data.success && data.data) {
      // Создаем словарь для быстрого доступа по ID
      const peopleMap = {}
      data.data.forEach(person => {
        peopleMap[person.id] = person
      })
      people.value = peopleMap
    }
  } catch (err) {
    console.error('Ошибка загрузки списка людей:', err)
    // В случае ошибки создаем заглушки только для нужных ID
    const fallbackPeople = {}
    personIds.forEach(id => {
      fallbackPeople[id] = { id, full_name: `Пользователь ${id}` }
    })
    people.value = fallbackPeople
  }
}

// Получение имени человека по ID
const getPersonName = (personId) => {
  if (!personId) return 'Не указан'

  const person = people.value[personId]
  if (!person) return `ID: ${personId}`

  // Формируем ФИО из полей firstname, surname, patronymic
  const parts = []
  if (person.surname) parts.push(person.surname)
  if (person.firstname) parts.push(person.firstname)
  if (person.patronymic) parts.push(person.patronymic)

  const fullName = parts.join(' ').trim()
  return fullName || `Пользователь ${personId}`
}

// Загрузка характеристик учёта
const loadBalanceTypes = async () => {
  try {
    const response = await axios.get(`${BACKEND_URL}/api/info/balance`)
    const data = response.data

    if (data.success) {
      balanceTypes.value = data.types || {}
    }
  } catch (err) {
    balanceTypes.value = staticBalances
  }
}

// Загрузка аудиторий с комментариями и отделами
const loadAuditoriums = async () => {
  try {
    const response = await axios.get(`${BACKEND_URL}/api/auditoriums`)
    const data = response.data

    if (data.success && data.data) {
      auditoriums.value = data.data
    }
  } catch (err) {
    auditoriums.value = []
  }
}

// Загрузка отделов
const loadBranches = async () => {
  try {
    const response = await axios.get(`${BACKEND_URL}/api/info/branches`)
    const data = response.data

    if (data.success) {
      const branchesData = {}
      data.data.forEach(branch => {
        branchesData[branch.id] = branch.name
      })
      branches.value = branchesData
    }
  } catch (err) {
    branches.value = {}
  }
}

// Загружаем условия и типы
const loadConditions = async () => {
  try {
    const response = await axios.get(`${BACKEND_URL}/api/info/thing-types`)
    const data = response.data

    if (data.success) {
      typeMap.value = data.types || {}
      conditionsMap.value = data.conditions || {}
    }
  } catch (err) {
    conditionsMap.value = staticConditions
    typeMap.value = {}
  }
}

// Получение названия кабинета по ID
const getAuditoriumName = (auditoriumId) => {
  if (!auditoriumId) return 'Не указан'

  const auditorium = auditoriums.value.find(a => a.id === auditoriumId)
  return auditorium ? auditorium.name : `ID: ${auditoriumId}`
}

// Получение этажа кабинета
const getAuditoriumFloor = (auditoriumId) => {
  if (!auditoriumId) return 'Не указан'

  const auditorium = auditoriums.value.find(a => a.id === auditoriumId)
  if (!auditorium || auditorium.floor === undefined || auditorium.floor === null) {
    return 'Не указан'
  }

  const floor = parseInt(auditorium.floor)
  const lastDigit = floor % 10
  const lastTwoDigits = floor % 100

  if (lastTwoDigits >= 11 && lastTwoDigits <= 19) {
    return `${floor} этаж`
  }

  switch (lastDigit) {
    case 1:
      return `${floor} этаж`
    case 2:
    case 3:
    case 4:
      return `${floor} этажа`
    default:
      return `${floor} этаж`
  }
}

// Получение комментария кабинета
const getAuditoriumComment = (auditoriumId) => {
  if (!auditoriumId) return 'Не указано'

  const auditorium = auditoriums.value.find(a => a.id === auditoriumId)
  return auditorium?.comment || 'Не указано'
}

// Получение названия отдела
const getBranchName = (branchId) => {
  if (!branchId) return 'Не указан'
  return branches.value[branchId] || `Отдел ${branchId}`
}

// Цвет для отдела
const getBranchColor = (branchId) => {
  if (!branchId) return 'bg-gray-400'

  const branchColors = {
    1: 'bg-gradient-to-br from-purple-500 to-purple-600',
    2: 'bg-gradient-to-br from-green-500 to-green-600',
    3: 'bg-gradient-to-br from-blue-500 to-blue-600',
    4: 'bg-gradient-to-br from-red-500 to-red-600',
    5: 'bg-gradient-to-br from-orange-500 to-orange-600',
    6: 'bg-gradient-to-br from-teal-500 to-teal-600',
    7: 'bg-gradient-to-br from-cyan-500 to-cyan-600',
    8: 'bg-gradient-to-br from-pink-500 to-pink-600',
    9: 'bg-gradient-to-br from-yellow-500 to-yellow-600',
    10: 'bg-gradient-to-br from-indigo-500 to-indigo-600',
    11: 'bg-gradient-to-br from-gray-500 to-gray-600',
    12: 'bg-gradient-to-br from-purple-500 to-purple-600',
    13: 'bg-gradient-to-br from-purple-500 to-purple-600',
    14: 'bg-gradient-to-br from-purple-500 to-purple-600',
    15: 'bg-gradient-to-br from-lime-500 to-lime-600',
    16: 'bg-gradient-to-br from-emerald-500 to-emerald-600',
    17: 'bg-gradient-to-br from-purple-500 to-purple-600',
    18: 'bg-gradient-to-br from-violet-500 to-violet-600',
    19: 'bg-gradient-to-br from-amber-500 to-amber-600',
    20: 'bg-gradient-to-br from-rose-500 to-rose-600'
  }

  return branchColors[branchId] || 'bg-gradient-to-br from-gray-400 to-gray-500'
}

// Получение метки характеристики учёта
const getBalanceLabel = (balanceId) => {
  if (balanceId === null || balanceId === undefined) return 'Не указано'

  if (Object.keys(balanceTypes.value).length > 0) {
    return balanceTypes.value[balanceId] || `Характеристика ${balanceId}`
  }
  return staticBalances[balanceId] || `Характеристика ${balanceId}`
}

// Методы форматирования
const formatDate = (dateString) => {
  if (!dateString) return ''
  try {
    return new Date(dateString).toLocaleDateString('ru-RU')
  } catch (e) {
    return dateString
  }
}

const formatCurrency = (amount) => {
  if (!amount && amount !== 0) return ''
  return new Intl.NumberFormat('ru-RU', {
    style: 'currency',
    currency: 'RUB',
    minimumFractionDigits: 2
  }).format(amount)
}

const getYearsInUse = (dateString) => {
  if (!dateString) return ''
  try {
    const now = new Date()
    const date = new Date(dateString)
    const years = now.getFullYear() - date.getFullYear()
    return years === 0 ? '<1 года' : `${years} ${getYearsText(years)}`
  } catch (e) {
    return ''
  }
}

const getYearsText = (years) => {
  if (years % 10 === 1 && years % 100 !== 11) return 'год'
  if ([2, 3, 4].includes(years % 10) && ![12, 13, 14].includes(years % 100)) return 'года'
  return 'лет'
}

// Метки для состояния
const getConditionLabel = (conditionId) => {
  if (conditionId === null || conditionId === undefined) return 'Не указано'

  if (Object.keys(conditionsMap.value).length > 0) {
    return conditionsMap.value[conditionId] || `Состояние ${conditionId}`
  }

  return staticConditions[conditionId] || `Состояние ${conditionId}`
}

const getConditionColor = (conditionId) => {
  if (conditionId === null || conditionId === undefined) return 'bg-gray-400'

  const colors = {
    1: 'bg-green-500',
    2: 'bg-red-500',
    3: 'bg-purple-400',
    4: 'bg-green-500',
    5: 'bg-green-400',
    6: 'bg-blue-400',
    7: 'bg-yellow-400',
    8: 'bg-orange-400',
  }

  return colors[conditionId] || 'bg-gray-400'
}

const getTypeLabel = (typeId) => {
  if (typeId === null || typeId === undefined) return 'Не указан'

  if (typeof typeId === 'string') {
    return typeId
  }

  if (Object.keys(typeMap.value).length > 0) {
    return typeMap.value[typeId] || `Тип ${typeId}`
  }

  return `Тип ${typeId}`
}

const getTypeColor = (typeId) => {
  if (typeId === null || typeId === undefined) return 'bg-gray-400'

  const colors = {
    1: 'bg-blue-500',
    2: 'bg-emerald-500',
    3: 'bg-purple-500',
    4: 'bg-amber-500',
    5: 'bg-red-500',
    6: 'bg-gray-500'
  }

  return colors[typeId] || 'bg-gray-400'
}

// Обработчики действий
const handleEdit = () => {
  router.push(`/things/edit/${route.params.id}`)
}

const handlePrint = () => {
  window.print()
}

const handleDelete = async () => {
  if (!confirm('Вы уверены, что хотите удалить этот предмет? Это действие нельзя отменить.')) {
    return
  }

  try {
    const thingId = route.params.id
    const response = await axios.delete(`${BACKEND_URL}/api/things/${thingId}`, {
      headers: {
        'Content-Type': 'application/json',
      }
    })

    const data = response.data
    if (data.success) {
      alert('Предмет успешно удален')
      router.push('/things/things')
    } else {
      throw new Error(data.message || 'Ошибка при удалении')
    }
  } catch (err) {
    let errorMessage = 'Не удалось удалить предмет'
    if (err.response) {
      errorMessage += `: ${err.response.status}`
      if (err.response.data?.message) {
        errorMessage += ` - ${err.response.data.message}`
      }
    } else if (err.message) {
      errorMessage += `: ${err.message}`
    }

    alert(errorMessage)
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