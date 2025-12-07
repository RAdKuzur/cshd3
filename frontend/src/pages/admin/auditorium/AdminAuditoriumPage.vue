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
              <router-link to="/admin" class="text-gray-500 hover:text-gray-700 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
              </router-link>
              <h1 class="text-3xl font-bold text-gray-900">Помещения</h1>
            </div>
            <p class="text-gray-600">Управление кабинетами и помещениями</p>
          </div>
          <button
              @click="openCreateModal"
              class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-6 py-3 rounded-lg font-semibold shadow-sm transition-all duration-200 flex items-center gap-2 hover:shadow-md"
          >
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Добавить кабинет
          </button>
        </div>

        <!-- Панель поиска и фильтров -->
        <div class="mt-6 flex gap-4 flex-wrap">
          <div class="flex-1 min-w-[300px]">
            <div class="relative">
              <input
                  v-model="searchQuery"
                  type="text"
                  placeholder="Поиск по названию, номеру, этажу..."
                  class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm bg-white"
              >
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </div>
            </div>
          </div>

          <div class="flex gap-4 flex-wrap">
            <select
                v-model="floorFilter"
                class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
            >
              <option value="">Все этажи</option>
              <option v-for="floor in availableFloors" :key="floor" :value="floor">
                {{ floor }} этаж
              </option>
            </select>

            <select
                v-model="departmentFilter"
                class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
            >
              <option value="">Все секторы</option>
              <option v-for="department in departments" :key="department.id" :value="department.id">
                {{ department.name }}
              </option>
            </select>

            <select
                v-model="sortField"
                class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
            >
              <option value="name">Сортировка по названию</option>
              <option value="floor">По этажу</option>
              <option value="number">По номеру</option>
              <option value="department_id">По сектору</option>
            </select>
          </div>
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
            <thead class="bg-gradient-to-r from-emerald-500 to-teal-600">
            <tr>
              <th
                  v-for="header in headers"
                  :key="header.key"
                  class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider cursor-pointer hover:bg-teal-700 transition-colors"
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
            <tr
                v-for="auditorium in paginatedItems"
                :key="auditorium.id"
                class="hover:bg-gradient-to-r hover:from-emerald-50 hover:to-teal-50 transition-all duration-200 group"
            >
              <!-- ID -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-emerald-100 to-teal-100 rounded-lg flex items-center justify-center shadow-sm">
                    <span class="text-sm font-bold text-teal-700">#{{ auditorium.id }}</span>
                  </div>
                  <div class="ml-4">
                    <div class="text-xs text-gray-500 font-medium">
                      ID
                    </div>
                    <div class="text-sm font-semibold text-gray-900">
                      {{ auditorium.id }}
                    </div>
                  </div>
                </div>
              </td>

              <!-- Название и номер -->
              <td class="px-6 py-4">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-8 w-8 bg-gradient-to-r from-emerald-100 to-teal-100 rounded-lg flex items-center justify-center mr-3 shadow-sm">
                    <svg class="h-4 w-4 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                  </div>
                  <div>
                    <div class="text-lg font-semibold text-gray-900 group-hover:text-teal-600 transition-colors">
                      {{ auditorium.name }}
                    </div>
                    <div class="text-xs text-gray-500">
                      Номер: {{ auditorium.number }}
                    </div>
                  </div>
                </div>
              </td>

              <!-- Этаж -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-8 w-8 bg-gradient-to-r from-blue-100 to-indigo-100 rounded-lg flex items-center justify-center mr-3 shadow-sm">
                    <svg class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                  </div>
                  <div>
                    <div class="text-sm font-medium text-gray-900">
                      {{ auditorium.floor }} этаж
                    </div>
                    <div class="text-xs text-gray-500">
                      Этаж
                    </div>
                  </div>
                </div>
              </td>

              <!-- Сектор -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div :class="getDepartmentColor(auditorium.department_id)" class="flex-shrink-0 h-8 w-8 rounded-lg flex items-center justify-center mr-3 shadow-sm">
                    <span class="text-sm font-bold text-white">{{ getDepartmentName(auditorium.department_id) }}</span>
                  </div>
                  <div>
                    <div class="text-sm font-medium text-gray-900">
                      {{ getDepartmentFullName(auditorium.department_id) }}
                    </div>
                    <div class="text-xs text-gray-500">
                      Сектор
                    </div>
                  </div>
                </div>
              </td>

              <!-- Действия -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center space-x-2">
                  <!-- Кнопка редактирования -->
                  <button
                      @click="openEditModal(auditorium)"
                      class="p-2 text-gray-400 hover:text-teal-600 hover:bg-teal-50 rounded-lg transition-colors"
                      title="Редактировать"
                  >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                  </button>

                  <!-- Кнопка удаления -->
                  <button
                      @click="openDeleteModal(auditorium)"
                      class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                      title="Удалить"
                  >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                  </button>
                </div>
              </td>
            </tr>
            </tbody>
          </table>
        </div>

        <!-- Пустое состояние -->
        <div v-if="!isLoading && filteredAuditoriums.length === 0" class="text-center py-12">
          <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
          </svg>
          <h3 class="mt-2 text-sm font-medium text-gray-900">Кабинеты не найдены</h3>
          <p class="mt-1 text-sm text-gray-500">
            {{ searchQuery || floorFilter || departmentFilter ? 'Попробуйте изменить параметры поиска' : 'Добавьте первый кабинет' }}
          </p>
        </div>

        <!-- Пагинация -->
        <div v-if="!isLoading && filteredAuditoriums.length > 0" class="px-6 py-4 border-t border-gray-200 bg-gray-50">
          <div class="flex items-center justify-between flex-wrap gap-4">
            <div class="text-sm text-gray-700">
              Показано с {{ startIndex }} по {{ endIndex }} из {{ filteredAuditoriums.length }} записей
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
                    ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-sm'
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
                class="px-3 py-1 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white"
            >
              <option value="10">10 на странице</option>
              <option value="20">20 на странице</option>
              <option value="50">50 на странице</option>
              <option value="100">100 на странице</option>
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
                {{ editingAuditorium ? 'Редактировать кабинет' : 'Создать кабинет' }}
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

            <form @submit.prevent="saveAuditorium">
              <div class="space-y-4">
                <!-- Название -->
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">
                    Название кабинета
                  </label>
                  <input
                      v-model="form.name"
                      type="text"
                      required
                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                      placeholder="Например: C7010"
                      :disabled="isSaving"
                  />
                  <p v-if="formErrors.name" class="mt-1 text-sm text-red-600">{{ formErrors.name }}</p>
                </div>

                <!-- Номер -->
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">
                    Номер кабинета
                  </label>
                  <input
                      v-model="form.number"
                      type="text"
                      required
                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                      placeholder="Например: 7010"
                      :disabled="isSaving"
                  />
                  <p v-if="formErrors.number" class="mt-1 text-sm text-red-600">{{ formErrors.number }}</p>
                </div>

                <!-- Этаж -->
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">
                    Этаж
                  </label>
                  <input
                      v-model="form.floor"
                      type="number"
                      required
                      min="0"
                      max="20"
                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                      placeholder="Например: 7"
                      :disabled="isSaving"
                  />
                  <p v-if="formErrors.floor" class="mt-1 text-sm text-red-600">{{ formErrors.floor }}</p>
                </div>

                <!-- Сектор -->
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">
                    Сектор
                  </label>
                  <select
                      v-model="form.department_id"
                      required
                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                      :disabled="isSaving"
                  >
                    <option value="">Выберите сектор</option>
                    <option v-for="department in departments" :key="department.id" :value="department.id">
                      {{ department.name }} ({{ department.id }})
                    </option>
                  </select>
                  <p v-if="formErrors.department_id" class="mt-1 text-sm text-red-600">{{ formErrors.department_id }}</p>
                </div>
              </div>

              <div class="flex justify-end gap-3 mt-6">
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
                    class="px-6 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-medium rounded-lg hover:from-emerald-700 hover:to-teal-700 disabled:opacity-50 disabled:cursor-not-allowed transition-all shadow-sm hover:shadow flex items-center gap-2"
                >
                  <svg v-if="isSaving" class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  {{ isSaving ? 'Сохранение...' : (editingAuditorium ? 'Сохранить' : 'Создать') }}
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
              <h3 class="text-lg font-bold text-gray-900 mb-2">Удалить кабинет</h3>
              <p class="text-gray-600 mb-6">
                Вы уверены, что хотите удалить кабинет
                <span class="font-semibold text-gray-900">"{{ auditoriumToDelete?.name }}"</span>?
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
  { key: 'id', label: 'ID' },
  { key: 'name', label: 'Название и номер' },
  { key: 'floor', label: 'Этаж' },
  { key: 'department_id', label: 'Сектор' }
])

const auditoriums = ref([])
const departments = ref([])
const isLoading = ref(false)
const error = ref(null)

// Поиск и фильтры
const searchQuery = ref('')
const floorFilter = ref('')
const departmentFilter = ref('')
const sortField = ref('name')
const sortKey = ref('name')
const sortOrder = ref('asc')

// Пагинация
const currentPage = ref(1)
const itemsPerPage = ref(20)

// Модальные окна
const showModal = ref(false)
const showDeleteModal = ref(false)
const editingAuditorium = ref(null)
const auditoriumToDelete = ref(null)
const isSaving = ref(false)
const isDeleting = ref(false)

// Форма
const form = ref({
  name: '',
  number: '',
  floor: '',
  department_id: ''
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

    // Загружаем данные параллельно
    const [auditoriumsResponse, departmentsResponse] = await Promise.all([
      axios.get(BACKEND_URL + '/api/admin/auditoriums/index'),
      axios.get(BACKEND_URL + '/api/info/departments')
    ])

    if (auditoriumsResponse.data.success) {
      auditoriums.value = auditoriumsResponse.data.data || []
    } else {
      throw new Error(auditoriumsResponse.data.message || 'Не удалось загрузить список кабинетов')
    }

    if (departmentsResponse.data.success) {
      departments.value = departmentsResponse.data.data || []
    } else {
      throw new Error(departmentsResponse.data.message || 'Не удалось загрузить список секторов')
    }
  } catch (err) {
    console.error('Ошибка при загрузке данных:', err)
    error.value = err.response?.data?.message || err.message || 'Ошибка соединения'
  } finally {
    isLoading.value = false
  }
}

onMounted(() => {
  loadData()
})

// Вычисляемые свойства
const availableFloors = computed(() => {
  const floors = new Set()
  auditoriums.value.forEach(auditorium => {
    if (auditorium.floor !== null && auditorium.floor !== undefined) {
      floors.add(auditorium.floor)
    }
  })
  return Array.from(floors).sort((a, b) => a - b)
})

const filteredAuditoriums = computed(() => {
  let filtered = auditoriums.value

  // Фильтрация по поиску
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(auditorium =>
        (auditorium.name && auditorium.name.toLowerCase().includes(query)) ||
        (auditorium.number && auditorium.number.toString().toLowerCase().includes(query)) ||
        (getDepartmentFullName(auditorium.department_id) && getDepartmentFullName(auditorium.department_id).toLowerCase().includes(query))
    )
  }

  // Фильтрация по этажу
  if (floorFilter.value !== '') {
    const floor = parseInt(floorFilter.value)
    filtered = filtered.filter(auditorium => auditorium.floor === floor)
  }

  // Фильтрация по сектору
  if (departmentFilter.value !== '') {
    const departmentId = parseInt(departmentFilter.value)
    filtered = filtered.filter(auditorium => auditorium.department_id === departmentId)
  }

  // Сортировка
  filtered = [...filtered].sort((a, b) => {
    let aVal = a[sortKey.value]
    let bVal = b[sortKey.value]

    if (sortKey.value === 'name') {
      aVal = aVal || ''
      bVal = bVal || ''
    } else if (sortKey.value === 'department_id') {
      // Сортировка по названию сектора
      aVal = getDepartmentFullName(a.department_id) || ''
      bVal = getDepartmentFullName(b.department_id) || ''
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

// Методы
const getDepartmentName = (departmentId) => {
  if (!departmentId) return '?'
  const department = departments.value.find(d => d.id === departmentId)
  return department ? department.name : '?'
}

const getDepartmentFullName = (departmentId) => {
  if (!departmentId) return 'Не указан'
  const department = departments.value.find(d => d.id === departmentId)
  return department ? `Сектор ${department.name}` : 'Неизвестный сектор'
}

const getDepartmentColor = (departmentId) => {
  const colors = {
    1: 'bg-gradient-to-br from-blue-500 to-blue-600', // A - синий
    2: 'bg-gradient-to-br from-emerald-500 to-emerald-600', // B - зеленый
    3: 'bg-gradient-to-br from-amber-500 to-amber-600', // C - оранжевый
    4: 'bg-gradient-to-br from-purple-500 to-purple-600' // D - фиолетовый
  }
  return colors[departmentId] || 'bg-gradient-to-br from-gray-400 to-gray-500'
}

const sortTable = (key) => {
  if (sortKey.value === key) {
    sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc'
  } else {
    sortKey.value = key
    sortOrder.value = 'asc'
  }
}

const prevPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--
  }
}

const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++
  }
}

const goToPage = (page) => {
  currentPage.value = page
}

// Работа с модальными окнами
const openCreateModal = () => {
  editingAuditorium.value = null
  form.value = {
    name: '',
    number: '',
    floor: '',
    department_id: ''
  }
  formErrors.value = {}
  showModal.value = true
}

const openEditModal = (auditorium) => {
  editingAuditorium.value = auditorium
  form.value = {
    name: auditorium.name,
    number: auditorium.number,
    floor: auditorium.floor,
    department_id: auditorium.department_id
  }
  formErrors.value = {}
  showModal.value = true
}

const openDeleteModal = (auditorium) => {
  auditoriumToDelete.value = auditorium
  showDeleteModal.value = true
}

const closeModal = () => {
  if (!isSaving.value) {
    showModal.value = false
    editingAuditorium.value = null
    form.value = {
      name: '',
      number: '',
      floor: '',
      department_id: ''
    }
    formErrors.value = {}
  }
}

const closeDeleteModal = () => {
  if (!isDeleting.value) {
    showDeleteModal.value = false
    auditoriumToDelete.value = null
  }
}

// Сохранение кабинета
const saveAuditorium = async () => {
  try {
    isSaving.value = true
    formErrors.value = {}

    const url = editingAuditorium.value
        ? `${BACKEND_URL}/api/admin/auditoriums/update/${editingAuditorium.value.id}`
        : `${BACKEND_URL}/api/admin/auditoriums/store`

    const method = editingAuditorium.value ? 'put' : 'post'

    const response = await axios[method](url, form.value)

    if (response.data.success) {
      showNotification(
          editingAuditorium.value
              ? 'Кабинет успешно обновлен'
              : 'Кабинет успешно создан'
      )

      closeModal()
      await loadData()
    } else {
      throw new Error(response.data.message || 'Ошибка сохранения')
    }
  } catch (err) {
    console.error('Ошибка при сохранении кабинета:', err)

    if (err.response?.data?.errors) {
      formErrors.value = err.response.data.errors

      const firstError = Object.values(err.response.data.errors)[0]
      if (firstError) {
        showNotification(firstError, 'error')
      }
    } else {
      formErrors.value = {
        name: err.response?.data?.message || err.message || 'Ошибка сохранения'
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

// Удаление кабинета
const confirmDelete = async () => {
  if (!auditoriumToDelete.value) return

  try {
    isDeleting.value = true

    const response = await axios.delete(`${BACKEND_URL}/api/admin/auditoriums/delete/${auditoriumToDelete.value.id}`)

    if (response.data.success) {
      showNotification('Кабинет успешно удален')
      closeDeleteModal()
      await loadData()
    } else {
      throw new Error(response.data.message || 'Ошибка удаления')
    }
  } catch (err) {
    console.error('Ошибка при удалении кабинета:', err)
    showNotification(
        err.response?.data?.message || err.message || 'Ошибка удаления',
        'error'
    )
  } finally {
    isDeleting.value = false
  }
}

// Сброс пагинации при изменении фильтров
watch([searchQuery, floorFilter, departmentFilter], () => {
  currentPage.value = 1
})

watch([sortField], () => {
  sortKey.value = sortField.value
  sortOrder.value = 'asc'
})

watch(itemsPerPage, () => {
  currentPage.value = 1
})
</script>

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

<style scoped>
/* Ваши существующие стили */
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
  box-shadow: 0 4px 12px -2px rgba(16, 185, 129, 0.1);
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