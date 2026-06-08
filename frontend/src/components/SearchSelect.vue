<!-- components/SearchSelect.vue -->
<template>
  <div class="relative">
    <!-- Кнопка/поле для открытия списка -->
    <div
        @click="!disabled && toggleDropdown()"
        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500 transition-colors cursor-pointer"
        :class="{
          'ring-2 ring-indigo-500': isOpen && !disabled,
          'bg-gray-100 cursor-not-allowed opacity-60': disabled,
          'bg-white': !disabled
        }"
    >
      <div class="flex items-center justify-between">
        <span :class="{ 'text-gray-500': !selectedOption, 'text-gray-700': selectedOption }">
          {{ selectedOption ? getOptionLabel(selectedOption) : placeholder }}
        </span>
        <svg
            class="w-5 h-5 text-gray-400 transition-transform"
            :class="{ 'transform rotate-180': isOpen }"
            fill="none" stroke="currentColor" viewBox="0 0 24 24"
        >
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
      </div>
    </div>

    <!-- Выпадающий список с поиском -->
    <div
        v-if="isOpen && !disabled"
        class="absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg overflow-hidden"
    >
      <!-- Поле поиска -->
      <div class="p-2 border-b border-gray-200">
        <input
            v-model="searchQuery"
            type="text"
            :placeholder="searchPlaceholder"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
            @click.stop
            @keyup.esc="closeDropdown"
        />
      </div>

      <!-- Список опций -->
      <div class="max-h-60 overflow-y-auto">
        <div
            v-for="option in filteredOptions"
            :key="option[valueField]"
            @click="!isOptionDisabled(option) && selectOption(option)"
            class="px-4 py-2 transition-colors"
            :class="{
              'hover:bg-indigo-50 cursor-pointer': !isOptionDisabled(option),
              'bg-indigo-100': !isOptionDisabled(option) && selectedOption && selectedOption[valueField] === option[valueField],
              'opacity-50 cursor-not-allowed bg-gray-50': isOptionDisabled(option)
            }"
        >
          {{ getOptionLabel(option) }}
        </div>

        <div v-if="filteredOptions.length === 0" class="px-4 py-2 text-gray-500 text-center">
          {{ emptyText }}
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch, onMounted, onUnmounted } from 'vue'

const props = defineProps({
  // Значение для v-model (может быть string, number или object)
  modelValue: [String, Number, Object],

  // Массив опций
  options: {
    type: Array,
    required: true,
    default: () => []
  },

  // Поле для значения опции
  valueField: {
    type: String,
    default: 'id'
  },

  // Поле для отображаемого текста опции
  labelField: {
    type: String,
    default: 'name'
  },

  // Placeholder для основного поля
  placeholder: {
    type: String,
    default: 'Выберите...'
  },

  // Placeholder для поля поиска
  searchPlaceholder: {
    type: String,
    default: 'Поиск...'
  },

  // Текст при отсутствии результатов
  emptyText: {
    type: String,
    default: 'Ничего не найдено'
  },

  // Отключение компонента
  disabled: {
    type: Boolean,
    default: false
  },

  // Массив значений disabled опций
  disabledOptions: {
    type: Array,
    default: () => []
  },

  // Поле для проверки disabled (обычно 'id' или значение из valueField)
  disabledField: {
    type: String,
    default: 'id'
  },

  // Кастомная функция форматирования метки опции
  formatLabel: {
    type: Function,
    default: null
  },

  // Очищать поиск при закрытии
  clearSearchOnClose: {
    type: Boolean,
    default: true
  },

  // Автоматически закрывать после выбора
  closeOnSelect: {
    type: Boolean,
    default: true
  }
})

const emit = defineEmits(['update:modelValue', 'select', 'open', 'close'])

// Состояния
const isOpen = ref(false)
const searchQuery = ref('')

// Выбранная опция
const selectedOption = computed(() => {
  if (!props.modelValue) return null

  // Если modelValue - объект, ищем по значению поля
  if (typeof props.modelValue === 'object') {
    return props.options.find(opt => opt[props.valueField] === props.modelValue[props.valueField])
  }

  // Если modelValue - примитив, ищем по valueField
  return props.options.find(opt => opt[props.valueField] === props.modelValue)
})

// Фильтрованные опции с учетом поиска
const filteredOptions = computed(() => {
  if (!searchQuery.value) return props.options

  const query = searchQuery.value.toLowerCase().trim()
  return props.options.filter(option => {
    const label = getOptionLabel(option).toLowerCase()
    return label.includes(query)
  })
})

// Получение метки опции с учетом кастомного форматирования
const getOptionLabel = (option) => {
  if (props.formatLabel) {
    return props.formatLabel(option)
  }

  // Если есть вложенные поля (например, option.name.inv_number)
  let label = option[props.labelField]

  // Автоматическое добавление инвентарного номера если есть
  if (option.inv_number) {
    label = `${label} (Инв. №${option.inv_number})`
  }

  // Добавление пометки о disabled опции
  if (isOptionDisabled(option)) {
    label += ' (недоступно)'
  }

  return label
}

// Проверка, отключена ли опция
const isOptionDisabled = (option) => {
  if (!props.disabledOptions.length) return false

  const optionValue = option[props.disabledField]
  return props.disabledOptions.includes(optionValue)
}

// Переключение выпадающего списка
const toggleDropdown = () => {
  if (props.disabled) return

  isOpen.value = !isOpen.value
  if (isOpen.value) {
    emit('open')
  } else {
    if (props.clearSearchOnClose) {
      searchQuery.value = ''
    }
    emit('close')
  }
}

// Закрытие выпадающего списка
const closeDropdown = () => {
  isOpen.value = false
  if (props.clearSearchOnClose) {
    searchQuery.value = ''
  }
  emit('close')
}

// Выбор опции
const selectOption = (option) => {
  if (isOptionDisabled(option)) return

  const value = option[props.valueField]
  emit('update:modelValue', value)
  emit('select', option)

  if (props.closeOnSelect) {
    closeDropdown()
  }
}

// Обработчик клика вне компонента
const handleClickOutside = (event) => {
  if (!event.target.closest('.relative')) {
    if (isOpen.value) {
      closeDropdown()
    }
  }
}

// Сброс поиска при открытии/закрытии
watch(isOpen, (newVal) => {
  if (!newVal && props.clearSearchOnClose) {
    searchQuery.value = ''
  }
})

// Синхронизация внешнего изменения modelValue
watch(() => props.modelValue, () => {
  // Можно добавить логику при изменении значения извне
})

// Жизненный цикл
onMounted(() => {
  document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>

<style scoped>
/* Дополнительные стили при необходимости */
.relative {
  position: relative;
}

/* Анимация для плавного появления списка */
.absolute {
  animation: fadeIn 0.15s ease-out;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(-5px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>