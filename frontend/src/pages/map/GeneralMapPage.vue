<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-4 md:p-6">
    <div class="max-w-7xl mx-auto relative">
      <!-- Слайдборд -->
      <div
          class="slideboard"
          :class="{ 'slideboard-open': selectedAuditorium }"
      >
        <div class="slideboard-content">
          <!-- Шапка слайдборда -->
          <div class="sticky top-0 z-10 bg-white border-b border-gray-200 px-6 py-4">
            <div class="flex items-center justify-between">
              <div class="flex items-center">
                <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center mr-3">
                  <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                  </svg>
                </div>
                <div>
                  <h2 class="text-xl font-bold text-gray-900">{{ selectedAuditorium?.auditorium_name }}</h2>
                  <div class="flex items-center mt-1">
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full mr-2">
                      {{ selectedAuditorium?.floor }} этаж
                    </span>
                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full mr-2">
                      {{ getBuildingFromName(selectedAuditorium?.auditorium_name) }}
                    </span>
                    <span v-if="getBranchName(selectedAuditorium?.branch_id)"
                          class="px-2 py-1 bg-purple-100 text-purple-800 text-xs font-medium rounded-full">
                      {{ getBranchName(selectedAuditorium?.branch_id) }}
                    </span>
                  </div>
                </div>
              </div>
              <button
                  @click="selectedAuditorium = null"
                  class="text-gray-400 hover:text-gray-600 transition-colors p-2 hover:bg-gray-100 rounded-lg"
              >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
          </div>

          <!-- Содержимое слайдборда -->
          <div class="p-6 overflow-y-auto h-[calc(100vh-200px)]">
            <!-- Статистика -->
            <div class="grid grid-cols-4 gap-4 mb-6">
              <div class="bg-blue-50 rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-blue-700">{{ selectedAuditorium?.things?.length || 0 }}</div>
                <div class="text-sm text-blue-600 mt-1">Объект</div>
              </div>
              <div class="bg-green-50 rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-green-700">{{ workingThingsCount }}</div>
                <div class="text-sm text-green-600 mt-1">Исправно</div>
              </div>
              <div class="bg-amber-50 rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-amber-700">{{ selectedAuditorium?.things?.length - workingThingsCount }}</div>
                <div class="text-sm text-amber-600 mt-1">Требует внимания</div>
              </div>
              <div class="bg-teal-50 rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-teal-700">{{ selectedAuditoriumTelephones.length || 0 }}</div>
                <div class="text-sm text-teal-600 mt-1">Телефон</div>
              </div>
            </div>

            <!-- Список сотрудников -->
            <div class="mb-8">
              <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Сотрудники кабинета
              </h3>

              <div v-if="!selectedAuditorium?.employees?.length" class="bg-gray-50 rounded-xl p-6 text-center">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                <p class="text-gray-600">В кабинете нет закрепленных сотрудников</p>
              </div>

              <div v-else class="space-y-3">
                <div
                    v-for="employee in selectedAuditorium.employees"
                    :key="employee.fio + employee.position"
                    class="group bg-white border border-gray-200 rounded-lg p-4 hover:border-purple-300 hover:shadow-sm transition-all"
                >
                  <div class="flex items-start">
                    <div class="flex-shrink-0 mr-4">
                      <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                      </div>
                    </div>
                    <div class="flex-1">
                      <h4 class="font-semibold text-gray-900 mb-1">{{ employee.fio }}</h4>
                      <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span>{{ employee.position }}</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Список телефонов -->
            <div v-if="selectedAuditoriumTelephones.length" class="mb-8">
              <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                Телефоны в кабинете
              </h3>

              <div class="space-y-3">
                <div
                    v-for="phone in selectedAuditoriumTelephones"
                    :key="phone.id"
                    class="group bg-white border border-gray-200 rounded-lg p-4 hover:border-teal-300 hover:shadow-sm transition-all"
                >
                  <div class="flex items-center justify-between">
                    <div class="flex items-center">
                      <div class="w-10 h-10 bg-teal-100 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                      </div>
                      <div>
                        <a
                            :href="'tel:' + phone.phone_number.replace(/\D/g, '')"
                            class="font-semibold text-gray-900 hover:text-teal-600 transition-colors"
                        >
                          {{ formatPhoneNumber(phone.phone_number) }}
                        </a>
                        <div class="text-sm text-gray-500 mt-1">
                          {{ phone.thing_id ? 'Номер телефона' : null }}
                        </div>
                      </div>
                    </div>
                    <svg class="w-5 h-5 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                    </svg>
                  </div>
                </div>
              </div>
            </div>

            <!-- Пустой список телефонов -->
            <div v-else class="mb-8">
              <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                Телефоны в кабинете
              </h3>

              <div class="bg-gray-50 rounded-xl p-6 text-center">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                </svg>
                <p class="text-gray-600">В кабинете нет телефонов</p>
              </div>
            </div>

            <!-- Список объектов -->
            <div class="mb-8">
              <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Объекты учёта
              </h3>

              <div v-if="!selectedAuditorium?.things?.length" class="bg-gray-50 rounded-xl p-6 text-center">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-gray-600">В кабинете нет объектов учёта</p>
              </div>

              <div v-else class="space-y-3">
                <div
                    v-for="thing in selectedAuditorium.things"
                    :key="thing.id"
                    class="group bg-white border border-gray-200 rounded-lg p-4 hover:border-blue-300 hover:shadow-sm transition-all cursor-pointer"
                    @click="viewThing(thing.id)"
                >
                  <div class="flex items-start justify-between">
                    <div class="flex-1">
                      <div class="flex items-center mb-2">
                        <div :class="getConditionColor(thing.condition)" class="w-2 h-2 rounded-full mr-2"></div>
                        <h4 class="font-medium text-gray-900">{{ thing.name || `Объект ${thing.id}` }}</h4>
                      </div>
                      <div class="grid grid-cols-2 gap-2 text-sm text-gray-600">
                        <div class="flex items-center">
                          <span class="font-medium mr-1">Инв. №:</span>
                          <span class="font-mono text-xs">{{ thing.inv_number }}</span>
                        </div>
                        <div class="flex items-center">
                          <span class="font-medium mr-1">Сер. №:</span>
                          <span class="font-mono text-xs">{{ thing.serial_number }}</span>
                        </div>
                        <div class="flex items-center">
                          <span class="font-medium mr-1">Тип:</span>
                          <span>{{ getTypeName(thing.thing_type_id) }}</span>
                        </div>
                        <div class="flex items-center">
                          <span class="font-medium mr-1">Учёт:</span>
                          <span class="text-indigo-600 font-medium">{{ getBalanceLabel(thing.balance) }}</span>
                        </div>
                      </div>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                  </div>
                </div>
              </div>
            </div>

            <!-- Назначение кабинета -->
            <div v-if="selectedAuditorium?.comment" class="mb-8">
              <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                </svg>
                Назначение кабинета
              </h3>

              <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-5 border border-blue-100">
                <div class="flex items-start">
                  <div class="flex-shrink-0 mr-3 mt-1">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                      <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h1m0-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                    </div>
                  </div>
                  <div class="flex-1">
                    <p class="text-gray-700 leading-relaxed">{{ selectedAuditorium.comment }}</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Детали кабинета -->
            <div>
              <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h1m0-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Информация о кабинете
              </h3>

              <div class="bg-gray-50 rounded-xl p-5">
                <div class="space-y-4">
                  <div class="grid grid-cols-2 gap-4">
                    <div>
                      <div class="text-sm text-gray-500 mb-1">Корпус</div>
                      <div class="font-medium">{{ getBuildingFromName(selectedAuditorium?.auditorium_name) }}</div>
                    </div>
                    <div>
                      <div class="text-sm text-gray-500 mb-1">Этаж</div>
                      <div class="font-medium">{{ selectedAuditorium?.floor }}</div>
                    </div>
                  </div>
                  <div>
                    <div class="text-sm text-gray-500 mb-1">Название кабинета</div>
                    <div class="font-medium">{{ selectedAuditorium?.auditorium_name }}</div>
                  </div>
                  <div v-if="getBranchName(selectedAuditorium?.branch_id)">
                    <div class="text-sm text-gray-500 mb-1">Отдел</div>
                    <div class="font-medium text-purple-700">{{ getBranchName(selectedAuditorium?.branch_id) }}</div>
                  </div>
                  <div class="grid grid-cols-2 gap-4">
                    <div>
                      <div class="text-sm text-gray-500 mb-1">Объекты учёта</div>
                      <div class="font-medium">{{ selectedAuditorium?.things?.length || 0 }} единиц</div>
                    </div>
                    <div>
                      <div class="text-sm text-gray-500 mb-1">Телефоны</div>
                      <div class="font-medium text-teal-600">{{ selectedAuditoriumTelephones.length || 0 }} шт.</div>
                    </div>
                  </div>
                  <div class="grid grid-cols-2 gap-4">
                    <div>
                      <div class="text-sm text-gray-500 mb-1">Сотрудников</div>
                      <div class="font-medium text-purple-600">{{ selectedAuditorium?.employees?.length || 0 }} чел.</div>
                    </div>
                    <div v-if="workingThingsCount > 0">
                      <div class="text-sm text-gray-500 mb-1">Исправных объектов</div>
                      <div class="font-medium text-green-600">{{ workingThingsCount }} шт.</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Оверлей при открытом слайдборде -->
      <div
          v-if="selectedAuditorium"
          class="slideboard-overlay"
          @click="selectedAuditorium = null"
      ></div>

      <!-- Заголовок -->
      <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Интерактивный план здания</h1>
        <p class="text-xl text-gray-600">Нажмите на кабинет для просмотра информации</p>
      </div>

      <!-- Панель управления -->
      <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 mb-8">
        <div class="flex flex-col lg:flex-row items-start justify-between gap-6">
          <!-- Поиск -->
          <div class="w-full lg:flex-1">
            <div class="relative w-full">
              <input
                  v-model="searchQuery"
                  type="text"
                  placeholder="Поиск по названию кабинета, объектам, сотрудникам, телефонам..."
                  class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg
             focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
             bg-white shadow-sm"
              >
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </div>
            </div>
          </div>

          <!-- Кнопка сброса фильтров -->
          <button
              v-if="selectedBuildings.length > 0 || selectedBranches.length > 0"
              @click="resetFilters"
              class="px-4 py-3 text-sm text-red-600 hover:text-red-700 font-medium flex items-center gap-2 transition-colors whitespace-nowrap"
          >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            Сбросить фильтры
          </button>
        </div>

        <!-- Фильтры в виде чекбоксов -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6 pt-6 border-t border-gray-200">
          <!-- Фильтр по корпусам -->
          <div>
            <div class="flex items-center justify-between mb-3">
              <label class="text-sm font-semibold text-gray-700 flex items-center">
                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                Корпуса
              </label>
              <button
                  @click="toggleAllBuildings"
                  class="text-xs text-indigo-600 hover:text-indigo-700 font-medium"
              >
                {{ selectedBuildings.length === buildings.length ? 'Снять все' : 'Выбрать все' }}
              </button>
            </div>
            <div class="flex flex-wrap gap-3">
              <label
                  v-for="building in buildings"
                  :key="building"
                  class="inline-flex items-center cursor-pointer group"
              >
                <div class="relative">
                  <input
                      type="checkbox"
                      :value="building"
                      v-model="selectedBuildings"
                      class="sr-only peer"
                  >
                  <div class="w-5 h-5 border-2 rounded-md transition-all duration-200
                              peer-checked:bg-indigo-600 peer-checked:border-indigo-600
                              border-gray-300 group-hover:border-indigo-400
                              flex items-center justify-center">
                    <svg
                        v-show="selectedBuildings.includes(building)"
                        class="w-3 h-3 text-white"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                  </div>
                </div>
                <span class="ml-2 text-sm text-gray-700 group-hover:text-gray-900 transition-colors">
                  {{ building }}
                </span>
              </label>
            </div>
            <div class="mt-2 text-xs text-gray-500">
              Выбрано: {{ selectedBuildings.length }} из {{ buildings.length }}
            </div>
          </div>

          <!-- Фильтр по отделам -->
          <div>
            <div class="flex items-center justify-between mb-3">
              <label class="text-sm font-semibold text-gray-700 flex items-center">
                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                Отделы
              </label>
              <button
                  @click="toggleAllBranches"
                  class="text-xs text-indigo-600 hover:text-indigo-700 font-medium"
              >
                {{ selectedBranches.length === branchesList.length ? 'Снять все' : 'Выбрать все' }}
              </button>
            </div>
            <div class="flex flex-wrap gap-3 max-h-32 overflow-y-auto p-1">
              <label
                  v-for="branch in branchesList"
                  :key="branch.id"
                  class="inline-flex items-center cursor-pointer group"
              >
                <div class="relative">
                  <input
                      type="checkbox"
                      :value="branch.id"
                      v-model="selectedBranches"
                      class="sr-only peer"
                  >
                  <div class="w-5 h-5 border-2 rounded-md transition-all duration-200
                              peer-checked:bg-purple-600 peer-checked:border-purple-600
                              border-gray-300 group-hover:border-purple-400
                              flex items-center justify-center">
                    <svg
                        v-show="selectedBranches.includes(branch.id)"
                        class="w-3 h-3 text-white"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                  </div>
                </div>
                <span class="ml-2 text-sm text-gray-700 group-hover:text-gray-900 transition-colors">
                  {{ branch.name }}
                </span>
              </label>
            </div>
            <div class="mt-2 text-xs text-gray-500">
              Выбрано: {{ selectedBranches.length }} из {{ branchesList.length }}
            </div>
          </div>
        </div>

        <!-- Активные фильтры (чипы) -->
        <div v-if="selectedBuildings.length > 0 || selectedBranches.length > 0" class="mt-4 pt-4 border-t border-gray-200">
          <div class="flex items-center gap-2 flex-wrap">
            <span class="text-xs text-gray-500">Активные фильтры:</span>
            <div
                v-for="building in selectedBuildings"
                :key="building"
                class="inline-flex items-center gap-1 px-2 py-1 bg-indigo-50 text-indigo-700 rounded-md text-xs"
            >
              <span>Корпус {{ building }}</span>
              <button @click="removeBuildingFilter(building)" class="hover:text-indigo-900">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
            <div
                v-for="branchId in selectedBranches"
                :key="branchId"
                class="inline-flex items-center gap-1 px-2 py-1 bg-purple-50 text-purple-700 rounded-md text-xs"
            >
              <span>{{ getBranchName(branchId) }}</span>
              <button @click="removeBranchFilter(branchId)" class="hover:text-purple-900">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Индикатор загрузки -->
      <div v-if="isLoading" class="flex justify-center items-center h-64">
        <div class="text-center">
          <svg class="animate-spin mx-auto h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          <p class="mt-2 text-gray-600">Загрузка данных...</p>
        </div>
      </div>

      <!-- Ошибка -->
      <div v-else-if="error" class="bg-red-50 border border-red-200 rounded-lg p-6 mb-8">
        <div class="flex items-center">
          <svg class="w-5 h-5 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span class="text-red-800">{{ error }}</span>
        </div>
      </div>

      <!-- Карта здания -->
      <div v-else class="bg-white rounded-2xl shadow-xl border border-gray-200 p-8">

        <!-- Подсказка при отсутствии выбора -->
        <div
            v-if="!selectedAuditorium && !isLoading && !error && filteredAuditoriums.length > 0"
            class="mb-8 text-center py-8 bg-gradient-to-br from-gray-50 to-blue-50 rounded-2xl border-2 border-dashed border-gray-300"
        >
          <h3 class="text-xl font-semibold text-gray-600 mb-2">Выберите кабинет</h3>
          <p class="text-gray-500">Нажмите на любой кабинет на плане для просмотра объектов учёта и сотрудников</p>
        </div>

        <!-- Табы этажей -->
        <div class="mb-8">
          <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg p-1">
            <div class="flex overflow-x-auto">
              <button
                  v-for="floor in uniqueFloors"
                  :key="floor"
                  class="flex-1 min-w-[120px] px-4 py-3 font-semibold rounded-md transition-all duration-200 whitespace-nowrap"
                  :class="{
                    'bg-indigo-100 text-indigo-800 shadow-lg': activeFloor === floor,
                    'text-white hover:text-indigo-100': activeFloor !== floor
                  }"
                  @click="setActiveFloor(floor)"
              >
                <div class="flex items-center justify-center">
                  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                  </svg>
                  {{ floor }} этаж
                </div>
              </button>
            </div>
          </div>
        </div>

        <!-- Сообщение при отсутствии кабинетов -->
        <div v-if="filteredAuditoriums.length === 0" class="text-center py-16">
          <svg class="w-24 h-24 text-gray-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <h3 class="text-2xl font-semibold text-gray-600 mb-3">Кабинеты не найдены</h3>
          <p class="text-gray-500 text-lg">Попробуйте изменить параметры поиска или выберите другой этаж</p>
        </div>

        <!-- Сетка кабинетов -->
        <div v-else class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
          <div
              v-for="auditorium in filteredAuditoriums"
              :key="auditorium.auditorium_id"
              class="auditorium-card group"
              :class="{ 'auditorium-card-active': selectedAuditorium?.auditorium_id === auditorium.auditorium_id }"
              @click="selectAuditorium(auditorium)"
          >
            <!-- Индикатор выбора -->
            <div
                v-if="selectedAuditorium?.auditorium_id === auditorium.auditorium_id"
                class="absolute top-2 right-2"
            >
              <div class="bg-indigo-600 text-white p-1 rounded-full">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
              </div>
            </div>

            <!-- Заголовок кабинета -->
            <div class="flex items-center justify-between mb-3">
              <h3 class="text-lg font-bold text-gray-900">{{ auditorium.auditorium_name }}</h3>
              <span class="px-2 py-1 bg-indigo-100 text-indigo-700 text-xs font-semibold rounded">
                {{ getBuildingFromName(auditorium.auditorium_name) }}
              </span>
            </div>

            <!-- Информация о кабинете -->
            <div class="space-y-2">
              <div class="flex items-center">
                <svg class="w-3 h-3 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span class="text-xs text-gray-600">{{ auditorium.floor }} этаж</span>
              </div>

              <div class="flex items-center">
                <svg class="w-3 h-3 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-xs font-medium" :class="getThingsCountColor(auditorium.things.length)">
                  {{ getObjectsCountText(auditorium.things.length) }}
                </span>
              </div>

              <!-- Отдел кабинета -->
              <div v-if="getBranchName(auditorium.branch_id)" class="flex items-center">
                <svg class="w-3 h-3 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                <span class="text-xs text-purple-600 truncate" :title="getBranchName(auditorium.branch_id)">
                  {{ getBranchName(auditorium.branch_id) }}
                </span>
              </div>

              <!-- Телефоны -->
              <div v-if="getAuditoriumTelephones(auditorium.auditorium_id).length" class="flex items-center">
                <svg class="w-3 h-3 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                <span class="text-xs text-gray-600">{{ getAuditoriumTelephones(auditorium.auditorium_id).length }} тел.</span>
              </div>

              <!-- Сотрудники -->
              <div v-if="auditorium.employees?.length" class="flex items-center">
                <svg class="w-3 h-3 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 1.197h-6" />
                </svg>
                <span class="text-xs text-gray-600">{{ auditorium.employees.length }} сотр.</span>
              </div>

              <!-- Назначение кабинета (превью) -->
              <div v-if="auditorium.comment" class="flex items-start">
                <svg class="w-3 h-3 text-gray-400 mr-1 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                </svg>
                <span class="text-xs text-gray-500 truncate" :title="auditorium.comment">
                  {{ truncateText(auditorium.comment, 60) }}
                </span>
              </div>
            </div>

            <!-- Быстрый просмотр объектов -->
            <div v-if="auditorium.things.length > 0 || auditorium.employees?.length || getAuditoriumTelephones(auditorium.auditorium_id).length" class="mt-3 pt-3 border-t border-gray-200">
              <div class="text-xs text-gray-500 mb-1">Содержание:</div>
              <div class="space-y-1">
                <!-- Объекты -->
                <div v-if="auditorium.things.length > 0" class="flex items-center">
                  <div class="w-1.5 h-1.5 bg-blue-500 rounded-full mr-1"></div>
                  <span class="text-xs text-gray-700">
                    {{ auditorium.things.length }} {{ getObjectsWord(auditorium.things.length) }}
                  </span>
                </div>
                <!-- Сотрудники -->
                <div v-if="auditorium.employees?.length" class="flex items-center">
                  <div class="w-1.5 h-1.5 bg-purple-500 rounded-full mr-1"></div>
                  <span class="text-xs text-gray-700">
                    {{ auditorium.employees.length }} {{ getEmployeesWord(auditorium.employees.length) }}
                  </span>
                </div>
                <!-- Телефоны -->
                <div v-if="getAuditoriumTelephones(auditorium.auditorium_id).length" class="flex items-center">
                  <div class="w-1.5 h-1.5 bg-teal-500 rounded-full mr-1"></div>
                  <span class="text-xs text-gray-700">
                    {{ getAuditoriumTelephones(auditorium.auditorium_id).length }} {{ getPhonesWord(getAuditoriumTelephones(auditorium.auditorium_id).length) }}
                  </span>
                </div>
                <!-- Пример телефона -->
                <div v-if="getAuditoriumTelephones(auditorium.auditorium_id).length" class="text-xs text-gray-500 truncate pl-2">
                  {{ formatPhoneNumber(getAuditoriumTelephones(auditorium.auditorium_id)[0].phone_number) }}
                </div>
              </div>
            </div>

            <!-- Пустое состояние -->
            <div v-else-if="!auditorium.comment" class="mt-3 pt-3 border-t border-gray-200">
              <div class="text-xs text-gray-400 italic">Нет объектов и сотрудников</div>
            </div>
          </div>
        </div>
      </div>


    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
import {BACKEND_URL} from "@/router.js";

const router = useRouter()

// Данные
const auditoriums = ref([])
const selectedAuditorium = ref(null)
const searchQuery = ref('')
const selectedBuildings = ref([])
const selectedBranches = ref([])
const floorFilter = ref('')
const activeFloor = ref(1)
const isLoading = ref(false)
const error = ref(null)
const types = ref({})
const balanceTypes = ref({})
const branches = ref({})
const telephones = ref([])

// Загрузка данных
const loadData = async () => {
  try {
    isLoading.value = true
    error.value = null

    const [mapResponse, typesResponse, balanceResponse, branchesResponse, telephonesResponse] = await Promise.all([
      axios.get(BACKEND_URL + '/api/auditoriums/map'),
      axios.get(BACKEND_URL + '/api/info/thing-types'),
      axios.get(BACKEND_URL + '/api/info/balance'),
      axios.get(BACKEND_URL + '/api/info/branches'),
      axios.get(BACKEND_URL + '/api/telephones')
    ])

    if (mapResponse.data.success) {
      auditoriums.value = mapResponse.data.data
    } else {
      throw new Error('Ошибка загрузки данных кабинетов')
    }

    if (typesResponse.data.success) {
      types.value = typesResponse.data.types || {}
    }

    if (balanceResponse.data.success) {
      balanceTypes.value = balanceResponse.data.types || {}
    }

    if (branchesResponse.data.success) {
      const branchesData = {}
      branchesResponse.data.data.forEach(branch => {
        branchesData[branch.id] = branch.name
      })
      branches.value = branchesData
    }

    if (telephonesResponse.data.success) {
      telephones.value = telephonesResponse.data.data || []
    }

  } catch (err) {
    error.value = 'Не удалось загрузить данные. Проверьте соединение с сервером.'
  } finally {
    isLoading.value = false
  }
}

onMounted(() => {
  loadData()
})

// Вычисляемые свойства
const filteredAuditoriums = computed(() => {
  let filtered = auditoriums.value

  if (activeFloor.value) {
    filtered = filtered.filter(a => a.floor === activeFloor.value)
  }

  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(a =>
        a.auditorium_name.toLowerCase().includes(query) ||
        (a.comment && a.comment.toLowerCase().includes(query)) ||
        a.things.some(t =>
            (t.name && t.name.toLowerCase().includes(query)) ||
            t.inv_number.toLowerCase().includes(query) ||
            t.serial_number.toLowerCase().includes(query) ||
            (getBalanceLabel(t.balance) && getBalanceLabel(t.balance).toLowerCase().includes(query))
        ) ||
        (getBranchName(a.branch_id) && getBranchName(a.branch_id).toLowerCase().includes(query)) ||
        (a.employees && a.employees.some(e =>
            e.fio.toLowerCase().includes(query) ||
            (e.position && e.position.toLowerCase().includes(query))
        )) ||
        getAuditoriumTelephones(a.auditorium_id).some(t =>
            t.phone_number.toLowerCase().includes(query)
        )
    )
  }

  if (selectedBuildings.value.length > 0) {
    filtered = filtered.filter(a => {
      const building = getBuildingFromName(a.auditorium_name)
      return selectedBuildings.value.includes(building)
    })
  }

  if (selectedBranches.value.length > 0) {
    filtered = filtered.filter(a => {
      return a.branch_id && selectedBranches.value.includes(a.branch_id)
    })
  }

  if (floorFilter.value) {
    filtered = filtered.filter(a => a.floor === parseInt(floorFilter.value))
  }

  return filtered
})

const uniqueFloors = computed(() => {
  const floors = new Set(auditoriums.value.map(a => a.floor))
  return Array.from(floors).sort((a, b) => a - b)
})

const buildings = computed(() => {
  const buildingsSet = new Set()
  auditoriums.value.forEach(a => {
    const building = getBuildingFromName(a.auditorium_name)
    if (building) buildingsSet.add(building)
  })
  return Array.from(buildingsSet).sort()
})

const floors = computed(() => {
  const floorsSet = new Set(auditoriums.value.map(a => a.floor))
  return Array.from(floorsSet).sort((a, b) => a - b)
})

const branchesList = computed(() => {
  return Object.entries(branches.value).map(([id, name]) => ({
    id: parseInt(id),
    name: name
  })).sort((a, b) => a.name.localeCompare(b.name))
})

// Методы для работы с фильтрами
const resetFilters = () => {
  selectedBuildings.value = []
  selectedBranches.value = []
}

const toggleAllBuildings = () => {
  if (selectedBuildings.value.length === buildings.value.length) {
    selectedBuildings.value = []
  } else {
    selectedBuildings.value = [...buildings.value]
  }
}

const toggleAllBranches = () => {
  const allBranchIds = branchesList.value.map(b => b.id)
  if (selectedBranches.value.length === allBranchIds.length) {
    selectedBranches.value = []
  } else {
    selectedBranches.value = allBranchIds
  }
}

const removeBuildingFilter = (building) => {
  const index = selectedBuildings.value.indexOf(building)
  if (index > -1) {
    selectedBuildings.value.splice(index, 1)
  }
}

const removeBranchFilter = (branchId) => {
  const index = selectedBranches.value.indexOf(branchId)
  if (index > -1) {
    selectedBranches.value.splice(index, 1)
  }
}

const getAuditoriumTelephones = (auditoriumId) => {
  return telephones.value.filter(t => t.auditorium_id === auditoriumId)
}

const selectedAuditoriumTelephones = computed(() => {
  if (!selectedAuditorium.value) return []
  return getAuditoriumTelephones(selectedAuditorium.value.auditorium_id)
})

const workingThingsCount = computed(() => {
  if (!selectedAuditorium.value?.things) return 0
  return selectedAuditorium.value.things.filter(t => t.condition === 1).length
})

const setActiveFloor = (floor) => {
  activeFloor.value = floor
  selectedAuditorium.value = null
}

const selectAuditorium = (auditorium) => {
  selectedAuditorium.value = auditorium
}

const getBuildingFromName = (name) => {
  if (!name) return ''
  const building = name.match(/^[A-Za-zА-Яа-я]/)
  return building ? building[0] : ''
}

const getBranchName = (branchId) => {
  if (!branchId) return null
  return branches.value[branchId] || null
}

const truncateText = (text, maxLength) => {
  if (!text) return ''
  if (text.length <= maxLength) return text
  return text.substring(0, maxLength) + '...'
}

const getThingsCountColor = (count) => {
  if (count === 0) return 'text-gray-500'
  if (count <= 5) return 'text-green-600'
  if (count <= 10) return 'text-blue-600'
  return 'text-orange-600'
}

const getObjectsCountText = (count) => {
  if (count === 0) return '0 объектов'
  if (count === 1) return '1 объект'
  if (count >= 2 && count <= 4) return `${count} объекта`
  return `${count} объектов`
}

const getObjectsWord = (count) => {
  if (count === 1) return 'объект'
  if (count >= 2 && count <= 4) return 'объекта'
  return 'объектов'
}

const getEmployeesWord = (count) => {
  if (count === 1) return 'сотрудник'
  if (count >= 2 && count <= 4) return 'сотрудника'
  return 'сотрудников'
}

const getPhonesWord = (count) => {
  if (count === 1) return 'телефон'
  if (count >= 2 && count <= 4) return 'телефона'
  return 'телефонов'
}

const getConditionColor = (conditionId) => {
  const colorMap = {
    1: 'bg-green-500',
    2: 'bg-red-500',
    3: 'bg-yellow-500',
    4: 'bg-blue-500',
    5: 'bg-gray-500'
  }
  return colorMap[conditionId] || 'bg-gray-400'
}

const getTypeName = (typeId) => {
  if (!typeId && typeId !== 0) return 'Не указан'
  return types.value[typeId] || `Тип ${typeId}`
}

const getBalanceLabel = (balanceId) => {
  if (balanceId === null || balanceId === undefined) return 'Не указано'

  if (Object.keys(balanceTypes.value).length > 0) {
    return balanceTypes.value[balanceId] || `Характеристика ${balanceId}`
  }

  const staticBalances = {
    1: 'Основное средство',
    2: 'За балансом'
  }
  return staticBalances[balanceId] || `Характеристика ${balanceId}`
}

const formatPhoneNumber = (phone) => {
  if (!phone) return ''
  const cleaned = phone.replace(/\D/g, '')

  if (cleaned.length === 11 && (cleaned.startsWith('7') || cleaned.startsWith('8'))) {
    return `+7 (${cleaned.slice(1, 4)}) ${cleaned.slice(4, 7)}-${cleaned.slice(7, 9)}-${cleaned.slice(9)}`
  }

  return phone
}

const viewThing = (thingId) => {
  router.push(`/things/view/${thingId}`)
}
</script>

<style scoped>
/* Стили для слайдборда */
.slideboard {
  position: fixed;
  top: 0;
  right: -500px;
  width: 500px;
  height: 100vh;
  z-index: 1000;
  transition: right 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  box-shadow: -10px 0 30px rgba(0, 0, 0, 0.1);
}

.slideboard-open {
  right: 0;
}

.slideboard-content {
  height: 100%;
  background: white;
  display: flex;
  flex-direction: column;
}

.slideboard-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  z-index: 999;
  animation: fadeIn 0.2s ease-out;
}

/* Стили для карточек кабинетов */
.auditorium-card {
  background: white;
  border: 2px solid #e5e7eb;
  border-radius: 12px;
  padding: 16px;
  cursor: pointer;
  transition: all 0.2s ease;
  position: relative;
}

.auditorium-card:hover {
  border-color: #6366f1;
  transform: translateY(-2px);
  box-shadow: 0 10px 20px rgba(99, 102, 241, 0.1);
}

.auditorium-card-active {
  border-color: #6366f1;
  background: linear-gradient(135deg, #f8fafc 0%, #f0f9ff 100%);
  box-shadow: 0 10px 25px rgba(99, 102, 241, 0.15);
}

/* Анимации */
@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

/* Адаптивность */
@media (max-width: 768px) {
  .slideboard {
    width: 100%;
    right: -100%;
  }

  .auditorium-card {
    padding: 12px;
  }
}

/* Кастомный скроллбар */
::-webkit-scrollbar {
  width: 6px;
}

::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 3px;
}

::-webkit-scrollbar-thumb {
  background: #c1c1c1;
  border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
  background: #a1a1a1;
}
</style>