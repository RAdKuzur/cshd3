<template>
  <div class="p-6 bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <div class="max-w-7xl mx-auto">

      <!-- Заголовок -->
      <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Акты передачи материальных ценностей</h1>
        <p class="text-gray-600 mt-2">
          Всего актов: {{ filteredActs.length }}
        </p>
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
            <th class="px-6 py-4 text-left text-sm text-white">Тип акта</th>
            <th class="px-6 py-4 text-left text-sm text-white">От кого</th>
            <th class="px-6 py-4 text-left text-sm text-white">Кому</th>
            <th class="px-6 py-4 text-left text-sm text-white">Дата</th>
<!--            <th class="px-6 py-4 text-left text-sm text-white">Статус</th>-->
            <th class="px-6 py-4 text-left text-sm text-white">Действия</th>
          </tr>
          </thead>

          <tbody class="divide-y">
          <tr
              v-for="act in paginatedActs"
              :key="act.id"
              class="hover:bg-indigo-50 transition"
          >
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
<!--            <td class="px-6 py-4">-->
<!--                <span-->
<!--                    :class="act.confirmed-->
<!--                    ? 'bg-green-100 text-green-700'-->
<!--                    : 'bg-yellow-100 text-yellow-700'"-->
<!--                    class="px-3 py-1 rounded-full text-sm font-medium"-->
<!--                >-->
<!--                  {{ act.confirmed ? 'Подтверждён' : 'Не подтверждён' }}-->
<!--                </span>-->
<!--            </td>-->

            <!-- Действия -->
            <td class="px-6 py-4">
              <router-link
                  :to="`/transfer-acts/view/${act.id}`"
                  class="text-indigo-600 hover:underline"
              >
                Просмотр
              </router-link>
            </td>
          </tr>
          </tbody>
        </table>

        <!-- Пусто -->
        <div v-if="filteredActs.length === 0"
             class="text-center py-12 text-gray-500">
          Ничего не найдено
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
                class="px-3 py-1 border rounded disabled:opacity-50"
            >
              Назад
            </button>

            <span>{{ currentPage }} / {{ totalPages }}</span>

            <button
                @click="nextPage"
                :disabled="currentPage === totalPages"
                class="px-3 py-1 border rounded disabled:opacity-50"
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

  const [actsRes, peopleRes, typesRes] = await Promise.all([
    axios.get(BACKEND_URL + '/api/transfer-acts/index'),
    axios.get(BACKEND_URL + '/api/people/index'),
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
      fromName: people.value[a.from] || '—',
      toName: people.value[a.to] || '—',
      type: a.type,
      typeLabel: actTypes.value[a.type] || `Тип ${a.type}`,
      confirmed: a.confirmed,
      time: a.time
    }))
  }

  isLoading.value = false
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
    new Date(date).toLocaleString('ru-RU')
</script>
