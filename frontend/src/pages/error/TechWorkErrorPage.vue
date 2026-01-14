<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-indigo-50 flex items-center justify-center p-6">
    <div class="max-w-2xl mx-auto">

      <!-- Основной контент -->
      <div class="bg-white rounded-3xl shadow-2xl border border-gray-200 p-12 text-center relative overflow-hidden">

        <!-- Декоративные элементы -->
        <div class="absolute -top-20 -right-20 w-40 h-40 bg-gradient-to-br from-amber-100 to-orange-100 rounded-full opacity-30"></div>
        <div class="absolute -bottom-16 -left-16 w-32 h-32 bg-gradient-to-tr from-indigo-100 to-purple-100 rounded-full opacity-30"></div>

        <!-- Анимированная иконка -->
        <div class="mb-8">
          <div class="relative inline-block">
            <div class="w-32 h-32 bg-gradient-to-br from-amber-100 to-orange-100 rounded-full flex items-center justify-center mx-auto mb-4 animate-pulse">
              <div class="relative">
                <svg class="w-20 h-20 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <div class="absolute -top-1 -right-1 w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-sm">
                  <svg class="w-5 h-5 text-amber-600 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                  </svg>
                </div>
              </div>
            </div>

            <!-- Анимированные элементы -->
            <div class="absolute -top-2 -right-2 w-8 h-8 bg-amber-400 rounded-full animate-bounce"></div>
            <div class="absolute -bottom-2 -left-2 w-6 h-6 bg-indigo-400 rounded-full animate-bounce" style="animation-delay: 0.2s;"></div>
          </div>
        </div>

        <!-- Заголовок -->
        <div class="mb-6">
          <span class="inline-block px-4 py-2 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-sm font-semibold rounded-full mb-4 animate-pulse">
            Техническое обслуживание
          </span>
          <h1 class="text-5xl font-bold text-gray-900 mb-4">
            <span class="bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">Временное техобслуживание</span>
          </h1>
        </div>

        <!-- Описание -->
        <div class="mb-8">
          <p class="text-xl text-gray-600 mb-6 leading-relaxed">
            Мы проводим плановые технические работы для улучшения производительности системы.
            В это время доступ к приложению может быть ограничен.
          </p>

          <!-- Таймер или информация о времени -->
<!--          <div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl p-5 border border-amber-200 inline-block max-w-md">-->
<!--            <div class="flex items-center justify-center space-x-4 text-amber-800">-->
<!--              <svg class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">-->
<!--                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />-->
<!--              </svg>-->
<!--              <div class="text-center">-->
<!--                <div class="font-medium">Работы завершатся через:</div>-->
<!--                <div class="text-2xl font-bold mt-1">{{ countdown }}</div>-->
<!--              </div>-->
<!--            </div>-->
<!--          </div>-->
        </div>

        <!-- Детали работ -->
        <div class="mb-10">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
            <!-- Что происходит -->
            <div class="bg-gradient-to-br from-gray-50 to-blue-50 rounded-xl p-5 border border-blue-100">
              <div class="flex items-center mb-3">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                  <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
                <h3 class="font-bold text-gray-800">Что происходит</h3>
              </div>
              <ul class="space-y-2 text-gray-600">
                <li class="flex items-start">
                  <span class="text-blue-500 mr-2">•</span>
                  <span>Обновление систем безопасности</span>
                </li>
                <li class="flex items-start">
                  <span class="text-blue-500 mr-2">•</span>
                  <span>Оптимизация производительности</span>
                </li>
                <li class="flex items-start">
                  <span class="text-blue-500 mr-2">•</span>
                  <span>Внедрение новых функций</span>
                </li>
                <li class="flex items-start">
                  <span class="text-blue-500 mr-2">•</span>
                  <span>Техническая профилактика</span>
                </li>
              </ul>
            </div>

            <!-- Что будет после -->
            <div class="bg-gradient-to-br from-gray-50 to-green-50 rounded-xl p-5 border border-green-100">
              <div class="flex items-center mb-3">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                  <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
                <h3 class="font-bold text-gray-800">Что будет после</h3>
              </div>
              <ul class="space-y-2 text-gray-600">
                <li class="flex items-start">
                  <span class="text-green-500 mr-2">•</span>
                  <span>Улучшенная скорость работы</span>
                </li>
                <li class="flex items-start">
                  <span class="text-green-500 mr-2">•</span>
                  <span>Новые полезные функции</span>
                </li>
                <li class="flex items-start">
                  <span class="text-green-500 mr-2">•</span>
                  <span>Повышенная стабильность</span>
                </li>
                <li class="flex items-start">
                  <span class="text-green-500 mr-2">•</span>
                  <span>Улучшенная безопасность</span>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <!-- Прогресс работ -->
<!--        <div class="mb-8">-->
<!--          <div class="mb-3 flex justify-between text-sm text-gray-600">-->
<!--            <span>Прогресс работ</span>-->
<!--            <span class="font-semibold">{{ progress }}%</span>-->
<!--          </div>-->
<!--          <div class="h-3 bg-gray-200 rounded-full overflow-hidden">-->
<!--            <div-->
<!--                class="h-full bg-gradient-to-r from-amber-500 to-orange-500 rounded-full transition-all duration-500 ease-out"-->
<!--                :style="{ width: progress + '%' }"-->
<!--            ></div>-->
<!--          </div>-->
<!--          <p class="text-sm text-gray-500 mt-2">Обновления внедряются поэтапно для минимизации простоев</p>-->
<!--        </div>-->

        <!-- Кнопки действий -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8">
<!--          <button-->
<!--              @click="checkStatus"-->
<!--              class="group relative overflow-hidden bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-semibold py-4 px-8 rounded-xl shadow-lg transition-all duration-300 transform hover:scale-105 hover:shadow-xl w-full sm:w-auto"-->
<!--          >-->
<!--            <span class="relative z-10 flex items-center justify-center">-->
<!--              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">-->
<!--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />-->
<!--              </svg>-->
<!--              Проверить статус-->
<!--            </span>-->
<!--          </button>-->

<!--          <button-->
<!--              @click="subscribeNotifications"-->
<!--              class="group relative overflow-hidden bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-semibold py-4 px-8 rounded-xl shadow-lg transition-all duration-300 transform hover:scale-105 hover:shadow-xl w-full sm:w-auto"-->
<!--          >-->
<!--            <span class="relative z-10 flex items-center justify-center">-->
<!--              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">-->
<!--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />-->
<!--              </svg>-->
<!--              Уведомить о завершении-->
<!--            </span>-->
<!--          </button>-->

          <button
              @click="goToHome"
              class="group relative overflow-hidden bg-white text-gray-700 font-semibold py-4 px-8 rounded-xl border border-gray-300 shadow-sm hover:shadow-md transition-all duration-300 transform hover:scale-105 w-full sm:w-auto"
          >
            <span class="relative z-10 flex items-center justify-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
              </svg>
              На главную
            </span>
          </button>
        </div>

        <!-- Дополнительная информация -->
<!--        <div class="mt-8 pt-6 border-t border-gray-200">-->
<!--          <div class="text-sm text-gray-500">-->
<!--            <p class="mb-2">Технические работы проводятся для вашего удобства</p>-->
<!--            <div class="flex flex-wrap justify-center gap-4">-->
<!--              <button @click="viewStatusPage" class="text-blue-600 hover:text-blue-700 font-medium transition-colors duration-200 flex items-center">-->
<!--                <span class="flex items-center">-->
<!--                  Страница статусов-->
<!--                  <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">-->
<!--                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />-->
<!--                  </svg>-->
<!--                </span>-->
<!--              </button>-->
<!--              <span class="text-gray-300">|</span>-->
<!--              <button @click="openFAQ" class="text-blue-600 hover:text-blue-700 font-medium transition-colors duration-200 flex items-center">-->
<!--                <span class="flex items-center">-->
<!--                  Частые вопросы-->
<!--                  <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">-->
<!--                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />-->
<!--                  </svg>-->
<!--                </span>-->
<!--              </button>-->
<!--              <span class="text-gray-300">|</span>-->
<!--              <button @click="contactSupport" class="text-blue-600 hover:text-blue-700 font-medium transition-colors duration-200 flex items-center">-->
<!--                <span class="flex items-center">-->
<!--                  Техподдержка-->
<!--                  <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">-->
<!--                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />-->
<!--                  </svg>-->
<!--                </span>-->
<!--              </button>-->
<!--            </div>-->
<!--          </div>-->
<!--        </div>-->
      </div>

      <!-- Футер -->
<!--      <div class="mt-8 text-center">-->
<!--        <p class="text-sm text-gray-500">-->
<!--          Технические работы проводятся с {{ maintenanceStart }} до {{ maintenanceEnd }}.-->
<!--          Приносим извинения за временные неудобства!-->
<!--        </p>-->
<!--      </div>-->
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

// Данные о техобслуживании
const maintenanceStart = ref('14:00')
const maintenanceEnd = ref('18:00')
const progress = ref(65) // Прогресс работ в процентах

// Таймер обратного отсчета
const countdown = ref('04:15:32')
const countdownInterval = ref(null)

// Методы действий
const checkStatus = () => {
  // Здесь можно добавить проверку статуса техработ
  window.location.reload()
}

const subscribeNotifications = () => {
  // Подписка на уведомления о завершении
  alert('Вы будете уведомлены по email о завершении работ!')
}

const viewStatusPage = () => {
  window.open('/status', '_blank')
}

const openFAQ = () => {
  window.open('/faq/maintenance', '_blank')
}

const contactSupport = () => {
  window.location.href = '/support?issue=maintenance'
}

const goToHome = () => {
  window.location.href = '/'
}

// Функция для обновления таймера
const updateCountdown = () => {
  // В реальном приложении здесь логика расчета времени до завершения
  // Сейчас это демо-логика
  const [hours, minutes, seconds] = countdown.value.split(':').map(Number)

  let totalSeconds = hours * 3600 + minutes * 60 + seconds - 1

  if (totalSeconds < 0) {
    totalSeconds = 0
    clearInterval(countdownInterval.value)
    countdown.value = 'Завершено!'
    progress.value = 100
    return
  }

  const newHours = Math.floor(totalSeconds / 3600)
  const newMinutes = Math.floor((totalSeconds % 3600) / 60)
  const newSeconds = totalSeconds % 60

  countdown.value = `${newHours.toString().padStart(2, '0')}:${newMinutes.toString().padStart(2, '0')}:${newSeconds.toString().padStart(2, '0')}`

  // Обновляем прогресс (демо-логика)
  if (progress.value < 100) {
    progress.value = Math.min(100, progress.value + 0.1)
  }
}

// При загрузке компонента
onMounted(() => {
  // Запускаем таймер
  countdownInterval.value = setInterval(updateCountdown, 1000)

  // Можно добавить получение реальных данных о техобслуживании
  fetchMaintenanceStatus()
})

// Очистка при размонтировании
onUnmounted(() => {
  if (countdownInterval.value) {
    clearInterval(countdownInterval.value)
  }
})

// Функция получения статуса (заглушка)
const fetchMaintenanceStatus = () => {
  // В реальном приложении здесь запрос к API
  console.log('Fetching maintenance status...')

  // Демо-данные
  setTimeout(() => {
    // Здесь можно обновить данные
  }, 1000)
}
</script>

<style scoped>
/* Дополнительные анимации */
@keyframes float {
  0%, 100% { transform: translateY(0px); }
  50% { transform: translateY(-10px); }
}

.animate-float {
  animation: float 3s ease-in-out infinite;
}

/* Анимация для иконки настроек */
@keyframes rotate {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}

.animate-rotate {
  animation: rotate 2s linear infinite;
}

/* Пульсация для прогресс-бара */
@keyframes pulse-glow {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.8; }
}

.pulse-glow {
  animation: pulse-glow 2s ease-in-out infinite;
}

/* Стили для кнопок */
button {
  transition: all 0.3s ease;
}

button:active {
  transform: scale(0.98);
}

/* Адаптивные стили */
@media (max-width: 640px) {
  .text-5xl {
    font-size: 2.5rem;
  }

  .p-12 {
    padding: 2rem 1.5rem;
  }
}
</style>