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
              <a
                  v-for="item in navigation"
                  :key="item.name"
                  :href="item.href"
                  :class="[
                  item.current
                    ? 'bg-white/20 text-white border-b-2 border-white'
                    : 'text-indigo-100 hover:bg-white/10 hover:text-white transition-colors duration-200',
                  'rounded-md px-3 py-2 text-sm font-medium flex items-center'
                ]"
                  :aria-current="item.current ? 'page' : undefined"
              >
                <component
                    :is="item.icon"
                    class="w-4 h-4 mr-2"
                    aria-hidden="true"
                />
                {{ item.name }}
              </a>
            </div>
          </div>
        </div>

        <!-- Блок для неавторизованных пользователей -->
        <div v-show="isAuth" class="hidden md:block">
          <div class="ml-4 flex items-center md:ml-6 space-x-3">
            <!-- Кнопка входа -->
            <a
                href="/login"
                class="relative flex items-center rounded-md bg-white/10 px-4 py-2 text-sm font-medium text-white hover:bg-white/20 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-600"
            >
              <UserIcon class="w-4 h-4 mr-2" aria-hidden="true" />
              Войти
            </a>
          </div>
        </div>

        <div v-show="!isAuth" class="hidden md:block">
          <div class="ml-4 flex items-center md:ml-6">
            <!-- Кнопка уведомлений -->
            <button class="relative rounded-full p-1 text-indigo-200 hover:text-white hover:bg-white/10 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-white">
              <span class="absolute -inset-1.5"></span>
              <span class="sr-only">Просмотреть уведомления</span>
              <BellIcon class="h-6 w-6" aria-hidden="true" />
              <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-xs text-white">
                3
              </span>
            </button>
            <Menu as="div" class="relative ml-3">
              <MenuButton class="relative flex max-w-xs items-center rounded-full bg-white/10 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-600 hover:bg-white/20 transition-colors duration-200">
                <span class="absolute -inset-1.5"></span>
                <span class="sr-only">Открыть меню пользователя</span>
                <img class="h-8 w-8 rounded-full border-2 border-white/20" src="/person.jpg" alt="Профиль пользователя" />
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
                <MenuItems class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                  <MenuItem v-slot="{ active }">
                    <a
                        :href="profileUrl"
                        :class="[active ? 'bg-gray-100' : '', 'flex items-center px-4 py-2 text-sm text-gray-700']"
                    >
                      <UserIcon class="w-4 h-4 mr-2 text-gray-400" />
                      Профиль
                    </a>
                  </MenuItem>
                  <MenuItem v-slot="{ active }">
                    <a
                        href="/settings"
                        :class="[active ? 'bg-gray-100' : '', 'flex items-center px-4 py-2 text-sm text-gray-700']"
                    >
                      <Cog6ToothIcon class="w-4 h-4 mr-2 text-gray-400" />
                      Настройки
                    </a>
                  </MenuItem>
                  <div class="border-t border-gray-100 my-1"></div>
                  <MenuItem v-slot="{ active }"  @click="logout">
                    <a
                        href="/logout"
                        :class="[active ? 'bg-gray-100' : '', 'flex items-center px-4 py-2 text-sm text-gray-700']"
                    >
                      <ArrowRightOnRectangleIcon class="w-4 h-4 mr-2 text-gray-400" />
                      Выход
                    </a>
                  </MenuItem>
                </MenuItems>
              </transition>
            </Menu>
          </div>
        </div>

        <div class="flex md:hidden">
          <DisclosureButton class="relative inline-flex items-center justify-center rounded-md p-2 text-indigo-200 hover:bg-white/10 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-inset">
            <span class="absolute -inset-0.5"></span>
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
            as="a"
            :href="item.href"
            :class="[
            item.current
              ? 'bg-white/20 text-white border-l-4 border-white'
              : 'text-indigo-100 hover:bg-white/10 hover:text-white',
            'block rounded-md px-3 py-2 text-base font-medium flex items-center transition-colors duration-200'
          ]"
            :aria-current="item.current ? 'page' : undefined"
        >
          <component
              :is="item.icon"
              class="w-5 h-5 mr-3"
              aria-hidden="true"
          />
          {{ item.name }}
        </DisclosureButton>
      </div>

      <!-- Мобильное меню для неавторизованных пользователей -->
      <div v-if="isAuth" class="border-t border-indigo-500 pt-4 pb-3">
        <div class="space-y-2 px-2">
          <DisclosureButton
              as="a"
              href="/login"
              class="flex items-center justify-center rounded-md bg-white/10 px-3 py-2 text-base font-medium text-white hover:bg-white/20 transition-colors duration-200"
          >
            <UserIcon class="w-5 h-5 mr-3" />
            Войти
          </DisclosureButton>
          <DisclosureButton
              as="a"
              href="/register"
              class="flex items-center justify-center rounded-md bg-white px-3 py-2 text-base font-medium text-indigo-600 hover:bg-gray-100 transition-colors duration-200"
          >
            <UserPlusIcon class="w-5 h-5 mr-3" />
            Регистрация
          </DisclosureButton>
        </div>
      </div>

      <!-- Мобильное меню для авторизованных пользователей (ваш исходный код) -->
      <div v-else class="border-t border-indigo-500 pt-4 pb-3">
        <div class="flex items-center px-5">
          <div class="flex-shrink-0">
            <img class="h-10 w-10 rounded-full border-2 border-white/20" src="/person.jpg" alt="Профиль пользователя" />
          </div>
          <div class="ml-3">
            <div class="text-base font-medium text-white">{{ profileBar.fio }}</div>
            <div class="text-sm font-medium text-indigo-200"></div>
          </div>
          <button class="relative ml-auto flex-shrink-0 rounded-full p-1 text-indigo-200 hover:text-white hover:bg-white/10">
            <span class="absolute -inset-1.5"></span>
            <span class="sr-only">Уведомления</span>
            <BellIcon class="h-6 w-6" aria-hidden="true" />
            <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-xs text-white">
              3
            </span>
          </button>
        </div>
        <div class="mt-3 space-y-1 px-2">
          <DisclosureButton
              as="a"
              href="/profile"
              class="flex items-center rounded-md px-3 py-2 text-base font-medium text-indigo-100 hover:bg-white/10 hover:text-white transition-colors duration-200"
          >
            <UserIcon class="w-5 h-5 mr-3" />
            Профиль
          </DisclosureButton>
          <DisclosureButton
              as="a"
              href="/settings"
              class="flex items-center rounded-md px-3 py-2 text-base font-medium text-indigo-100 hover:bg-white/10 hover:text-white transition-colors duration-200"
          >
            <Cog6ToothIcon class="w-5 h-5 mr-3" />
            Настройки
          </DisclosureButton>
          <DisclosureButton
              as="a"
              href="/logout"
              class="flex items-center rounded-md px-3 py-2 text-base font-medium text-indigo-100 hover:bg-white/10 hover:text-white transition-colors duration-200"
          >
            <ArrowRightOnRectangleIcon class="w-5 h-5 mr-3" />
            Выход
          </DisclosureButton>
        </div>
      </div>
    </DisclosurePanel>
  </Disclosure>
</template>

<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import {
  Bars3Icon,
  BellIcon,
  XMarkIcon,
  ChevronDownIcon,
  UserIcon,
  Cog6ToothIcon,
  ArrowRightOnRectangleIcon,
  UserPlusIcon // Добавлена новая иконка
} from '@heroicons/vue/24/outline'
import {
  BuildingStorefrontIcon,
  UserGroupIcon,
  DocumentTextIcon,
  MapIcon
} from '@heroicons/vue/24/outline'
import {ScaleIcon} from "@heroicons/vue/24/outline/index.js";
import AuthService from "@/services/AuthService.js";
import {computed, onMounted, ref} from "vue";

async function logout() {
  try {
    await AuthService.logout();
  } catch (e) {
    console.log('Ошибка выхода')
  }
}
const profileBar = ref({
  username: '',
  fio: ''
})
const isAuth = computed(() => {
  return !profileBar.value.fio;
})
const profileUrl = computed(() => {
  return `/profile/${profileBar.value.username}`
})
onMounted(() => {
  profileBar.value.fio = localStorage.getItem('fio')
  profileBar.value.username = localStorage.getItem('username')
})

const createStorageEvent = (key, newValue) => {
  window.dispatchEvent(new CustomEvent('localStorageChange', {
    detail: { key, newValue }
  }))
}

const originalSetItem = localStorage.setItem
localStorage.setItem = function(key, value) {
  originalSetItem.call(this, key, value)
  createStorageEvent(key, value)
}

const originalRemoveItem = localStorage.removeItem
localStorage.removeItem = function(key) {
  originalRemoveItem.call(this, key)
  createStorageEvent(key, null)
}

window.addEventListener('localStorageChange', (event) => {
  const { key, newValue } = event.detail
  if (key === 'fio' || key === 'username') {
    profileBar.value[key] = newValue
  }
})

const navigation = [
  {
    name: 'Основные средства',
    href: '/objects',
    current: false,
    icon: BuildingStorefrontIcon
  },
  {
    name: 'Кадры',
    href: '/stuff',
    current: false,
    icon: UserGroupIcon
  },
  {
    name: 'Документооборот',
    href: '/docs',
    current: false,
    icon: DocumentTextIcon
  },
  {
    name: 'Интерактивная карта',
    href: '/map',
    current: false,
    icon: MapIcon
  },
]
</script>

<style scoped>

</style>