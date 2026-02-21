<template>
  <div class="p-6 bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
      <!-- Уведомления -->
      <transition name="notification">
        <div v-if="notification.show" :class="['notification', notification.type]" class="mb-6">
          {{ notification.message }}
        </div>
      </transition>

      <!-- Заголовок и элементы управления -->
      <div class="mb-8">
        <div class="flex justify-between items-center">
          <div>
            <div class="flex items-center gap-3 mb-2">
              <h1 class="text-3xl font-bold text-gray-900">История перемещений сотрудников</h1>
            </div>
            <p class="text-gray-600">Управление перемещениями сотрудников между отделами и должностями</p>
          </div>
          <button
              @click="openCreateModal"
              class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-6 py-3 rounded-lg font-semibold shadow-sm transition-all duration-200 flex items-center gap-2 hover:shadow-md"
          >
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Добавить перемещение
          </button>
        </div>

        <!-- Панель поиска -->
        <div class="mt-6">
          <div class="relative max-w-md">
            <input
                v-model="searchQuery"
                type="text"
                placeholder="Поиск по ФИО сотрудника, отделу или должности..."
                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm bg-white"
            >
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
              <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
            </div>
          </div>
        </div>

        <!-- Фильтры по статусу -->
        <div class="mt-4 flex gap-2">
          <button
              @click="statusFilter = 'all'"
              :class="[
                'px-4 py-2 rounded-lg text-sm font-medium transition-all',
                statusFilter === 'all'
                  ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-sm'
                  : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-300'
              ]"
          >
            Все перемещения
          </button>
          <button
              @click="statusFilter = 'current'"
              :class="[
                'px-4 py-2 rounded-lg text-sm font-medium transition-all',
                statusFilter === 'current'
                  ? 'bg-gradient-to-r from-green-600 to-emerald-600 text-white shadow-sm'
                  : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-300'
              ]"
          >
            <span class="flex items-center gap-1">
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" />
                <circle cx="12" cy="12" r="3" fill="currentColor" />
              </svg>
              Текущее расположение
            </span>
          </button>
          <button
              @click="statusFilter = 'history'"
              :class="[
                'px-4 py-2 rounded-lg text-sm font-medium transition-all',
                statusFilter === 'history'
                  ? 'bg-gradient-to-r from-blue-600 to-cyan-600 text-white shadow-sm'
                  : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-300'
              ]"
          >
            <span class="flex items-center gap-1">
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              История перемещений
            </span>
          </button>
        </div>
      </div>

      <!-- Загрузка -->
      <div v-if="isLoading" class="text-center py-12">
        <svg class="animate-spin mx-auto h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <p class="mt-2 text-gray-600">Загрузка данных...</p>
      </div>

      <!-- Ошибка -->
      <div v-else-if="error" class="bg-gradient-to-r from-red-50 to-pink-50 border border-red-200 rounded-xl p-6 text-center shadow-sm">
        <svg class="mx-auto h-12 w-12 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z" />
        </svg>
        <h3 class="mt-2 text-sm font-medium text-red-800">Ошибка загрузки</h3>
        <p class="mt-1 text-sm text-red-600">{{ error }}</p>
        <button
            @click="loadData"
            class="mt-4 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors shadow-sm"
        >
          Попробовать снова
        </button>
      </div>

      <!-- Таблица -->
      <div v-else class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead class="bg-gradient-to-r from-blue-500 to-indigo-600">
            <tr>
              <th
                  v-for="header in headers"
                  :key="header.key"
                  class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider cursor-pointer hover:bg-indigo-700 transition-colors"
                  @click="sortTable(header.key)"
              >
                <div class="flex items-center">
                  {{ header.label }}
                  <svg
                      v-if="sortKey === header.key"
                      class="w-4 h-4 ml-1"
                      :class="sortOrder === 'asc' ? 'rotate-180' : ''"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                  >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                  </svg>
                </div>
              </th>
              <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider">
                Действия
              </th>
            </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
            <template v-for="person in paginatedItems" :key="person.people_id">
              <tr
                  v-for="(movement, index) in getCurrentMovements(person)"
                  :key="movement.id"
                  class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-200 group"
                  :class="{ 'border-t-2 border-indigo-200': index === 0 && person.peoplePositions.length > 1 }"
              >
                <!-- ФИО сотрудника -->
                <td class="px-6 py-4">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-lg flex items-center justify-center shadow-sm">
                      <svg class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                      </svg>
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors">
                        {{ getFullName(person) }}
                      </div>
                      <div class="text-xs text-gray-500">
                        Аудитория №{{ person.auditorium_id }}
                      </div>
                    </div>
                  </div>
                </td>

                <!-- Отдел -->
                <td class="px-6 py-4">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-8 w-8 bg-gradient-to-r from-purple-100 to-pink-100 rounded-lg flex items-center justify-center mr-3 shadow-sm">
                      <svg class="h-4 w-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                      </svg>
                    </div>
                    <div>
                      <div class="text-sm font-semibold text-gray-900">
                        {{ getBranchName(movement.branch_id) }}
                      </div>
                    </div>
                  </div>
                </td>

                <!-- Должность -->
                <td class="px-6 py-4">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-8 w-8 bg-gradient-to-r from-green-100 to-emerald-100 rounded-lg flex items-center justify-center mr-3 shadow-sm">
                      <svg class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                      </svg>
                    </div>
                    <div>
                      <div class="text-sm font-semibold text-gray-900">
                        {{ getPositionName(movement.position_id) }}
                      </div>
                    </div>
                  </div>
                </td>

                <!-- Период -->
                <td class="px-6 py-4">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-8 w-8 bg-gradient-to-r from-yellow-100 to-amber-100 rounded-lg flex items-center justify-center mr-3 shadow-sm">
                      <svg class="h-4 w-4 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                      </svg>
                    </div>
                    <div>
                      <div class="text-sm font-semibold text-gray-900">
                        {{ formatDate(movement.start_date) }}
                        <span v-if="movement.end_date" class="text-gray-500"> → {{ formatDate(movement.end_date) }}</span>
                        <span v-else class="text-green-600 font-medium ml-2">(текущее)</span>
                      </div>
                      <div class="text-xs text-gray-500">
                        {{ getMovementDuration(movement.start_date, movement.end_date) }}
                      </div>
                    </div>
                  </div>
                </td>

                <!-- Статус -->
                <td class="px-6 py-4">
                  <span
                      :class="[
                        'px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full',
                        !movement.end_date
                          ? 'bg-gradient-to-r from-green-100 to-emerald-100 text-green-800'
                          : 'bg-gradient-to-r from-gray-100 to-blue-100 text-gray-800'
                      ]"
                  >
                    {{ movement.end_date ? 'В истории' : 'Актуально' }}
                  </span>
                </td>

                <!-- Действия -->
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center space-x-2">
                    <!-- Кнопка редактирования (только для текущего расположения) -->
                    <button
                        v-if="!movement.end_date"
                        @click="openEditModal(movement)"
                        class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                        title="Редактировать перемещение"
                    >
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                      </svg>
                    </button>

                    <!-- Кнопка удаления (только для текущего расположения) -->
                    <button
                        v-if="!movement.end_date"
                        @click="openDeleteModal(movement)"
                        class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                        title="Удалить перемещение"
                    >
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                      </svg>
                    </button>
                  </div>
                </td>
              </tr>
            </template>
            </tbody>
          </table>
        </div>

        <!-- Пустое состояние -->
        <div v-if="!isLoading && filteredPeople.length === 0" class="text-center py-12">
          <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
          </svg>
          <h3 class="mt-2 text-sm font-medium text-gray-900">Перемещения не найдены</h3>
          <p class="mt-1 text-sm text-gray-500">
            {{ searchQuery || statusFilter !== 'all' ? 'Попробуйте изменить параметры поиска' : 'Добавьте первое перемещение' }}
          </p>
        </div>

        <!-- Пагинация -->
        <div v-if="!isLoading && filteredPeople.length > 0" class="px-6 py-4 border-t border-gray-200 bg-gray-50">
          <div class="flex items-center justify-between flex-wrap gap-4">
            <div class="text-sm text-gray-700">
              Показано с {{ startIndex }} по {{ endIndex }} из {{ filteredPeople.length }} записей
            </div>
            <div class="flex items-center space-x-2">
              <button
                  @click="prevPage"
                  :disabled="currentPage === 1"
                  class="px-3 py-1 rounded-md border border-gray-300 text-sm font-medium transition-colors"
                  :class="currentPage === 1
                  ? 'text-gray-400 cursor-not-allowed bg-gray-100'
                  : 'text-gray-700 hover:bg-gray-100 hover:border-gray-400'"
              >
                Назад
              </button>

              <div class="flex space-x-1">
                <button
                    v-for="page in visiblePages"
                    :key="page"
                    @click="goToPage(page)"
                    class="w-8 h-8 rounded-md text-sm font-medium transition-all"
                    :class="page === currentPage
                    ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-sm'
                    : 'text-gray-700 hover:bg-gray-100 hover:shadow-sm'"
                >
                  {{ page }}
                </button>
                <span v-if="showEllipsis" class="px-2 py-1 text-gray-500">...</span>
              </div>

              <button
                  @click="nextPage"
                  :disabled="currentPage === totalPages"
                  class="px-3 py-1 rounded-md border border-gray-300 text-sm font-medium transition-colors"
                  :class="currentPage === totalPages
                  ? 'text-gray-400 cursor-not-allowed bg-gray-100'
                  : 'text-gray-700 hover:bg-gray-100 hover:border-gray-400'"
              >
                Вперед
              </button>
            </div>

            <select
                v-model="itemsPerPage"
                class="px-3 py-1 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white"
            >
              <option value="5">5 на странице</option>
              <option value="10">10 на странице</option>
              <option value="20">20 на странице</option>
              <option value="50">50 на странице</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <!-- Модальное окно создания/редактирования -->
    <transition name="modal-fade">
      <div v-if="showModal" class="fixed inset-0 flex items-center justify-center p-4 z-50">
        <!-- Размытый фон -->
        <div class="absolute inset-0 backdrop-blur-sm bg-white/30" @click="closeModal"></div>

        <!-- Модальное окно -->
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-100">
          <div class="p-6">
            <div class="flex justify-between items-center mb-6">
              <h3 class="text-xl font-bold text-gray-900">
                {{ editingMovement ? 'Редактировать перемещение' : 'Добавить перемещение' }}
              </h3>
              <button
                  @click="closeModal"
                  class="text-gray-400 hover:text-gray-600 transition-colors p-1 hover:bg-gray-100 rounded-lg"
              >
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>

            <form @submit.prevent="saveMovement">
              <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Сотрудник *
                </label>
                <div class="relative">
                  <select
                      v-model="form.people_id"
                      required
                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-white"
                      :disabled="isSaving || peopleLoading || !!editingMovement"
                  >
                    <option value="">Выберите сотрудника</option>
                    <option
                        v-for="person in peopleList"
                        :key="person.id"
                        :value="person.id"
                        :disabled="!editingMovement && hasCurrentLocation(person.id)"
                    >
                      {{ getFullName(person) }}
                      {{ hasCurrentLocation(person.id) ? ' (уже имеет текущее расположение)' : '' }}
                    </option>
                  </select>
                  <div v-if="peopleLoading" class="absolute right-3 top-3">
                    <svg class="animate-spin h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                  </div>
                </div>
                <p v-if="formErrors.people_id" class="mt-2 text-sm text-red-600">{{ formErrors.people_id }}</p>
              </div>

              <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Отдел *
                </label>
                <div class="relative">
                  <select
                      v-model="form.branch_id"
                      required
                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-white"
                      :disabled="isSaving || branchesLoading"
                  >
                    <option value="">Выберите отдел</option>
                    <option
                        v-for="branch in branchesList"
                        :key="branch.id"
                        :value="branch.id"
                    >
                      {{ branch.name }}
                    </option>
                  </select>
                  <div v-if="branchesLoading" class="absolute right-3 top-3">
                    <svg class="animate-spin h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                  </div>
                </div>
                <p v-if="formErrors.branch_id" class="mt-2 text-sm text-red-600">{{ formErrors.branch_id }}</p>
              </div>

              <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Должность *
                </label>
                <div class="relative">
                  <select
                      v-model="form.position_id"
                      required
                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-white"
                      :disabled="isSaving || positionsLoading"
                  >
                    <option value="">Выберите должность</option>
                    <option
                        v-for="position in positionsList"
                        :key="position.id"
                        :value="position.id"
                    >
                      {{ position.name }}
                    </option>
                  </select>
                  <div v-if="positionsLoading" class="absolute right-3 top-3">
                    <svg class="animate-spin h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                  </div>
                </div>
                <p v-if="formErrors.position_id" class="mt-2 text-sm text-red-600">{{ formErrors.position_id }}</p>
              </div>

              <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Дата начала *
                </label>
                <input
                    v-model="form.start_date"
                    type="date"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                    :disabled="isSaving"
                    :max="new Date().toISOString().split('T')[0]"
                />
                <p v-if="formErrors.start_date" class="mt-2 text-sm text-red-600">{{ formErrors.start_date }}</p>
              </div>

              <div class="flex justify-end gap-3">
                <button
                    type="button"
                    @click="closeModal"
                    :disabled="isSaving"
                    class="px-4 py-2.5 border border-gray-300 text-gray-700 hover:bg-gray-50 rounded-lg font-medium transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  Отмена
                </button>
                <button
                    type="submit"
                    :disabled="isSaving"
                    class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium rounded-lg hover:from-blue-700 hover:to-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed transition-all shadow-sm hover:shadow flex items-center gap-2"
                >
                  <svg v-if="isSaving" class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  {{ isSaving ? 'Сохранение...' : (editingMovement ? 'Сохранить' : 'Добавить') }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </transition>

    <!-- Модальное окно удаления -->
    <transition name="modal-fade">
      <div v-if="showDeleteModal" class="fixed inset-0 flex items-center justify-center p-4 z-50">
        <!-- Размытый фон -->
        <div class="absolute inset-0 backdrop-blur-sm bg-white/30" @click="closeDeleteModal"></div>

        <!-- Модальное окно -->
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-100">
          <div class="p-6">
            <div class="text-center">
              <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-gradient-to-br from-red-100 to-pink-100 mb-4">
                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
              </div>
              <h3 class="text-lg font-bold text-gray-900 mb-2">Удалить перемещение</h3>
              <p class="text-gray-600 mb-6">
                Вы уверены, что хотите удалить перемещение сотрудника
                <span class="font-semibold text-gray-900">"{{ getPersonName(movementToDelete?.people_id) }}"</span>
                в отдел
                <span class="font-semibold text-gray-900">"{{ getBranchName(movementToDelete?.branch_id) }}"</span>
                на должность
                <span class="font-semibold text-gray-900">"{{ getPositionName(movementToDelete?.position_id) }}"</span>?
                <br>Это действие нельзя отменить.
              </p>
            </div>

            <div class="flex justify-end gap-3">
              <button
                  type="button"
                  @click="closeDeleteModal"
                  :disabled="isDeleting"
                  class="px-4 py-2.5 border border-gray-300 text-gray-700 hover:bg-gray-50 rounded-lg font-medium transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
              >
                Отмена
              </button>
              <button
                  type="button"
                  @click="confirmDelete"
                  :disabled="isDeleting"
                  class="px-6 py-2.5 bg-gradient-to-r from-red-600 to-pink-600 text-white font-medium rounded-lg hover:from-red-700 hover:to-pink-700 disabled:opacity-50 disabled:cursor-not-allowed transition-all shadow-sm hover:shadow flex items-center gap-2"
              >
                <svg v-if="isDeleting" class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                {{ isDeleting ? 'Удаление...' : 'Удалить' }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref, computed, watch, onMounted } from 'vue'
import axios from 'axios'
import { BACKEND_URL } from '@/router.js'

// Реактивные данные
const headers = ref([
  { key: 'name', label: 'Сотрудник' },
  { key: 'branch', label: 'Отдел' },
  { key: 'position', label: 'Должность' },
  { key: 'period', label: 'Период' },
  { key: 'status', label: 'Статус' }
])

// Данные для таблицы (история перемещений сотрудников)
const historyItems = ref([])
// Справочные данные для форм
const peopleList = ref([])
const branchesList = ref([])
const positionsList = ref([])

const isLoading = ref(false)
const peopleLoading = ref(false)
const branchesLoading = ref(false)
const positionsLoading = ref(false)
const error = ref(null)

// Поиск и сортировка
const searchQuery = ref('')
const statusFilter = ref('all')
const sortKey = ref('name')
const sortOrder = ref('asc')

// Пагинация
const currentPage = ref(1)
const itemsPerPage = ref(10)

// Модальные окна
const showModal = ref(false)
const showDeleteModal = ref(false)
const editingMovement = ref(null)
const movementToDelete = ref(null)
const isSaving = ref(false)
const isDeleting = ref(false)

// Форма
const form = ref({
  people_id: '',
  branch_id: '',
  position_id: '',
  start_date: new Date().toISOString().split('T')[0]
})

const formErrors = ref({})

// Уведомления
const notification = ref({
  show: false,
  message: '',
  type: 'success'
})

// Показать уведомление
const showNotification = (message, type = 'success') => {
  notification.value = {
    show: true,
    message,
    type
  }

  setTimeout(() => {
    notification.value.show = false
  }, 3000)
}

// Вспомогательные функции для работы с ФИО
const getFullName = (person) => {
  if (!person) return 'Неизвестный сотрудник'
  const parts = []
  if (person.surname) parts.push(person.surname)
  if (person.firstname) parts.push(person.firstname)
  if (person.patronymic) parts.push(person.patronymic)
  return parts.join(' ') || 'Неизвестный сотрудник'
}

const getPersonName = (peopleId) => {
  // Сначала ищем в peopleList
  const personFromList = peopleList.value.find(p => p.id === peopleId)
  if (personFromList) return getFullName(personFromList)

  // Если не нашли, ищем в истории
  const personFromHistory = historyItems.value.find(p => p.people_id === peopleId)
  return personFromHistory ? getFullName(personFromHistory) : 'Неизвестный сотрудник'
}

const getBranchName = (branchId) => {
  const branch = branchesList.value.find(b => b.id === branchId)
  return branch ? branch.name : 'Неизвестный отдел'
}

const getPositionName = (positionId) => {
  const position = positionsList.value.find(p => p.id === positionId)
  return position ? position.name : 'Неизвестная должность'
}

const formatDate = (dateString) => {
  if (!dateString) return ''
  const date = new Date(dateString)
  return date.toLocaleDateString('ru-RU')
}

const getMovementDuration = (startDate, endDate) => {
  const start = new Date(startDate)
  const end = endDate ? new Date(endDate) : new Date()
  const days = Math.round((end - start) / (1000 * 60 * 60 * 24))

  if (days === 0) return 'менее дня'
  if (days === 1) return '1 день'
  if (days < 7) return `${days} дней`
  if (days < 30) return `${Math.round(days / 7)} недель`
  if (days < 365) return `${Math.round(days / 30)} месяцев`
  return `${Math.round(days / 365)} лет`
}

const hasCurrentLocation = (peopleId) => {
  const person = historyItems.value.find(p => p.people_id === peopleId)
  if (!person || !person.peoplePositions) return false
  return person.peoplePositions.some(m => !m.end_date)
}

const getCurrentMovements = (person) => {
  if (!person.peoplePositions) return []
  return [...person.peoplePositions].sort((a, b) => {
    if (!a.end_date && b.end_date) return -1
    if (a.end_date && !b.end_date) return 1
    return new Date(b.start_date) - new Date(a.start_date)
  })
}

// Загрузка данных
const loadPeopleList = async () => {
  try {
    peopleLoading.value = true
    const response = await axios.get(`${BACKEND_URL}/api/people`)
    if (response.data.success) {
      peopleList.value = response.data.data || []
    }
  } catch (err) {
    showNotification('Ошибка загрузки списка сотрудников', 'error')
  } finally {
    peopleLoading.value = false
  }
}

const loadBranches = async () => {
  try {
    branchesLoading.value = true
    const response = await axios.get(`${BACKEND_URL}/api/info/branches`)
    if (response.data.success) {
      branchesList.value = response.data.data || []
    }
  } catch (err) {
    console.error('Ошибка загрузки отделов:', err)
    showNotification('Ошибка загрузки списка отделов', 'error')
  } finally {
    branchesLoading.value = false
  }
}

const loadPositions = async () => {
  try {
    positionsLoading.value = true
    const response = await axios.get(`${BACKEND_URL}/api/admin/positions`)
    if (response.data.success) {
      positionsList.value = response.data.data || []
    }
  } catch (err) {
    console.error('Ошибка загрузки должностей:', err)
    showNotification('Ошибка загрузки списка должностей', 'error')
  } finally {
    positionsLoading.value = false
  }
}

const loadData = async () => {
  try {
    isLoading.value = true
    error.value = null

    const response = await axios.get(`${BACKEND_URL}/api/history/people-positions`)
    if (response.data.success) {
      historyItems.value = response.data.data || []
    } else {
      throw new Error(response.data.message || 'Не удалось загрузить историю')
    }
  } catch (err) {
    error.value = err.response?.data?.message || err.message || 'Ошибка соединения'
  } finally {
    isLoading.value = false
  }
}

onMounted(async () => {
  // Загружаем все данные параллельно
  await Promise.all([
    loadData(),
    loadBranches(),
    loadPositions(),
    loadPeopleList() // Добавляем загрузку списка людей
  ])
})

// Фильтрация
const filteredPeople = computed(() => {
  let filtered = historyItems.value

  if (statusFilter.value === 'current') {
    filtered = filtered.filter(person =>
        person.peoplePositions?.some(m => !m.end_date)
    )
  } else if (statusFilter.value === 'history') {
    filtered = filtered.filter(person =>
        person.peoplePositions?.some(m => m.end_date)
    )
  }

  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(person => {
      const fullName = getFullName(person).toLowerCase()
      if (fullName.includes(query)) return true

      return person.peoplePositions?.some(m => {
        const branchName = getBranchName(m.branch_id).toLowerCase()
        const positionName = getPositionName(m.position_id).toLowerCase()
        return branchName.includes(query) || positionName.includes(query)
      })
    })
  }

  filtered = [...filtered].sort((a, b) => {
    let aVal, bVal

    switch (sortKey.value) {
      case 'name':
        aVal = getFullName(a)
        bVal = getFullName(b)
        break
      case 'branch':
        const aCurrent = a.peoplePositions?.find(m => !m.end_date)
        const bCurrent = b.peoplePositions?.find(m => !m.end_date)
        aVal = getBranchName(aCurrent?.branch_id)
        bVal = getBranchName(bCurrent?.branch_id)
        break
      case 'position':
        const aCurrentPos = a.peoplePositions?.find(m => !m.end_date)
        const bCurrentPos = b.peoplePositions?.find(m => !m.end_date)
        aVal = getPositionName(aCurrentPos?.position_id)
        bVal = getPositionName(bCurrentPos?.position_id)
        break
      case 'status':
        aVal = a.peoplePositions?.some(m => !m.end_date) ? 1 : 0
        bVal = b.peoplePositions?.some(m => !m.end_date) ? 1 : 0
        break
      default:
        aVal = a[sortKey.value]
        bVal = b[sortKey.value]
    }

    if (aVal < bVal) return sortOrder.value === 'asc' ? -1 : 1
    if (aVal > bVal) return sortOrder.value === 'asc' ? 1 : -1
    return 0
  })

  return filtered
})

// Пагинация
const totalPages = computed(() => Math.ceil(filteredPeople.value.length / itemsPerPage.value))

const paginatedItems = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return filteredPeople.value.slice(start, end)
})

const startIndex = computed(() => (currentPage.value - 1) * itemsPerPage.value + 1)
const endIndex = computed(() => Math.min(currentPage.value * itemsPerPage.value, filteredPeople.value.length))

const visiblePages = computed(() => {
  const pages = []
  const maxVisible = 5
  let start = Math.max(1, currentPage.value - Math.floor(maxVisible / 2))
  let end = Math.min(totalPages.value, start + maxVisible - 1)

  if (end - start + 1 < maxVisible) {
    start = Math.max(1, end - maxVisible + 1)
  }

  for (let i = start; i <= end; i++) {
    pages.push(i)
  }
  return pages
})

const showEllipsis = computed(() => totalPages.value > visiblePages.value.length)

// Методы пагинации и сортировки
const sortTable = (key) => {
  if (sortKey.value === key) {
    sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc'
  } else {
    sortKey.value = key
    sortOrder.value = 'asc'
  }
}

const prevPage = () => {
  if (currentPage.value > 1) currentPage.value--
}

const nextPage = () => {
  if (currentPage.value < totalPages.value) currentPage.value++
}

const goToPage = (page) => {
  currentPage.value = page
}

// Работа с модальными окнами
const openCreateModal = async () => {
  editingMovement.value = null
  form.value = {
    people_id: '',
    branch_id: '',
    position_id: '',
    start_date: new Date().toISOString().split('T')[0]
  }
  formErrors.value = {}

  showModal.value = true

  try {
    await Promise.all([
      loadPeopleList(),
      loadBranches(),
      loadPositions()
    ])
  } catch (error) {
    console.error('Ошибка загрузки данных:', error)
    showNotification('Ошибка загрузки справочных данных', 'error')
  }
}

const openEditModal = async (movement) => {
  editingMovement.value = movement
  form.value = {
    people_id: movement.people_id,
    branch_id: movement.branch_id,
    position_id: movement.position_id,
    start_date: movement.start_date
  }
  formErrors.value = {}

  showModal.value = true

  try {
    await Promise.all([
      loadPeopleList(),
      loadBranches(),
      loadPositions()
    ])
  } catch (error) {
    console.error('Ошибка загрузки данных:', error)
    showNotification('Ошибка загрузки справочных данных', 'error')
  }
}

const openDeleteModal = (movement) => {
  movementToDelete.value = movement
  showDeleteModal.value = true
}

const closeModal = () => {
  if (!isSaving.value) {
    showModal.value = false
    editingMovement.value = null
    form.value = {
      people_id: '',
      branch_id: '',
      position_id: '',
      start_date: new Date().toISOString().split('T')[0]
    }
    formErrors.value = {}
    peopleList.value = []
  }
}

const closeDeleteModal = () => {
  if (!isDeleting.value) {
    showDeleteModal.value = false
    movementToDelete.value = null
  }
}

// Сохранение перемещения
const saveMovement = async () => {
  try {
    isSaving.value = true
    formErrors.value = {}

    const url = editingMovement.value
        ? `${BACKEND_URL}/api/history/people-positions/${editingMovement.value.id}`
        : `${BACKEND_URL}/api/history/people-positions`

    const method = editingMovement.value ? 'put' : 'post'

    const response = await axios[method](url, {
      people_id: form.value.people_id,
      branch_id: form.value.branch_id,
      position_id: form.value.position_id,
      start_date: form.value.start_date
    })

    if (response.data.success) {
      showNotification(
          editingMovement.value
              ? 'Перемещение успешно обновлено'
              : 'Перемещение успешно создано'
      )
      closeModal()
      await loadData()
    } else {
      throw new Error(response.data.message || 'Ошибка сохранения')
    }
  } catch (err) {
    if (err.response?.data?.errors) {
      formErrors.value = err.response.data.errors
      const firstError = Object.values(err.response.data.errors)[0]
      if (firstError) showNotification(firstError, 'error')
    } else {
      formErrors.value = {
        people_id: err.response?.data?.message || err.message || 'Ошибка сохранения'
      }
      showNotification(
          err.response?.data?.message || err.message || 'Ошибка сохранения',
          'error'
      )
    }
  } finally {
    isSaving.value = false
  }
}

// Удаление перемещения
const confirmDelete = async () => {
  if (!movementToDelete.value) return

  try {
    isDeleting.value = true

    const response = await axios.delete(`${BACKEND_URL}/api/history/people-positions/${movementToDelete.value.id}`)

    if (response.data.success) {
      showNotification('Перемещение успешно удалено')
      closeDeleteModal()
      await loadData()
    } else {
      throw new Error(response.data.message || 'Ошибка удаления')
    }
  } catch (err) {
    showNotification(
        err.response?.data?.message || err.message || 'Ошибка удаления',
        'error'
    )
  } finally {
    isDeleting.value = false
  }
}

watch([searchQuery, statusFilter], () => {
  currentPage.value = 1
})

watch(itemsPerPage, () => {
  currentPage.value = 1
})
</script>

<style scoped>
.modal-fade-enter-active,
.modal-fade-leave-active {
  transition: all 0.3s ease;
}

.modal-fade-enter-from,
.modal-fade-leave-to {
  opacity: 0;
}

.modal-fade-enter-from .bg-white,
.modal-fade-leave-to .bg-white {
  transform: scale(0.95);
}

/* Анимация строк таблицы */
tbody tr {
  animation: slideIn 0.3s ease forwards;
  opacity: 0;
  transform: translateY(10px);
}

@keyframes slideIn {
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

tbody tr:nth-child(1) { animation-delay: 0.05s; }
tbody tr:nth-child(2) { animation-delay: 0.1s; }
tbody tr:nth-child(3) { animation-delay: 0.15s; }
tbody tr:nth-child(4) { animation-delay: 0.2s; }
tbody tr:nth-child(5) { animation-delay: 0.25s; }
tbody tr:nth-child(6) { animation-delay: 0.3s; }
tbody tr:nth-child(7) { animation-delay: 0.35s; }
tbody tr:nth-child(8) { animation-delay: 0.4s; }
tbody tr:nth-child(9) { animation-delay: 0.45s; }
tbody tr:nth-child(10) { animation-delay: 0.5s; }

/* Улучшенные hover-эффекты */
tr:hover {
  transform: translateY(-1px);
  box-shadow: 0 4px 12px -2px rgba(59, 130, 246, 0.1);
}

thead tr:hover {
  transform: none;
  box-shadow: none;
}

/* Кастомный скроллбар для таблицы */
.overflow-x-auto::-webkit-scrollbar {
  height: 6px;
}

.overflow-x-auto::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 3px;
}

.overflow-x-auto::-webkit-scrollbar-thumb {
  background: #c1c1c1;
  border-radius: 3px;
}

.overflow-x-auto::-webkit-scrollbar-thumb:hover {
  background: #a1a1a1;
}
</style>

<style>
/* Стили для уведомлений */
.notification {
  padding: 1rem;
  border-radius: 0.75rem;
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
  font-weight: 500;
  transition: all 0.3s ease;
  animation: slideDown 0.3s ease;
}

.notification.success {
  background: linear-gradient(to right, #f0fdf4, #ecfdf5);
  border: 1px solid #bbf7d0;
  color: #065f46;
}

.notification.error {
  background: linear-gradient(to right, #fef2f2, #fdf2f8);
  border: 1px solid #fecaca;
  color: #991b1b;
}

@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.notification-enter-active,
.notification-leave-active {
  transition: all 0.3s ease;
}

.notification-enter-from,
.notification-leave-to {
  opacity: 0;
  transform: translateY(-20px);
}
</style>