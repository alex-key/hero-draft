<script setup lang="ts">
import { computed } from 'vue'

export interface HeroCardItem {
  id: number
  uuid: string
  name: string | null
  description: string | null
  stats: Record<string, number>
  points: number
  image_path: string
  prompt: string
}

const props = defineProps<{
  card: HeroCardItem
}>()

const mainSkill = {
  name: Object.keys(props.card.stats)[0],
  value: Object.values(props.card.stats)[0],
}
const skills = computed(() => {
  const statsCopy = { ...props.card.stats }
  delete statsCopy[mainSkill.name]
  return statsCopy
})
</script>

<template>
  <div class="hero-card relative aspect-[9/16] overflow-hidden rounded-xl">
    <img
      :src="card.image_path"
      :alt="card.name || 'Unnamed Hero'"
      class="absolute inset-0 h-full w-full object-cover object-top"
    />
    <img
      src="/img/card-elements/card-frame-common.png"
      class="absolute inset-0 h-full w-full object-cover object-top"
    />

    <div
      class="absolute inset-0 bg-gradient-to-b from-black/60 via-transparent to-black/80"
    />

    <div class="absolute inset-x-0 top-0 p-4 pt-5 text-center">
      <h3 class="text-xl font-bold text-white drop-shadow-lg">
        {{ card.name || 'Unnamed Hero' }}
      </h3>
    </div>

    <div
      v-if="card.stats"
      class="main-skill text-md absolute inset-x-0 flex w-full justify-center text-center text-white/90 drop-shadow"
    >
      <span class="capitalize">{{ mainSkill.name }}</span>
      <span class="ml-2 font-bold">{{ mainSkill.value }}</span>
    </div>
    <div
      v-if="card.stats"
      class="skills absolute inset-x-0 flex w-full justify-center text-center text-sm text-white/90 drop-shadow"
    >
      <div
        v-for="(value, skill) in skills"
        :key="skill"
        class="px-2 py-1 text-xs text-white"
      >
        <span class="capitalize">{{ skill }}</span>
        <span class="ml-1 font-bold">{{ value }}</span>
      </div>
    </div>

    <div class="description absolute inset-x-0 bottom-0 flex flex-col gap-2 px-4">
      <p
        v-if="card.description"
        class="line-clamp-3 text-center text-sm text-gray-400 drop-shadow"
      >
        {{ card.description }}
      </p>
    </div>
  </div>
</template>

<style scoped>
.main-skill {
  top: 66%;
  left: 0;
}

.skills {
  top: 73%;
  bottom: 0;
}

.description {
  min-height: 19%;
}
</style>
