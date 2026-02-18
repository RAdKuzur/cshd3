<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-orange-50 flex items-center justify-center p-6">
    <div class="max-w-2xl mx-auto">

      <!-- Основной контент -->
      <div class="bg-white rounded-3xl shadow-2xl border border-gray-200 p-12 text-center relative overflow-hidden">

        <!-- Анимированная иконка -->
        <div class="mb-8">
          <div class="relative inline-block">
            <div class="w-32 h-32 bg-gradient-to-br from-orange-100 to-red-100 rounded-full flex items-center justify-center mx-auto mb-4 animate-pulse">
              <svg class="w-16 h-16 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
              </svg>
            </div>

            <!-- Анимированные элементы -->
            <div class="absolute -top-2 -right-2 w-8 h-8 bg-orange-500 rounded-full animate-bounce"></div>
            <div class="absolute -bottom-2 -left-2 w-6 h-6 bg-red-500 rounded-full animate-bounce" style="animation-delay: 0.2s;"></div>
            <div class="absolute top-4 -right-4 w-4 h-4 bg-yellow-500 rounded-full animate-bounce" style="animation-delay: 0.4s;"></div>

            <!-- Разрывающиеся круги -->
            <div class="absolute top-0 left-1/4 w-3 h-3 bg-orange-400 rounded-full animate-ping"></div>
            <div class="absolute bottom-4 right-1/4 w-2 h-2 bg-red-400 rounded-full animate-ping" style="animation-delay: 0.3s;"></div>
          </div>
        </div>

        <!-- Статус с анимацией -->
        <div class="mb-6 relative">
          <div class="relative inline-block">
            <span class="text-8xl font-bold bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent animate-shake">
              401
            </span>
            <div class="absolute -top-2 -right-4">
              <span class="text-sm font-bold text-red-500 bg-red-100 px-2 py-1 rounded-full animate-pulse">
                НЕ ДЕЙСТВИТЕЛЬНА
              </span>
            </div>
          </div>
        </div>

        <!-- Заголовок -->
        <h1 class="text-4xl font-bold text-gray-900 mb-4">
          Срок действия ссылки истек
        </h1>

        <!-- Описание -->
        <p class="text-xl text-gray-600 mb-8 leading-relaxed">
          Эта ссылка больше не действительна. Возможно, она устарела или была использована ранее.
        </p>

        <!-- Кнопки действий -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8">
          <button
              @click="goHome"
              class="group relative overflow-hidden bg-white text-gray-700 font-semibold py-4 px-8 rounded-xl border border-gray-300 shadow-sm hover:shadow-md transition-all duration-300 transform hover:scale-105"
          >
            <span class="relative z-10 flex items-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
              </svg>
              На главную
            </span>
          </button>
        </div>

        <!-- Декор -->
        <div class="absolute -bottom-10 -left-10 w-20 h-20 bg-orange-200 rounded-full opacity-20 animate-pulse"></div>
        <div class="absolute -top-10 -right-10 w-16 h-16 bg-red-200 rounded-full opacity-30 animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/3 -left-8 w-10 h-10 bg-yellow-200 rounded-full opacity-25 animate-pulse" style="animation-delay: 0.5s;"></div>
        <div class="absolute bottom-1/4 -right-6 w-12 h-12 bg-purple-200 rounded-full opacity-20 animate-pulse" style="animation-delay: 0.8s;"></div>

        <!-- Анимированные элементы -->
        <div class="absolute top-20 left-10 animate-float">
          <div class="w-4 h-4 bg-orange-400 rounded-full opacity-70"></div>
        </div>
        <div class="absolute bottom-20 right-12 animate-float" style="animation-delay: 0.5s;">
          <div class="w-3 h-3 bg-red-400 rounded-full opacity-70"></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import {ref, onMounted} from 'vue'

// Генерация ID ссылки
const generateLinkId = () => {
  return 'link_' + Math.random().toString(36).substring(2, 10) + '_' + Date.now().toString(36)
}

const linkId = ref(generateLinkId())
const expiredTime = ref('')

// Форматирование времени истечения
const formatExpiredTime = () => {
  const now = new Date()
  const expiredDate = new Date(now.getTime() - 24 * 60 * 60 * 1000) // 24 часа назад

  const options = {
    day: 'numeric',
    month: 'long',
    hour: '2-digit',
    minute: '2-digit'
  }

  return expiredDate.toLocaleString('ru-RU', options)
}

// Методы действий
const goHome = () => {
  window.location.href = '/'
}

const requestNewLink = () => {
  // Анимация нажатия
  const button = document.querySelector('.bg-gradient-to-r.from-orange-500')
  button.classList.add('animate-pulse')

  setTimeout(() => {
    button.classList.remove('animate-pulse')
    alert('Новая ссылка отправлена на вашу почту!')
  }, 1000)

  // Здесь можно добавить реальную логику отправки запроса
  console.log('Запрос новой ссылки')
}

const contactSupport = () => {
  const subject = encodeURIComponent('Проблема с недействительной ссылкой')
  const body = encodeURIComponent(`Здравствуйте! У меня проблема с недействительной ссылкой.\n\nID ссылки: ${linkId.value}\nВремя обращения: ${new Date().toLocaleString('ru-RU')}\n\nОпишите вашу проблему:`)
  window.location.href = `mailto:support@example.com?subject=${subject}&body=${body}`
}

// Инициализация
onMounted(() => {
  expiredTime.value = formatExpiredTime()

  // Анимация для иконки
  const icon = document.querySelector('.w-16.h-16')
  if (icon) {
    setInterval(() => {
      icon.classList.add('animate-shake')
      setTimeout(() => {
        icon.classList.remove('animate-shake')
      }, 500)
    }, 5000)
  }
})
</script>

<style scoped>
/* Анимации */
@keyframes float {
  0%, 100% {
    transform: translateY(0px) rotate(0deg);
  }
  50% {
    transform: translateY(-10px) rotate(5deg);
  }
}

@keyframes shake {
  0%, 100% {
    transform: translateX(0) rotate(0deg);
  }
  10%, 30%, 50%, 70%, 90% {
    transform: translateX(-2px) rotate(-1deg);
  }
  20%, 40%, 60%, 80% {
    transform: translateX(2px) rotate(1deg);
  }
}

.animate-float {
  animation: float 3s ease-in-out infinite;
}

.animate-shake {
  animation: shake 0.5s ease-in-out;
}

/* Эффекты для кнопок */
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
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
  transition: left 0.7s;
}

button:hover::after {
  left: 100%;
}

/* Градиентная обводка для главной кнопки */
button.bg-gradient-to-r.from-orange-500::before {
  content: '';
  position: absolute;
  top: -2px;
  left: -2px;
  right: -2px;
  bottom: -2px;
  background: linear-gradient(45deg, #f97316, #ef4444, #f97316);
  border-radius: 14px;
  z-index: -1;
  opacity: 0;
  transition: opacity 0.3s;
}

button.bg-gradient-to-r.from-orange-500:hover::before {
  opacity: 1;
}

/* Адаптивность */
@media (max-width: 640px) {
  .text-8xl {
    font-size: 4rem;
  }

  .text-4xl {
    font-size: 2rem;
  }

  .p-12 {
    padding: 1.5rem;
  }
}
</style>