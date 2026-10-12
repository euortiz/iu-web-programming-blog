<script setup>
import { useAuth } from './composables/useAuth'

const { user } = useAuth()
</script>

<template>
  <div class="min-h-screen text-zinc-200 antialiased">
    <header class="sticky top-0 z-10 border-b border-purple-500/20 bg-[#0b0614]/85 backdrop-blur">
      <nav class="mx-auto flex max-w-6xl items-center justify-between px-6 py-5">
        <RouterLink
          to="/"
          class="bg-gradient-to-r from-purple-400 to-fuchsia-400 bg-clip-text text-xl font-bold tracking-tight text-transparent text-shadow-[0_0_18px_rgba(192,132,252,0.45)]"
        >
          DevLog
        </RouterLink>

        <div class="flex items-center gap-6 text-sm font-medium">
          <RouterLink
            to="/"
            class="text-zinc-400 transition hover:text-fuchsia-300 hover:text-shadow-[0_0_10px_rgba(232,121,249,0.5)]"
          >
            Home
          </RouterLink>
          <RouterLink
            v-if="user"
            to="/admin"
            class="text-zinc-400 transition hover:text-fuchsia-300 hover:text-shadow-[0_0_10px_rgba(232,121,249,0.5)]"
          >
            Dashboard
          </RouterLink>
          <RouterLink
            v-else
            to="/login"
            class="text-zinc-400 transition hover:text-fuchsia-300 hover:text-shadow-[0_0_10px_rgba(232,121,249,0.5)]"
          >
            Admin
          </RouterLink>
        </div>
      </nav>
    </header>

    <RouterView />
  </div>
</template>
