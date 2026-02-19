<script setup lang="ts">
import AppLogoIcon from '@/components/AppLogoIcon.vue'
import { Link } from '@inertiajs/vue3'
</script>

<template>
  <Link href="/" class="flex items-center justify-center">
    <AppLogoIcon class="size-16" />
    <div class="ml-4 w-auto text-2xl font-bold text-blue-800">HERO DRAFT</div>
  </Link>
</template>
