<script setup>
import AppLayout from '@/layouts/AppLayout.vue'
import FormShell from '@/layouts/FormShell.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select } from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';

const props = defineProps({
  statuses: { type: Array, default: () => [] },
})

const form = useForm({
  name: '',
  description: '',
  status: props.statuses[0]?.value ?? '',
  due_date: '',
})

function submit() {
  form.post(route('tasks.store'), {
    preserveScroll: true,
    onSuccess: () => form.reset('name', 'description', 'status', 'due_date'),
  })
}

const breadcrumbs = [{ title: 'Tasks', href: route('tasks.index') }]
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbs">
    <Head title="Nova Task" />

    <FormShell title="Nova Task" description="Crie uma tarefa e defina status e vencimento." max="2xl">
      <div class="flex items-center justify-between -mb-2">
        <div />
        <Link :href="route('tasks.index')" class="text-sky-700 hover:underline">Voltar</Link>
      </div>

      <form @submit.prevent="submit" class="space-y-6">
        <div class="grid gap-2">
          <Label class="name">Nome</label>
        <Input id="name" class="mt-1 block w-full" v-model="form.name" required placeholder="Ex.: Implementar listagem de pedidos" />
          <div v-if="form.errors.name" class="text-sm text-red-600">
            {{ form.errors.name }}
          </div>
        </div>

        <div class="grid gap-2">
          <Label class="status">Status</label>
          <Select
            v-model="form.status"
            class="mt-1 block w-full" >
            <option v-for="s in statuses" :key="s.value" :value="s.value">
              {{ s.label ?? s.value }}
            </option>
          </Select>
          <div v-if="form.errors.status" class="text-sm text-red-600">
            {{ form.errors.status }}
          </div>
        </div>

        <div class="grid gap-2">
          <Label class="vencimento">Vencimento</label>
          <Input
            v-model="form.due_date"
            type="date"
            class="mt-1 block w-full" />
          <div v-if="form.errors.due_date" class="text-sm text-red-600">
            {{ form.errors.due_date }}
          </div>
        </div>

        <div class="grid gap-2">
          <Label class="description">Descrição</label>
          <Textarea
            v-model="form.description"
            rows="6"
            class="mt-1 block w-full"
            placeholder="Detalhes da tarefa..."
          />
          <div v-if="form.errors.description" class="text-sm text-red-600">
            {{ form.errors.description }}
          </div>
        </div>

        <div class="flex items-center gap-3">
          <button
            type="submit"
            :disabled="form.processing"
            class="px-5 py-2.5 rounded-xl bg-sky-600 text-white hover:bg-sky-700 disabled:opacity-50"
          >
            Salvar
          </button>
          <Link :href="route('tasks.index')" class="px-5 py-2.5 rounded-xl border border-gray-300">
            Cancelar
          </Link>
        </div>
      </form>
    </FormShell>
  </AppLayout>
</template>
