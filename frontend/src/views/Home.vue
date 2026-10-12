<script setup>
import { onMounted } from 'vue'
import { usePosts } from '../composables/usePosts'

const { posts, loading, error, fetchPosts } = usePosts()

onMounted(fetchPosts)
</script>

<template>
  <main class="mx-auto max-w-5xl px-6 py-16">
    <section class="mb-14">
      <p class="mb-3 font-mono text-xs uppercase tracking-[0.3em] text-fuchsia-400 text-shadow-[0_0_12px_rgba(232,121,249,0.45)]">
        DevLog
      </p>

      <h1 class="max-w-2xl text-4xl font-bold tracking-tight text-zinc-50 sm:text-5xl">
        Notes from a
        <span class="bg-gradient-to-r from-purple-400 to-fuchsia-400 bg-clip-text text-transparent">
          developer's desk.
        </span>
      </h1>

      <p class="mt-5 max-w-2xl text-lg leading-8 text-zinc-400">
        Practical ideas, experiments, and lessons from building software.
      </p>
    </section>

    <p v-if="loading" class="font-mono text-zinc-500">Loading posts...</p>
    <p v-else-if="error" class="text-rose-400">{{ error }}</p>

    <section v-else class="grid gap-6 md:grid-cols-2">
      <article
        v-for="post in posts"
        :key="post.id"
        class="rounded-2xl border border-purple-500/25 bg-[#140d22]/80 p-7 transition-all duration-300 hover:-translate-y-1 hover:border-purple-400/60 hover:shadow-[0_0_30px_rgba(168,85,247,0.22)]"
      >
        <div class="flex items-center justify-between gap-4 font-mono text-xs text-purple-300/70">
          <span>{{ new Date(post.created_at).toLocaleDateString() }}</span>
          <span>{{ post.comments_count }} comments</span>
        </div>

        <h2 class="mt-3 text-2xl font-semibold text-zinc-100">
          {{ post.title }}
        </h2>

        <p class="mt-4 line-clamp-3 leading-7 text-zinc-400">
          {{ post.content }}
        </p>

        <RouterLink
          :to="{ name: 'post', params: { id: post.id } }"
          class="mt-6 inline-flex font-medium text-fuchsia-400 transition hover:text-fuchsia-300 hover:text-shadow-[0_0_12px_rgba(232,121,249,0.5)]"
        >
          Read article
        </RouterLink>
      </article>
    </section>
  </main>
</template>
