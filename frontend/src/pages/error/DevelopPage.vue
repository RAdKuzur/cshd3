<template>
  <div class="min-h-screen bg-gradient-to-br from-amber-50 to-orange-100 flex items-center justify-center p-6">
    <div class="max-w-2xl mx-auto">

      <!-- Основной контент -->
      <div class="bg-white rounded-3xl shadow-2xl border border-amber-200 p-12 text-center relative overflow-hidden">

        <!-- Анимированная иконка -->
        <div class="mb-8">
          <div class="relative inline-block">
            <div class="w-32 h-32 bg-gradient-to-br from-amber-100 to-orange-100 rounded-full flex items-center justify-center mx-auto mb-4 animate-pulse">
              <svg class="w-16 h-16 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
              </svg>
            </div>

            <!-- Анимированные элементы - инструменты разработчика -->
            <div class="absolute -top-2 -right-2 w-8 h-8 bg-amber-500 rounded-full animate-bounce flex items-center justify-center">
              <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
              </svg>
            </div>
            <div class="absolute -bottom-2 -left-2 w-6 h-6 bg-orange-500 rounded-full animate-bounce flex items-center justify-center" style="animation-delay: 0.2s;">
              <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
              </svg>
            </div>

            <!-- Круги с элементами -->
            <div class="absolute top-0 left-1/4 w-3 h-3 bg-amber-400 rounded-full animate-ping"></div>
            <div class="absolute bottom-4 right-1/4 w-2 h-2 bg-orange-400 rounded-full animate-ping" style="animation-delay: 0.3s;"></div>
          </div>
        </div>

        <!-- Статус разработки -->
        <div class="mb-6 relative">
          <div class="relative inline-block">
            <span class="text-6xl font-bold bg-gradient-to-r from-amber-700 to-orange-700 bg-clip-text text-transparent animate-pulse">
              🚧 В РАЗРАБОТКЕ
            </span>
            <div class="absolute -top-2 -right-4">
              <span class="text-sm font-bold text-amber-700 bg-amber-100 px-3 py-1 rounded-full animate-pulse">
                COMING SOON
              </span>
            </div>
          </div>
        </div>

        <!-- Заголовок -->
        <h1 class="text-4xl font-bold text-gray-900 mb-4">
          Этот раздел сейчас в разработке
        </h1>

        <!-- Описание -->
        <p class="text-xl text-gray-600 mb-8 leading-relaxed max-w-lg mx-auto">
          Наша команда активно работает над созданием этого раздела. Скоро здесь появится что-то потрясающее!
        </p>

        <!-- Прогресс разработки -->
<!--        <div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl p-6 mb-8 border border-amber-200">-->
<!--          <div class="flex items-center justify-center space-x-2 text-amber-700 mb-4">-->
<!--            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">-->
<!--              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />-->
<!--            </svg>-->
<!--            <span class="font-semibold">Прогресс разработки</span>-->
<!--          </div>-->

<!--          &lt;!&ndash; Индикатор прогресса &ndash;&gt;-->
<!--          <div class="mb-4">-->
<!--            <div class="flex justify-between text-sm text-gray-600 mb-2">-->
<!--              <span>Завершено:</span>-->
<!--              <span class="font-bold text-amber-700">{{ progress }}%</span>-->
<!--            </div>-->
<!--            <div class="h-3 bg-gray-200 rounded-full overflow-hidden">-->
<!--              <div-->
<!--                  class="h-full bg-gradient-to-r from-amber-400 to-orange-500 rounded-full transition-all duration-1000 ease-out"-->
<!--                  :style="{ width: progress + '%' }"-->
<!--              ></div>-->
<!--            </div>-->
<!--          </div>-->

<!--          &lt;!&ndash; Детали разработки &ndash;&gt;-->
<!--          <div class="text-gray-700 text-sm space-y-3 text-left max-w-md mx-auto">-->
<!--            <div class="flex items-start bg-white p-3 rounded-lg">-->
<!--              <svg class="w-4 h-4 mt-0.5 mr-2 flex-shrink-0 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">-->
<!--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />-->
<!--              </svg>-->
<!--              <div>-->
<!--                <span class="font-medium">Ожидаемое время запуска:</span>-->
<!--                <span class="ml-2 text-amber-600 font-semibold">{{ estimatedLaunch }}</span>-->
<!--              </div>-->
<!--            </div>-->

<!--            <div class="flex items-start bg-white p-3 rounded-lg">-->
<!--              <svg class="w-4 h-4 mt-0.5 mr-2 flex-shrink-0 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">-->
<!--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />-->
<!--              </svg>-->
<!--              <div>-->
<!--                <span class="font-medium">Команда разработчиков:</span>-->
<!--                <span class="ml-2 text-amber-600 font-semibold">Активно работает</span>-->
<!--              </div>-->
<!--            </div>-->
<!--          </div>-->
<!--        </div>-->

        <!-- Кнопки действий -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8">
          <button
              @click="goHome"
              class="group relative overflow-hidden bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold py-4 px-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105"
          >
            <span class="relative z-10 flex items-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
              </svg>
              На главную страницу
            </span>
          </button>

<!--          <button-->
<!--              @click="notifyMe"-->
<!--              class="group relative overflow-hidden bg-white text-gray-700 font-semibold py-4 px-8 rounded-xl border border-amber-300 shadow-sm hover:shadow-md transition-all duration-300 transform hover:scale-105"-->
<!--          >-->
<!--            <span class="relative z-10 flex items-center">-->
<!--              <svg class="w-5 h-5 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">-->
<!--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />-->
<!--              </svg>-->
<!--              Уведомить о запуске-->
<!--            </span>-->
<!--          </button>-->
        </div>

        <!-- Что уже готово -->
<!--        <div class="mt-8 pt-6 border-t border-gray-200">-->
<!--          <h3 class="text-lg font-semibold text-gray-700 mb-4">Что мы уже сделали:</h3>-->
<!--          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-w-lg mx-auto">-->
<!--            <div class="p-3 text-left bg-green-50 rounded-lg border border-green-200">-->
<!--              <div class="flex items-center">-->
<!--                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">-->
<!--                  <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">-->
<!--                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />-->
<!--                  </svg>-->
<!--                </div>-->
<!--                <div>-->
<!--                  <div class="font-medium text-green-800">Дизайн интерфейса</div>-->
<!--                  <div class="text-xs text-green-600">100% готово</div>-->
<!--                </div>-->
<!--              </div>-->
<!--            </div>-->

<!--            <div class="p-3 text-left bg-blue-50 rounded-lg border border-blue-200">-->
<!--              <div class="flex items-center">-->
<!--                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">-->
<!--                  <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">-->
<!--                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />-->
<!--                  </svg>-->
<!--                </div>-->
<!--                <div>-->
<!--                  <div class="font-medium text-blue-800">Фронтенд-разработка</div>-->
<!--                  <div class="text-xs text-blue-600">{{ frontendProgress }}% готово</div>-->
<!--                </div>-->
<!--              </div>-->
<!--            </div>-->

<!--            <div class="p-3 text-left bg-purple-50 rounded-lg border border-purple-200">-->
<!--              <div class="flex items-center">-->
<!--                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">-->
<!--                  <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">-->
<!--                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />-->
<!--                  </svg>-->
<!--                </div>-->
<!--                <div>-->
<!--                  <div class="font-medium text-purple-800">Бэкенд-разработка</div>-->
<!--                  <div class="text-xs text-purple-600">{{ backendProgress }}% готово</div>-->
<!--                </div>-->
<!--              </div>-->
<!--            </div>-->

<!--            <div class="p-3 text-left bg-yellow-50 rounded-lg border border-yellow-200">-->
<!--              <div class="flex items-center">-->
<!--                <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">-->
<!--                  <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">-->
<!--                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />-->
<!--                  </svg>-->
<!--                </div>-->
<!--                <div>-->
<!--                  <div class="font-medium text-yellow-800">Тестирование</div>-->
<!--                  <div class="text-xs text-yellow-600">{{ testingProgress }}% готово</div>-->
<!--                </div>-->
<!--              </div>-->
<!--            </div>-->
<!--          </div>-->
<!--        </div>-->

        <!-- Счетчик времени -->
<!--        <div class="mt-6 pt-4 border-t border-gray-200">-->
<!--          <div class="inline-flex items-center space-x-2 text-gray-600">-->
<!--            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">-->
<!--              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />-->
<!--            </svg>-->
<!--            <span>Раздел в разработке уже: <span class="font-bold text-amber-700">{{ daysInDevelopment }}</span> дней</span>-->
<!--          </div>-->
<!--        </div>-->

        <!-- Декор -->
        <div class="absolute -bottom-10 -left-10 w-20 h-20 bg-amber-200 rounded-full opacity-20 animate-pulse"></div>
        <div class="absolute -top-10 -right-10 w-16 h-16 bg-orange-200 rounded-full opacity-30 animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/3 -left-8 w-10 h-10 bg-amber-100 rounded-full opacity-25 animate-pulse" style="animation-delay: 0.5s;"></div>
        <div class="absolute bottom-1/4 -right-6 w-12 h-12 bg-orange-100 rounded-full opacity-20 animate-pulse" style="animation-delay: 0.8s;"></div>

        <!-- Анимированные элементы разработки -->
        <div class="absolute top-20 left-10 animate-float">
          <div class="w-4 h-4 bg-amber-400 rounded-full opacity-70 flex items-center justify-center">
            <svg class="w-2 h-2 text-white" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
            </svg>
          </div>
        </div>
        <div class="absolute bottom-20 right-12 animate-float" style="animation-delay: 0.5s;">
          <div class="w-3 h-3 bg-orange-400 rounded-full opacity-70"></div>
        </div>
        <div class="absolute top-10 right-20 animate-float" style="animation-delay: 0.3s;">
          <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
          </svg>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

// Прогресс разработки
const progress = ref(0)
const frontendProgress = ref(0)
const backendProgress = ref(0)
const testingProgress = ref(0)
const daysInDevelopment = ref(14)
const estimatedLaunch = ref('15 декабря 2023')

// Симуляция прогресса разработки
const simulateProgress = () => {
  const progressInterval = setInterval(() => {
    if (progress.value < 75) {
      progress.value += 1

      // Обновляем отдельные прогрессы
      if (frontendProgress.value < 90) frontendProgress.value += Math.random() * 2
      if (backendProgress.value < 80) backendProgress.value += Math.random() * 1.5
      if (testingProgress.value < 60) testingProgress.value += Math.random() * 1

      // Ограничиваем значения
      if (frontendProgress.value > 90) frontendProgress.value = 90
      if (backendProgress.value > 80) backendProgress.value = 80
      if (testingProgress.value > 60) testingProgress.value = 60
      if (progress.value > 75) progress.value = 75
    }
  }, 1000)

  return progressInterval
}

// Методы действий
const goHome = () => {
  window.location.href = '/'
}

const notifyMe = () => {
  const email = prompt('Введите ваш email, чтобы мы уведомили вас о запуске раздела:')
  if (email) {
    alert(`Спасибо! Мы уведомим вас на адрес ${email}, когда раздел будет готов.`)
    // Здесь можно отправить email на сервер для уведомления
  }
}

// Счетчик дней в разработке (каждый день увеличивается)
const startDaysCounter = () => {
  // В реальном приложении можно получать дату начала разработки из API
  // Для демо просто увеличиваем каждый день
  const savedDate = localStorage.getItem('dev_start_date')
  if (!savedDate) {
    const startDate = new Date()
    localStorage.setItem('dev_start_date', startDate.toISOString())
    daysInDevelopment.value = 1
  } else {
    const startDate = new Date(savedDate)
    const today = new Date()
    const diffTime = Math.abs(today - startDate)
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24))
    daysInDevelopment.value = diffDays
  }
}

// Анимация для иконки
const animateIcon = () => {
  const icon = document.querySelector('.w-16.h-16')
  if (icon) {
    setInterval(() => {
      icon.classList.add('animate-shake')
      setTimeout(() => {
        icon.classList.remove('animate-shake')
      }, 500)
    }, 3000)
  }
}

// Инициализация
onMounted(() => {
  startDaysCounter()
  const progressInterval = simulateProgress()
  animateIcon()

  // Обновляем время запуска (для демо)
  const today = new Date()
  const launchDate = new Date(today)
  launchDate.setDate(launchDate.getDate() + 30)
  estimatedLaunch.value = launchDate.toLocaleDateString('ru-RU', {
    day: 'numeric',
    month: 'long',
    year: 'numeric'
  })

  // Сохраняем интервал для очистки
  onUnmounted(() => {
    clearInterval(progressInterval)
  })
})
</script>

<style scoped>
/* Дополнительные анимации */
@keyframes float {
  0%, 100% { transform: translateY(0px) rotate(0deg); }
  50% { transform: translateY(-10px) rotate(5deg); }
}

@keyframes shake {
  0%, 100% { transform: translateX(0) rotate(0deg); }
  10%, 30%, 50%, 70%, 90% { transform: translateX(-2px) rotate(-1deg); }
  20%, 40%, 60%, 80% { transform: translateX(2px) rotate(1deg); }
}

@keyframes pulse-glow {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.7; box-shadow: 0 0 10px rgba(245, 158, 11, 0.5); }
}

@keyframes construction {
  0% { transform: rotate(0deg); }
  25% { transform: rotate(5deg); }
  50% { transform: rotate(0deg); }
  75% { transform: rotate(-5deg); }
  100% { transform: rotate(0deg); }
}

.animate-float {
  animation: float 3s ease-in-out infinite;
}

.animate-shake {
  animation: shake 0.5s ease-in-out;
}

.animate-glow {
  animation: pulse-glow 2s ease-in-out infinite;
}

.animate-construction {
  animation: construction 2s ease-in-out infinite;
}

/* Стили для иконки */
svg {
  transition: all 0.3s ease;
}

/* Градиентный фон для кнопок */
button {
  position: relative;
  overflow: hidden;
}

button::after {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
  transition: left 0.7s;
}

button:hover::after {
  left: 100%;
}

/* Специальный эффект для главной кнопки */
button.bg-gradient-to-r.from-amber-500::before {
  content: '';
  position: absolute;
  top: -2px;
  left: -2px;
  right: -2px;
  bottom: -2px;
  background: linear-gradient(45deg, #f59e0b, #f97316, #f59e0b);
  border-radius: 14px;
  z-index: -1;
  opacity: 0;
  transition: opacity 0.3s;
}

button.bg-gradient-to-r.from-amber-500:hover::before {
  opacity: 1;
}

/* Анимация для прогресс-бара */
.progress-bar {
  transition: width 0.5s ease-in-out;
}

/* Эффект для элементов в разработке */
.bg-gradient-to-br.from-amber-100 {
  background-size: 200% 200%;
  animation: gradientShift 3s ease infinite;
}

@keyframes gradientShift {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

/* Адаптивность */
@media (max-width: 640px) {
  .text-6xl {
    font-size: 2.5rem;
  }

  .text-4xl {
    font-size: 2rem;
  }

  .p-12 {
    padding: 1.5rem;
  }
}
</style>