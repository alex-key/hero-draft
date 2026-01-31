<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue'
import type { BreadcrumbItem } from '@/types'

type Props = {
  breadcrumbs?: BreadcrumbItem[]
}

withDefaults(defineProps<Props>(), {
  breadcrumbs: () => [],
})
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbs" class="bg-gray-200">
    <slot />
  </AppLayout>
</template>
