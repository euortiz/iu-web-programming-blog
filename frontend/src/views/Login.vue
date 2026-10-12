<script setup>
import { reactive, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useAuth } from '../composables/useAuth'

const router = useRouter()
const route = useRoute()
const { login } = useAuth()

const form = reactive({
  email: '',
  password: '',
})

const error = ref('')
const submitting = ref(false)

const submit = async () => {
  submitting.value = true
  error.value = ''

  try {
    await login(form)
    router.push(route.query.redirect || '/admin')
  } catch (exception) {
    error.value = exception.response?.data?.message || 'Invalid credentials.'
  } finally {
    submitting.value = false
  }
}
</script>

<template>
  <main class="mx-auto max-w-md px-6 py-20">
    <div class="rounded-2xl border border-purple-500/30 bg-[#140d22]/80 p-8 shadow-[0_0_40px_rgba(168,85,247,0.15)]">
      <h1 class="text-3xl font-bold text-zinc-50">Admin access</h1>
      <p class="mt-2 text-zinc-400">Sign in to manage DevLog content.</p>

      <form class="mt-8 space-y-5" @submit.prevent="submit">
        <input
          v-model="form.email"
          type="email"
          required
          placeholder="Email"
          class="w-full rounded-lg border border-purple-500/30 bg-[#0d0817] px-4 py-3 text-zinc-200 placeholder-zinc-600 outline-none transition focus:border-fuchsia-400/60 focus:ring-2 focus:ring-fuchsia-500/25"
        >

        <input
          v-model="form.password"
          type="password"
          required
          placeholder="Password"
          class="w-full rounded-lg border border-purple-500/30 bg-[#0d0817] px-4 py-3 text-zinc-200 placeholder-zinc-600 outline-none transition focus:border-fuchsia-400/60 focus:ring-2 focus:ring-fuchsia-500/25"
        >

        <p v-if="error" class="text-sm text-rose-400">{{ error }}</p>

        <button
          type="submit"
          :disabled="submitting"
          class="w-full rounded-lg bg-gradient-to-r from-purple-600 to-fuchsia-600 px-5 py-3 font-medium text-white shadow-[0_0_25px_rgba(192,132,252,0.35)] transition hover:brightness-110 hover:shadow-[0_0_35px_rgba(192,132,252,0.55)] disabled:cursor-not-allowed disabled:opacity-50"
        >
          {{ submitting ? 'Signing in...' : 'Sign in' }}
        </button>
      </form>
    </div>
  </main>
</template>
