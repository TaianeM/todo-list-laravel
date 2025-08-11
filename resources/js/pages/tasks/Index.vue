<script setup>
import AppLayout from '@/layouts/AppLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import { computed, ref } from 'vue'
import { Button } from '@/components/ui/button';


const props = defineProps({
  tasks: { type: Array, default: () => [] }
})

const COLS = [
  { key: 'pending',  title: 'To Do',   accent: 'bg-sky-500' },
  { key: 'progress', title: 'Doing',   accent: 'bg-amber-500' },
  { key: 'completed',  title: 'Done',    accent: 'bg-emerald-500' },
]

const itemsByCol = computed(() =>
  COLS.reduce((acc, c) => {
    acc[c.key] = props.tasks.filter(t => t.status === c.key)
    return acc
  }, {})
)

const overCol = ref(null)

function onDragStart(taskId) {
  return (e) => e.dataTransfer.setData('text/plain', String(taskId))
}
function onDragEnter(colKey) { return () => (overCol.value = colKey) }
function onDragLeave() { overCol.value = null }
function onDrop(colKey) {
  return (e) => {
    e.preventDefault()
    const id = Number(e.dataTransfer.getData('text/plain'))
    overCol.value = null
    if (!id) return
    router.patch(route('tasks.move', id), { status: colKey }, { preserveScroll: true })
  }
}
function allowDrop(e){ e.preventDefault() }
</script>

<template>
  <AppLayout>
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-semibold tracking-tight ml-3">Tasks</h1>
      <Button :href="route('tasks.create')" :preserve-state="false" :preserve-scroll="false" replace class="mt-3 mr-3"
       >Nova Task</Button>
    </div>

    <div v-if="!tasks?.length" class="text-gray-600">Sem tasks.</div>

    <div v-else class="grid md:grid-cols-3 gap-4 ml-3 mr-3">
      <section
        v-for="c in COLS"
        :key="c.key"
        class="rounded-2xl border border-gray-200 bg-white/60 backdrop-blur p-3 shadow-sm"
        @dragover="allowDrop"
        @dragenter="onDragEnter(c.key)"
        @dragleave="onDragLeave"
        @drop="onDrop(c.key)"
      >
        <header class="flex items-center justify-between px-2 pb-3">
          <div class="flex items-center gap-2">
            <span :class="['h-2.5 w-2.5 rounded-full', c.accent]"></span>
            <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-700">{{ c.title }}</h2>
          </div>
          <span class="text-xs text-gray-500">{{ itemsByCol[c.key].length }}</span>
        </header>

        <div
          :class="[
            'min-h-[280px] rounded-xl p-2 transition',
            overCol === c.key ? 'ring-2 ring-offset-2 ring-sky-400 bg-sky-50/60' : 'bg-gray-50'
          ]"
        >
          <article
            v-for="t in itemsByCol[c.key]"
            :key="t.id"
            class="group cursor-grab active:cursor-grabbing mb-2 rounded-xl border border-gray-200 bg-white p-3 shadow hover:shadow-md transition"
            draggable="true"
            @dragstart="onDragStart(t.id)"
          >
            <div class="font-medium text-gray-900">{{ t.name }}</div>
            <div class="mt-1 text-xs text-gray-500">
              Status: <span class="font-medium">{{ t.status }}</span>
              <span class="mx-1">•</span>
              Venc.: {{ t.due_date ?? '—' }}
            </div>

            <div class="mt-3 flex gap-3 opacity-0 group-hover:opacity-100 transition">
              <Link :href="route('tasks.show', t.id)" class="text-sky-700 hover:underline text-sm">Ver</Link>
              <Link :href="route('tasks.edit', t.id)" class="text-amber-700 hover:underline text-sm">Editar</Link>
            </div>
          </article>

          <p v-if="!itemsByCol[c.key].length" class="text-xs text-gray-400 text-center py-6 select-none">
            Arraste tarefas para cá
          </p>
        </div>
      </section>
    </div>
  </AppLayout>
</template>
