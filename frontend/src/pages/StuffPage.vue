<template>
  <!-- Тот же template остаётся без изменений -->
  <div class="p-6 bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <div class="max-w-7xl mx-auto">

      <!-- Заголовок -->
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Управление сотрудниками</h1>
        <p class="text-gray-600 mt-2">Структура компании по отделам</p>
      </div>

      <!-- Табы -->
      <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden mb-8">
        <!-- Навигация табов -->
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6">
          <div class="flex space-x-8 overflow-x-auto">
            <button
                v-for="(branch, index) in branches"
                :key="branch.branch_id"
                class="px-6 py-4 text-white font-semibold border-b-2 transition-all duration-200 tab-button relative whitespace-nowrap"
                :class="{
                'border-white text-white': activeTab === branch.branch_id,
                'border-transparent text-indigo-100 hover:text-white': activeTab !== branch.branch_id
              }"
                @click="setActiveTab(branch.branch_id)"
            >
              <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                {{ branch.branch_name }}
              </div>
              <div
                  v-if="activeTab === branch.branch_id"
                  class="absolute bottom-0 left-0 right-0 h-0.5 bg-white transform transition-transform duration-200"
              ></div>
            </button>
          </div>
        </div>

        <!-- Контент табов -->
        <div class="p-8">
          <!-- Контент для каждого отдела -->
          <div
              v-for="branch in branches"
              :key="branch.branch_id"
              class="tab-content space-y-6"
              v-show="activeTab === branch.branch_id"
          >
            <div class="flex justify-between items-center mb-6">
              <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ branch.branch_name }}</h2>
                <p class="text-gray-600 mt-2">Информация о сотрудниках отдела</p>
              </div>
              <div class="text-sm text-gray-500">
                Всего сотрудников: {{ getBranchStats(branch.branch_id).total }}
              </div>
            </div>

            <div class="grid gap-6">
              <Record
                  v-for="employee in branch.stuff"
                  :key="employee.id"
                  :employee="formatEmployee(employee)"
              />
            </div>

            <div
                v-if="branch.stuff.length === 0"
                class="text-center py-8 text-gray-500"
            >
              <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
              </svg>
              <p class="mt-2">В этом отделе пока нет сотрудников</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Статистика -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0 h-12 w-12 bg-blue-100 rounded-lg flex items-center justify-center">
              <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Всего сотрудников</p>
              <p class="text-2xl font-bold text-gray-900">{{ totalEmployees }}</p>
            </div>
          </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0 h-12 w-12 bg-purple-100 rounded-lg flex items-center justify-center">
              <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Отделов</p>
              <p class="text-2xl font-bold text-gray-900">{{ branches.length }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios' // Импортируем axios
import Record from "@/components/layouts/Record.vue";
import {BACKEND_URL} from "@/router.js";

const activeTab = ref(null)
const branches = ref([])
const loading = ref(true)

const loadStuffData = async () => {
  try {
    loading.value = true
    const response = await axios.get(`${BACKEND_URL}/api/stuff`)
    const result = response.data

    if (result.success) {
      branches.value = result.data
      if (branches.value.length > 0) {
        activeTab.value = branches.value[0].branch_id
      }
    }
  } catch (error) {
    console.error('Ошибка при загрузке данных:', error)
    if (branches.value.length > 0) {
      activeTab.value = branches.value[0].branch_id
    }
  } finally {
    loading.value = false
  }
}

const setActiveTab = (branchId) => {
  activeTab.value = branchId
}

// Форматирование сотрудника для компонента Record
const formatEmployee = (employee) => {
  return {
    id: employee.id,
    name: employee.fio,
    position: employee.position,
    status: 'active', // Все сотрудники из API считаются активными
    email: '', // Email не приходит из API
    avatar: '', // Аватар не приходит из API
    auditorium: employee.auditorium,
    start_date: employee.start_date,
    icon_link: employee.icon_link
  }
}

// Статистика по отделам
const getBranchStats = (branchId) => {
  const branch = branches.value.find(b => b.branch_id === branchId)
  if (!branch) return { total: 0 }

  return {
    total: branch.stuff.length
  }
}

// Общая статистика
const totalEmployees = computed(() => {
  return branches.value.reduce((total, branch) => total + branch.stuff.length, 0)
})


onMounted(() => {
  loadStuffData()
})
</script>

<style scoped>
.tab-button {
  transition: all 0.3s ease;
}

.tab-button:hover {
  transform: translateY(-1px);
}

.tab-content {
  animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>