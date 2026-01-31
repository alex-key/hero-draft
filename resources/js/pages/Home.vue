<script setup lang="ts">
import GenerateHeroForm from '@/components/GenerateHeroForm.vue'
import FinishHeroBanner from '@/components/hero-cards/FinishHeroBanner.vue'
import AppHeaderLayout from '@/layouts/app/AppHeaderLayout.vue'

interface HeroCard {
  id: number
  uuid: string
  name: string | null
  description: string | null
  image_path: string
  points: number | null
  prompt: string
  stats: Record<string, number> | null
}

defineProps<{
  currentHero: HeroCard | null
}>()
</script>

<template>
  <AppHeaderLayout>
    <div
      class="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0"
    >
      <FinishHeroBanner v-if="currentHero" :hero-card="currentHero" />
      <GenerateHeroForm v-else />
    </div>
    <section>
      <span>Generated HeroCards list</span>
    </section>
    <div class="hidden h-14.5 lg:block"></div>
  </AppHeaderLayout>
</template>
