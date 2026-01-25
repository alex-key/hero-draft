<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AppHeader from '@/components/AppHeader.vue'

</script>

<template>
  <Head title="Welcome">
    <link rel="preconnect" href="https://rsms.me/" />
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
  </Head>
  <div
    class="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a] w-full"
  >
    <AppHeader />
    <div
      class="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0"
    ></div>
    <div class="hidden h-14.5 lg:block"></div>
  </div>
</template>
