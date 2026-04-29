<!-- components/SearchSelect.vue -->
<template>
  <div class="relative">
    <!-- Кнопка/поле для открытия списка -->
    <div
        @click="toggleDropdown"
        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500 transition-colors cursor-pointer"
        :class="{ 'ring-2 ring-indigo-500': isOpen }"
    >
      <div class="flex items-center justify-between">
        <span :class="{ 'text-gray-500': !selectedOption }">
          {{ selectedOption ? selectedOption[labelField] : placeholder }}
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
        v-if="isOpen"
        class="absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg overflow-hidden"
    >
      <!-- Поле поиска -->
      <div class="p-2 border-b border-gray-200">
        <input
            v-model="searchQuery"
            type="text"
            placeholder="Поиск..."
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
            @click.stop
        />
      </div>

      <!-- Список опций -->
      <div class="max-h-60 overflow-y-auto">
        <div
            v-for="option in filteredOptions"
            :key="option[valueField]"
            @click="selectOption(option)"
            class="px-4 py-2 hover:bg-indigo-50 cursor-pointer transition-colors"
            :class="{ 'bg-indigo-100': selectedOption && selectedOption[valueField] === option[valueField] }"
        >
          {{ option[labelField] }}
        </div>

        <div v-if="filteredOptions.length === 0" class="px-4 py-2 text-gray-500 text-center">
          Ничего не найдено
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import {ref, computed, watch, onMounted, onUnmounted} from 'vue'

const props = defineProps({
  modelValue: [String, Number, Object],
  options: {
    type: Array,
    required: true,
    default: () => []
  },
  valueField: {
    type: String,
    default: 'id'
  },
  labelField: {
    type: String,
    default: 'name'
  },
  placeholder: {
    type: String,
    default: 'Выберите...'
  }
})

const emit = defineEmits(['update:modelValue'])

const isOpen = ref(false)
const searchQuery = ref('')

const selectedOption = computed(() => {
  if (!props.modelValue) return null

  return props.options.find(opt => opt[props.valueField] === props.modelValue)
})

const filteredOptions = computed(() => {
  if (!searchQuery.value) return props.options

  return props.options.filter(option =>
      option[props.labelField].toLowerCase().includes(searchQuery.value.toLowerCase())
  )
})

const toggleDropdown = () => {
  isOpen.value = !isOpen.value
  if (!isOpen.value) {
    searchQuery.value = ''
  }
}

const selectOption = (option) => {
  emit('update:modelValue', option[props.valueField])
  isOpen.value = false
  searchQuery.value = ''
}

// Закрытие при клике вне компонента
const handleClickOutside = (event) => {
  if (!event.target.closest('.relative')) {
    isOpen.value = false
  }
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>