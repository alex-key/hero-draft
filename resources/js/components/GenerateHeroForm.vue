<script setup lang="ts">
import { Form } from '@inertiajs/vue3'
import InputError from '@/components/InputError.vue'
import { Button } from '@/components/ui/button'
import {
  Card,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'
import { Textarea } from '@/components/ui/textarea'
import { generateHero } from '@/routes'

const { form: generateHeroForm } = generateHero
</script>

<template>
  <Card class="w-full max-w-3xl shadow-xs">
    <CardHeader>
      <CardTitle> Create Hero Card </CardTitle>
      <CardDescription>
        Enter a detailed prompt to generate your Hero Card. We will use one of
        the available APIs of image generation AI. You could check previously
        generated Hero Cards and prompts that where used for it's generation
      </CardDescription>
    </CardHeader>

    <CardContent>
      <div class="generate-hero">
        <Form
          v-bind="generateHeroForm()"
          v-slot="{ errors, processing }"
          class="generate-hero-form"
        >
          <Textarea
            name="prompt"
            placeholder="Enter your prompt here..."
            class="min-h-30"
            maxlength="400"
          />
          <InputError :message="errors.prompt" />
          <div class="flex content-end items-end">
            <Button
              type="submit"
              class="mt-4 bg-cyan-800"
              :disabled="processing"
            >
              {{ processing ? 'Generating...' : 'Generate Hero' }}
            </Button>
          </div>
        </Form>
      </div>
    </CardContent>
  </Card>
</template>
