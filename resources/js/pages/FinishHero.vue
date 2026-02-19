<script setup lang="ts">
import { Badge } from '@/components/ui/badge'
import { Button } from '@/components/ui/button'
import {
  Card,
  CardContent,
  CardFooter,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Textarea } from '@/components/ui/textarea'
import AppHeaderLayout from '@/layouts/app/AppHeaderLayout.vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { Minus, Plus } from 'lucide-vue-next'
import { computed, reactive, ref } from 'vue'

const props = defineProps<{
  heroCard: {
    id: number
    uuid: string
    name: string | null
    description: string | null
    image_path: string
    points: number
    prompt: string
    stats: Record<string, number>
  }
}>()

const name = ref(props.heroCard.name || '')
const description = ref(props.heroCard.description || '')
const skills = reactive<Record<string, number>>({ ...props.heroCard.stats })
const errors = reactive<Record<string, string>>({})
const processing = ref(false)

const usedPoints = computed(() => {
  return Object.values(skills).reduce((sum, val) => sum + val, 0)
})

const remainingPoints = computed(() => {
  return props.heroCard.points - usedPoints.value
})

const incrementSkill = (skill: string) => {
  if (remainingPoints.value > 0) {
    skills[skill]++
  }
}

const decrementSkill = (skill: string) => {
  if (skills[skill] > 1) {
    skills[skill]--
  }
}

const validate = (): boolean => {
  errors.name = ''
  errors.description = ''
  errors.stats = ''

  let isValid = true

  if (!name.value.trim()) {
    errors.name = 'Name is required'
    isValid = false
  }

  if (!description.value.trim()) {
    errors.description = 'Description is required'
    isValid = false
  }

  if (remainingPoints.value !== 0) {
    errors.stats = `You must use all ${props.heroCard.points} skill points`
    isValid = false
  }

  for (const [, value] of Object.entries(skills)) {
    if (value < 1) {
      errors.stats = 'Each skill must have at least 1 point'
      isValid = false
      break
    }
  }

  return isValid
}

const submit = () => {
  if (!validate()) {
    return
  }

  processing.value = true

  router.post(
    '/save-hero',
    {
      name: name.value,
      description: description.value,
      stats: { ...skills },
    },
    {
      onError: (serverErrors) => {
        Object.assign(errors, serverErrors)
      },
      onFinish: () => {
        processing.value = false
      },
    },
  )
}
</script>

<template>
  <Head title="Finish Hero" />
  <AppHeaderLayout>
    <div class="flex w-full items-center justify-center">
      <Card class="mt-10 w-full max-w-4xl shadow-xs">
        <CardHeader class="border-b">
          <CardTitle>Finish Hero Card</CardTitle>
        </CardHeader>

        <CardContent>
          <div class="flex gap-8">
            <div class="w-1/3 shrink-0">
              <img
                :src="heroCard.image_path"
                :alt="heroCard.name || 'Hero preview'"
                class="w-full rounded-lg object-cover object-top"
              />
            </div>

            <div class="w-2/3 space-y-6">
              <div class="space-y-2">
                <Label for="name">Name</Label>
                <Input
                  id="name"
                  v-model="name"
                  placeholder="Enter hero name"
                  :class="{ 'border-red-500': errors.name }"
                />
                <p v-if="errors.name" class="text-sm text-red-500">
                  {{ errors.name }}
                </p>
              </div>

              <div class="space-y-2">
                <Label for="description">Description</Label>
                <Textarea
                  id="description"
                  v-model="description"
                  placeholder="Enter hero description"
                  class="min-h-32"
                  :class="{ 'border-red-500': errors.description }"
                />
                <p v-if="errors.description" class="text-sm text-red-500">
                  {{ errors.description }}
                </p>
              </div>

              <div class="space-y-4">
                <div
                  class="flex items-center justify-between text-sm font-medium"
                >
                  <span class="font">
                    Skill points
                    <Badge class="ml-2 bg-green-600 text-white">{{
                      heroCard.points
                    }}</Badge>
                  </span>
                  <span class="text-gray-500">{{ remainingPoints }} left</span>
                </div>

                <div class="space-y-3">
                  <div
                    v-for="(value, skill) in skills"
                    :key="skill"
                    class="flex items-center justify-between"
                  >
                    <span class="text-sm capitalize">{{ skill }}</span>
                    <div class="flex items-center gap-3">
                      <Button
                        variant="outline"
                        size="icon"
                        class="h-8 w-8"
                        :disabled="value <= 1"
                        @click="decrementSkill(skill as string)"
                      >
                        <Minus class="h-4 w-4" />
                      </Button>
                      <span class="w-8 text-center font-medium">{{
                        value
                      }}</span>
                      <Button
                        variant="outline"
                        size="icon"
                        class="h-8 w-8"
                        :disabled="remainingPoints <= 0"
                        @click="incrementSkill(skill as string)"
                      >
                        <Plus class="h-4 w-4" />
                      </Button>
                    </div>
                  </div>
                </div>

                <p class="text-xs text-muted-foreground italic">
                  The skill with the most points will become your hero's Main
                  attribute.
                </p>
                <p v-if="errors.stats" class="text-sm text-red-500">
                  {{ errors.stats }}
                </p>
              </div>
            </div>
          </div>
        </CardContent>

        <CardFooter class="flex justify-between border-t pt-6">
          <Button size="lg" variant="outline" as-child>
            <Link href="/">Back</Link>
          </Button>
          <Button
            size="lg"
            class="bg-cyan-800"
            :disabled="processing"
            @click="submit"
          >
            {{ processing ? 'Saving...' : 'Save Card' }}
          </Button>
        </CardFooter>
      </Card>
    </div>
  </AppHeaderLayout>
</template>
