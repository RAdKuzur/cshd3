<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 flex items-center justify-center p-6">
    <div class="max-w-2xl mx-auto">

      <!-- Основной контент -->
      <div class="bg-white rounded-3xl shadow-2xl border border-gray-200 p-12 text-center relative overflow-hidden">

        <!-- Декоративные элементы -->
        <div class="absolute -top-20 -right-20 w-40 h-40 bg-gradient-to-br from-red-100 to-orange-100 rounded-full opacity-30"></div>
        <div class="absolute -bottom-16 -left-16 w-32 h-32 bg-gradient-to-tr from-blue-100 to-purple-100 rounded-full opacity-30"></div>

        <!-- Анимированная иконка -->
        <div class="mb-8">
          <div class="relative inline-block">
            <div class="w-32 h-32 bg-gradient-to-br from-red-100 to-orange-100 rounded-full flex items-center justify-center mx-auto mb-4 animate-pulse">
              <div class="relative">
                <svg class="w-20 h-20 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                <div class="absolute -top-1 -right-1 w-8 h-8 bg-white rounded-full flex items-center justify-center">
                  <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                  </svg>
                </div>
              </div>
            </div>

            <!-- Анимированные круги -->
            <div class="absolute -top-2 -right-2 w-8 h-8 bg-yellow-400 rounded-full animate-bounce"></div>
            <div class="absolute -bottom-2 -left-2 w-6 h-6 bg-blue-400 rounded-full animate-bounce" style="animation-delay: 0.2s;"></div>
          </div>
        </div>

        <!-- Заголовок ошибки -->
        <div class="mb-6">
          <span class="inline-block px-4 py-2 bg-gradient-to-r from-red-500 to-orange-500 text-white text-sm font-semibold rounded-full mb-4 animate-pulse">
            Код ошибки: LIC-EXP-403
          </span>
          <h1 class="text-5xl font-bold text-gray-900 mb-4">
            Лицензия <span class="bg-gradient-to-r from-red-600 to-orange-600 bg-clip-text text-transparent">отозвана или истекла</span>
          </h1>
        </div>

        <!-- Описание проблемы -->
        <div class="mb-8">
          <p class="text-xl text-gray-600 mb-6 leading-relaxed">
            Доступ к приложению временно ограничен из-за проблем с лицензией.
            Это может быть связано с истечением срока действия или отзывом лицензионного ключа.
          </p>

<!--          <div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl p-5 border border-amber-200 inline-block">-->
<!--            <div class="flex items-center justify-center space-x-2 text-amber-800">-->
<!--              <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">-->
<!--                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />-->
<!--              </svg>-->
<!--              <span class="font-medium">Срок действия лицензии: <span class="font-bold">{{ licenseExpiry }}</span></span>-->
<!--            </div>-->
<!--          </div>-->
        </div>

        <!-- Причины и решения -->
        <div class="mb-10">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
            <!-- Возможные причины -->
            <div class="bg-gradient-to-br from-gray-50 to-blue-50 rounded-xl p-5 border border-blue-100">
              <div class="flex items-center mb-3">
                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                  <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                  </svg>
                </div>
                <h3 class="font-bold text-gray-800">Возможные причины</h3>
              </div>
              <ul class="space-y-2 text-gray-600">
                <li class="flex items-start">
                  <span class="text-red-500 mr-2">•</span>
                  <span>Истек срок действия лицензии</span>
                </li>
                <li class="flex items-start">
                  <span class="text-red-500 mr-2">•</span>
                  <span>Лицензия была отозвана</span>
                </li>
                <li class="flex items-start">
                  <span class="text-red-500 mr-2">•</span>
                  <span>Проблемы с оплатой лицензии</span>
                </li>
                <li class="flex items-start">
                  <span class="text-red-500 mr-2">•</span>
                  <span>Нарушение условий лицензионного соглашения</span>
                </li>
              </ul>
            </div>

            <!-- Как решить -->
            <div class="bg-gradient-to-br from-gray-50 to-green-50 rounded-xl p-5 border border-green-100">
              <div class="flex items-center mb-3">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                  <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
                <h3 class="font-bold text-gray-800">Как решить</h3>
              </div>
              <ul class="space-y-2 text-gray-600">
                <li class="flex items-start">
                  <span class="text-green-500 mr-2">•</span>
                  <span>Обновите лицензию</span>
                </li>
                <li class="flex items-start">
                  <span class="text-green-500 mr-2">•</span>
                  <span>Обратитесь к администратору системы</span>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <!-- Кнопки действий -->
<!--        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8">-->
<!--          <button-->
<!--              @click="renewLicense"-->
<!--              class="group relative overflow-hidden bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold py-4 px-8 rounded-xl shadow-lg transition-all duration-300 transform hover:scale-105 hover:shadow-xl w-full sm:w-auto"-->
<!--          >-->
<!--            <span class="relative z-10 flex items-center justify-center">-->
<!--              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">-->
<!--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />-->
<!--              </svg>-->
<!--              Обновить лицензию-->
<!--            </span>-->
<!--          </button>-->

<!--          <button-->
<!--              @click="contactSupport"-->
<!--              class="group relative overflow-hidden bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-semibold py-4 px-8 rounded-xl shadow-lg transition-all duration-300 transform hover:scale-105 hover:shadow-xl w-full sm:w-auto"-->
<!--          >-->
<!--            <span class="relative z-10 flex items-center justify-center">-->
<!--              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">-->
<!--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />-->
<!--              </svg>-->
<!--              Связаться с поддержкой-->
<!--            </span>-->
<!--          </button>-->

<!--          <button-->
<!--              @click="checkLicense"-->
<!--              class="group relative overflow-hidden bg-white text-gray-700 font-semibold py-4 px-8 rounded-xl border border-gray-300 shadow-sm hover:shadow-md transition-all duration-300 transform hover:scale-105 w-full sm:w-auto"-->
<!--          >-->
<!--            <span class="relative z-10 flex items-center justify-center">-->
<!--              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">-->
<!--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />-->
<!--              </svg>-->
<!--              Проверить статус-->
<!--            </span>-->
<!--          </button>-->
<!--        </div>-->

        <!-- Дополнительная информация -->
        <div class="mt-8 pt-6 border-t border-gray-200">
          <div class="text-sm text-gray-500">
<!--            <p class="mb-2">Нужна дополнительная информация о лицензировании?</p>-->
            <div class="flex flex-wrap justify-center gap-4">
<!--              <button @click="openLicenseDocs" class="text-blue-600 hover:text-blue-700 font-medium transition-colors duration-200 flex items-center">-->
<!--                <span class="flex items-center">-->
<!--                  Документация по лицензиям-->
<!--                  <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">-->
<!--                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />-->
<!--                  </svg>-->
<!--                </span>-->
<!--              </button>-->
<!--              <span class="text-gray-300">|</span>-->
<!--              <button @click="viewLicenseHistory" class="text-blue-600 hover:text-blue-700 font-medium transition-colors duration-200 flex items-center">-->
<!--                <span class="flex items-center">-->
<!--                  История лицензий-->
<!--                  <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">-->
<!--                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />-->
<!--                  </svg>-->
<!--                </span>-->
<!--              </button>-->
<!--              <span class="text-gray-300">|</span>-->
              <button @click="goToHome" class="text-blue-600 hover:text-blue-700 font-medium transition-colors duration-200 flex items-center">
                <span class="flex items-center">
                  На главную
                  <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                  </svg>
                </span>
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Футер -->
<!--      <div class="mt-8 text-center">-->
<!--        <p class="text-sm text-gray-500">-->
<!--          По вопросам лицензирования обращайтесь по email:-->
<!--          <a href="mailto:license@example.com" class="text-blue-600 hover:text-blue-700 underline">license@example.com</a>-->
<!--          или по телефону: <span class="font-medium">+7 (999) 123-45-67</span>-->
<!--        </p>-->
<!--      </div>-->
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

// Данные о лицензии (можно получать из API)
const licenseExpiry = ref('15 марта 2024')

// Методы действий
const renewLicense = () => {
  // Здесь логика для обновления лицензии
  window.location.href = '/license/renew'
  // Или открытие модального окна
}

const contactSupport = () => {
  window.location.href = '/support?issue=license'
}

const checkLicense = () => {
  // Проверка статуса лицензии
  window.location.href = '/dashboard/license'
}

const openLicenseDocs = () => {
  window.open('/docs/licensing', '_blank')
}

const viewLicenseHistory = () => {
  window.location.href = '/license/history'
}

const goToHome = () => {
  window.location.href = '/'
}

// При загрузке страницы можно собрать информацию об ошибке
const reportLicenseError = () => {
  const errorInfo = {
    errorType: 'license_expired_or_revoked',
    url: window.location.href,
    userAgent: navigator.userAgent,
    timestamp: new Date().toISOString(),
    // Можно добавить идентификатор лицензии, если доступен
    // licenseId: getLicenseIdFromStorage()
  }

  // Здесь можно отправить информацию на сервер
}

// При загрузке компонента
onMounted(() => {
  reportLicenseError()

  // Можно добавить таймер для демонстрации (опционально)
  const timer = setInterval(() => {
    // Обновляем время каждую минуту
    // В реальном приложении здесь может быть проверка статуса лицензии
  }, 60000)

  return () => clearInterval(timer)
})
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

/* Анимация для предупреждающего значка */
@keyframes shake {
  0%, 100% { transform: rotate(0deg); }
  25% { transform: rotate(-5deg); }
  75% { transform: rotate(5deg); }
}

.animate-shake {
  animation: shake 0.5s ease-in-out infinite;
}

/* Стили для градиентных кнопок */
button {
  transition: all 0.3s ease;
}

button:active {
  transform: scale(0.98);
}
</style>