<script setup lang="ts">
import type { HTMLAttributes } from 'vue'
import { cn } from '@/lib/utils'
import { useVModel } from '@vueuse/core'

const props = defineProps<{
  modelValue?: string
  defaultValue?: string
  class?: HTMLAttributes['class']
  rows?: number | string
  invalid?: boolean
}>()

const emit = defineEmits<{
  (e: 'update:modelValue', v: string): void
}>()

const model = useVModel(props, 'modelValue', emit, {
  passive: true,
  defaultValue: props.defaultValue ?? '',
})
</script>

<template>
  <textarea
    v-model="model"
    :rows="rows ?? 6"
    data-slot="textarea"
    :aria-invalid="props.invalid || undefined"
    :class="cn(
      'border-input w-full min-w-0 rounded-md border bg-transparent px-3 py-2 text-base shadow-xs outline-none transition-[color,box-shadow] md:text-sm',
      'focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px]',
      'aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive',
      'placeholder:text-muted-foreground selection:bg-primary selection:text-primary-foreground dark:bg-input/30',
      props.class
    )"
  />
</template>
