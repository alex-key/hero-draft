<script setup lang="ts">
import GenerateHeroForm from '@/components/GenerateHeroForm.vue'
import AppHeaderLayout from '@/layouts/app/AppHeaderLayout.vue'
</script>

<template>
  <AppHeaderLayout>
    <div
      class="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0"
    >
      <GenerateHeroForm />
    </div>
    <section>
      <span>Generated HeroCards list</span>
    </section>
    <div class="hidden h-14.5 lg:block"></div>
  </AppHeaderLayout>
</template>
