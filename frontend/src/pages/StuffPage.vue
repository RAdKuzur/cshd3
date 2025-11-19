<template>
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
          <div class="flex space-x-8">
            <button
                class="px-6 py-4 text-white font-semibold border-b-2 transition-all duration-200 tab-button relative"
                :class="{
                'border-white text-white': activeTab === 'tab1',
                'border-transparent text-indigo-100 hover:text-white': activeTab !== 'tab1'
              }"
                @click="setActiveTab('tab1')"
            >
              <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                IT Отдел
              </div>
              <div
                  v-if="activeTab === 'tab1'"
                  class="absolute bottom-0 left-0 right-0 h-0.5 bg-white transform transition-transform duration-200"
              ></div>
            </button>
            <button
                class="px-6 py-4 text-white font-semibold border-b-2 transition-all duration-200 tab-button relative"
                :class="{
                'border-white text-white': activeTab === 'tab2',
                'border-transparent text-indigo-100 hover:text-white': activeTab !== 'tab2'
              }"
                @click="setActiveTab('tab2')"
            >
              <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                Отдел маркетинга
              </div>
              <div
                  v-if="activeTab === 'tab2'"
                  class="absolute bottom-0 left-0 right-0 h-0.5 bg-white transform transition-transform duration-200"
              ></div>
            </button>
            <button
                class="px-6 py-4 text-white font-semibold border-b-2 transition-all duration-200 tab-button relative"
                :class="{
                'border-white text-white': activeTab === 'tab3',
                'border-transparent text-indigo-100 hover:text-white': activeTab !== 'tab3'
              }"
                @click="setActiveTab('tab3')"
            >
              <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Финансовый отдел
              </div>
              <div
                  v-if="activeTab === 'tab3'"
                  class="absolute bottom-0 left-0 right-0 h-0.5 bg-white transform transition-transform duration-200"
              ></div>
            </button>
          </div>
        </div>

        <!-- Контент табов -->
        <div class="p-8">
          <!-- IT Отдел -->
          <div
              class="tab-content space-y-6"
              v-show="activeTab === 'tab1'"
          >
            <div class="flex justify-between items-center mb-6">
              <div>
                <h2 class="text-2xl font-bold text-gray-900">IT Отдел</h2>
                <p class="text-gray-600 mt-2">Разработка и поддержка IT-инфраструктуры</p>
              </div>
              <div class="text-sm text-gray-500">
                Всего сотрудников: {{ getDepartmentStats('tab1').total }}
                <span class="mx-2">•</span>
                Активных: {{ getDepartmentStats('tab1').active }}
              </div>
            </div>

            <div class="grid gap-6">
              <Record
                  v-for="employee in departmentEmployees.tab1"
                  :key="employee.id"
                  :employee="employee"
              />
            </div>
          </div>

          <!-- Отдел маркетинга -->
          <div
              class="tab-content space-y-6"
              v-show="activeTab === 'tab2'"
          >
            <div class="flex justify-between items-center mb-6">
              <div>
                <h2 class="text-2xl font-bold text-gray-900">Отдел маркетинга</h2>
                <p class="text-gray-600 mt-2">Продвижение и брендинг компании</p>
              </div>
              <div class="text-sm text-gray-500">
                Всего сотрудников: {{ getDepartmentStats('tab2').total }}
                <span class="mx-2">•</span>
                Активных: {{ getDepartmentStats('tab2').active }}
              </div>
            </div>

            <div class="grid gap-6">
              <Record
                  v-for="employee in departmentEmployees.tab2"
                  :key="employee.id"
                  :employee="employee"
              />
            </div>
          </div>

          <!-- Финансовый отдел -->
          <div
              class="tab-content space-y-6"
              v-show="activeTab === 'tab3'"
          >
            <div class="flex justify-between items-center mb-6">
              <div>
                <h2 class="text-2xl font-bold text-gray-900">Финансовый отдел</h2>
                <p class="text-gray-600 mt-2">Управление финансами и отчетностью</p>
              </div>
              <div class="text-sm text-gray-500">
                Всего сотрудников: {{ getDepartmentStats('tab3').total }}
                <span class="mx-2">•</span>
                Активных: {{ getDepartmentStats('tab3').active }}
              </div>
            </div>

            <div class="grid gap-6">
              <Record
                  v-for="employee in departmentEmployees.tab3"
                  :key="employee.id"
                  :employee="employee"
              />
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
            <div class="flex-shrink-0 h-12 w-12 bg-green-100 rounded-lg flex items-center justify-center">
              <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Активных</p>
              <p class="text-2xl font-bold text-gray-900">{{ activeEmployees }}</p>
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
              <p class="text-2xl font-bold text-gray-900">3</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import Record from "@/components/layouts/Record.vue";

const activeTab = ref('tab1')

// Тестовые данные сотрудников
const departmentEmployees = {
  tab1: [
    {
      id: 1,
      name: 'Алексей Петров',
      position: 'Senior Developer',
      status: 'active',
      email: 'alexey@company.com',
      avatar: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&h=150&fit=crop&crop=face'
    },
    {
      id: 2,
      name: 'Ирина Смирнова',
      position: 'DevOps Engineer',
      status: 'active',
      email: 'irina@company.com',
      avatar: 'https://images.unsplash.com/photo-1494790108755-2616b612b786?w=150&h=150&fit=crop&crop=face'
    },
    {
      id: 3,
      name: 'Дмитрий Козлов',
      position: 'Frontend Developer',
      status: 'active',
      email: 'dmitry@company.com',
      avatar: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&h=150&fit=crop&crop=face'
    }
  ],
  tab2: [
    {
      id: 4,
      name: 'Мария Иванова',
      position: 'Marketing Manager',
      status: 'active',
      email: 'maria@company.com',
      avatar: 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150&h=150&fit=crop&crop=face'
    },
    {
      id: 5,
      name: 'Сергей Николаев',
      position: 'Content Specialist',
      status: 'inactive',
      email: 'sergey@company.com',
      avatar: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150&h=150&fit=crop&crop=face'
    }
  ],
  tab3: [
    {
      id: 6,
      name: 'Ольга Сидорова',
      position: 'Financial Analyst',
      status: 'active',
      email: 'olga@company.com',
      avatar: 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=150&h=150&fit=crop&crop=face'
    },
    {
      id: 7,
      name: 'Андрей Волков',
      position: 'Chief Accountant',
      status: 'active',
      email: 'andrey@company.com',
      avatar: 'https://images.unsplash.com/photo-1507591064344-4c6ce005b128?w=150&h=150&fit=crop&crop=face'
    },
    {
      id: 8,
      name: 'Екатерина Морозова',
      position: 'Auditor',
      status: 'active',
      email: 'ekaterina@company.com',
      avatar: 'https://images.unsplash.com/photo-1552058544-f2b08422138a?w=150&h=150&fit=crop&crop=face'
    }
  ]
}

const setActiveTab = (tabId) => {
  activeTab.value = tabId
}

// Статистика
const getDepartmentStats = (department) => {
  const employees = departmentEmployees[department] || []
  return {
    total: employees.length,
    active: employees.filter(emp => emp.status === 'active').length
  }
}

const totalEmployees = computed(() => {
  return Object.values(departmentEmployees).flat().length
})

const activeEmployees = computed(() => {
  return Object.values(departmentEmployees).flat().filter(emp => emp.status === 'active').length
})

onMounted(() => {
  setActiveTab('tab1')
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