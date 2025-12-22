<template>
  <Disclosure as="nav" class="bg-gradient-to-r from-indigo-600 to-purple-600 shadow-lg" v-slot="{ open }">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="flex h-16 items-center justify-between">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <ScaleIcon class="w-7 h-7 text-white" />
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
            <!-- Кнопка уведомлений -->
            <button
                class="relative rounded-full p-1 text-indigo-200 hover:text-white hover:bg-white/10 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-white"
            >
              <span class="sr-only">Просмотреть уведомления</span>
              <BellIcon class="h-6 w-6" aria-hidden="true" />
              <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-xs text-white">
                3
              </span>
            </button>

            <!-- Профиль -->
            <Menu as="div" class="relative ml-3">
              <MenuButton
                  class="relative flex max-w-xs items-center rounded-full bg-white/10 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-600 hover:bg-white/20 transition-colors duration-200"
              >
                <span class="sr-only">Открыть меню пользователя</span>
                <img
                    class="h-8 w-8 rounded-full border-2 border-white/20"
                    src="/person.jpg"
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
            <div class="text-sm font-medium text-indigo-200">{{ profileBar.position }}</div>
          </div>
          <button class="relative ml-auto flex-shrink-0 rounded-full p-1 text-indigo-200 hover:text-white hover:bg-white/10">
            <span class="sr-only">Уведомления</span>
            <BellIcon class="h-6 w-6" aria-hidden="true" />
            <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-xs text-white">3</span>
          </button>
        </div>

        <div class="mt-3 space-y-1 px-2">
          <router-link
              :to="profileUrl"
              class="flex items-center rounded-md px-3 py-2 text-base font-medium text-indigo-100 hover:bg-white/10 hover:text-white transition-colors duration-200"
          >
            <UserIcon class="w-5 h-5 mr-3" />
            Профиль
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
</template>

<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { useAuthContextStore } from '@/services/AuthContext.js'
import { computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import {
  ScaleIcon, Bars3Icon, XMarkIcon, ChevronDownIcon, UserIcon, Cog6ToothIcon, UserPlusIcon, BellIcon, ArrowRightOnRectangleIcon,
  CalculatorIcon, CommandLineIcon, BuildingStorefrontIcon, UserGroupIcon, MapIcon
} from '@heroicons/vue/24/outline'

const router = useRouter()
const authStore = useAuthContextStore()

const isAuth = computed(() => !!authStore.user)
const profileBar = computed(() => ({
  username: authStore.user?.username || '',
  fio: authStore.user?.fio || '',
  role: authStore.user?.role || '',
  position: authStore.user?.position || ''
}))
const profileUrl = computed(() => `/profile/${profileBar.value.username}`)

const logout = async () => {
  try {
    await authStore.logout()
    router.push('/login')
  } catch (e) {
    console.error('Ошибка выхода', e)
  }
}

const navigation = [
  { name: 'Материальные ценности', href: '/things', current: false, icon: BuildingStorefrontIcon },
  { name: 'Кадры', href: '/stuff', current: false, icon: UserGroupIcon },
  { name: 'Отчёты', href: '/reports', current: false, icon: CalculatorIcon },
  { name: 'Интерактивная карта', href: '/map', current: false, icon: MapIcon },
  { name: 'Панель администратора', href: '/admin', current: false, icon: CommandLineIcon },
]

onMounted(async () => {
  if (!authStore.initialized) {
    try {
      await authStore.refresh()
    } catch (e) {
      console.error('Ошибка при инициализации Navbar authStore:', e)
    }
  }
})
</script>

<style scoped>
/* можно оставить пустым или добавить свои стили */
</style>
