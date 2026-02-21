<template>
  <div class="p-6 bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <div class="max-w-7xl mx-auto">

      <!-- Заголовок -->
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Управление сотрудниками</h1>
        <p class="text-gray-600 mt-2">Структура по отделам</p>
      </div>

      <!-- Основной контейнер с боковыми табами -->
      <div class="flex flex-col lg:flex-row gap-6">
        <!-- Боковая панель с табами -->
        <div class="lg:w-1/4">
          <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-b from-indigo-500 to-purple-600 p-4">
              <h3 class="text-white font-semibold text-lg mb-4">Отделы</h3>
            </div>

            <div class="p-4 space-y-1">
              <button
                  v-for="(branch, index) in branches"
                  :key="branch.branch_id"
                  class="w-full px-4 py-3 text-left rounded-xl transition-all duration-200 tab-button flex items-center justify-between group"
                  :class="{
                    'bg-indigo-50 text-indigo-700 border border-indigo-100 shadow-sm': activeTab === branch.branch_id,
                    'text-gray-700 hover:bg-gray-50 hover:text-gray-900': activeTab !== branch.branch_id
                  }"
                  @click="setActiveTab(branch.branch_id)"
              >
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-10 w-10 rounded-lg flex items-center justify-center mr-3"
                       :class="{
                         'bg-indigo-100 text-indigo-600': activeTab === branch.branch_id,
                         'bg-gray-100 text-gray-600 group-hover:bg-gray-200': activeTab !== branch.branch_id
                       }">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                  </div>
                  <div>
                    <div class="font-medium">{{ branch.branch_name }}</div>
                    <div class="text-sm opacity-75">{{ getBranchStats(branch.branch_id).total }} сотрудник</div>
                  </div>
                </div>

                <svg v-if="activeTab === branch.branch_id"
                     class="w-5 h-5 text-indigo-500"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
              </button>
            </div>
          </div>

          <!-- Статистика в боковой панели -->
          <div class="mt-6 bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h3 class="font-semibold text-gray-900 mb-4">Общая статистика</h3>
            <div class="space-y-4">
              <div class="flex items-center justify-between">
                <div class="flex items-center">
                  <div class="h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">

                    <UserIcon class="h-5 w-5 text-blue-600" />

                  </div>
                  <div>
                    <p class="text-sm font-medium text-gray-600">Всего сотрудников</p>
                    <p class="text-xl font-bold text-gray-900">{{ totalEmployees }}</p>
                  </div>
                </div>
              </div>
              <div class="flex items-center justify-between">
                <div class="flex items-center">
                  <div class="h-10 w-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                    <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                  </div>
                  <div>
                    <p class="text-sm font-medium text-gray-600">Отделов</p>
                    <p class="text-xl font-bold text-gray-900">{{ branches.length }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Основной контент -->
        <div class="lg:w-3/4">
          <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden h-full">
            <div class="p-6 border-b border-gray-200">
              <div class="flex justify-between items-center">
                <div>
                  <h2 class="text-2xl font-bold text-gray-900">
                    {{ activeBranch ? activeBranch.branch_name : 'Выберите отдел' }}
                  </h2>
                  <p class="text-gray-600 mt-2">Информация о сотрудниках отдела</p>
                </div>
                <div v-if="activeBranch" class="text-sm text-gray-500">
                  Всего сотрудников: {{ getBranchStats(activeTab).total }}
                </div>
              </div>
            </div>

            <div class="p-6">
              <div v-if="!activeTab" class="text-center py-12">
                <UserIcon class="w-16 h-16 mx-auto text-gray-400 mb-4" />

                <p class="text-gray-500">Выберите отдел для просмотра сотрудников</p>
              </div>
              <div v-else>
                <div class="grid gap-6">
                  <Record
                      v-for="employee in activeBranch.staff"
                      :key="employee.id"
                      :employee="formatEmployee(employee)"
                  />
                </div>

                <div
                    v-if="activeBranch.staff.length === 0"
                    class="text-center py-12 text-gray-500"
                >
                  <UserIcon class="w-16 h-16 mx-auto text-gray-400 mb-4" />
                  <p class="text-lg font-medium mb-2">В этом отделе пока нет сотрудников</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'
import Record from "@/components/layouts/Record.vue";
import {BACKEND_URL} from "@/router.js";
import { UserIcon } from '@heroicons/vue/24/outline'
const activeTab = ref(null)
const branches = ref([])
const loading = ref(true)

const loadStaffData = async () => {
  try {
    loading.value = true
    const response = await axios.get(`${BACKEND_URL}/api/staff`)
    const result = response.data

    if (result.success) {
      branches.value = result.data
      if (branches.value.length > 0) {
        activeTab.value = branches.value[0].branch_id
      }
    }
  } catch (error) {
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

// Получаем активный отдел
const activeBranch = computed(() => {
  return branches.value.find(b => b.branch_id === activeTab.value)
})

// Форматирование сотрудника для компонента Record
const formatEmployee = (employee) => {
  return {
    id: employee.id,
    name: employee.fio,
    position: employee.position,
    status: 'active',
    email: '',
    avatar: '',
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
    total: branch.staff.length
  }
}

// Общая статистика
const totalEmployees = computed(() => {
  return branches.value.reduce((total, branch) => total + branch.staff.length, 0)
})

onMounted(() => {
  loadStaffData()
})
</script>

<style scoped>
.tab-button {
  transition: all 0.2s ease;
}

.tab-button:hover {
  transform: translateX(4px);
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