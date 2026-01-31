<script setup lang="ts">
import { ChevronDown } from 'lucide-vue-next'
import type { HeroCardItem } from '@/components/hero-cards/HeroCard.vue';
import HeroCard from '@/components/hero-cards/HeroCard.vue'
import { Card } from '@/components/ui/card'
import {
  Collapsible,
  CollapsibleContent,
  CollapsibleTrigger,
} from '@/components/ui/collapsible'

defineProps<{
  cards: HeroCardItem[]
}>()
</script>

<template>
  <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
    <Card v-for="card in cards" :key="card.id" class="overflow-hidden p-0">
      <HeroCard :card="card" />
      <Collapsible class="px-4 pb-4">
        <CollapsibleTrigger
          class="flex w-full items-center justify-between py-2 text-sm text-muted-foreground hover:text-foreground"
        >
          <span>Show prompt</span>
          <ChevronDown class="h-4 w-4 transition-transform [[data-state=open]_&]:rotate-180" />
        </CollapsibleTrigger>
        <CollapsibleContent>
          <p class="text-sm text-muted-foreground">{{ card.prompt }}</p>
        </CollapsibleContent>
      </Collapsible>
    </Card>
  </div>
</template>
