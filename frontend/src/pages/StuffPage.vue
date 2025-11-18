<template>
  <div class="w-5/7 mt-10 max-w-x mx-auto">

    <div class="bg-blue-500 p-2 rounded-t-lg">
      <div class="flex justify-center space-x-4">
        <button
            class="px-4 py-2 text-white font-semibold border-b-4 border-blue-700 hover:bg-blue-700 focus:outline-none tab-button"
            :class="{ 'active': activeTab === 'tab1' }"
            @click="setActiveTab('tab1')"
        >
          Отдел 1
        </button>
        <button
            class="px-4 py-2 text-white font-semibold border-b-4 border-blue-700 hover:bg-blue-700 focus:outline-none tab-button"
            :class="{ 'active': activeTab === 'tab2' }"
            @click="setActiveTab('tab2')"
        >
          Отдел 2
        </button>
        <button
            class="px-4 py-2 text-white font-semibold border-b-4 border-blue-700 hover:bg-blue-700 focus:outline-none tab-button"
            :class="{ 'active': activeTab === 'tab3' }"
            @click="setActiveTab('tab3')"
        >
          Отдел 3
        </button>
      </div>
    </div>

    <div
        id="tab1"
        class="p-4 tab-content bg-white shadow-md rounded-lg"
        v-show="activeTab === 'tab1'"
    >
      <h2 class="text-2xl font-semibold mb-2 text-blue-700">Сотрудники отдела 1</h2>
        <div class="m-6"><Record></Record></div>
        <div class="m-6"> <Record></Record></div>
        <div class="m-6"><Record></Record></div>
    </div>

    <div
        id="tab2"
        class="p-4 tab-content bg-white shadow-md rounded-lg"
        v-show="activeTab === 'tab2'"
    >
      <h2 class="text-2xl font-semibold mb-2 text-blue-700">Сотрудники отдела 2</h2>
      <div class="m-4"><Record></Record></div>
      <div class="m-4"> <Record></Record></div>
      <div class="m-4"><Record></Record></div>
    </div>

    <div
        id="tab3"
        class="p-4 tab-content bg-white shadow-md rounded-lg"
        v-show="activeTab === 'tab3'"
    >
      <h2 class="text-2xl font-semibold mb-2 text-blue-700">Сотрудники отдела 3</h2>
      <div class="m-4"><Record></Record></div>
      <div class="m-4"> <Record></Record></div>
      <div class="m-4"><Record></Record></div>
    </div>
  </div>
</template>

<script setup>
  import { ref, onMounted } from 'vue'
  import Record from "@/components/layouts/Record.vue";

  const activeTab = ref('tab1')

  const setActiveTab = (tabId) => {
    activeTab.value = tabId
  }
  onMounted(() => {
    setActiveTab('tab1')
  })
</script>

<style scoped>
.tab-button.active {
  background-color: rgb(29 78 216);
  border-color: rgb(30 64 175);
}

.tab-content {
  transition: opacity 0.3s ease;
}
</style>