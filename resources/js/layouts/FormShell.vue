<script setup lang="ts">
import Heading from '@/components/Heading.vue'

interface Props {
  title: string
  description?: string
  max?: 'xl' | '2xl' | '3xl'
}
const props = withDefaults(defineProps<Props>(), {
  description: '',
  max: 'xl',
})

const maxMap = {
  xl: 'max-w-xl',
  '2xl': 'max-w-2xl',
  '3xl': 'max-w-3xl',
} as const
</script>

<template>
  <div class="px-4 py-6">
    <Heading :title="title" :description="description" />

    <div class="mt-6">
      <section :class="[maxMap[max], 'space-y-12']">
        <slot />
      </section>
    </div>
  </div>
</template>
