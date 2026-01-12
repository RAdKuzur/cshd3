<template>
  <TransitionGroup
      name="toast"
      tag="div"
      class="fixed bottom-4 right-4 z-50 flex flex-col items-end space-y-2"
  >
    <div
        v-for="toast in toasts"
        :key="toast.id"
        class="w-80 bg-white rounded-lg shadow-lg overflow-hidden border-l-4 border-blue-500"
    >
      <div class="p-3">
        <div class="flex items-center justify-between">
          <!-- Левая часть с иконкой и текстом -->
          <div class="flex items-center min-w-0">
            <div class="flex-shrink-0 mr-3">
              <div class="rounded-full p-2 bg-blue-100 text-blue-600">
                <BellIcon class="w-4 h-4" />
              </div>
            </div>
            <div class="min-w-0 flex-1">
              <p class="text-sm font-medium text-gray-900 truncate">
                Уведомление
              </p>
              <p class="text-xs text-gray-500 truncate">
                {{ toast.message }}
              </p>
            </div>
          </div>

          <!-- Правая часть с временем и кнопкой -->
          <div class="flex items-center ml-2">
            <span class="text-xs text-gray-400 mr-2">
              {{ formatTime(toast.time) }}
            </span>
            <button
                @click="removeToast(toast.id)"
                class="text-gray-400 hover:text-gray-500"
            >
              <XMarkIcon class="h-4 w-4" />
            </button>
          </div>
        </div>
      </div>
    </div>
  </TransitionGroup>
</template>

<script setup>
import { BellIcon, XMarkIcon } from '@heroicons/vue/24/outline'
import { ref } from 'vue'

const props = defineProps({
  maxToasts: {
    type: Number,
    default: 3
  }
})

const toasts = ref([])

const formatTime = (time) => {
  try {
    return new Date(time).toLocaleTimeString('ru-RU', {
      hour: '2-digit',
      minute: '2-digit'
    })
  } catch (e) {
    return 'только что'
  }
}

const removeToast = (id) => {
  const index = toasts.value.findIndex(toast => toast.id === id)
  if (index > -1) {
    toasts.value.splice(index, 1)
  }
}

const addToast = (notification) => {
  const toast = {
    id: Date.now(),
    message: notification.message,
    time: notification.time || new Date()
  }

  toasts.value.unshift(toast)

  // Ограничиваем количество уведомлений
  if (toasts.value.length > props.maxToasts) {
    toasts.value.pop()
  }

  // Автоматическое удаление через 5 секунд
  const timeoutId = setTimeout(() => {
    removeToast(toast.id)
  }, 5000)

  // Сохраняем ID таймера для очистки при ручном закрытии
  toast.timeoutId = timeoutId
}

// Экспортируем метод для использования извне
defineExpose({
  addToast
})
</script>

<style scoped>
.toast-enter-active,
.toast-leave-active {
  transition: all 0.3s ease;
}

.toast-enter-from,
.toast-leave-to {
  opacity: 0;
  transform: translateX(100%);
}

.toast-move {
  transition: transform 0.3s ease;
}

/* Анимация однократного пульсирования */
@keyframes pulse-once {
  0% {
    box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7);
  }
  70% {
    box-shadow: 0 0 0 10px rgba(59, 130, 246, 0);
  }
  100% {
    box-shadow: 0 0 0 0 rgba(59, 130, 246, 0);
  }
}

.animate-pulse-once {
  animation: pulse-once 1.5s ease-in-out;
}
</style>