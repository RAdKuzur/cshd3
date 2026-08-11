<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 bg-white">
    <div class="relative ">
      <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-2xl py-24 sm:py-32 lg:py-40">
          <div class="text-center">
            <div class="flex items-center justify-center mb-8">
              <div class="w-16 h-16 bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl flex items-center justify-center mr-4">
                <ScaleIcon class="w-8 h-8 text-white" />
              </div>
              <div class="text-left">
                <h1 class="text-2xl font-bold text-gray-900">Московский областной суд</h1>
              </div>
            </div>
            <h2 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">
              Единая система управления
            </h2>
            <p class="mt-6 text-lg leading-8 text-gray-600">
              Комплексное решение для автоматизации учета основных средств,
              управления кадрами и документооборота Московского областного суда
            </p>
            <div class="mt-10 flex items-center justify-center gap-x-6">
              <router-link to="/login">
                <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-semibold shadow-sm transition-colors">
                  Перейти в систему
                </button>
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Таблицы с данными -->
    <div class="mx-auto max-w-7xl px-6 lg:px-8 pb-24">
      <div v-if="loading" class="flex justify-center items-center py-12">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"></div>
      </div>

      <div v-else-if="error" class="text-center py-12 text-red-600">
        {{ error }}
      </div>

      <div v-else-if="!groupedByCategory || Object.keys(groupedByCategory).length === 0" class="text-center py-12 text-gray-500">
        Нет данных для отображения
      </div>

      <div v-else>
        <!-- Сводная таблица -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
          <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-900">Сводная ведомость</h3>
          </div>
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16 border-r border-gray-200">
                  №
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[200px] border-r border-gray-200">
                  Наименование
                </th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Количество (общее по всем годам и типам)
                </th>
              </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
              <tr
                  v-for="(categoryData, categoryName, index) in groupedByCategory"
                  :key="categoryName"
                  class="hover:bg-gray-50 transition-colors"
              >
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-r border-gray-200">
                  {{ index + 1 }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-900 border-r border-gray-200">
                  {{ categoryName }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-bold text-indigo-600">
                  {{ categoryData.mainTotal + categoryData.freeTotal }}
                </td>
              </tr>
              <!-- Итоговая строка -->
              <tr class="bg-blue-50 font-semibold">
                <td class="px-6 py-4 whitespace-nowrap text-sm border-r border-gray-200" colspan="2">
                  ВСЕГО:
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-indigo-700 font-bold text-lg">
                  {{ getTotalAll() }}
                </td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Для каждого наименования создаем отдельную таблицу -->
        <div
            v-for="(categoryData, categoryName) in groupedByCategory"
            :key="categoryName"
            class="bg-white rounded-lg shadow-lg overflow-hidden mb-8 last:mb-0"
        >
          <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-900">{{ categoryName }}</h3>
          </div>

          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
              <!-- Первая строка шапки - группы лет -->
              <tr>
                <th
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16 border-r border-gray-200"
                    rowspan="2"
                >
                  №
                </th>
                <th
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[200px] border-r border-gray-200"
                    rowspan="2"
                >
                  Наименование
                </th>
                <th
                    v-for="group in yearGroups"
                    :key="group.label"
                    :colspan="group.years.length"
                    class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-x border-gray-200"
                    :style="{ backgroundColor: group.color }"
                >
                  {{ group.label }}
                </th>
                <th
                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider font-bold"
                    rowspan="2"
                >
                  Итого
                </th>
                <th
                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider font-bold"
                    rowspan="2"
                >
                  Всего
                </th>
              </tr>
              <!-- Вторая строка шапки - конкретные годы -->
              <tr>
                <template v-for="group in yearGroups" :key="group.label">
                  <th
                      v-for="year in group.years"
                      :key="year"
                      class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-x border-gray-200"
                      :style="{ backgroundColor: group.color }"
                  >
                    {{ year }}
                  </th>
                </template>
              </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
              <!-- Строка для основного средства -->
              <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-r border-gray-200">
                  1
                </td>
                <td class="px-6 py-4 text-sm text-gray-900 border-r border-gray-200">
                  {{ categoryName }} (основное средство)
                </td>
                <template v-for="group in yearGroups" :key="group.label">
                  <td
                      v-for="year in group.years"
                      :key="year"
                      class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-900 border-x border-gray-200"
                      :style="{ backgroundColor: group.color + '20' }"
                  >
                    {{ getValue(categoryData.main, year) }}
                  </td>
                </template>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-bold text-indigo-600">
                  {{ categoryData.mainTotal }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-bold text-indigo-600" rowspan="2">
                  {{ categoryData.mainTotal + categoryData.freeTotal }}
                </td>
              </tr>
              <!-- Строка для безвозмездного пользования -->
              <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-r border-gray-200">
                  2
                </td>
                <td class="px-6 py-4 text-sm text-gray-900 border-r border-gray-200">
                  {{ categoryName }} (безвоз. пользование)
                </td>
                <template v-for="group in yearGroups" :key="group.label">
                  <td
                      v-for="year in group.years"
                      :key="year"
                      class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-900 border-x border-gray-200"
                      :style="{ backgroundColor: group.color + '20' }"
                  >
                    {{ getValue(categoryData.free, year) }}
                  </td>
                </template>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-bold text-indigo-600">
                  {{ categoryData.freeTotal }}
                </td>
              </tr>
              <!-- Строка с суммарными показателями по группам лет -->
              <tr class="bg-blue-50 font-semibold">
                <td class="px-6 py-4 whitespace-nowrap text-sm border-r border-gray-200" colspan="2">
                  {{ categoryName }} ИТОГО:
                </td>
                <td
                    v-for="group in yearGroups"
                    :key="group.label"
                    :colspan="group.years.length"
                    class="px-4 py-4 whitespace-nowrap text-sm text-center border-x border-gray-200"
                    :style="{ backgroundColor: group.color + '60' }"
                >
                  {{ getGroupTotalByGroup(categoryData, group) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-indigo-700 font-bold">
                  {{ categoryData.mainTotal + categoryData.freeTotal }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-indigo-700 font-bold text-lg">
                  {{ categoryData.mainTotal + categoryData.freeTotal }}
                </td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import {ref, onMounted} from 'vue'
import {ScaleIcon} from '@heroicons/vue/24/outline'
import axios from 'axios'
import {BACKEND_URL} from "@/router.js";

const loading = ref(true)
const error = ref(null)
const groupedByCategory = ref({})
const yearGroups = ref([])
const currentYear = new Date().getFullYear()

// Функция для получения значения с проверкой
const getValue = (obj, year) => {
  return obj && obj[year] ? obj[year] : '-'
}

// Функция для получения суммы по всей группе лет
const getGroupTotalByGroup = (categoryData, group) => {
  let total = 0
  group.years.forEach(year => {
    total += (categoryData.main[year] || 0) + (categoryData.free[year] || 0)
  })
  return total
}

// Функция для получения общего итога по всем категориям
const getTotalAll = () => {
  let total = 0
  Object.values(groupedByCategory.value).forEach(categoryData => {
    total += categoryData.mainTotal + categoryData.freeTotal
  })
  return total
}

// Функция для группировки годов
const groupYears = (years) => {
  const groups = {
    'старше 10 лет': {
      years: [],
      color: '#fef3c7'
    },
    'от 8 до 10 лет': {
      years: [],
      color: '#fed7aa'
    },
    'от 6 до 7 лет': {
      years: [],
      color: '#bfdbfe'
    },
    'до 5 лет': {
      years: [],
      color: '#a7f3d0'
    }
  }

  years.forEach(year => {
    const yearNum = parseInt(year)
    const age = currentYear - yearNum

    if (age > 10) {
      groups['старше 10 лет'].years.push(year)
    } else if (age >= 8 && age <= 10) {
      groups['от 8 до 10 лет'].years.push(year)
    } else if (age >= 6 && age <= 7) {
      groups['от 6 до 7 лет'].years.push(year)
    } else if (age <= 5) {
      groups['до 5 лет'].years.push(year)
    }
  })

  return Object.entries(groups)
      .filter(([_, group]) => group.years.length > 0)
      .map(([label, group]) => ({
        label,
        years: [...group.years].sort(),
        color: group.color
      }))
}

// Функция для получения данных
const fetchData = async () => {
  try {
    loading.value = true
    error.value = null

    const response = await axios.get(`${BACKEND_URL}/api/demo`, {
      timeout: 10000
    })

    if (response.data.success) {
      const data = response.data.data

      // Получаем все уникальные годы
      const yearsSet = new Set()
      Object.values(data).forEach(item => {
        Object.keys(item).forEach(year => {
          yearsSet.add(year)
        })
      })

      // Группируем годы
      yearGroups.value = groupYears(Array.from(yearsSet))

      // Группируем данные по категориям
      const grouped = {}

      Object.entries(data).forEach(([category, yearsData]) => {
        grouped[category] = {
          main: {},
          free: {},
          mainTotal: 0,
          freeTotal: 0
        }

        Object.entries(yearsData).forEach(([year, typeData]) => {
          if (typeData['2']) {
            grouped[category].main[year] = typeData['2']
            grouped[category].mainTotal += typeData['2']
          }
          if (typeData['6']) {
            grouped[category].free[year] = typeData['6']
            grouped[category].freeTotal += typeData['6']
          }
        })
      })

      groupedByCategory.value = grouped
    } else {
      error.value = 'Ошибка при получении данных'
    }
  } catch (err) {
    console.error('Error fetching data:', err)
    if (err.code === 'ECONNABORTED') {
      error.value = 'Превышено время ожидания ответа от сервера'
    } else {
      error.value = 'Не удалось загрузить данные. Проверьте подключение к серверу.'
    }
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchData()
})
</script>

<style scoped>
</style>