<template>
  <Disclosure as="nav" class="bg-gradient-to-r from-indigo-600 to-purple-600 shadow-lg sticky top-0 z-50" v-slot="{ open }">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="flex h-16 items-center justify-between">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <a href="/home" class="inline-block">
              <ScaleIcon class="w-7 h-7 text-white hover:text-gray-300 cursor-pointer" />
            </a>
          </div>
          <div class="hidden md:block">
            <div class="ml-10 flex items-baseline space-x-4">
              <router-link
                  v-for="item in navigation"
                  :key="item.name"
                  :to="item.href"
                  :class="[
                  item.current
                    ? 'bg-white/20 text-white border-b-2 border-white'
                    : 'text-indigo-100 hover:bg-white/10 hover:text-white transition-colors duration-200',
                  'rounded-md px-3 py-2 text-sm font-medium flex items-center'
                ]"
              >
                <component :is="item.icon" class="w-4 h-4 mr-2" aria-hidden="true" />
                {{ item.name }}
              </router-link>
            </div>
          </div>
        </div>

        <!-- Блок для неавторизованных пользователей -->
        <div v-if="!isAuth" class="hidden md:block">
          <div class="ml-4 flex items-center md:ml-6 space-x-3">
            <router-link
                to="/login"
                class="relative flex items-center rounded-md bg-white/10 px-4 py-2 text-sm font-medium text-white hover:bg-white/20 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-600"
            >
              <UserIcon class="w-4 h-4 mr-2" aria-hidden="true" />
              Войти
            </router-link>
          </div>
        </div>

        <!-- Блок для авторизованных пользователей -->
        <div v-else class="hidden md:block">
          <div class="ml-4 flex items-center md:ml-6">
            <!-- Компонент уведомлений -->
            <Menu as="div" class="relative">
              <!-- Кнопка уведомлений -->
              <MenuButton
                  class="relative rounded-full p-1 text-indigo-200 hover:text-white hover:bg-white/10 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-white"
                  @click="fetchNotifications"
              >
                <span class="sr-only">Просмотреть уведомления</span>
                <BellIcon class="h-6 w-6" aria-hidden="true" />
                <!-- Бейдж с количеством непрочитанных -->
                <span
                    v-if="unreadCount > 0"
                    class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-xs text-white"
                >
                  {{ unreadCount }}
                </span>
              </MenuButton>

              <!-- Выпадающее меню уведомлений -->
              <transition
                  enter-active-class="transition ease-out duration-100"
                  enter-from-class="transform opacity-0 scale-95"
                  enter-to-class="transform opacity-100 scale-100"
                  leave-active-class="transition ease-in duration-75"
                  leave-from-class="transform opacity-100 scale-100"
                  leave-to-class="transform opacity-0 scale-95"
              >
                <MenuItems
                    class="absolute right-0 z-50 mt-2 w-96 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                >
                  <div class="py-1">
                    <!-- Заголовок с кнопкой прочитать все -->
                    <div class="flex items-center justify-between px-4 py-2 border-b">
                      <span class="text-sm font-semibold text-gray-900">Уведомления</span>
                      <button
                          v-if="unreadCount > 0"
                          @click.stop="markAllAsRead"
                          class="text-xs text-indigo-600 hover:text-indigo-800 font-medium"
                          :disabled="isMarkingAllAsRead"
                      >
                        <ArrowPathIcon v-if="isMarkingAllAsRead" class="w-3 h-3 animate-spin inline mr-1" />
                        <span v-else>Прочитать все</span>
                      </button>
                    </div>

                    <!-- Список уведомлений -->
                    <div class="max-h-96 overflow-y-auto">
                      <!-- Состояние загрузки -->
                      <div v-if="isLoading" class="p-4 text-center">
                        <ArrowPathIcon class="w-6 h-6 animate-spin mx-auto text-gray-400" />
                        <p class="text-sm text-gray-500 mt-2">Загрузка уведомлений...</p>
                      </div>

                      <!-- Уведомления -->
                      <div v-else-if="notifications.length > 0">
                        <MenuItem
                            v-for="notification in unreadNotifications"
                            :key="notification.id"
                            v-slot="{ active }"
                        >
                          <div
                              :class="[
                              active ? 'bg-gray-50' : '',
                              'px-4 py-3 cursor-pointer',
                              notification.is_read === 1 ? 'bg-indigo-50 border-l-4 border-indigo-500' : ''
                            ]"
                              @click="markAsRead(notification.id)"
                          >
                            <div class="flex items-start">
                              <!-- Иконка типа уведомления -->
                              <div class="flex-shrink-0">
                                <div
                                    :class="[
                                    'rounded-full p-2',
                                    notification.is_read === 1 ? 'bg-indigo-100 text-indigo-600' : 'bg-gray-100 text-gray-600'
                                  ]"
                                >
                                  <BellIcon class="w-4 h-4" />
                                </div>
                              </div>

                              <div class="ml-3 w-0 flex-1">
                                <!-- Текст уведомления -->
                                <p
                                    :class="[
                                    'text-sm font-medium',
                                    notification.is_read === 1 ? 'text-gray-900' : 'text-gray-500'
                                  ]"
                                >
                                  {{ notification.message }}
                                </p>

                                <!-- Время уведомления -->
                                <p
                                    v-if="notification.created_at"
                                    class="text-xs text-gray-400 mt-1"
                                >
                                  {{ formatDate(notification.created_at) }}
                                </p>

                                <!-- Кнопка прочитать -->
                                <button
                                    v-if="notification.is_read === 1"
                                    @click.stop="markAsRead(notification.id)"
                                    class="text-xs text-indigo-600 hover:text-indigo-800 mt-1"
                                    :disabled="isMarkingAsRead === notification.id"
                                >
                                  <span v-if="isMarkingAsRead === notification.id">
                                    <ArrowPathIcon class="w-3 h-3 animate-spin inline mr-1" />
                                  </span>
                                  Отметить как прочитанное
                                </button>
                              </div>

                              <!-- Индикатор непрочитанного -->
                              <div v-if="notification.is_read === 1" class="ml-2">
                                <div class="w-2 h-2 rounded-full bg-indigo-500"></div>
                              </div>
                            </div>
                          </div>
                        </MenuItem>
                      </div>

                      <!-- Нет уведомлений -->
                      <div v-else class="p-4 text-center">
                        <BellIcon class="w-12 h-12 mx-auto text-gray-300" />
                        <p class="text-sm text-gray-500 mt-2">У вас нет уведомлений</p>
                      </div>
                    </div>
                  </div>
                </MenuItems>
              </transition>
            </Menu>

            <!-- Профиль -->
            <Menu as="div" class="relative ml-3">
              <MenuButton
                  class="relative flex max-w-xs items-center rounded-full bg-white/10 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-600 hover:bg-white/20 transition-colors duration-200"
              >
                <span class="sr-only">Открыть меню пользователя</span>
                <img
                    class="h-8 w-8 rounded-full border-2 border-white/20"
                    :src="profileBar.icon_link"
                    alt="Профиль пользователя"
                />
                <span class="ml-2 mr-1 text-indigo-100 text-sm font-medium hidden lg:block">
                  {{ profileBar.fio }}
                </span>
                <ChevronDownIcon class="ml-1 h-4 w-4 text-indigo-200" aria-hidden="true" />
              </MenuButton>

              <transition
                  enter-active-class="transition ease-out duration-100"
                  enter-from-class="transform opacity-0 scale-95"
                  enter-to-class="transform opacity-100 scale-100"
                  leave-active-class="transition ease-in duration-75"
                  leave-from-class="transform opacity-100 scale-100"
                  leave-to-class="transform opacity-0 scale-95"
              >
                <MenuItems
                    class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                >
                  <MenuItem v-slot="{ active }">
                    <router-link
                        :to="profileUrl"
                        :class="[active ? 'bg-gray-100' : '', 'flex items-center px-4 py-2 text-sm text-gray-700']"
                    >
                      <UserIcon class="w-4 h-4 mr-2 text-gray-400" />
                      Профиль
                    </router-link>
                  </MenuItem>

                  <!-- Новый пункт "Настройки" -->
                  <MenuItem v-slot="{ active }">
                    <router-link
                        :to="settingsUrl"
                        :class="[active ? 'bg-gray-100' : '', 'flex items-center px-4 py-2 text-sm text-gray-700']"
                    >
                      <Cog6ToothIcon class="w-4 h-4 mr-2 text-gray-400" />
                      Настройки
                    </router-link>
                  </MenuItem>

                  <MenuItem v-slot="{ active }">
                    <router-link
                        :to="inventoryUrl"
                        :class="[active ? 'bg-gray-100' : '', 'flex items-center px-4 py-2 text-sm text-gray-700']"
                    >
                      <ArchiveBoxIcon class="w-4 h-4 mr-2 text-gray-400" />
                      Мои мат. ценности
                    </router-link>
                  </MenuItem>

                  <div class="border-t border-gray-100 my-1"></div>
                  <MenuItem v-slot="{ active }" @click="logout">
                    <button
                        :class="[active ? 'bg-gray-100' : '', 'flex w-full items-center px-4 py-2 text-sm text-gray-700']"
                    >
                      <ArrowRightOnRectangleIcon class="w-4 h-4 mr-2 text-gray-400" />
                      Выход
                    </button>
                  </MenuItem>
                </MenuItems>
              </transition>
            </Menu>
          </div>
        </div>

        <!-- Мобильное меню -->
        <div class="flex md:hidden">
          <DisclosureButton
              class="relative inline-flex items-center justify-center rounded-md p-2 text-indigo-200 hover:bg-white/10 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-inset"
          >
            <span class="sr-only">Открыть главное меню</span>
            <Bars3Icon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
            <XMarkIcon v-else class="block h-6 w-6" aria-hidden="true" />
          </DisclosureButton>
        </div>
      </div>
    </div>

    <DisclosurePanel class="md:hidden border-t border-indigo-500">
      <div class="space-y-1 px-2 pt-2 pb-3">
        <DisclosureButton
            v-for="item in navigation"
            :key="item.name"
            as="router-link"
            :to="item.href"
            :class="[
            item.current ? 'bg-white/20 text-white border-l-4 border-white' : 'text-indigo-100 hover:bg-white/10 hover:text-white',
            'block rounded-md px-3 py-2 text-base font-medium flex items-center transition-colors duration-200'
          ]"
        >
          <component :is="item.icon" class="w-5 h-5 mr-3" aria-hidden="true" />
          {{ item.name }}
        </DisclosureButton>
      </div>

      <!-- Мобильное меню для авторизованных/неавторизованных пользователей -->
      <div v-if="!isAuth" class="border-t border-indigo-500 pt-4 pb-3">
        <router-link
            to="/login"
            class="flex items-center justify-center rounded-md bg-white/10 px-3 py-2 text-base font-medium text-white hover:bg-white/20 transition-colors duration-200"
        >
          <UserIcon class="w-5 h-5 mr-3" />
          Войти
        </router-link>
      </div>

      <div v-else class="border-t border-indigo-500 pt-4 pb-3">
        <div class="flex items-center px-5">
          <img class="h-10 w-10 rounded-full border-2 border-white/20" src="/person.jpg" alt="Профиль пользователя" />
          <div class="ml-3">
            <div class="text-base font-medium text-white">{{ profileBar.fio }}</div>
          </div>

          <!-- Мобильная версия кнопки уведомлений -->
          <button
              class="relative ml-auto flex-shrink-0 rounded-full p-1 text-indigo-200 hover:text-white hover:bg-white/10"
              @click="showMobileNotifications = !showMobileNotifications"
          >
            <span class="sr-only">Уведомления</span>
            <BellIcon class="h-6 w-6" aria-hidden="true" />
            <span
                v-if="mobileUnreadCount > 0"
                class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-xs text-white"
            >
              {{ mobileUnreadCount }}
            </span>
          </button>
        </div>

        <!-- Мобильные уведомления -->
        <div v-if="showMobileNotifications" class="mt-3 px-2">
          <div class="bg-white/10 rounded-lg p-3 max-h-64 overflow-y-auto">
            <div class="flex items-center justify-between mb-2">
              <h4 class="text-white font-medium">Уведомления</h4>
              <button
                  v-if="mobileUnreadCount > 0"
                  @click="markAllAsRead"
                  class="text-xs text-white hover:text-indigo-200 font-medium"
                  :disabled="isMarkingAllAsRead"
              >
                <ArrowPathIcon v-if="isMarkingAllAsRead" class="w-3 h-3 animate-spin inline mr-1" />
                <span v-else>Прочитать все</span>
              </button>
            </div>

            <!-- Состояние загрузки -->
            <div v-if="isLoading" class="text-center py-4">
              <ArrowPathIcon class="w-6 h-6 animate-spin mx-auto text-white/50" />
              <p class="text-sm text-white/70 mt-2">Загрузка...</p>
            </div>

            <!-- Уведомления -->
            <div v-else-if="notifications.length > 0">
              <div
                  v-for="notification in notifications "
                  :key="notification.id"
                  :class="[
                  'text-sm text-white p-3 mb-2 rounded transition-colors duration-150'
                ]"
                  @click="markAsRead(notification.id)"
              >
                <div class="flex items-start">
                  <BellIcon class="w-4 h-4 mt-0.5 mr-2 flex-shrink-0" />
                  <div class="flex-1">
                    <p>{{ notification.message }}</p>
                    <p v-if="notification.created_at" class="text-xs text-white/70 mt-1">
                      {{ formatDate(notification.created_at) }}
                    </p>
                    <button
                        v-if="notification.is_read === 1"
                        @click.stop="markAsRead(notification.id)"
                        class="text-xs text-indigo-200 hover:text-white mt-1"
                        :disabled="isMarkingAsRead === notification.id"
                    >
                      <ArrowPathIcon v-if="isMarkingAsRead === notification.id" class="w-3 h-3 animate-spin inline mr-1" />
                      Отметить как прочитанное
                    </button>
                  </div>
                  <div v-if="notification.is_read === 1" class="ml-2">
                    <div class="w-2 h-2 rounded-full bg-indigo-300"></div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Нет уведомлений -->
            <div v-else class="text-center py-4">
              <p class="text-sm text-white/70">У вас нет уведомлений</p>
            </div>
          </div>
        </div>

        <div class="mt-3 space-y-1 px-2">
          <router-link
              :to="profileUrl"
              class="flex items-center rounded-md px-3 py-2 text-base font-medium text-indigo-100 hover:bg-white/10 hover:text-white transition-colors duration-200"
          >
            <UserIcon class="w-5 h-5 mr-3" />
            Профиль
          </router-link>

          <!-- Настройки в мобильном меню -->
          <router-link
              :to="settingsUrl"
              class="flex items-center rounded-md px-3 py-2 text-base font-medium text-indigo-100 hover:bg-white/10 hover:text-white transition-colors duration-200"
          >
            <Cog6ToothIcon class="w-5 h-5 mr-3" />
            Настройки
          </router-link>

          <router-link
              to="/logout"
              class="flex items-center rounded-md px-3 py-2 text-base font-medium text-indigo-100 hover:bg-white/10 hover:text-white transition-colors duration-200"
              @click.prevent="logout"
          >
            <ArrowRightOnRectangleIcon class="w-5 h-5 mr-3" />
            Выход
          </router-link>
        </div>
      </div>
    </DisclosurePanel>
  </Disclosure>

  <!-- Компонент всплывающих уведомлений -->
  <ToastNotification ref="toastNotification" />
</template>

<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { useAuthContextStore } from '@/services/AuthContext.js'
import { computed, ref, onMounted, watch, onUnmounted } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
import Echo from 'laravel-echo'
import Pusher from 'pusher-js'
import { BACKEND_URL } from "@/router.js";
import {
  ScaleIcon, Bars3Icon, XMarkIcon, ChevronDownIcon, UserIcon, BellIcon,
  ArrowRightOnRectangleIcon, ArrowPathIcon, Cog6ToothIcon, ArchiveBoxIcon,  // Добавлен импорт Cog6ToothIcon
  CalculatorIcon, CommandLineIcon, BuildingStorefrontIcon, UserGroupIcon, MapIcon, DocumentIcon,  MagnifyingGlassIcon
} from '@heroicons/vue/24/outline'

// Импортируем компонент всплывающих уведомлений
import ToastNotification from './ToastNotification.vue'

const router = useRouter()
const authStore = useAuthContextStore()

// Реактивные переменные для уведомлений
const notifications = ref([])
const isLoading = ref(false)
const isMarkingAsRead = ref(null)
const isMarkingAllAsRead = ref(false)
const showMobileNotifications = ref(false)

// Ref для компонента всплывающих уведомлений
const toastNotification = ref(null)

// Echo instance для вебсокетов
let echo = null

// Вычисляемые свойства
const isAuth = computed(() => !!authStore.user)
const profileBar = computed(() => ({
  username: authStore.user?.username || '',
  fio: authStore.user?.fio || '',
  role: authStore.user?.role || '',
  icon_link: authStore.user?.icon_link || '',
}))
const profileUrl = computed(() => `/profile/${profileBar.value.username}`)

// URL для настроек (можно изменить на нужный путь)
const settingsUrl = computed(() => `/settings/${profileBar.value.username}`)

const inventoryUrl = computed(() => `/inventory/${profileBar.value.username}`)

const currentUser = computed(() => {
  return authStore.user?.username || ''
})

const unreadCount = computed(() => {
  return notifications.value.filter(n => n.is_read === 1).length
})

const unreadNotifications = computed(() => {
  return notifications.value.filter(n => n.is_read === 1)
})

const mobileUnreadCount = computed(() => unreadCount.value)

const navigation = [
  { name: 'Материальные ценности', href: '/things', current: false, icon: BuildingStorefrontIcon },
  { name: 'Кадры', href: '/staff', current: false, icon: UserGroupIcon },
  { name: 'Отчёты', href: '/reports', current: false, icon: CalculatorIcon },
  { name: 'Интерактивная карта', href: '/map', current: false, icon: MapIcon },
  { name: 'Панель администратора', href: '/admin', current: false, icon: CommandLineIcon },
  { name: 'Поиск', href: '/search', current: false, icon: MagnifyingGlassIcon },
  // { name: 'Файловая система', href: '/files', current: false, icon: DocumentIcon }
]

// Инициализация Echo для вебсокетов с публичным каналом
const initializeEcho = () => {
  if (!currentUser.value) {
    return
  }

  // Если уже есть инстанс, отключаем его
  if (echo) {
    echo.disconnect()
  }

  try {
    // Создаем новый инстанс Echo для публичного канала
    echo = new Echo({
      broadcaster: 'reverb',
      key: import.meta.env.VITE_REVERB_APP_KEY,
      wsHost: import.meta.env.VITE_REVERB_HOST,
      wsPort: import.meta.env.VITE_REVERB_PORT,
      wssPort: import.meta.env.VITE_REVERB_PORT,
      forceTLS: false,
      enabledTransports: ['ws', 'wss'],
      disableStats: true,
    })

    // Подписываемся на ПУБЛИЧНЫЙ канал уведомлений
    const channelName = `Notification.${currentUser.value}`


    // Используем .channel() вместо .private() для публичного канала
    echo.channel(channelName)
        .listen('.Notification', (data) => {

          // Создаем объект уведомления из полученных данных
          const notificationData = {
            id: Date.now(), // Временный ID
            message: data.message,
            is_read: 1,
            created_at: new Date().toISOString()
          }
          notifications.value.unshift(notificationData)
          if (toastNotification.value) {
            toastNotification.value.addToast({
              message: data.message,
              time: new Date().toISOString()
            })
          }
          playNotificationSound()
        })
    // echo.channel(`Notification.${currentUser.value}`)
    //     .listen('.TransferActCreated', (data) => {
    //     })
    // Обработчики событий подключения
    echo.connector.pusher.connection.bind('connected', () => {
    })

    echo.connector.pusher.connection.bind('disconnected', () => {
    })

    echo.connector.pusher.connection.bind('error', (error) => {
    })

  } catch (error) {
  }
}

// Воспроизведение звука уведомления
const playNotificationSound = () => {
  try {
    // Создаем простой звук уведомления
    const audio = new Audio('data:audio/wav;base64,UklGRigAAABXQVZFZm10IBIAAAABAAEAQB8AAEAfAAABAAgAZGF0YQ')

    // Альтернативный метод с использованием Web Audio API
    if (window.AudioContext || window.webkitAudioContext) {
      const audioContext = new (window.AudioContext || window.webkitAudioContext)()
      const oscillator = audioContext.createOscillator()
      const gainNode = audioContext.createGain()

      oscillator.connect(gainNode)
      gainNode.connect(audioContext.destination)

      oscillator.frequency.value = 800
      oscillator.type = 'sine'

      gainNode.gain.setValueAtTime(0.3, audioContext.currentTime)
      gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.3)

      oscillator.start(audioContext.currentTime)
      oscillator.stop(audioContext.currentTime + 0.3)
    } else {
      // Простой beep для старых браузеров
    }
  } catch (e) {
  }
}

// Методы для уведомлений
const fetchNotifications = async () => {
  if (!currentUser.value) return

  try {
    isLoading.value = true
    const response = await axios.get(
        `${BACKEND_URL}/api/notifications/${currentUser.value}`
    )

    if (response.data.success) {
      notifications.value = response.data.data
    }
  } catch (error) {
  } finally {
    isLoading.value = false
  }
}

const markAsRead = async (notificationId) => {
  try {
    isMarkingAsRead.value = notificationId

    await axios.post(
        `${BACKEND_URL}/api/notifications/${notificationId}/read`
    )

    // Обновляем локальное состояние
    const notificationIndex = notifications.value.findIndex(n => n.id === notificationId)
    if (notificationIndex !== -1) {
      notifications.value[notificationIndex].is_read = 2
    }
  } catch (error) {
  } finally {
    isMarkingAsRead.value = null
  }
}

const markAllAsRead = async () => {
  if (!currentUser.value || unreadCount.value === 0) return

  try {
    isMarkingAllAsRead.value = true

    await axios.post(
        `${BACKEND_URL}/api/notifications/${currentUser.value}`
    )

    // Обновляем все уведомления как прочитанные
    notifications.value = notifications.value.map(n => ({
      ...n,
      is_read: 2
    }))
  } catch (error) {
  } finally {
    isMarkingAllAsRead.value = false
  }
}

const formatDate = (dateString) => {
  if (!dateString) return ''
  const date = new Date(dateString)
  return new Intl.DateTimeFormat('ru-RU', {
    day: 'numeric',
    month: 'short',
    hour: '2-digit',
    minute: '2-digit'
  }).format(date)
}

const logout = async () => {
  try {
    // Отключаем вебсокет при выходе
    if (echo) {
      echo.disconnect()
      echo = null
    }

    await authStore.logout()
    router.push('/login')
  } catch (e) {
  }
}

// Хуки жизненного цикла
onMounted(() => {
  if (authStore.user) {
    fetchNotifications()
    // Даем немного времени на загрузку страницы перед инициализацией вебсокета
    setTimeout(() => {
      initializeEcho()
    }, 500)
  }
})

// Следим за изменением пользователя
watch(() => authStore.user, (newUser) => {
  if (newUser) {
    fetchNotifications()
    // Ждем обновления username
    setTimeout(() => {
      initializeEcho()
    }, 100)
  } else {
    // Отключаем вебсокет при выходе
    if (echo) {
      echo.disconnect()
      echo = null
    }
  }
})

// Отключаем вебсокет при размонтировании компонента
onUnmounted(() => {
  if (echo) {
    echo.disconnect()
    echo = null
  }
})
</script>

<style scoped>
/* Прокрутка для уведомлений */
.max-h-96 {
  max-height: 24rem;
}

.max-h-64 {
  max-height: 16rem;
}

/* Стилизация скроллбара */
::-webkit-scrollbar {
  width: 4px;
}

::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 2px;
}

::-webkit-scrollbar-thumb {
  background: #888;
  border-radius: 2px;
}

::-webkit-scrollbar-thumb:hover {
  background: #555;
}

/* Стилизация скроллбара для темного фона */
.bg-white\/10 ::-webkit-scrollbar-track {
  background: rgba(255, 255, 255, 0.1);
}

.bg-white\/10 ::-webkit-scrollbar-thumb {
  background: rgba(255, 255, 255, 0.3);
}

.bg-white\/10 ::-webkit-scrollbar-thumb:hover {
  background: rgba(255, 255, 255, 0.5);
}
</style>