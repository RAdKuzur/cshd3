<template>
  <div class="p-6 bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <div class="max-w-7xl mx-auto">

      <!-- Заголовок и кнопка создания -->
      <div class="mb-6 flex justify-between items-center">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Акты передачи материальных ценностей</h1>
          <p class="text-gray-600 mt-2">
            Всего актов: {{ filteredActs.length }}
          </p>
        </div>

        <router-link
            to="transfer-acts/create"
            class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 flex items-center transition"
        >
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
          </svg>
          Создать акт
        </router-link>
      </div>

      <!-- Фильтры -->
      <div class="mb-6 flex flex-wrap gap-4">
        <!-- Поиск -->
        <input
            v-model="searchQuery"
            type="text"
            placeholder="Поиск по ФИО"
            class="flex-1 min-w-[300px] px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500"
        >

        <!-- Тип акта -->
        <select
            v-model="typeFilter"
            class="px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500"
        >
          <option value="">Все типы актов</option>
          <option
              v-for="(label, id) in actTypes"
              :key="id"
              :value="id"
          >
            {{ label }}
          </option>
        </select>

        <!-- Кнопка сброса фильтров -->
        <button
            @click="resetFilters"
            class="px-4 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50"
        >
          Сбросить фильтры
        </button>
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

      <!-- Таблица -->
      <div v-else class="bg-white rounded-2xl shadow-lg border overflow-hidden">
        <table class="w-full">
          <thead class="bg-gradient-to-r from-indigo-500 to-purple-600">
          <tr>
            <th class="px-6 py-4 text-left text-sm text-white">ID</th>
            <th class="px-6 py-4 text-left text-sm text-white">Тип акта</th>
            <th class="px-6 py-4 text-left text-sm text-white">От кого</th>
            <th class="px-6 py-4 text-left text-sm text-white">Кому</th>
            <th class="px-6 py-4 text-left text-sm text-white">Дата</th>
            <th class="px-6 py-4 text-left text-sm text-white">Статус</th>
            <th class="px-6 py-4 text-left text-sm text-white">Действия</th>
          </tr>
          </thead>

          <tbody class="divide-y">
          <tr
              v-for="act in paginatedActs"
              :key="act.id"
              class="hover:bg-indigo-50 transition"
          >
            <!-- ID -->
            <td class="px-6 py-4 font-mono text-sm">
              #{{ act.id }}
            </td>

            <!-- Тип -->
            <td class="px-6 py-4 font-medium">
              {{ act.typeLabel }}
            </td>

            <!-- От -->
            <td class="px-6 py-4">
              {{ act.fromName }}
            </td>

            <!-- Кому -->
            <td class="px-6 py-4">
              {{ act.toName }}
            </td>

            <!-- Дата -->
            <td class="px-6 py-4">
              {{ formatDate(act.time) }}
            </td>

            <!-- Статус -->
            <td class="px-6 py-4">
                <span
                    :class="act.confirmed
                    ? 'bg-green-100 text-green-700'
                    : 'bg-yellow-100 text-yellow-700'"
                    class="px-3 py-1 rounded-full text-sm font-medium"
                >
                  {{ act.confirmed ? 'Подтверждён' : 'Не подтверждён' }}
                </span>
            </td>

            <!-- Действия -->
            <td class="px-6 py-4">
              <div class="flex gap-3">
                <router-link
                    :to="`transfer-acts/view/${act.id}`"
                    class="text-indigo-600 hover:text-indigo-800 flex items-center"
                    title="Просмотр"
                >
                  <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                  </svg>
                  Просмотр
                </router-link>

                <router-link
                    :to="`transfer-acts/edit/${act.id}`"
                    class="text-green-600 hover:text-green-800 flex items-center"
                    title="Редактировать"
                >
                  <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                  </svg>
                  Редактировать
                </router-link>
              </div>
            </td>
          </tr>
          </tbody>
        </table>

        <!-- Пусто -->
        <div v-if="filteredActs.length === 0"
             class="text-center py-12 text-gray-500">
          <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
          </svg>
          <h3 class="mt-2 text-sm font-medium text-gray-900">Нет актов</h3>
          <p class="mt-1 text-sm text-gray-500">Начните с создания нового акта передачи.</p>
          <div class="mt-6">
            <router-link
                to="transfer-acts/create"
                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700"
            >
              <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
              </svg>
              Создать акт
            </router-link>
          </div>
        </div>

        <!-- Пагинация -->
        <div class="px-6 py-4 border-t bg-gray-50 flex justify-between items-center">
          <div class="text-sm text-gray-600">
            Показано {{ startIndex }}–{{ endIndex }} из {{ filteredActs.length }}
          </div>

          <div class="flex items-center gap-2">
            <button
                @click="prevPage"
                :disabled="currentPage === 1"
                class="px-3 py-1 border rounded disabled:opacity-50 hover:bg-gray-50"
            >
              Назад
            </button>

            <span>{{ currentPage }} / {{ totalPages }}</span>

            <button
                @click="nextPage"
                :disabled="currentPage === totalPages"
                class="px-3 py-1 border rounded disabled:opacity-50 hover:bg-gray-50"
            >
              Вперёд
            </button>
          </div>
        </div>
      </div>

    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue'
import axios from 'axios'
import { BACKEND_URL } from '@/router.js'

const isLoading = ref(false)

const acts = ref([])
const people = ref({})
const actTypes = ref({})

// фильтры
const searchQuery = ref('')
const typeFilter = ref('')

// пагинация
const currentPage = ref(1)
const perPage = 10

const loadData = async () => {
  isLoading.value = true

  try {
    const [actsRes, peopleRes, typesRes] = await Promise.all([
      axios.get(BACKEND_URL + '/api/transfer-acts'),
      axios.get(BACKEND_URL + '/api/people'),
      axios.get(BACKEND_URL + '/api/info/transfer-acts/types')
    ])

    if (peopleRes.data.success) {
      people.value = Object.fromEntries(
          peopleRes.data.data.map(p => [
            p.id,
            `${p.surname} ${p.firstname}`
          ])
      )
    }

    if (typesRes.data.success) {
      actTypes.value = typesRes.data.data
    }

    if (actsRes.data.success) {
      acts.value = actsRes.data.data.map(a => ({
        id: a.id,
        from: a.from,
        to: a.to,
        fromName: people.value[a.from] || '—',
        toName: people.value[a.to] || '—',
        type: a.type,
        typeLabel: actTypes.value[a.type] || `Тип ${a.type}`,
        confirmed: a.confirmed,
        time: a.time
      }))
    }
  } catch (error) {
    console.error('Ошибка загрузки данных:', error)
  } finally {
    isLoading.value = false
  }
}

onMounted(loadData)

// фильтрация
const filteredActs = computed(() => {
  let list = acts.value

  if (searchQuery.value) {
    const q = searchQuery.value.toLowerCase()
    list = list.filter(a =>
        a.fromName.toLowerCase().includes(q) ||
        a.toName.toLowerCase().includes(q)
    )
  }

  if (typeFilter.value !== '') {
    list = list.filter(a => a.type === Number(typeFilter.value))
  }

  return list
})

// сброс фильтров
const resetFilters = () => {
  searchQuery.value = ''
  typeFilter.value = ''
  currentPage.value = 1
}

// пагинация
const totalPages = computed(() =>
    Math.ceil(filteredActs.value.length / perPage)
)

const paginatedActs = computed(() => {
  const start = (currentPage.value - 1) * perPage
  return filteredActs.value.slice(start, start + perPage)
})

const startIndex = computed(() =>
    filteredActs.value.length
        ? (currentPage.value - 1) * perPage + 1
        : 0
)

const endIndex = computed(() =>
    Math.min(currentPage.value * perPage, filteredActs.value.length)
)

const prevPage = () => currentPage.value > 1 && currentPage.value--
const nextPage = () => currentPage.value < totalPages.value && currentPage.value++

watch([searchQuery, typeFilter], () => {
  currentPage.value = 1
})

// utils
const formatDate = (date) =>
    date ? new Date(date).toLocaleString('ru-RU') : '—'
</script>