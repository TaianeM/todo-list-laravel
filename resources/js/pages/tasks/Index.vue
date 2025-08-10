<script setup>
import AppLayout from '@/layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'
defineProps({ tasks: Array })
</script>

<template>
  <AppLayout>
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-semibold">Tasks</h1>
      <Link :href="route('tasks.create')" class="px-3 py-2 bg-blue-600 text-white rounded">Nova Task</Link>
    </div>

    <div v-if="!tasks?.length">Sem tasks.</div>

    <ul v-else class="space-y-2">
      <li v-for="t in tasks" :key="t.id" class="border p-3 rounded">
        <div class="font-medium">{{ t.name }}</div>
        <div class="text-sm text-gray-600">Status: {{ t.status }} | Venc.: {{ t.due_date ?? '—' }}</div>
        <div class="mt-2 flex gap-2">
          <Link :href="route('tasks.show', t.id)" class="text-blue-600">Ver</Link>
          <Link :href="route('tasks.edit', t.id)" class="text-amber-600">Editar</Link>
        </div>
      </li>
    </ul>
  </AppLayout>
</template>
