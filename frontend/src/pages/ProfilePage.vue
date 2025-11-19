<script setup>

</script>

<template>
  <div class="bg-gray-100">
    <div class="container mx-auto py-10">
      <div class="grid grid-cols-4 sm:grid-cols-12 gap-6 px-4">
        <div class="col-span-4 sm:col-span-3">
          <div class="bg-white shadow rounded-lg p-6">
            <div class="flex flex-col items-center">
              <img src="/person.jpg" class="w-32 h-32 bg-gray-300 rounded-full mb-4 shrink-0">
              <h1 class="text-xl font-bold">Имя Фамилия</h1>
              <p class="text-gray-700">Должность</p>
              <div class="mt-6 flex flex-wrap gap-4 justify-center">
                <a href="#" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">Связаться по почте</a>
              </div>
            </div>
            <hr class="my-6 border-t border-gray-300">
            <div class="flex flex-col">
              <span class="text-gray-700 uppercase font-bold tracking-wider mb-2">Контакты</span>
              <ul>
                <li class="mb-2">Почта</li>
                <li class="mb-2">Телефон</li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-span-4 sm:col-span-9">
          <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-bold mb-4">О себе</h2>
            <p class="text-gray-700">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed finibus est
              vitae tortor ullamcorper, ut vestibulum velit convallis. Aenean posuere risus non velit egestas
              suscipit. Nunc finibus vel ante id euismod. Vestibulum ante ipsum primis in faucibus orci luctus
              et ultrices posuere cubilia Curae; Aliquam erat volutpat. Nulla vulputate pharetra tellus, in
              luctus risus rhoncus id.
            </p>
            <h2 class="text-xl font-bold mt-6 mb-4">Опыт работы</h2>
            <div class="mb-6">
              <div class="flex justify-between flex-wrap gap-2 w-full">
                <span class="text-gray-700 font-bold">Web Developer</span>
                <p>
                  <span class="text-gray-700 mr-2">at ABC Company</span>
                  <span class="text-gray-700">2017 - 2019</span>
                </p>
              </div>
              <p class="mt-2">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed finibus est vitae
                tortor ullamcorper, ut vestibulum velit convallis. Aenean posuere risus non velit egestas
                suscipit.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>