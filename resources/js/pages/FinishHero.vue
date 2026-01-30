<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AppHeaderLayout from '@/layouts/app/AppHeaderLayout.vue'

defineProps<{
  heroCard: {
    id: number
    uuid: string
    name: string | null
    description: string | null
    image_path: string
    points: number | null
    prompt: string
    stats: Record<string, number> | null
  }
}>()
</script>

<template>
  <Head title="Finish Hero" />
  <AppHeaderLayout>
    <div>
      <h3>Finish Hero</h3>
      <img :src="heroCard.image_path" />
    </div>
  </AppHeaderLayout>
</template>
