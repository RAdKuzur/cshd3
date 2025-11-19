<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-6">
    <div class="max-w-4xl mx-auto">

      <!-- Заголовок -->
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Настройки профиля</h1>
        <p class="text-gray-600 mt-2">Управление вашей учетной записью и настройками</p>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Боковая панель навигации -->
        <div class="lg:col-span-1">
          <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 sticky top-6">
            <nav class="space-y-2">
              <button
                  v-for="tab in tabs"
                  :key="tab.id"
                  @click="activeTab = tab.id"
                  class="w-full flex items-center px-4 py-3 text-left rounded-lg transition-all duration-200"
                  :class="activeTab === tab.id
                  ? 'bg-indigo-50 text-indigo-700 border border-indigo-200'
                  : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
              >
                <component :is="tab.icon" class="w-5 h-5 mr-3" />
                <span class="font-medium">{{ tab.name }}</span>
              </button>
            </nav>

            <!-- Статистика профиля -->
            <div class="mt-8 pt-6 border-t border-gray-200">
              <div class="text-sm text-gray-500 mb-2">Активность</div>
              <div class="space-y-3">
                <div class="flex justify-between items-center">
                  <span class="text-sm text-gray-600">В системе</span>
                  <span class="text-sm font-medium text-gray-900">2 года 3 мес</span>
                </div>
                <div class="flex justify-between items-center">
                  <span class="text-sm text-gray-600">Последний вход</span>
                  <span class="text-sm font-medium text-gray-900">Сегодня, 10:24</span>
                </div>
                <div class="flex justify-between items-center">
                  <span class="text-sm text-gray-600">Активность</span>
                  <span class="text-sm font-medium text-green-600">Онлайн</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Основной контент -->
        <div class="lg:col-span-2">

          <!-- Основная информация -->
          <div v-if="activeTab === 'profile'" class="space-y-6">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
              <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900">Основная информация</h2>
                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                  Активен
                </span>
              </div>

              <div class="flex items-center space-x-6 mb-8">
                <div class="relative">
                  <img
                      class="h-24 w-24 rounded-full border-4 border-white shadow-lg"
                      src="/person.jpg"
                      alt="Аватар"
                  >
                  <button class="absolute bottom-0 right-0 p-2 bg-indigo-600 text-white rounded-full shadow-lg hover:bg-indigo-700 transition-colors">
                    <CameraIcon class="w-4 h-4" />
                  </button>
                </div>
                <div>
                  <h3 class="text-lg font-semibold text-gray-900">{{ user.name }}</h3>
                  <p class="text-gray-600">{{ user.position }}</p>
                  <p class="text-sm text-gray-500 mt-1">{{ user.department }}</p>
                </div>
              </div>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Имя</label>
                  <input
                      v-model="user.name"
                      type="text"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                  >
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Должность</label>
                  <input
                      v-model="user.position"
                      type="text"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                  >
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                  <input
                      v-model="user.email"
                      type="email"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                  >
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Телефон</label>
                  <input
                      v-model="user.phone"
                      type="tel"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                  >
                </div>
                <div class="md:col-span-2">
                  <label class="block text-sm font-medium text-gray-700 mb-2">О себе</label>
                  <textarea
                      v-model="user.bio"
                      rows="3"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                      placeholder="Расскажите о себе..."
                  ></textarea>
                </div>
              </div>

              <div class="flex justify-end space-x-3 mt-6 pt-6 border-t border-gray-200">
                <button class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                  Отмена
                </button>
                <button
                    @click="saveProfile"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors"
                >
                  Сохранить изменения
                </button>
              </div>
            </div>
          </div>

          <!-- Безопасность -->
          <div v-if="activeTab === 'security'" class="space-y-6">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
              <h2 class="text-xl font-bold text-gray-900 mb-6">Безопасность</h2>

              <div class="space-y-6">
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                  <div>
                    <h3 class="font-semibold text-gray-900">Двухфакторная аутентификация</h3>
                    <p class="text-sm text-gray-600 mt-1">Добавьте дополнительный уровень безопасности</p>
                  </div>
                  <button
                      @click="toggle2FA"
                      class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors text-sm"
                  >
                    {{ user.twoFactorEnabled ? 'Отключить' : 'Включить' }}
                  </button>
                </div>

                <div>
                  <h3 class="font-semibold text-gray-900 mb-4">Смена пароля</h3>
                  <div class="space-y-4">
                    <div>
                      <label class="block text-sm font-medium text-gray-700 mb-2">Текущий пароль</label>
                      <input
                          v-model="password.current"
                          type="password"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                      >
                    </div>
                    <div>
                      <label class="block text-sm font-medium text-gray-700 mb-2">Новый пароль</label>
                      <input
                          v-model="password.new"
                          type="password"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                      >
                    </div>
                    <div>
                      <label class="block text-sm font-medium text-gray-700 mb-2">Подтвердите пароль</label>
                      <input
                          v-model="password.confirm"
                          type="password"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                      >
                    </div>
                  </div>
                  <button
                      @click="changePassword"
                      class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors"
                  >
                    Сменить пароль
                  </button>
                </div>

                <div class="border-t border-gray-200 pt-6">
                  <h3 class="font-semibold text-gray-900 mb-4">Активные сессии</h3>
                  <div class="space-y-3">
                    <div
                        v-for="session in activeSessions"
                        :key="session.id"
                        class="flex items-center justify-between p-3 border border-gray-200 rounded-lg"
                    >
                      <div class="flex items-center space-x-3">
                        <MonitorIcon class="w-5 h-5 text-gray-400" />
                        <div>
                          <div class="font-medium text-gray-900">{{ session.device }}</div>
                          <div class="text-sm text-gray-500">{{ session.location }} • {{ session.lastActive }}</div>
                        </div>
                      </div>
                      <button
                          v-if="!session.current"
                          @click="terminateSession(session.id)"
                          class="text-red-600 hover:text-red-800 text-sm font-medium"
                      >
                        Завершить
                      </button>
                      <span v-else class="text-green-600 text-sm font-medium">Текущая</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Уведомления -->
          <div v-if="activeTab === 'notifications'" class="space-y-6">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
              <h2 class="text-xl font-bold text-gray-900 mb-6">Настройки уведомлений</h2>

              <div class="space-y-6">
                <div>
                  <h3 class="font-semibold text-gray-900 mb-4">Email уведомления</h3>
                  <div class="space-y-3">
                    <div
                        v-for="setting in emailSettings"
                        :key="setting.id"
                        class="flex items-center justify-between p-3 border border-gray-200 rounded-lg"
                    >
                      <div>
                        <div class="font-medium text-gray-900">{{ setting.name }}</div>
                        <div class="text-sm text-gray-500">{{ setting.description }}</div>
                      </div>
                      <button
                          @click="toggleEmailSetting(setting.id)"
                          class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out"
                          :class="setting.enabled ? 'bg-indigo-600' : 'bg-gray-200'"
                          role="switch"
                      >
                        <span
                            aria-hidden="true"
                            class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                            :class="setting.enabled ? 'translate-x-5' : 'translate-x-0'"
                        />
                      </button>
                    </div>
                  </div>
                </div>

                <div class="border-t border-gray-200 pt-6">
                  <h3 class="font-semibold text-gray-900 mb-4">Push уведомления</h3>
                  <div class="space-y-3">
                    <div
                        v-for="setting in pushSettings"
                        :key="setting.id"
                        class="flex items-center justify-between p-3 border border-gray-200 rounded-lg"
                    >
                      <div>
                        <div class="font-medium text-gray-900">{{ setting.name }}</div>
                        <div class="text-sm text-gray-500">{{ setting.description }}</div>
                      </div>
                      <button
                          @click="togglePushSetting(setting.id)"
                          class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out"
                          :class="setting.enabled ? 'bg-indigo-600' : 'bg-gray-200'"
                          role="switch"
                      >
                        <span
                            aria-hidden="true"
                            class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                            :class="setting.enabled ? 'translate-x-5' : 'translate-x-0'"
                        />
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Внешний вид -->
          <div v-if="activeTab === 'appearance'" class="space-y-6">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
              <h2 class="text-xl font-bold text-gray-900 mb-6">Внешний вид</h2>

              <div class="space-y-6">
                <div>
                  <h3 class="font-semibold text-gray-900 mb-4">Тема оформления</h3>
                  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div
                        v-for="theme in themes"
                        :key="theme.id"
                        @click="selectTheme(theme.id)"
                        class="border-2 rounded-lg p-4 cursor-pointer transition-all duration-200"
                        :class="activeTheme === theme.id
                        ? 'border-indigo-500 bg-indigo-50'
                        : 'border-gray-200 hover:border-gray-300'"
                    >
                      <div class="flex items-center space-x-3">
                        <div class="w-6 h-6 rounded-full" :class="theme.color"></div>
                        <div>
                          <div class="font-medium text-gray-900">{{ theme.name }}</div>
                          <div class="text-sm text-gray-500">{{ theme.description }}</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="border-t border-gray-200 pt-6">
                  <h3 class="font-semibold text-gray-900 mb-4">Язык интерфейса</h3>
                  <select
                      v-model="selectedLanguage"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                  >
                    <option value="ru">Русский</option>
                    <option value="en">English</option>
                    <option value="de">Deutsch</option>
                  </select>
                </div>

                <div class="border-t border-gray-200 pt-6">
                  <h3 class="font-semibold text-gray-900 mb-4">Плотность отображения</h3>
                  <div class="space-y-3">
                    <div
                        v-for="density in densities"
                        :key="density.id"
                        @click="selectDensity(density.id)"
                        class="flex items-center justify-between p-3 border-2 rounded-lg cursor-pointer"
                        :class="activeDensity === density.id
                        ? 'border-indigo-500 bg-indigo-50'
                        : 'border-gray-200 hover:border-gray-300'"
                    >
                      <div>
                        <div class="font-medium text-gray-900">{{ density.name }}</div>
                        <div class="text-sm text-gray-500">{{ density.description }}</div>
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
  </div>
</template>

<script setup>
import { ref } from 'vue'

// Иконки
const UserIcon = {
  template: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>`
}

const ShieldCheckIcon = {
  template: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>`
}

const BellIcon = {
  template: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM10.24 8.56a5.97 5.97 0 01-4.66-7.4 5.97 5.97 0 017.4 4.66 5.97 5.97 0 01-2.74 2.74zM12 6.75v.75m0 3v3.75"/></svg>`
}

const PaletteIcon = {
  template: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm8-12h4m-4 4h4m-4 4h4"/></svg>`
}

const CameraIcon = {
  template: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>`
}

const MonitorIcon = {
  template: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>`
}

// Реактивные данные
const activeTab = ref('profile')

// Данные пользователя
const user = ref({
  name: 'Алексей Петров',
  position: 'Senior Developer',
  department: 'IT Отдел',
  email: 'alexey.petrov@company.com',
  phone: '+7 (999) 123-45-67',
  bio: 'Full-stack разработчик с 5-летним опытом. Специализируюсь на Vue.js и Node.js.',
  avatar: '/person.png',
  twoFactorEnabled: true
})

// Настройки безопасности
const password = ref({
  current: '',
  new: '',
  confirm: ''
})

const activeSessions = ref([
  {
    id: 1,
    device: 'Windows PC - Chrome',
    location: 'Москва, Россия',
    lastActive: '2 минуты назад',
    current: true
  },
  {
    id: 2,
    device: 'iPhone 13 - Safari',
    location: 'Москва, Россия',
    lastActive: '5 часов назад',
    current: false
  },
  {
    id: 3,
    device: 'MacBook Pro - Firefox',
    location: 'Санкт-Петербург, Россия',
    lastActive: '2 дня назад',
    current: false
  }
])

// Настройки уведомлений
const emailSettings = ref([
  {
    id: 1,
    name: 'Новые документы',
    description: 'Уведомления о новых входящих документах',
    enabled: true
  },
  {
    id: 2,
    name: 'Напоминания',
    description: 'Напоминания о сроках исполнения',
    enabled: true
  },
  {
    id: 3,
    name: 'Системные уведомления',
    description: 'Важные системные сообщения',
    enabled: false
  }
])

const pushSettings = ref([
  {
    id: 1,
    name: 'Срочные уведомления',
    description: 'Push-уведомления для срочных событий',
    enabled: true
  },
  {
    id: 2,
    name: 'Ежедневный дайджест',
    description: 'Сводка за день',
    enabled: false
  }
])

// Настройки внешнего вида
const activeTheme = ref('light')
const selectedLanguage = ref('ru')
const activeDensity = ref('comfortable')

const themes = ref([
  {
    id: 'light',
    name: 'Светлая',
    description: 'Классическая светлая тема',
    color: 'bg-white border border-gray-300'
  },
  {
    id: 'dark',
    name: 'Темная',
    description: 'Темная тема для работы в ночное время',
    color: 'bg-gray-800'
  },
  {
    id: 'auto',
    name: 'Авто',
    description: 'Автоматически подстраивается под систему',
    color: 'bg-gradient-to-r from-white to-gray-800 border border-gray-300'
  }
])

const densities = ref([
  {
    id: 'compact',
    name: 'Компактная',
    description: 'Больше контента на экране'
  },
  {
    id: 'comfortable',
    name: 'Комфортная',
    description: 'Сбалансированные отступы'
  },
  {
    id: 'spacious',
    name: 'Просторная',
    description: 'Больше воздуха и пространства'
  }
])

// Табы навигации
const tabs = ref([
  { id: 'profile', name: 'Профиль', icon: UserIcon },
  { id: 'security', name: 'Безопасность', icon: ShieldCheckIcon },
  { id: 'notifications', name: 'Уведомления', icon: BellIcon },
  { id: 'appearance', name: 'Внешний вид', icon: PaletteIcon }
])

// Методы
const saveProfile = () => {
  // Логика сохранения профиля
  console.log('Сохранение профиля:', user.value)
}

const toggle2FA = () => {
  user.value.twoFactorEnabled = !user.value.twoFactorEnabled
}

const changePassword = () => {
  // Логика смены пароля
  console.log('Смена пароля:', password.value)
  password.value = { current: '', new: '', confirm: '' }
}

const terminateSession = (sessionId) => {
  activeSessions.value = activeSessions.value.filter(session => session.id !== sessionId)
}

const toggleEmailSetting = (settingId) => {
  const setting = emailSettings.value.find(s => s.id === settingId)
  if (setting) {
    setting.enabled = !setting.enabled
  }
}

const togglePushSetting = (settingId) => {
  const setting = pushSettings.value.find(s => s.id === settingId)
  if (setting) {
    setting.enabled = !setting.enabled
  }
}

const selectTheme = (themeId) => {
  activeTheme.value = themeId
}

const selectDensity = (densityId) => {
  activeDensity.value = densityId
}
</script>

<style scoped>
.sticky {
  position: sticky;
}
</style>