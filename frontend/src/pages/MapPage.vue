<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-6">
    <div class="max-w-6xl mx-auto">

      <!-- Заголовок -->
      <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">План здания</h1>
        <p class="text-xl text-gray-600">Нажмите на кабинет для просмотра информации</p>
      </div>

      <!-- Основной контейнер -->
      <div class="bg-white rounded-2xl shadow-xl border border-gray-200 p-8">

        <!-- Панель управления: поиск и этажи -->
        <div class="mb-8">
          <!-- Поиск -->
          <div class="mb-6">
            <div class="relative max-w-md mx-auto">
              <input
                  v-model="searchQuery"
                  type="text"
                  placeholder="Поиск комнат..."
                  class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white shadow-sm"
              >
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </div>
            </div>
          </div>

          <!-- Табы этажей -->
          <div class="bg-gradient-to-r from-red-500 to-purple-600 rounded-lg p-1">
            <div class="flex space-x-1">
              <button
                  v-for="floor in floors"
                  :key="floor.id"
                  class="flex-1 px-6 py-3 text-white font-semibold rounded-md transition-all duration-200 relative"
                  :class="{
                  'bg-white text-indigo-600 shadow-lg': activeFloor === floor.id,
                  'text-indigo-100 hover:text-black': activeFloor !== floor.id
                }"
                  @click="setActiveFloor(floor.id)"
              >
                <div class="flex items-center justify-center">
                  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                  </svg>
                  {{ floor.name }}
                </div>
              </button>
            </div>
          </div>
        </div>

        <!-- Карта дома -->
        <div class="bg-gray-100 rounded-lg p-6 mb-8 border-2 border-gray-300">

          <!-- Сообщение при поиске -->
          <div
              v-if="searchQuery && filteredRooms.length === 0"
              class="text-center py-12"
          >
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">Комната не найдена</h3>
            <p class="text-gray-500">Попробуйте изменить запрос поиска</p>
          </div>

          <!-- Сетка комнат -->
          <div
              v-else
              class="grid grid-cols-2 gap-6 h-96 transition-all duration-300"
          >

            <!-- Комната 1 - Гостиная -->
            <div
                v-if="showRoom('living')"
                class="bg-gradient-to-br from-orange-100 to-orange-200 border-2 border-orange-300 rounded-lg cursor-pointer transition-all duration-300 hover:shadow-lg hover:scale-105 hover:border-orange-400 room flex flex-col justify-between"
                :class="{ 'ring-4 ring-orange-400 border-orange-500': selectedRoom === 'living' }"
                @click="selectRoom('living')"
            >
              <div class="p-4">
                <h3 class="font-semibold text-orange-800 text-lg">Гостиная</h3>
                <div class="mt-2 text-sm text-orange-600">
                  <div class="flex items-center mb-1">
                    <div class="w-3 h-3 bg-orange-400 rounded-full mr-2"></div>
                    <span>25 м²</span>
                  </div>
                </div>
              </div>
              <div class="p-4 bg-orange-50 border-t border-orange-200 rounded-b-lg">
                <div class="text-xs text-orange-500">Диван • Телевизор • Кресла</div>
              </div>
            </div>

            <!-- Комната 2 - Кухня -->
            <div
                v-if="showRoom('kitchen')"
                class="bg-gradient-to-br from-green-100 to-green-200 border-2 border-green-300 rounded-lg cursor-pointer transition-all duration-300 hover:shadow-lg hover:scale-105 hover:border-green-400 room flex flex-col justify-between"
                :class="{ 'ring-4 ring-green-400 border-green-500': selectedRoom === 'kitchen' }"
                @click="selectRoom('kitchen')"
            >
              <div class="p-4">
                <h3 class="font-semibold text-green-800 text-lg">Кухня</h3>
                <div class="mt-2 text-sm text-green-600">
                  <div class="flex items-center mb-1">
                    <div class="w-3 h-3 bg-green-400 rounded-full mr-2"></div>
                    <span>18 м²</span>
                  </div>
                </div>
              </div>
              <div class="p-4 bg-green-50 border-t border-green-200 rounded-b-lg">
                <div class="text-xs text-green-500">Холодильник • Плита • Обеденный стол</div>
              </div>
            </div>

            <!-- Комната 3 - Спальня -->
            <div
                v-if="showRoom('bedroom')"
                class="bg-gradient-to-br from-blue-100 to-blue-200 border-2 border-blue-300 rounded-lg cursor-pointer transition-all duration-300 hover:shadow-lg hover:scale-105 hover:border-blue-400 room flex flex-col justify-between"
                :class="{ 'ring-4 ring-blue-400 border-blue-500': selectedRoom === 'bedroom' }"
                @click="selectRoom('bedroom')"
            >
              <div class="p-4">
                <h3 class="font-semibold text-blue-800 text-lg">Спальня</h3>
                <div class="mt-2 text-sm text-blue-600">
                  <div class="flex items-center mb-1">
                    <div class="w-3 h-3 bg-blue-400 rounded-full mr-2"></div>
                    <span>20 м²</span>
                  </div>
                </div>
              </div>
              <div class="p-4 bg-blue-50 border-t border-blue-200 rounded-b-lg">
                <div class="text-xs text-blue-500">Кровать • Гардероб • Тумбы</div>
              </div>
            </div>

            <!-- Комната 4 - Ванная -->
            <div
                v-if="showRoom('bathroom')"
                class="bg-gradient-to-br from-purple-100 to-purple-200 border-2 border-purple-300 rounded-lg cursor-pointer transition-all duration-300 hover:shadow-lg hover:scale-105 hover:border-purple-400 room flex flex-col justify-between"
                :class="{ 'ring-4 ring-purple-400 border-purple-500': selectedRoom === 'bathroom' }"
                @click="selectRoom('bathroom')"
            >
              <div class="p-4">
                <h3 class="font-semibold text-purple-800 text-lg">Ванная</h3>
                <div class="mt-2 text-sm text-purple-600">
                  <div class="flex items-center mb-1">
                    <div class="w-3 h-3 bg-purple-400 rounded-full mr-2"></div>
                    <span>12 м²</span>
                  </div>
                </div>
              </div>
              <div class="p-4 bg-purple-50 border-t border-purple-200 rounded-b-lg">
                <div class="text-xs text-purple-500">Ванна • Душ • Умывальник</div>
              </div>
            </div>

            <!-- Дополнительные комнаты для других этажей -->
            <div
                v-if="showRoom('office')"
                class="bg-gradient-to-br from-red-100 to-red-200 border-2 border-red-300 rounded-lg cursor-pointer transition-all duration-300 hover:shadow-lg hover:scale-105 hover:border-red-400 room flex flex-col justify-between"
                :class="{ 'ring-4 ring-red-400 border-red-500': selectedRoom === 'office' }"
                @click="selectRoom('office')"
            >
              <div class="p-4">
                <h3 class="font-semibold text-red-800 text-lg">Кабинет</h3>
                <div class="mt-2 text-sm text-red-600">
                  <div class="flex items-center mb-1">
                    <div class="w-3 h-3 bg-red-400 rounded-full mr-2"></div>
                    <span>15 м²</span>
                  </div>
                </div>
              </div>
              <div class="p-4 bg-red-50 border-t border-red-200 rounded-b-lg">
                <div class="text-xs text-red-500">Стол • Кресло • Книжные полки</div>
              </div>
            </div>

            <div
                v-if="showRoom('guest')"
                class="bg-gradient-to-br from-yellow-100 to-yellow-200 border-2 border-yellow-300 rounded-lg cursor-pointer transition-all duration-300 hover:shadow-lg hover:scale-105 hover:border-yellow-400 room flex flex-col justify-between"
                :class="{ 'ring-4 ring-yellow-400 border-yellow-500': selectedRoom === 'guest' }"
                @click="selectRoom('guest')"
            >
              <div class="p-4">
                <h3 class="font-semibold text-yellow-800 text-lg">Гостевая</h3>
                <div class="mt-2 text-sm text-yellow-600">
                  <div class="flex items-center mb-1">
                    <div class="w-3 h-3 bg-yellow-400 rounded-full mr-2"></div>
                    <span>16 м²</span>
                  </div>
                </div>
              </div>
              <div class="p-4 bg-yellow-50 border-t border-yellow-200 rounded-b-lg">
                <div class="text-xs text-yellow-500">Кровать • Шкаф • Тумба</div>
              </div>
            </div>

          </div>

          <!-- Легенда коридора -->
          <div v-if="!searchQuery" class="mt-4 text-center">
            <div class="inline-flex items-center px-4 py-2 bg-gray-200 rounded-lg">
              <div class="w-4 h-4 bg-gray-400 rounded mr-2"></div>
              <span class="text-gray-600 text-sm">Коридор и общие зоны</span>
            </div>
          </div>

        </div>

        <!-- Информация о выбранной комнате -->
        <div
            v-if="selectedRoom"
            class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 transition-all duration-300 animate-fade-in"
        >
          <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
              <span
                  class="w-4 h-4 rounded-full mr-3"
                  :class="getRoomColor(selectedRoom)"
              ></span>
              <h2 class="text-2xl font-bold text-gray-900">{{ roomInfo[selectedRoom].name }}</h2>
              <span class="ml-3 px-2 py-1 bg-gray-100 text-gray-600 rounded text-sm">
                {{ getFloorName(roomInfo[selectedRoom].floor) }}
              </span>
            </div>
            <button
                @click="selectedRoom = null"
                class="text-gray-400 hover:text-gray-600 transition-colors p-1 hover:bg-gray-100 rounded"
            >
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>

          <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Основная информация -->
            <div>
              <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Описание</h3>
                <p class="text-gray-600 leading-relaxed">{{ roomInfo[selectedRoom].description }}</p>
              </div>

              <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="bg-gray-50 rounded-lg p-4">
                  <div class="text-sm text-gray-500">Площадь</div>
                  <div class="text-lg font-semibold text-gray-900">{{ roomInfo[selectedRoom].area }}</div>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                  <div class="text-sm text-gray-500">Окна</div>
                  <div class="text-lg font-semibold text-gray-900">{{ roomInfo[selectedRoom].windows }}</div>
                </div>
              </div>
            </div>

            <!-- Мебель и оборудование -->
            <div>
              <h3 class="text-lg font-semibold text-gray-900 mb-3">Мебель и оборудование</h3>
              <div class="space-y-3">
                <div
                    v-for="item in roomInfo[selectedRoom].furniture"
                    :key="item"
                    class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors"
                >
                  <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                  <span class="text-gray-700">{{ item }}</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Дополнительные характеристики -->
          <div class="mt-6 pt-6 border-t border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-3">Характеристики</h3>
            <div class="flex flex-wrap gap-2">
              <span
                  v-for="feature in roomInfo[selectedRoom].features"
                  :key="feature"
                  class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium"
              >
                {{ feature }}
              </span>
            </div>
          </div>
        </div>

        <!-- Подсказка при отсутствии выбора -->
        <div
            v-if="!selectedRoom && !searchQuery"
            class="text-center py-12 bg-gradient-to-br from-gray-50 to-blue-50 rounded-xl border-2 border-dashed border-gray-300"
        >
          <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
          </svg>
          <h3 class="text-xl font-semibold text-gray-600 mb-2">Выберите комнату</h3>
          <p class="text-gray-500">Нажмите на любую комнату на плане для просмотра подробной информации</p>
        </div>

      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const selectedRoom = ref(null)
const searchQuery = ref('')
const activeFloor = ref('first')

// Этажи
const floors = [
  { id: 'first', name: 'Первый этаж' },
  { id: 'second', name: 'Второй этаж' },
  { id: 'basement', name: 'Цокольный этаж' }
]

// Информация о комнатах с указанием этажа
const roomInfo = {
  living: {
    name: 'Гостиная',
    area: '25 м²',
    windows: '2 окна',
    floor: 'first',
    description: 'Просторная гостиная с панорамными окнами, идеально подходит для отдыха и приема гостей. Естественное освещение в течение всего дня.',
    furniture: [
      'Диван 3-местный угловой',
      'Журнальный стол из дерева',
      'Телевизор 55" Smart TV',
      'Книжные полки на стену',
      'Кресло-качалка',
      'Тумба под ТВ с отделениями'
    ],
    features: ['Панорамные окна', 'Кондиционер', 'Паркетный пол', 'Встроенное освещение']
  },
  kitchen: {
    name: 'Кухня',
    area: '18 м²',
    windows: '1 окно',
    floor: 'first',
    description: 'Современная кухня с функциональным островом и барной стойкой. Встроенная техника премиум-класса.',
    furniture: [
      'Кухонный гарнитур с фасадами МДФ',
      'Обеденный стол на 6 персон',
      'Стулья барные (4 шт)',
      'Холодильник Side-by-Side',
      'Духовой шкаф с грилем',
      'Посудомоечная машина'
    ],
    features: ['Кухонный остров', 'Вытяжка', 'Столешница из кварца', 'Встроенная техника']
  },
  bathroom: {
    name: 'Ванная',
    area: '12 м²',
    windows: '1 окно',
    floor: 'first',
    description: 'Просторная ванная комната с душевой кабиной и отдельной ванной. Современная сантехника.',
    furniture: [
      'Душевая кабина с гидромассажем',
      'Акриловая ванна 170см',
      'Умывальник с тумбой и зеркалом',
      'Зеркало с подсветкой и подогревом',
      'Стиральная машина с сушкой'
    ],
    features: ['Подогрев пола', 'Влагостойкие материалы', 'Встроенная подсветка', 'Система вентиляции']
  },
  bedroom: {
    name: 'Спальня',
    area: '20 м²',
    windows: '1 окно',
    floor: 'second',
    description: 'Уютная спальня с гардеробной комнатой. Спокойная цветовая гамма создает расслабляющую атмосферу.',
    furniture: [
      'Двуспальная кровать ортопедическая',
      'Прикроватные тумбы с ящиками',
      'Гардеробная система купе',
      'Туалетный столик с зеркалом',
      'Комод 4-х ящичный'
    ],
    features: ['Гардеробная', 'Кондиционер', 'Ковровое покрытие', 'Прикроватное освещение']
  },
  office: {
    name: 'Кабинет',
    area: '15 м²',
    windows: '1 окно',
    floor: 'second',
    description: 'Рабочий кабинет с книжными полками и комфортным рабочим местом. Идеально для работы и учебы.',
    furniture: [
      'Письменный стол с ящиками',
      'Офисное кресло эргономичное',
      'Книжные полки',
      'Тумба для документов',
      'Настольная лампа'
    ],
    features: ['Встроенные полки', 'Эргономичная мебель', 'Дополнительное освещение', 'Розетки для техники']
  },
  guest: {
    name: 'Гостевая',
    area: '16 м²',
    windows: '1 окно',
    floor: 'second',
    description: 'Уютная гостевая комната для приема гостей. Комфортная мебель и все необходимое для отдыха.',
    furniture: [
      'Двуспальная кровать',
      'Прикроватные тумбы',
      'Шкаф для одежды',
      'Зеркало',
      'Пуфик'
    ],
    features: ['Гостевая зона', 'Комфортная кровать', 'Система хранения', 'Прикроватное освещение']
  }
}

// Комнаты по этажам
const floorRooms = {
  first: ['living', 'kitchen', 'bathroom'],
  second: ['bedroom', 'office', 'guest'],
  basement: [] // можно добавить комнаты для цокольного этажа
}

// Вычисляемые свойства
const filteredRooms = computed(() => {
  if (!searchQuery.value) {
    return floorRooms[activeFloor.value] || []
  }

  const query = searchQuery.value.toLowerCase()
  return Object.keys(roomInfo).filter(roomId =>
      roomInfo[roomId].name.toLowerCase().includes(query) ||
      roomInfo[roomId].description.toLowerCase().includes(query)
  )
})

// Методы
const setActiveFloor = (floorId) => {
  activeFloor.value = floorId
  selectedRoom.value = null
}

const selectRoom = (room) => {
  selectedRoom.value = room
}

const showRoom = (roomId) => {
  if (searchQuery.value) {
    return filteredRooms.value.includes(roomId)
  }
  return floorRooms[activeFloor.value]?.includes(roomId) || false
}

const getRoomColor = (room) => {
  const colors = {
    living: 'bg-orange-500',
    kitchen: 'bg-green-500',
    bedroom: 'bg-blue-500',
    bathroom: 'bg-purple-500',
    office: 'bg-red-500',
    guest: 'bg-yellow-500'
  }
  return colors[room] || 'bg-gray-500'
}

const getFloorName = (floorId) => {
  const floorNames = {
    first: 'Первый этаж',
    second: 'Второй этаж',
    basement: 'Цокольный этаж'
  }
  return floorNames[floorId] || floorId
}
</script>

<style scoped>
.room {
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.animate-fade-in {
  animation: fadeIn 0.5s ease-in-out;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Адаптивность для мобильных устройств */
@media (max-width: 768px) {
  .grid.grid-cols-2 {
    grid-template-columns: 1fr;
    height: auto;
  }

  .h-96 {
    height: auto;
    min-height: 400px;
  }
}
</style>