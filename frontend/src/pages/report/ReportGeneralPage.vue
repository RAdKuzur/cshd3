<template>
  <div class="p-6 bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
      <!-- Заголовок -->
      <div class="mb-8">
        <div class="flex justify-between items-center">
          <div>
            <h1 class="text-3xl font-bold text-gray-900">Общие сведения по отделам</h1>
            <p class="text-gray-600 mt-2">Материальные ценности по отделам</p>
          </div>
          <button
              v-if="showGraph && activeTab"
              @click="showGraph = false"
              class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors flex items-center"
          >
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Вернуться к таблице
          </button>
        </div>
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
                  :key="branch.id"
                  class="w-full px-4 py-3 text-left rounded-xl transition-all duration-200 tab-button flex items-center justify-between group"
                  :class="{
                    'bg-indigo-50 text-indigo-700 border border-indigo-100 shadow-sm': activeTab === branch.id,
                    'text-gray-700 hover:bg-gray-50 hover:text-gray-900': activeTab !== branch.id
                  }"
                  @click="setActiveTab(branch.id)"
              >
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-10 w-10 rounded-lg flex items-center justify-center mr-3"
                       :class="{
                         'bg-indigo-100 text-indigo-600': activeTab === branch.id,
                         'bg-gray-100 text-gray-600 group-hover:bg-gray-200': activeTab !== branch.id
                       }">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                  </div>
                  <div>
                    <div class="font-medium">{{ branch.name }}</div>
                    <div class="text-sm opacity-75">{{ getBranchStats(branch.id).total }} объектов материальной ценностей</div>
                  </div>
                </div>

                <svg v-if="activeTab === branch.id"
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
                    <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                  </div>
                  <div>
                    <p class="text-sm font-medium text-gray-600">Всего объектов материальной ценностей</p>
                    <p class="text-xl font-bold text-gray-900">{{ totalThings }}</p>
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
              <div class="flex items-center justify-between">
                <div class="flex items-center">
                  <div class="h-10 w-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                    <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                  </div>
                  <div>
                    <p class="text-sm font-medium text-gray-600">Общая стоимость</p>
                    <p class="text-xl font-bold text-gray-900">{{ formatCurrency(totalCost) }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Основной контент -->
        <div class="lg:w-5/4">
          <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden h-full">
            <div class="p-6 border-b border-gray-200">
              <div class="flex justify-between items-center">
                <div>
                  <h2 class="text-2xl font-bold text-gray-900">
                    {{ activeBranch ? activeBranch.name : 'Выберите отдел' }}
                  </h2>
                  <p class="text-gray-600 mt-2" v-if="!showGraph">Материальные ценности отдела</p>
                  <p class="text-gray-600 mt-2" v-else>Инфографика по годам эксплуатации</p>
                </div>
<!--                <div v-if="activeBranch && !showGraph" class="text-sm text-gray-500">-->
<!--                  Вещей: {{ getBranchStats(activeTab).total }} |-->
<!--                  Стоимость: {{ formatCurrency(getBranchStats(activeTab).totalCost) }}-->
<!--                </div>-->
                <button
                    v-if="activeTab && !showGraph && filteredThings.length > 0"
                    @click="showGraph = true"
                    class="px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-lg hover:opacity-90 transition-opacity flex items-center"
                >
                  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                  </svg>
                  Перейти к инфографике
                </button>
              </div>
            </div>

            <div class="p-6">
              <!-- Загрузка -->
              <div v-if="loading || loadingThings" class="text-center py-12">
                <svg class="animate-spin mx-auto h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p class="mt-2 text-gray-600">Загрузка данных...</p>
              </div>

              <div v-else>
                <div v-if="!activeTab" class="text-center py-12">
                  <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                  </svg>
                  <p class="text-gray-500">Выберите отдел для просмотра материальных ценностей</p>
                </div>

                <!-- Режим инфографики -->
                <div v-else-if="showGraph" class="space-y-6">
                  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-6 rounded-2xl border border-blue-100">
                      <div class="flex items-center">
                        <div class="h-12 w-12 bg-blue-100 rounded-xl flex items-center justify-center mr-4">
                          <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                          </svg>
                        </div>
                        <div>
                          <p class="text-sm text-blue-600 font-medium">Всего объектов материальной ценностей в отделе</p>
                          <p class="text-2xl font-bold text-gray-900">{{ filteredThings.length }}</p>
                        </div>
                      </div>
                    </div>

                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 p-6 rounded-2xl border border-purple-100">
                      <div class="flex items-center">
                        <div class="h-12 w-12 bg-purple-100 rounded-xl flex items-center justify-center mr-4">
                          <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                          </svg>
                        </div>
                        <div>
                          <p class="text-sm text-purple-600 font-medium">Период эксплуатации</p>
                          <p class="text-2xl font-bold text-gray-900">{{ getYearRange() }}</p>
                        </div>
                      </div>
                    </div>

                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-6 rounded-2xl border border-green-100">
                      <div class="flex items-center">
                        <div class="h-12 w-12 bg-green-100 rounded-xl flex items-center justify-center mr-4">
                          <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                          </svg>
                        </div>
                        <div>
                          <p class="text-sm text-green-600 font-medium">Общая стоимость</p>
                          <p class="text-2xl font-bold text-gray-900">{{ formatCurrency(getTotalCostForFiltered()) }}</p>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Диаграмма по годам -->
                  <div class="bg-white p-6 rounded-2xl border border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                      <div>
                        <h3 class="text-xl font-bold text-gray-900">Распределение объектов материальной ценностей по годам эксплуатации</h3>
                        <p class="text-gray-600 mt-1">Количество объектов материальной ценностей в зависимости от срока использования</p>
                      </div>
                      <div class="text-sm text-gray-500">
                        Всего: {{ filteredThings.length }} объектов материальной ценностей
                      </div>
                    </div>

                    <div class="relative">
                      <!-- Легенда -->
                      <div class="flex flex-wrap gap-4 mb-6">
                        <div class="flex items-center">
                          <div class="h-3 w-6 bg-blue-500 rounded mr-2"></div>
                          <span class="text-sm text-gray-700">Менее 5 лет</span>
                        </div>
                        <div class="flex items-center">
                          <div class="h-3 w-6 bg-yellow-500 rounded mr-2"></div>
                          <span class="text-sm text-gray-700">5-10 лет</span>
                        </div>
                        <div class="flex items-center">
                          <div class="h-3 w-6 bg-red-500 rounded mr-2"></div>
                          <span class="text-sm text-gray-700">Более 10 лет</span>
                        </div>
                      </div>

                      <!-- Диаграмма -->
                      <div class="h-64">
                        <div v-if="filteredThings.length === 0" class="text-center py-12 text-gray-500">
                          <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                          </svg>
                          <p class="text-lg font-medium mb-2">Нет данных для построения диаграммы</p>
                          <p class="text-sm">Попробуйте изменить фильтры</p>
                        </div>

                        <div v-else class="flex items-end h-48 space-x-8 px-4 justify-center">
                          <!-- Столбец "Менее 5 лет" -->
                          <div class="flex-1 max-w-[120px] flex flex-col items-center">
                            <div class="w-full flex justify-center">
                              <div
                                  class="w-16 bg-gradient-to-t from-blue-400 to-blue-500 rounded-t-lg transition-all duration-300 hover:opacity-90 cursor-pointer"
                                  :style="{ height: getBarHeight(yearData['0-5']) + 'px' }"
                                  :title="`Менее 5 лет: ${yearData['0-5']} объектов материальной ценностей`"
                              ></div>
                            </div>
                            <div class="mt-4 text-center">
                              <div class="text-lg font-bold text-gray-900">{{ yearData['0-5'] }}</div>
                              <div class="text-sm text-gray-600">Менее 5 лет</div>
                              <div class="text-xs text-blue-500 mt-1">{{ getPercentage('0-5') }}%</div>
                            </div>
                          </div>

                          <!-- Столбец "5-10 лет" -->
                          <div class="flex-1 max-w-[120px] flex flex-col items-center">
                            <div class="w-full flex justify-center">
                              <div
                                  class="w-16 bg-gradient-to-t from-yellow-400 to-yellow-500 rounded-t-lg transition-all duration-300 hover:opacity-90 cursor-pointer"
                                  :style="{ height: getBarHeight(yearData['5-10']) + 'px' }"
                                  :title="`5-10 лет: ${yearData['5-10']} объектов материальной ценностей`"
                              ></div>
                            </div>
                            <div class="mt-4 text-center">
                              <div class="text-lg font-bold text-gray-900">{{ yearData['5-10'] }}</div>
                              <div class="text-sm text-gray-600">5-10 лет</div>
                              <div class="text-xs text-yellow-500 mt-1">{{ getPercentage('5-10') }}%</div>
                            </div>
                          </div>

                          <!-- Столбец "Более 10 лет" -->
                          <div class="flex-1 max-w-[120px] flex flex-col items-center">
                            <div class="w-full flex justify-center">
                              <div
                                  class="w-16 bg-gradient-to-t from-red-400 to-red-500 rounded-t-lg transition-all duration-300 hover:opacity-90 cursor-pointer"
                                  :style="{ height: getBarHeight(yearData['10+']) + 'px' }"
                                  :title="`Более 10 лет: ${yearData['10+']} объектов материальной ценностей`"
                              ></div>
                            </div>
                            <div class="mt-4 text-center">
                              <div class="text-lg font-bold text-gray-900">{{ yearData['10+'] }}</div>
                              <div class="text-sm text-gray-600">Более 10 лет</div>
                              <div class="text-xs text-red-500 mt-1">{{ getPercentage('10+') }}%</div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Детальная информация -->
                    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
                      <div class="bg-blue-50 p-4 rounded-xl">
                        <div class="flex justify-between items-center">
                          <div>
                            <p class="text-sm font-medium text-blue-600">Менее 5 лет</p>
                            <p class="text-lg font-bold text-gray-900">{{ yearData['0-5'] }} объектов материальной ценностей</p>
                          </div>
                          <div class="text-right">
                            <p class="text-sm text-blue-500">{{ getPercentage('0-5') }}%</p>
                            <p class="text-xs text-gray-500">
                              Стоимость: {{ formatCurrency(getCategoryCost('0-5')) }}
                            </p>
                          </div>
                        </div>
                      </div>

                      <div class="bg-yellow-50 p-4 rounded-xl">
                        <div class="flex justify-between items-center">
                          <div>
                            <p class="text-sm font-medium text-yellow-600">5-10 лет</p>
                            <p class="text-lg font-bold text-gray-900">{{ yearData['5-10'] }} объектов материальной ценностей</p>
                          </div>
                          <div class="text-right">
                            <p class="text-sm text-yellow-500">{{ getPercentage('5-10') }}%</p>
                            <p class="text-xs text-gray-500">
                              Стоимость: {{ formatCurrency(getCategoryCost('5-10')) }}
                            </p>
                          </div>
                        </div>
                      </div>

                      <div class="bg-red-50 p-4 rounded-xl">
                        <div class="flex justify-between items-center">
                          <div>
                            <p class="text-sm font-medium text-red-600">Более 10 лет</p>
                            <p class="text-lg font-bold text-gray-900">{{ yearData['10+'] }} объектов материальной ценностей</p>
                          </div>
                          <div class="text-right">
                            <p class="text-sm text-red-500">{{ getPercentage('10+') }}%</p>
                            <p class="text-xs text-gray-500">
                              Стоимость: {{ formatCurrency(getCategoryCost('10+')) }}
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Дополнительная статистика -->
                  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="bg-white p-6 rounded-2xl border border-gray-200">
                      <h4 class="text-lg font-semibold text-gray-900 mb-4">Средний возраст объектов материальной ценностей</h4>
                      <div class="text-center py-4">
                        <div class="text-5xl font-bold text-indigo-600 mb-2">{{ averageYears }}</div>
                        <p class="text-gray-600">лет эксплуатации в среднем</p>
                      </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl border border-gray-200">
                      <h4 class="text-lg font-semibold text-gray-900 mb-4">Распределение по типам</h4>
                      <div v-if="topTypes.length === 0" class="text-center py-4 text-gray-500">
                        <p>Нет данных о типах</p>
                      </div>
                      <div v-else class="space-y-3">
                        <div v-for="type in topTypes" :key="type.id" class="flex items-center justify-between">
                          <span class="text-sm text-gray-700 truncate mr-2">{{ type.name }}</span>
                          <div class="flex items-center">
                            <span class="text-sm font-medium text-gray-900 mr-2">{{ type.count }}</span>
                            <div class="w-20 bg-gray-200 rounded-full h-2">
                              <div
                                  class="bg-indigo-500 h-2 rounded-full"
                                  :style="{ width: type.percentage + '%' }"
                              ></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Режим таблицы -->
                <div v-else>
                  <!-- Панель фильтров -->
                  <div class="mb-6 space-y-4">
                    <!-- Строка 1: Поиск и основные фильтры -->
                    <div class="flex gap-4 flex-wrap">
                      <div class="flex-1 min-w-[300px]">
                        <div class="relative">
                          <input
                              v-model="searchQuery"
                              type="text"
                              placeholder="Поиск по названию, серийному или инвентарному номеру..."
                              class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                          >
                          <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                          </div>
                        </div>
                      </div>

                      <select
                          v-model="conditionFilter"
                          class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                      >
                        <option value="">Все состояния</option>
                        <option v-for="(label, key) in conditions" :key="key" :value="parseInt(key)">
                          {{ label }}
                        </option>
                      </select>

                      <select
                          v-model="balanceFilter"
                          class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                      >
                        <option value="">Все характеристики учёта</option>
                        <option v-for="(name, id) in balanceTypes" :key="id" :value="parseInt(id)">
                          {{ name }}
                        </option>
                      </select>
                    </div>

                    <!-- Строка 2: Мультивыбор по годам и типам -->
                    <div class="flex gap-4 flex-wrap">
                      <!-- Фильтр по годам эксплуатации -->
                      <div class="flex-1 min-w-[300px]">
                        <div class="relative">
                          <div class="flex items-center border border-gray-300 rounded-lg px-3 py-2 focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500">
                            <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <div class="flex-1">
                              <div class="text-sm text-gray-500 mb-1">Годы эксплуатации (возраст)</div>
                              <div class="flex flex-wrap gap-2">
                                <label v-for="yearOption in yearOptions" :key="yearOption.value" class="inline-flex items-center">
                                  <input
                                      type="checkbox"
                                      :value="yearOption.value"
                                      v-model="selectedYears"
                                      class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                  >
                                  <span class="ml-2 text-sm text-gray-700">{{ yearOption.label }}</span>
                                </label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- Фильтр по типам -->
                      <div class="flex-1 min-w-[300px]">
                        <div class="relative">
                          <div class="flex items-center border border-gray-300 rounded-lg px-3 py-2 focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500">
                            <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            <div class="flex-1">
                              <div class="text-sm text-gray-500 mb-1">Типы объектов материальной ценностей</div>
                              <div class="flex flex-wrap gap-2 max-h-20 overflow-y-auto">
                                <label v-for="type in availableTypes" :key="type.id" class="inline-flex items-center">
                                  <input
                                      type="checkbox"
                                      :value="type.id"
                                      v-model="selectedTypes"
                                      class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                  >
                                  <span class="ml-2 text-sm text-gray-700">{{ type.name }}</span>
                                </label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Отладочная информация -->
                  <div v-if="debugMode" class="mb-4 p-3 bg-yellow-50 rounded-lg text-sm">
                    <p><strong>Debug Info:</strong></p>
                    <p>Всего объектов материальной ценностей в отделе: {{ thingsForActiveBranch.length }}</p>
                    <p>Отфильтровано объектов материальной ценностей: {{ filteredThings.length }}</p>
                    <p>Активный отдел: {{ activeTab }}</p>
                  </div>

                  <!-- Таблица вещей -->
                  <div v-if="filteredThings.length > 0" class="overflow-x-auto mb-6">
                    <table class="w-full">
                      <thead class="bg-gradient-to-r from-indigo-500 to-purple-600">
                      <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider">
                          Название и номер
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider">
                          Состояние и тип
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider">
                          Характеристика учёта
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider">
                          Аудитория
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider">
                          Дата эксплуатации
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider">
                          Стоимость
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider">
                          Действия
                        </th>
                      </tr>
                      </thead>

                      <tbody class="divide-y divide-gray-200">
                      <tr
                          v-for="item in paginatedItems"
                          :key="item.id"
                          class="hover:bg-gradient-to-r hover:from-indigo-50 hover:to-white transition-all duration-200 group"
                          :class="getRowHighlightClass(item.operation_date)"
                      >
                        <!-- Название и номер -->
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                              <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                              </svg>
                            </div>
                            <div class="ml-4">
                              <router-link :to="`/things/view/${item.id}`" class="block">
                                <div class="text-sm font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors hover:underline">
                                  {{ item.name || `Объект ${item.id}` }}
                                </div>
                              </router-link>
                              <div class="text-sm text-gray-500">
                                Инв. №: {{ item.inv_number }}
                              </div>
                              <div class="text-xs text-gray-400">
                                Сер. №: {{ item.serial_number }}
                              </div>
                            </div>
                          </div>
                        </td>

                        <!-- Состояние и тип -->
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div class="flex items-center">
                            <div :class="getConditionColor(item.condition)" class="flex-shrink-0 h-8 w-8 rounded-full flex items-center justify-center mr-3">
                              <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                              </svg>
                            </div>
                            <div>
                              <div class="text-sm font-medium text-gray-900">{{ getConditionLabel(item.condition) }}</div>
                              <div class="text-xs text-gray-500">{{ getTypeName(item.thing_type_id) }}</div>
                            </div>
                          </div>
                        </td>

                        <!-- Характеристика учёта -->
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                              <svg class="h-4 w-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                              </svg>
                            </div>
                            <div>
                              <div class="text-sm font-medium text-gray-900">
                                {{ getBalanceLabel(item.balance) }}
                              </div>
                              <div class="text-xs text-indigo-500">
                                Характеристика учёта
                              </div>
                            </div>
                          </div>
                        </td>

                        <!-- Аудитория -->
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                              <svg class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                              </svg>
                            </div>
                            <div>
                              <div class="text-sm font-semibold text-gray-900">
                                {{ item.auditorium_name || 'Не указана' }}
                              </div>
                              <div v-if="item.auditorium_floor" class="text-xs text-gray-500">
                                {{ item.auditorium_floor }}
                              </div>
                            </div>
                          </div>
                        </td>

                        <!-- Дата ввода в эксплуатацию -->
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div class="text-sm text-gray-900 font-medium">{{ formatDate(item.operation_date) }}</div>
                          <div class="text-xs text-gray-500">{{ getYearsInUse(item.operation_date) }} в использовании</div>
                        </td>

                        <!-- Стоимость -->
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                              <svg class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                              </svg>
                            </div>
                            <div>
                              <div class="text-sm font-semibold text-gray-900">
                                {{ formatCurrency(item.price) }}
                              </div>
                            </div>
                          </div>
                        </td>

                        <!-- Действия -->
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div class="flex items-center space-x-2">
                            <router-link :to="`/things/view/${item.id}`">
                              <button class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Просмотреть">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                              </button>
                            </router-link>
                          </div>
                        </td>
                      </tr>
                      </tbody>
                    </table>
                  </div>

                  <!-- Пустое состояние -->
                  <div
                      v-if="filteredThings.length === 0 && activeTab"
                      class="text-center py-12 text-gray-500"
                  >
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <p class="text-lg font-medium mb-2">В этом отделе пока нет материальных ценностей</p>
                    <p class="text-sm">На данный момент нет объектов материальной ценностей, привязанных к этому отделу</p>
                  </div>

                  <!-- Пагинация -->
                  <div v-if="filteredThings.length > 0" class="mt-6 border-t border-gray-200 pt-6">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                      <div class="text-sm text-gray-700">
                        Показано с {{ startIndex }} по {{ endIndex }} из {{ filteredThings.length }} записей
                      </div>
                      <div class="flex items-center space-x-2">
                        <button
                            @click="prevPage"
                            :disabled="currentPage === 1"
                            class="px-3 py-1 rounded-md border border-gray-300 text-sm font-medium"
                            :class="currentPage === 1 ? 'text-gray-400 cursor-not-allowed' : 'text-gray-700 hover:bg-gray-100'"
                        >
                          Назад
                        </button>

                        <div class="flex space-x-1">
                          <button
                              v-for="page in visiblePages"
                              :key="page"
                              @click="goToPage(page)"
                              class="w-8 h-8 rounded-md text-sm font-medium"
                              :class="page === currentPage
                                ? 'bg-indigo-600 text-white'
                                : 'text-gray-700 hover:bg-gray-100'"
                          >
                            {{ page }}
                          </button>
                          <span v-if="showEllipsis" class="px-2 py-1 text-gray-500">...</span>
                        </div>

                        <button
                            @click="nextPage"
                            :disabled="currentPage === totalPages"
                            class="px-3 py-1 rounded-md border border-gray-300 text-sm font-medium"
                            :class="currentPage === totalPages ? 'text-gray-400 cursor-not-allowed' : 'text-gray-700 hover:bg-gray-100'"
                        >
                          Вперед
                        </button>
                      </div>

                      <select
                          v-model="itemsPerPage"
                          class="px-3 py-1 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
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
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch, onMounted } from 'vue'
import axios from 'axios'
import { BACKEND_URL } from "@/router.js"
const debugMode = ref(false) // Включите для отладки

const activeTab = ref(null)
const branches = ref([])
const loading = ref(true)
const loadingThings = ref(false)
const allThings = ref([])
const showGraph = ref(false) // Новое состояние для переключения между таблицей и графиком

// Дополнительные справочники
const types = ref({})
const conditions = ref({})
const balanceTypes = ref({})
const auditoriums = ref([])

// Фильтры для вещей
const searchQuery = ref('')
const conditionFilter = ref('')
const balanceFilter = ref('')
const selectedYears = ref([]) // Множественный выбор по годам
const selectedTypes = ref([]) // Множественный выбор по типам

// Пагинация
const currentPage = ref(1)
const itemsPerPage = ref(10)
const getCategoryCost = (category) => {
  return filteredThings.value.reduce((sum, item) => {
    const years = item.years_in_use
    let inCategory = false

    switch (category) {
      case '0-5':
        inCategory = years < 5
        break
      case '5-10':
        inCategory = years >= 5 && years <= 10
        break
      case '10+':
        inCategory = years > 10
        break
    }

    return inCategory ? sum + (item.price || 0) : sum
  }, 0)
}
// Опции для фильтра по годам
const yearOptions = [
  { value: '0-5', label: 'Менее 5 лет' },
  { value: '5-10', label: '5-10 лет' },
  { value: '10+', label: 'Более 10 лет' }
]

// Данные для графика по годам
const yearData = computed(() => {
  const data = {
    '0-5': 0,
    '5-10': 0,
    '10+': 0
  }

  filteredThings.value.forEach(item => {
    const years = item.years_in_use

    if (years < 5) {
      data['0-5']++
    } else if (years >= 5 && years <= 10) {
      data['5-10']++
    } else if (years > 10) {
      data['10+']++
    }
  })

  return data
})

// Высота столбцов для графика
const getBarHeight = (value) => {
  const maxValue = Math.max(yearData.value['0-5'], yearData.value['5-10'], yearData.value['10+'])
  if (maxValue === 0) return 0
  return (value / maxValue) * 120 // 120px - максимальная высота
}

// Процентное соотношение
const getPercentage = (category) => {
  const total = filteredThings.value.length
  if (total === 0) return 0
  return Math.round((yearData.value[category] / total) * 100)
}

// Есть ли данные для графика
const hasDataForGraph = computed(() => {
  return filteredThings.value.length > 0
})

// Средний возраст вещей
const averageYears = computed(() => {
  if (filteredThings.value.length === 0) return 0
  const totalYears = filteredThings.value.reduce((sum, item) => sum + item.years_in_use, 0)
  return (totalYears / filteredThings.value.length).toFixed(1)
})

// Топ типов вещей
const topTypes = computed(() => {
  const typeCounts = {}

  filteredThings.value.forEach(item => {
    const typeId = item.thing_type_id
    if (typeId) {
      typeCounts[typeId] = (typeCounts[typeId] || 0) + 1
    }
  })

  const typesArray = Object.entries(typeCounts).map(([id, count]) => ({
    id: parseInt(id),
    name: getTypeName(parseInt(id)),
    count,
    percentage: Math.round((count / filteredThings.value.length) * 100)
  }))

  return typesArray.sort((a, b) => b.count - a.count).slice(0, 5)
})

// Диапазон годов
const getYearRange = () => {
  if (filteredThings.value.length === 0) return 'Нет данных'

  const years = filteredThings.value.map(item => item.years_in_use)
  const minYear = Math.min(...years)
  const maxYear = Math.max(...years)

  if (minYear === maxYear) return `${minYear} лет`
  return `${minYear}-${maxYear} лет`
}

// Общая стоимость отфильтрованных вещей
const getTotalCostForFiltered = () => {
  return filteredThings.value.reduce((sum, item) => sum + (item.price || 0), 0)
}

const loadAllData = async () => {
  try {
    loading.value = true
    loadingThings.value = true

    // Загружаем ВСЕ данные параллельно
    const [
      branchesResponse,
      thingsResponse,
      typesResponse,
      balanceResponse,
      auditoriumsResponse
    ] = await Promise.all([
      axios.get(`${BACKEND_URL}/api/admin/branches`),
      axios.get(`${BACKEND_URL}/api/reports/general`),
      axios.get(`${BACKEND_URL}/api/info/thing-types`),
      axios.get(`${BACKEND_URL}/api/info/balance`),
      axios.get(`${BACKEND_URL}/api/auditoriums`)
    ])

    // 1. Сначала сохраняем все справочники
    if (branchesResponse.data.success) {
      branches.value = branchesResponse.data.data
      if (branches.value.length > 0) {
        activeTab.value = branches.value[0].id
      }
    }

    if (auditoriumsResponse.data.success) {
      auditoriums.value = auditoriumsResponse.data.data || []
      console.log('Загруженные аудитории:', auditoriums.value.length)
    }

    if (balanceResponse.data.success) {
      balanceTypes.value = balanceResponse.data.types || {}
    }

    if (typesResponse.data.success) {
      types.value = typesResponse.data.types || {}
      conditions.value = typesResponse.data.conditions || {}
    }

    // 2. Только ПОСЛЕ загрузки аудиторий обрабатываем вещи
    if (thingsResponse.data.success) {
      allThings.value = thingsResponse.data.data.map(item => {
        // Теперь auditoriums.value уже заполнен
        const auditorium = auditoriums.value.find(a => a.id === item.auditorium_id)

        const auditoriumName = auditorium ? auditorium.name : 'Не указана'
        const auditoriumFloor = auditorium ? getFloorText(auditorium.floor) : ''

        return {
          id: item.id,
          name: item.name,
          serial_number: item.serial_number,
          inv_number: item.inv_number,
          thing_type_id: item.thing_type_id,
          condition: item.condition,
          balance: item.balance || null,
          operation_date: item.operation_date,
          auditorium_id: item.auditorium_id,
          auditorium_name: auditoriumName,
          auditorium_floor: auditoriumFloor,
          price: item.price,
          branch_id: item.branch_id,
          years_in_use: getYearsFromDate(item.operation_date)
        }
      })
    }

  } catch (error) {
    console.error('Ошибка при загрузке данных:', error)
  } finally {
    loading.value = false
    loadingThings.value = false
  }
}

// Остальные методы и computed свойства остаются без изменений
// Доступные типы для фильтра
const availableTypes = computed(() => {
  return Object.entries(types.value).map(([id, name]) => ({
    id: parseInt(id),
    name: name
  }))
})

const setActiveTab = (branchId) => {
  activeTab.value = branchId
  showGraph.value = false // При смене отдела возвращаемся к таблице
}

// Получаем активный отдел
const activeBranch = computed(() => {
  return branches.value.find(b => b.id === activeTab.value)
})

// Фильтруем вещи для активного отдела
const thingsForActiveBranch = computed(() => {
  if (!activeTab.value) return []
  return allThings.value.filter(item => item.branch_id === activeTab.value)
})

// Фильтруем вещи по всем критериям
const filteredThings = computed(() => {
  let filtered = thingsForActiveBranch.value

  // Фильтрация по поиску
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(item =>
        (item.name && item.name.toLowerCase().includes(query)) ||
        (item.serial_number && item.serial_number.toLowerCase().includes(query)) ||
        (item.inv_number && item.inv_number.toString().toLowerCase().includes(query)) ||
        (getTypeName(item.thing_type_id) && getTypeName(item.thing_type_id).toLowerCase().includes(query)) ||
        (getBalanceLabel(item.balance) && getBalanceLabel(item.balance).toLowerCase().includes(query))
    )
  }

  // Фильтрация по состоянию
  if (conditionFilter.value !== '') {
    const conditionId = parseInt(conditionFilter.value)
    filtered = filtered.filter(item => {
      return item.condition === conditionId
    })
  }

  // Фильтрация по характеристике учёта
  if (balanceFilter.value !== '') {
    const balanceId = parseInt(balanceFilter.value)
    filtered = filtered.filter(item => {
      return item.balance === balanceId
    })
  }

  // Фильтрация по годам эксплуатации (множественный выбор)
  if (selectedYears.value.length > 0) {
    filtered = filtered.filter(item => {
      const years = item.years_in_use

      return selectedYears.value.some(yearOption => {
        switch (yearOption) {
          case '0-5':
            return years < 5
          case '5-10':
            return years >= 5 && years <= 10
          case '10+':
            return years > 10
          default:
            return false
        }
      })
    })
  }

  // Фильтрация по типам (множественный выбор)
  if (selectedTypes.value.length > 0) {
    filtered = filtered.filter(item => {
      return selectedTypes.value.includes(item.thing_type_id)
    })
  }

  return filtered
})

// Пагинация
const totalPages = computed(() => Math.ceil(filteredThings.value.length / itemsPerPage.value))

const paginatedItems = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return filteredThings.value.slice(start, end)
})

const startIndex = computed(() => (currentPage.value - 1) * itemsPerPage.value + 1)
const endIndex = computed(() => Math.min(currentPage.value * itemsPerPage.value, filteredThings.value.length))

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

// Методы пагинации
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

// Статистика по отделам
const getBranchStats = (branchId) => {
  const thingsInBranch = allThings.value.filter(item => item.branch_id === branchId)
  const totalCost = thingsInBranch.reduce((sum, item) => sum + (item.price || 0), 0)

  return {
    total: thingsInBranch.length,
    totalCost: totalCost
  }
}

// Общая статистика
const totalThings = computed(() => {
  return allThings.value.length
})

const totalCost = computed(() => {
  return allThings.value.reduce((sum, item) => sum + (item.price || 0), 0)
})

// Вспомогательные методы
const getTypeName = (typeId) => {
  if (!typeId) return ''
  return types.value[typeId] || `Тип ${typeId}`
}

const getConditionLabel = (condition) => {
  if (condition === null || condition === undefined) return 'Не указано'
  return conditions.value[condition] || `Состояние ${condition}`
}

const getConditionColor = (condition) => {
  if (condition === null || condition === undefined) return 'bg-gray-400'

  const colors = {
    1: 'bg-green-500',
    2: 'bg-red-500',
    3: 'bg-purple-400',
    4: 'bg-green-500',
    5: 'bg-green-400',
    6: 'bg-blue-400',
    7: 'bg-yellow-400',
    8: 'bg-orange-400',
  }

  return colors[condition] || 'bg-gray-400'
}

const getBalanceLabel = (balanceId) => {
  if (balanceId === null || balanceId === undefined) return 'Не указано'

  if (Object.keys(balanceTypes.value).length > 0) {
    return balanceTypes.value[balanceId] || `Характеристика ${balanceId}`
  }

  // Запасной вариант
  const staticBalances = {
    1: 'Основное средство',
    2: 'За балансом'
  }
  return staticBalances[balanceId] || `Характеристика ${balanceId}`
}

const getFloorText = (floorNumber) => {
  if (floorNumber === null || floorNumber === undefined || floorNumber === '') {
    return ''
  }

  const floor = Number(floorNumber)
  if (isNaN(floor)) return ''

  const lastDigit = floor % 10
  const lastTwoDigits = floor % 100

  if (lastTwoDigits >= 11 && lastTwoDigits <= 19) {
    return `${floor} этаж`
  }

  switch (lastDigit) {
    case 1:
      return `${floor} этаж`
    case 2:
    case 3:
    case 4:
      return `${floor} этажа`
    default:
      return `${floor} этаж`
  }
}

// Получаем количество лет с даты
const getYearsFromDate = (dateString) => {
  if (!dateString) return 0
  try {
    const now = new Date()
    const date = new Date(dateString)
    const years = now.getFullYear() - date.getFullYear()
    return Math.max(0, years)
  } catch (e) {
    return 0
  }
}

// Подсветка строк в зависимости от возраста
const getRowHighlightClass = (dateString) => {
  const years = getYearsFromDate(dateString)

  if (years >= 5 && years <= 10) {
    return 'bg-yellow-50 hover:bg-yellow-100'
  } else if (years > 10) {
    return 'bg-red-50 hover:bg-red-100'
  }
  return ''
}

// Форматирование валюты
const formatCurrency = (amount) => {
  if (!amount && amount !== 0) return '0 ₽'
  return new Intl.NumberFormat('ru-RU', {
    style: 'currency',
    currency: 'RUB',
    minimumFractionDigits: 0
  }).format(amount)
}

const formatDate = (dateString) => {
  if (!dateString) return 'Не указана'
  try {
    return new Date(dateString).toLocaleDateString('ru-RU')
  } catch (e) {
    return dateString
  }
}

const getYearsInUse = (dateString) => {
  if (!dateString) return 'Неизвестно'
  try {
    const now = new Date()
    const date = new Date(dateString)
    const years = now.getFullYear() - date.getFullYear()
    return years === 0 ? '<1 года' : `${years} ${getYearsText(years)}`
  } catch (e) {
    return 'Неизвестно'
  }
}

const getYearsText = (years) => {
  if (years % 10 === 1 && years % 100 !== 11) return 'год'
  if ([2, 3, 4].includes(years % 10) && ![12, 13, 14].includes(years % 100)) return 'года'
  return 'лет'
}

onMounted(() => {
  loadAllData()
})

// Сброс фильтров и пагинации при смене отдела
watch(activeTab, () => {
  searchQuery.value = ''
  conditionFilter.value = ''
  balanceFilter.value = ''
  selectedYears.value = []
  selectedTypes.value = []
  currentPage.value = 1
  showGraph.value = false
})

// Сброс пагинации при изменении фильтров
watch([searchQuery, conditionFilter, balanceFilter, selectedYears, selectedTypes], () => {
  currentPage.value = 1
})

watch(itemsPerPage, () => {
  currentPage.value = 1
})

// При изменении фильтров сбрасываем график
watch([searchQuery, conditionFilter, balanceFilter, selectedYears, selectedTypes], () => {
  if (showGraph.value) {
    // Можно оставить график, он автоматически обновится через computed свойства
  }
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

.graph-bar {
  transition: height 0.5s ease;
}
</style>