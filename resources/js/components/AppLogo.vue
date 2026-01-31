<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import AppLogoIcon from '@/components/AppLogoIcon.vue'
</script>

<template>
  <Link href="/" class="flex items-center justify-center">
    <AppLogoIcon class="size-16" />
    <div class="font-bold text-2xl text-blue-800 w-auto ml-4">HERO DRAFT</div>
  </Link>
</template>
