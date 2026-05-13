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
              <router-link to="/things" class="text-gray-500 hover:text-gray-700 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
              </router-link>
              <h1 class="text-3xl font-bold text-gray-900">История ответственных за кабинеты</h1>
            </div>
            <p class="text-gray-600">Управление ответственными лицами за аудиториями</p>
          </div>
          <button
              @click="openCreateModal"
              class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-6 py-3 rounded-lg font-semibold shadow-sm transition-all duration-200 flex items-center gap-2 hover:shadow-md"
          >
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Назначить ответственного
          </button>
        </div>

        <!-- Панель поиска -->
        <div class="mt-6">
          <div class="relative max-w-md">
            <input
                v-model="searchQuery"
                type="text"
                placeholder="Поиск по аудитории, отделу или ответственному..."
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
            Все назначения
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
              Текущие ответственные
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
              История назначений
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
            <template v-for="auditorium in paginatedItems" :key="auditorium.id">
              <tr
                  v-for="(responsibility, index) in getCurrentResponsibilities(auditorium)"
                  :key="responsibility.id"
                  class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-200 group"
                  :class="{ 'border-t-2 border-indigo-200': index === 0 && auditorium.auditoriumResponsibilities?.length > 1 }"
              >
                <!-- Аудитория -->
                <td class="px-6 py-4">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-purple-100 to-pink-100 rounded-lg flex items-center justify-center shadow-sm">
                      <svg class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                      </svg>
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors">
                        {{ auditorium.name }}
                      </div>
                      <div class="text-xs text-gray-500">
                        каб. {{ auditorium.number }}, эт. {{ auditorium.floor }}
                        <span v-if="auditorium.area"> | {{ auditorium.area }} м²</span>
                      </div>
                    </div>
                  </div>
                </td>

                <!-- Отдел -->
                <td class="px-6 py-4">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-8 w-8 bg-gradient-to-r from-amber-100 to-yellow-100 rounded-lg flex items-center justify-center mr-3 shadow-sm">
                      <svg class="h-4 w-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                      </svg>
                    </div>
                    <div>
                      <div class="text-sm font-semibold text-gray-900">
                        {{ getBranchName(auditorium.branch_id) }}
                      </div>
                    </div>
                  </div>
                </td>

                <!-- Ответственный -->
                <td class="px-6 py-4">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-8 w-8 bg-gradient-to-r from-green-100 to-emerald-100 rounded-lg flex items-center justify-center mr-3 shadow-sm">
                      <svg class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                      </svg>
                    </div>
                    <div>
                      <div class="text-sm font-semibold text-gray-900">
                        {{ getPersonName(responsibility.people_id) }}
                      </div>
                    </div>
                  </div>
                </td>

                <!-- Период -->
                <td class="px-6 py-4">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-8 w-8 bg-gradient-to-r from-blue-100 to-cyan-100 rounded-lg flex items-center justify-center mr-3 shadow-sm">
                      <svg class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                      </svg>
                    </div>
                    <div>
                      <div class="text-sm font-semibold text-gray-900">
                        {{ formatDate(responsibility.start_date) }}
                        <span v-if="responsibility.end_date" class="text-gray-500"> → {{ formatDate(responsibility.end_date) }}</span>
                        <span v-else class="text-green-600 font-medium ml-2">(текущий)</span>
                      </div>
                      <div class="text-xs text-gray-500">
                        {{ getResponsibilityDuration(responsibility.start_date, responsibility.end_date) }}
                      </div>
                    </div>
                  </div>
                </td>

                <!-- Статус -->
                <td class="px-6 py-4">
                  <span
                      :class="[
                        'px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full',
                        !responsibility.end_date
                          ? 'bg-gradient-to-r from-green-100 to-emerald-100 text-green-800'
                          : 'bg-gradient-to-r from-gray-100 to-blue-100 text-gray-800'
                      ]"
                  >
                    {{ responsibility.end_date ? 'В истории' : 'Актуально' }}
                  </span>
                </td>

                <!-- Действия -->
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center space-x-2">
                    <!-- Кнопка редактирования (только для текущего назначения) -->
                    <button
                        v-if="!responsibility.end_date"
                        @click="openEditModal(responsibility)"
                        class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                        title="Редактировать назначение"
                    >
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                      </svg>
                    </button>

                    <!-- Кнопка удаления (только для текущего назначения) -->
                    <button
                        v-if="!responsibility.end_date"
                        @click="openDeleteModal(responsibility)"
                        class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                        title="Удалить назначение"
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
        <div v-if="!isLoading && filteredAuditoriums.length === 0" class="text-center py-12">
          <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A2 2 0 013 15.382V8.618a2 2 0 011.052-1.768L9 4m0 0l5.447 2.724A2 2 0 0116 8.618v6.764a2 2 0 01-1.052 1.768L9 20m0-16v16" />
          </svg>
          <h3 class="mt-2 text-sm font-medium text-gray-900">Назначения не найдены</h3>
          <p class="mt-1 text-sm text-gray-500">
            {{ searchQuery || statusFilter !== 'all' ? 'Попробуйте изменить параметры поиска' : 'Назначьте первого ответственного' }}
          </p>
        </div>

        <!-- Пагинация -->
        <div v-if="!isLoading && filteredAuditoriums.length > 0" class="px-6 py-4 border-t border-gray-200 bg-gray-50">
          <div class="flex items-center justify-between flex-wrap gap-4">
<!--            <div class="text-sm text-gray-700">-->
<!--              Показано аудиторий с {{ startIndex }} по {{ endIndex }} из {{ filteredAuditoriums.length }}-->
<!--            </div>-->
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
                {{ editingResponsibility ? 'Редактировать назначение' : 'Назначить ответственного' }}
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

            <form @submit.prevent="saveResponsibility">
              <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Аудитория *
                </label>
                <div class="relative">
                  <select
                      v-model="form.auditorium_id"
                      required
                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-white"
                      :disabled="isSaving || auditoriumsFormLoading || !!editingResponsibility"
                  >
                    <option value="">Выберите аудиторию</option>
                    <option
                        v-for="auditorium in auditoriumsForForm"
                        :key="auditorium.id"
                        :value="auditorium.id"
                    >
                      {{ auditorium.name }} (этаж {{ auditorium.floor }}, каб. {{ auditorium.number }})
                    </option>
                  </select>
                  <div v-if="auditoriumsFormLoading" class="absolute right-3 top-3">
                    <svg class="animate-spin h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                  </div>
                </div>
                <p v-if="formErrors.auditorium_id" class="mt-2 text-sm text-red-600">{{ formErrors.auditorium_id }}</p>
              </div>

              <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Ответственный *
                </label>
                <div class="relative">
                  <select
                      v-model="form.people_id"
                      required
                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-white"
                      :disabled="isSaving || peopleLoading"
                  >
                    <option value="">Выберите ответственного</option>
                    <option
                        v-for="person in peopleList"
                        :key="person.id"
                        :value="person.id"
                    >
                      {{ getFullName(person) }}
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
                  Дата назначения *
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
                  {{ isSaving ? 'Сохранение...' : (editingResponsibility ? 'Сохранить' : 'Назначить') }}
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
              <h3 class="text-lg font-bold text-gray-900 mb-2">Удалить назначение</h3>
              <p class="text-gray-600 mb-6">
                Вы уверены, что хотите удалить назначение ответственного
                <span class="font-semibold text-gray-900">"{{ getPersonName(responsibilityToDelete?.people_id) }}"</span>
                для аудитории
                <span class="font-semibold text-gray-900">"{{ getAuditoriumName(responsibilityToDelete?.auditorium_id) }}"</span>?
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
  { key: 'auditorium', label: 'Аудитория' },
  { key: 'branch', label: 'Отдел' },
  { key: 'person', label: 'Ответственный' },
  { key: 'period', label: 'Период' },
  { key: 'status', label: 'Статус' }
])

// Данные для таблицы
const historyItems = ref([])
const auditoriumsForTable = ref([])
const auditoriumsForForm = ref([])  // <-- Добавлено!
const branchesList = ref([])
const peopleList = ref([])

// Состояния загрузки
const isLoading = ref(false)
const auditoriumsFormLoading = ref(false)
const peopleLoading = ref(false)
const error = ref(null)

// Поиск и сортировка
const searchQuery = ref('')
const statusFilter = ref('all')
const sortKey = ref('auditorium')
const sortOrder = ref('asc')

// Пагинация
const currentPage = ref(1)
const itemsPerPage = ref(10)

// Модальные окна
const showModal = ref(false)
const showDeleteModal = ref(false)
const editingResponsibility = ref(null)
const responsibilityToDelete = ref(null)
const isSaving = ref(false)
const isDeleting = ref(false)

// Форма
const form = ref({
  people_id: '',
  auditorium_id: '',
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

// Загрузка данных
const loadData = async () => {
  try {
    isLoading.value = true
    error.value = null

    const [historyResponse, auditoriumsResponse, branchesResponse, peopleResponse] = await Promise.all([
      axios.get(`${BACKEND_URL}/api/history/auditorium-responsibilities`),
      axios.get(`${BACKEND_URL}/api/auditoriums`),
      axios.get(`${BACKEND_URL}/api/info/branches`),
      axios.get(`${BACKEND_URL}/api/people`)
    ])

    if (historyResponse.data.success) {
      historyItems.value = historyResponse.data.data || []
    }

    if (auditoriumsResponse.data.success) {
      auditoriumsForTable.value = auditoriumsResponse.data.data || []
    }

    if (branchesResponse.data.success) {
      branchesList.value = branchesResponse.data.data || []
    }

    if (peopleResponse.data.success) {
      peopleList.value = peopleResponse.data.data || []
    }

  } catch (err) {
    error.value = err.response?.data?.message || err.message || 'Ошибка соединения'
  } finally {
    isLoading.value = false
  }
}

// Загрузка аудиторий для формы
const loadAuditoriumsForForm = async () => {
  try {
    auditoriumsFormLoading.value = true
    const response = await axios.get(`${BACKEND_URL}/api/auditoriums`)
    if (response.data.success) {
      auditoriumsForForm.value = response.data.data || []
    }
  } catch (err) {
    console.error('Ошибка загрузки аудиторий:', err)
    showNotification('Ошибка загрузки списка аудиторий', 'error')
  } finally {
    auditoriumsFormLoading.value = false
  }
}

// Загрузка людей для формы
const loadPeopleList = async () => {
  try {
    peopleLoading.value = true
    const response = await axios.get(`${BACKEND_URL}/api/people`)
    if (response.data.success) {
      peopleList.value = response.data.data || []
    }
  } catch (err) {
    console.error('Ошибка загрузки людей:', err)
    showNotification('Ошибка загрузки списка людей', 'error')
  } finally {
    peopleLoading.value = false
  }
}

onMounted(() => {
  loadData()
})

// Вспомогательные функции
const getFullName = (person) => {
  if (!person) return ''
  const parts = [person.surname, person.firstname, person.patronymic].filter(Boolean)
  return parts.join(' ')
}

const getPersonName = (personId) => {
  const person = peopleList.value.find(p => p.id === personId)
  return person ? getFullName(person) : 'Неизвестный'
}

const getAuditoriumName = (auditoriumId) => {
  const auditorium = auditoriumsForTable.value.find(a => a.id === auditoriumId)
  return auditorium ? auditorium.name : 'Неизвестная аудитория'
}

const getBranchName = (branchId) => {
  const branch = branchesList.value.find(b => b.id === branchId)
  return branch ? branch.name : 'Неизвестный отдел'
}

const formatDate = (dateString) => {
  if (!dateString) return 'не указана'
  const date = new Date(dateString)
  return date.toLocaleDateString('ru-RU')
}

const getResponsibilityDuration = (startDate, endDate) => {
  if (!startDate) return 'не указано'
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

const hasCurrentResponsibility = (auditoriumId) => {
  const auditorium = historyItems.value.find(a => a.id === auditoriumId)
  if (!auditorium || !auditorium.auditoriumResponsibilities) return false
  return auditorium.auditoriumResponsibilities.some(r => !r.end_date)
}

const getCurrentResponsibilities = (auditorium) => {
  if (!auditorium.auditoriumResponsibilities) return []
  return [...auditorium.auditoriumResponsibilities].sort((a, b) => {
    if (!a.end_date && b.end_date) return -1
    if (a.end_date && !b.end_date) return 1
    return new Date(b.start_date || 0) - new Date(a.start_date || 0)
  })
}

// Фильтрация
const filteredAuditoriums = computed(() => {
  let filtered = historyItems.value

  if (statusFilter.value === 'current') {
    filtered = filtered.filter(auditorium =>
        auditorium.auditoriumResponsibilities?.some(r => !r.end_date)
    )
  } else if (statusFilter.value === 'history') {
    filtered = filtered.filter(auditorium =>
        auditorium.auditoriumResponsibilities?.some(r => r.end_date)
    )
  }
  else if (statusFilter.value === 'all') {
    filtered = filtered.filter(auditorium =>
        auditorium.auditoriumResponsibilities?.some(r => !r.end_date)
    )
  }

  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(auditorium => {
      // Поиск по аудитории
      if (auditorium.name.toLowerCase().includes(query) ||
          auditorium.number.toLowerCase().includes(query)) {
        return true
      }

      // Поиск по отделу
      const branch = branchesList.value.find(b => b.id === auditorium.branch_id)
      if (branch?.name.toLowerCase().includes(query)) {
        return true
      }

      // Поиск по ответственному
      return auditorium.auditoriumResponsibilities?.some(r => {
        const person = peopleList.value.find(p => p.id === r.people_id)
        return person && getFullName(person).toLowerCase().includes(query)
      })
    })
  }

  filtered = [...filtered].sort((a, b) => {
    let aVal, bVal

    switch (sortKey.value) {
      case 'auditorium':
        aVal = a.name
        bVal = b.name
        break
      case 'branch':
        aVal = getBranchName(a.branch_id)
        bVal = getBranchName(b.branch_id)
        break
      case 'person':
        const aCurrent = a.auditoriumResponsibilities?.find(r => !r.end_date)
        const bCurrent = b.auditoriumResponsibilities?.find(r => !r.end_date)
        aVal = getPersonName(aCurrent?.people_id)
        bVal = getPersonName(bCurrent?.people_id)
        break
      case 'status':
        aVal = a.auditoriumResponsibilities?.some(r => !r.end_date) ? 1 : 0
        bVal = b.auditoriumResponsibilities?.some(r => !r.end_date) ? 1 : 0
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
const totalPages = computed(() => Math.ceil(filteredAuditoriums.value.length / itemsPerPage.value))

const paginatedItems = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return filteredAuditoriums.value.slice(start, end)
})

const startIndex = computed(() => (currentPage.value - 1) * itemsPerPage.value + 1)
const endIndex = computed(() => Math.min(currentPage.value * itemsPerPage.value, filteredAuditoriums.value.length))

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
  editingResponsibility.value = null
  form.value = {
    people_id: '',
    auditorium_id: '',
    start_date: new Date().toISOString().split('T')[0]
  }
  formErrors.value = {}

  showModal.value = true

  try {
    await Promise.all([
      loadAuditoriumsForForm(),
      loadPeopleList()
    ])
  } catch (error) {
    console.error('Ошибка загрузки данных:', error)
    showNotification('Ошибка загрузки данных', 'error')
  }
}

const openEditModal = async (responsibility) => {
  editingResponsibility.value = responsibility
  form.value = {
    people_id: responsibility.people_id,
    auditorium_id: responsibility.auditorium_id,
    start_date: responsibility.start_date
  }
  formErrors.value = {}

  showModal.value = true

  try {
    await Promise.all([
      loadAuditoriumsForForm(),
      loadPeopleList()
    ])
  } catch (error) {
    console.error('Ошибка загрузки данных:', error)
    showNotification('Ошибка загрузки данных', 'error')
  }
}

const openDeleteModal = (responsibility) => {
  responsibilityToDelete.value = responsibility
  showDeleteModal.value = true
}

const closeModal = () => {
  if (!isSaving.value) {
    showModal.value = false
    editingResponsibility.value = null
    form.value = {
      people_id: '',
      auditorium_id: '',
      start_date: new Date().toISOString().split('T')[0]
    }
    formErrors.value = {}
    auditoriumsForForm.value = []
    // Не очищаем peopleList.value, так как он используется в таблице
  }
}

const closeDeleteModal = () => {
  if (!isDeleting.value) {
    showDeleteModal.value = false
    responsibilityToDelete.value = null
  }
}

// Сохранение назначения
const saveResponsibility = async () => {
  try {
    isSaving.value = true
    formErrors.value = {}

    const url = editingResponsibility.value
        ? `${BACKEND_URL}/api/history/auditorium-responsibilities/${editingResponsibility.value.id}`
        : `${BACKEND_URL}/api/history/auditorium-responsibilities`

    const method = editingResponsibility.value ? 'put' : 'post'

    const response = await axios[method](url, {
      people_id: form.value.people_id,
      auditorium_id: form.value.auditorium_id,
      start_date: form.value.start_date
    })

    if (response.data.success) {
      showNotification(
          editingResponsibility.value
              ? 'Назначение успешно обновлено'
              : 'Ответственный успешно назначен'
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

// Удаление назначения
const confirmDelete = async () => {
  if (!responsibilityToDelete.value) return

  try {
    isDeleting.value = true

    const response = await axios.delete(`${BACKEND_URL}/api/history/auditorium-responsibilities/${responsibilityToDelete.value.id}`)

    if (response.data.success) {
      showNotification('Назначение успешно удалено')
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

tbody tr:nth-child(1) {
  animation-delay: 0.05s;
}

tbody tr:nth-child(2) {
  animation-delay: 0.1s;
}

tbody tr:nth-child(3) {
  animation-delay: 0.15s;
}

tbody tr:nth-child(4) {
  animation-delay: 0.2s;
}

tbody tr:nth-child(5) {
  animation-delay: 0.25s;
}

tbody tr:nth-child(6) {
  animation-delay: 0.3s;
}

tbody tr:nth-child(7) {
  animation-delay: 0.35s;
}

tbody tr:nth-child(8) {
  animation-delay: 0.4s;
}

tbody tr:nth-child(9) {
  animation-delay: 0.45s;
}

tbody tr:nth-child(10) {
  animation-delay: 0.5s;
}

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