<script setup lang="ts">
import { Button } from '@/components/ui/button'
import {
  Card,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'
import { Link } from '@inertiajs/vue3'

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
  heroCard: HeroCard
}>()
</script>

<template>
  <Card class="w-full max-w-3xl shadow-xs">
    <CardHeader class="border-b">
      <CardTitle>Continue Your Hero</CardTitle>
      <CardDescription>
        You have an unfinished Hero Card waiting for you
      </CardDescription>
    </CardHeader>

    <CardContent>
      <div class="flex items-center gap-6">
        <div class="shrink-0">
          <img
            :src="heroCard.image_path"
            :alt="heroCard.name || 'Hero preview'"
            class="h-32 w-32 rounded-lg object-cover object-top"
          />
        </div>

        <div class="flex-1">
          <p class="text-muted-foreground">
            Your hero image has been generated and is ready to be completed. Add
            a name, stats, and finish creating your unique hero card.
          </p>
        </div>

        <div class="shrink-0">
          <Button as-child class="bg-cyan-800">
            <Link href="/finish-hero">Finish Card</Link>
          </Button>
        </div>
      </div>
    </CardContent>
  </Card>
</template>
