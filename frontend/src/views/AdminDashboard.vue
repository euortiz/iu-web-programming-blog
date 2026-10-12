<script setup>
import { onMounted, reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuth } from '../composables/useAuth'
import { usePosts } from '../composables/usePosts'

const router = useRouter()
const { user, logout } = useAuth()
const { posts, loading, error, fetchPosts, createPost, deletePost } = usePosts()

const form = reactive({
  title: '',
  content: '',
})

const formError = ref('')
const submitting = ref(false)

const submit = async () => {
  submitting.value = true
  formError.value = ''

  try {
    await createPost(form)
    form.title = ''
    form.content = ''
  } catch (exception) {
    formError.value = exception.response?.data?.message || 'Unable to create post.'
  } finally {
    submitting.value = false
  }
}

const remove = async (id) => {
  if (!window.confirm('Delete this post?')) {
    return
  }

  await deletePost(id)
}

const signOut = async () => {
  await logout()
  router.push('/')
}

onMounted(fetchPosts)
</script>

<template>
  <main class="mx-auto max-w-6xl px-6 py-16">
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
      <div>
        <p class="font-mono text-xs uppercase tracking-[0.3em] text-fuchsia-400 text-shadow-[0_0_12px_rgba(232,121,249,0.45)]">
          Dashboard
        </p>
        <h1 class="mt-2 text-4xl font-bold tracking-tight text-zinc-50">
          Manage posts
        </h1>
        <p v-if="user" class="mt-2 text-zinc-400">Signed in as {{ user.name }}</p>
      </div>

      <button
        class="rounded-lg border border-purple-500/40 px-4 py-2 font-medium text-purple-200 transition hover:bg-purple-500/10 hover:shadow-[0_0_20px_rgba(168,85,247,0.25)]"
        @click="signOut"
      >
        Sign out
      </button>
    </div>

    <section class="mt-12 rounded-2xl border border-purple-500/25 bg-[#140d22]/80 p-7">
      <h2 class="text-2xl font-semibold text-zinc-100">Create a post</h2>

      <form class="mt-6 space-y-5" @submit.prevent="submit">
        <input
          v-model="form.title"
          required
          maxlength="255"
          placeholder="Post title"
          class="w-full rounded-lg border border-purple-500/30 bg-[#0d0817] px-4 py-3 text-zinc-200 placeholder-zinc-600 outline-none transition focus:border-fuchsia-400/60 focus:ring-2 focus:ring-fuchsia-500/25"
        >

        <textarea
          v-model="form.content"
          required
          rows="7"
          placeholder="Post content"
          class="w-full rounded-lg border border-purple-500/30 bg-[#0d0817] px-4 py-3 text-zinc-200 placeholder-zinc-600 outline-none transition focus:border-fuchsia-400/60 focus:ring-2 focus:ring-fuchsia-500/25"
        ></textarea>

        <p v-if="formError" class="text-sm text-rose-400">{{ formError }}</p>

        <button
          type="submit"
          :disabled="submitting"
          class="rounded-lg bg-gradient-to-r from-purple-600 to-fuchsia-600 px-5 py-3 font-medium text-white shadow-[0_0_25px_rgba(192,132,252,0.35)] transition hover:brightness-110 hover:shadow-[0_0_35px_rgba(192,132,252,0.55)] disabled:cursor-not-allowed disabled:opacity-50"
        >
          {{ submitting ? 'Publishing...' : 'Publish post' }}
        </button>
      </form>
    </section>

    <section class="mt-12">
      <p v-if="loading" class="font-mono text-zinc-500">Loading posts...</p>
      <p v-else-if="error" class="text-rose-400">{{ error }}</p>

      <div v-else class="overflow-hidden rounded-2xl border border-purple-500/25 bg-[#140d22]/80">
        <table class="min-w-full divide-y divide-purple-500/15">
          <thead class="bg-purple-500/10">
            <tr>
              <th class="px-6 py-4 text-left font-mono text-xs uppercase tracking-widest text-purple-200">
                Title
              </th>
              <th class="px-6 py-4 text-left font-mono text-xs uppercase tracking-widest text-purple-200">
                Published
              </th>
              <th class="px-6 py-4 text-right font-mono text-xs uppercase tracking-widest text-purple-200">
                Action
              </th>
            </tr>
          </thead>

          <tbody class="divide-y divide-purple-500/10">
            <tr v-for="post in posts" :key="post.id" class="transition hover:bg-purple-500/5">
              <td class="px-6 py-4 font-medium text-zinc-100">
                {{ post.title }}
              </td>
              <td class="px-6 py-4 font-mono text-xs text-purple-300/70">
                {{ new Date(post.created_at).toLocaleDateString() }}
              </td>
              <td class="px-6 py-4 text-right">
                <button
                  class="font-medium text-rose-400 transition hover:text-rose-300 hover:text-shadow-[0_0_10px_rgba(251,113,133,0.5)]"
                  @click="remove(post.id)"
                >
                  Delete
                </button>
              </td>
            </tr>

            <tr v-if="!posts.length">
              <td
                colspan="3"
                class="px-6 py-8 text-center text-zinc-500"
              >
                No posts yet.
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>
  </main>
</template>
