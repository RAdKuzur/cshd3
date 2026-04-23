<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-6">
    <div class="max-w-7xl mx-auto">
      <!-- Заголовок и навигация -->
      <div class="mb-12">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
          <div>
            <h1 class="text-3xl font-bold text-gray-900">Административная панель</h1>
            <p class="text-gray-600 mt-2">Управление системой материальных ценностей</p>
          </div>

          <div class="flex flex-wrap items-center gap-3">
            <!-- Кнопка Кадровик -->
            <button
                @click="navigateTo('/staff/history')"
                class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-400 to-indigo-500
                     text-white font-medium rounded-lg hover:from-blue-500 hover:to-indigo-600
                     transition-all hover:shadow-lg active:scale-[0.98] focus:outline-none focus:ring-2
                     focus:ring-blue-500 focus:ring-offset-2"
            >
              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
              Кадры
            </button>

            <button
                @click="navigateTo('/admin/tech-works')"
                class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-orange-500 to-amber-600
                     text-white font-medium rounded-lg hover:from-orange-600 hover:to-amber-700
                     transition-all hover:shadow-lg active:scale-[0.98] focus:outline-none focus:ring-2
                     focus:ring-orange-500 focus:ring-offset-2"
            >
              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z" />
              </svg>
              Технические работы
            </button>

            <!-- Кнопка Ввести лицензию -->
<!--            <button-->
<!--                @click="navigateTo('/admin/licences')"-->
<!--                class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600-->
<!--                     text-white font-medium rounded-lg hover:from-green-600 hover:to-emerald-700-->
<!--                     transition-all hover:shadow-lg active:scale-[0.98] focus:outline-none focus:ring-2-->
<!--                     focus:ring-green-500 focus:ring-offset-2"-->
<!--            >-->
<!--              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
<!--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"-->
<!--                      d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />-->
<!--              </svg>-->
<!--              Ввести лицензию-->
<!--            </button>-->

            <!-- Кнопка назад -->
            <router-link
                to="/"
                class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:text-blue-600
                     transition-colors border border-gray-300 rounded-lg hover:border-blue-400"
            >
              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
              </svg>
              Назад
            </router-link>
          </div>
        </div>

        <!-- Карточки управления -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
          <!-- Карточка кадровика - отдельная и первая -->
          <div
              class="relative overflow-hidden rounded-xl p-6 flex flex-col justify-between
           bg-gradient-to-br from-blue-400 to-indigo-500
           hover:from-blue-500 hover:to-indigo-600
           transition-all hover:shadow-lg hover:scale-[1.02] hover:shadow-indigo-200
           cursor-pointer group border-2 border-white/50"
              @click="navigateTo('/staff/history')"
          >
            <!-- Иконка кадровика -->
            <div class="absolute right-6 top-6">
              <div class="bg-white/20 backdrop-blur-sm p-3 rounded-xl">
                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
              </div>
            </div>

            <!-- Контент -->
            <div class="pr-16">
              <h3 class="text-xl font-semibold text-white mb-2 flex items-center gap-2">
                Кадры
              </h3>
              <p class="text-sm text-blue-100 leading-relaxed">
                Управление перемещениями сотрудников между отделами и должностями, история кадровых изменений
              </p>
            </div>
            <!-- Стрелка и статус -->
            <div class="mt-6 flex justify-end">
              <div class="bg-white/20 p-2 rounded-lg group-hover:bg-white/30 transition-colors">
                <svg class="w-5 h-5 text-white transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
              </div>
            </div>
          </div>

          <!-- Должности -->
          <div
              class="relative overflow-hidden rounded-xl p-6 flex flex-col justify-between
           bg-gradient-to-br from-blue-500 to-indigo-600
           hover:from-blue-600 hover:to-indigo-700
           transition-all hover:shadow-lg hover:scale-[1.01]
           cursor-pointer group"
              @click="navigateTo('/admin/positions')"
          >
            <!-- Иконка -->
            <div class="absolute right-6 top-6">
              <div class="bg-white/20 backdrop-blur-sm p-3 rounded-xl">
                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
              </div>
            </div>

            <!-- Контент с отступом для иконки -->
            <div class="pr-16">
              <h3 class="text-xl font-semibold text-white mb-2">
                Должности
              </h3>
              <p class="text-sm text-blue-100 leading-relaxed">
                Управление должностями сотрудников, правами доступа и ролями в системе
              </p>
            </div>

            <!-- Стрелка -->
            <div class="mt-6 flex justify-end">
              <div class="bg-white/20 p-2 rounded-lg group-hover:bg-white/30 transition-colors">
                <svg class="w-5 h-5 text-white transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
              </div>
            </div>
          </div>

          <!-- Пользователи -->
          <div
              class="relative overflow-hidden rounded-xl p-6 flex flex-col justify-between
           bg-gradient-to-br from-emerald-500 to-teal-600
           hover:from-emerald-600 hover:to-teal-700
           transition-all hover:shadow-lg hover:scale-[1.01]
           cursor-pointer group"
              @click="navigateTo('/admin/users')"
          >
            <div class="absolute right-6 top-6">
              <div class="bg-white/20 backdrop-blur-sm p-3 rounded-xl">
                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
              </div>
            </div>

            <div class="pr-16">
              <h3 class="text-xl font-semibold text-white mb-2">
                Пользователи
              </h3>
              <p class="text-sm text-emerald-100 leading-relaxed">
                Управление учетными записями сотрудников, их профилями и активностью
              </p>
            </div>

            <div class="mt-6 flex justify-end">
              <div class="bg-white/20 p-2 rounded-lg group-hover:bg-white/30 transition-colors">
                <svg class="w-5 h-5 text-white transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
              </div>
            </div>
          </div>

          <!-- Отделы -->
          <div
              class="relative overflow-hidden rounded-xl p-6 flex flex-col justify-between
           bg-gradient-to-br from-purple-500 to-violet-600
           hover:from-purple-600 hover:to-violet-700
           transition-all hover:shadow-lg hover:scale-[1.01]
           cursor-pointer group"
              @click="navigateTo('/admin/branches')"
          >
            <div class="absolute right-6 top-6">
              <div class="bg-white/20 backdrop-blur-sm p-3 rounded-xl">
                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
              </div>
            </div>

            <div class="pr-16">
              <h3 class="text-xl font-semibold text-white mb-2">
                Отделы
              </h3>
              <p class="text-sm text-purple-100 leading-relaxed">
                Управление структурными подразделениями компании и организационной иерархией
              </p>
            </div>

            <div class="mt-6 flex justify-end">
              <div class="bg-white/20 p-2 rounded-lg group-hover:bg-white/30 transition-colors">
                <svg class="w-5 h-5 text-white transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
              </div>
            </div>
          </div>

          <!-- Помещения -->
          <div
              class="relative overflow-hidden rounded-xl p-6 flex flex-col justify-between
           bg-gradient-to-br from-amber-500 to-orange-600
           hover:from-amber-600 hover:to-orange-700
           transition-all hover:shadow-lg hover:scale-[1.01]
           cursor-pointer group"
              @click="navigateTo('/admin/auditoriums')"
          >
            <div class="absolute right-6 top-6">
              <div class="bg-white/20 backdrop-blur-sm p-3 rounded-xl">
                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
              </div>
            </div>

            <div class="pr-16">
              <h3 class="text-xl font-semibold text-white mb-2">
                Помещения
              </h3>
              <p class="text-sm text-amber-100 leading-relaxed">
                Управление офисными помещениями, кабинетами и местами расположения активов
              </p>
            </div>

            <div class="mt-6 flex justify-end">
              <div class="bg-white/20 p-2 rounded-lg group-hover:bg-white/30 transition-colors">
                <svg class="w-5 h-5 text-white transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
              </div>
            </div>
          </div>

          <!-- Файловая система -->
          <div
              class="relative overflow-hidden rounded-xl p-6 flex flex-col justify-between
           bg-gradient-to-br from-pink-500 to-rose-600
           hover:from-pink-600 hover:to-rose-700
           transition-all hover:shadow-lg hover:scale-[1.01]
           cursor-pointer group"
              @click="navigateTo('/admin/files')"
          >
            <div class="absolute right-6 top-6">
              <div class="bg-white/20 backdrop-blur-sm p-3 rounded-xl">
                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
              </div>
            </div>

            <div class="pr-16">
              <h3 class="text-xl font-semibold text-white mb-2">
                Файловая система
              </h3>
              <p class="text-sm text-pink-100 leading-relaxed">
                Управление файлами и документами, хранение сканов и прочей документации
              </p>
            </div>

            <div class="mt-6 flex justify-end">
              <div class="bg-white/20 p-2 rounded-lg group-hover:bg-white/30 transition-colors">
                <svg class="w-5 h-5 text-white transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
              </div>
            </div>
          </div>

          <!-- Компании -->
          <div
              class="relative overflow-hidden rounded-xl p-6 flex flex-col justify-between
           bg-gradient-to-br from-cyan-500 to-sky-600
           hover:from-cyan-600 hover:to-sky-700
           transition-all hover:shadow-lg hover:scale-[1.01]
           cursor-pointer group"
              @click="navigateTo('/admin/companies')"
          >
            <div class="absolute right-6 top-6">
              <div class="bg-white/20 backdrop-blur-sm p-3 rounded-xl">
                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
              </div>
            </div>

            <div class="pr-16">
              <h3 class="text-xl font-semibold text-white mb-2">
                Компании
              </h3>
              <p class="text-sm text-cyan-100 leading-relaxed">
                Управление компаниями
              </p>
            </div>

            <div class="mt-6 flex justify-end">
              <div class="bg-white/20 p-2 rounded-lg group-hover:bg-white/30 transition-colors">
                <svg class="w-5 h-5 text-white transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
              </div>
            </div>
          </div>

          <!-- Модели устройств -->
          <div
              class="relative overflow-hidden rounded-xl p-6 flex flex-col justify-between
           bg-gradient-to-br from-lime-500 to-green-600
           hover:from-lime-600 hover:to-green-700
           transition-all hover:shadow-lg hover:scale-[1.01]
           cursor-pointer group"
              @click="navigateTo('/admin/models')"
          >
            <div class="absolute right-6 top-6">
              <div class="bg-white/20 backdrop-blur-sm p-3 rounded-xl">
                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                </svg>
              </div>
            </div>

            <div class="pr-16">
              <h3 class="text-xl font-semibold text-white mb-2">
                Модели устройств
              </h3>
              <p class="text-sm text-lime-100 leading-relaxed">
                Управление моделями оборудования, их характеристиками и спецификациями
              </p>
            </div>

            <div class="mt-6 flex justify-end">
              <div class="bg-white/20 p-2 rounded-lg group-hover:bg-white/30 transition-colors">
                <svg class="w-5 h-5 text-white transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
              </div>
            </div>
          </div>

          <!-- Потребление расходных материалов -->
          <div
              class="relative overflow-hidden rounded-xl p-6 flex flex-col justify-between
     bg-gradient-to-br from-red-500 to-pink-600
     hover:from-red-600 hover:to-pink-700
     transition-all hover:shadow-lg hover:scale-[1.01]
     cursor-pointer group"
              @click="navigateTo('/admin/model-resources')"
          >
            <div class="absolute right-6 top-6">
              <div class="bg-white/20 backdrop-blur-sm p-3 rounded-xl">
                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                </svg>
              </div>
            </div>

            <div class="pr-16">
              <h3 class="text-xl font-semibold text-white mb-2">
                Потребление расходных материалов
              </h3>
              <p class="text-sm text-red-100 leading-relaxed">
                Учёт и управление расходными материалами, отслеживание потребления и остатков
              </p>
            </div>

            <div class="mt-6 flex justify-end">
              <div class="bg-white/20 p-2 rounded-lg group-hover:bg-white/30 transition-colors">
                <svg class="w-5 h-5 text-white transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
              </div>
            </div>
          </div>

          <!-- Безопасность (новая карточка) -->
          <div
              class="relative overflow-hidden rounded-xl p-6 flex flex-col justify-between
           bg-gradient-to-br from-indigo-600 to-blue-700
           hover:from-indigo-700 hover:to-blue-800
           transition-all hover:shadow-lg hover:scale-[1.01]
           cursor-pointer group border-2 border-white/30"
              @click="navigateTo('/admin/security')"
          >
            <div class="absolute right-6 top-6">
              <div class="bg-white/20 backdrop-blur-sm p-3 rounded-xl">
                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                </svg>
              </div>
            </div>

            <div class="pr-16">
              <h3 class="text-xl font-semibold text-white mb-2 flex items-center gap-2">
                Безопасность
              </h3>
              <p class="text-sm text-indigo-100 leading-relaxed">
                Управление токенами доступа, мониторинг активных сессий, отзыв токенов
              </p>
            </div>

            <div class="mt-6 flex justify-end">
              <div class="bg-white/20 p-2 rounded-lg group-hover:bg-white/30 transition-colors">
                <svg class="w-5 h-5 text-white transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

// Моковые данные статистики
const stats = ref({
  positions: 15,
  users: 42,
  auditoriums: 28,
  branches: 10,
  activeSessions: 8,
  dailyActivity: '142',
  lastUpdate: '2 мин назад',
  // Данные для кадровика
  employees: 156,
  activeEmployees: 142,
  lastHRUpdate: '5 мин назад'
})

// Метод навигации
const navigateTo = (path) => {
  router.push(path)
}
</script>

<style scoped>
.admin-card {
  position: relative;
  padding: 1.5rem;
  display: flex;
  flex-direction: column;
  cursor: pointer;
  transition: all 0.3s;
  transform: translateY(0);
  min-height: 280px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  border-radius: 1rem;
  overflow: hidden;
}

.admin-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
}

.admin-card::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.1), transparent);
  opacity: 0;
  transition: opacity 0.3s;
}

.admin-card:hover::before {
  opacity: 1;
}

/* Анимация иконок */
.admin-card svg {
  transition: all 0.3s ease;
}

.admin-card:hover svg:not(.group-hover\:translate-x-1) {
  transform: scale(1.1);
}

/* Градиентные границы */
.admin-card {
  border: 2px solid transparent;
  background-clip: padding-box;
  position: relative;
}

.admin-card::after {
  content: '';
  position: absolute;
  inset: 0;
  z-index: -1;
  background: linear-gradient(to right,
  rgba(255, 255, 255, 0.2),
  rgba(255, 255, 255, 0.1),
  transparent);
  opacity: 0;
  transition: opacity 0.3s ease;
  border-radius: inherit;
}

.admin-card:hover::after {
  opacity: 1;
}

/* Адаптивность */
@media (max-width: 640px) {
  .admin-card {
    min-height: 240px;
    padding: 1.25rem;
  }

  .grid {
    grid-template-columns: 1fr;
  }
}

@media (min-width: 641px) and (max-width: 768px) {
  .grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (min-width: 769px) and (max-width: 1024px) {
  .grid {
    grid-template-columns: repeat(3, 1fr);
  }
}

@media (min-width: 1025px) and (max-width: 1280px) {
  .grid {
    grid-template-columns: repeat(4, 1fr);
  }
}

@media (min-width: 1281px) {
  .grid {
    grid-template-columns: repeat(5, 1fr);
  }
}

/* Анимация пульсации для индикатора */
@keyframes pulse {
  0%, 100% {
    opacity: 1;
  }
  50% {
    opacity: 0.5;
  }
}

.animate-pulse {
  animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
</style>