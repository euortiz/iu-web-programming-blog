<script setup>
import { computed, onMounted, reactive, ref } from 'vue'
import { useRoute } from 'vue-router'
import { usePosts } from '../composables/usePosts'
import { useComments } from '../composables/useComments'

const route = useRoute()
const { post, loading, error, fetchPost } = usePosts()
const { addComment } = useComments()

const form = reactive({
  author_name: '',
  content: '',
})

const submitting = ref(false)
const success = ref('')
const commentError = ref('')

const comments = computed(() => post.value?.comments || [])

const submitComment = async () => {
  submitting.value = true
  success.value = ''
  commentError.value = ''

  try {
    const comment = await addComment(route.params.id, form)

    post.value.comments.push(comment)
    form.author_name = ''
    form.content = ''
    success.value = 'Comment added successfully.'
  } catch (exception) {
    commentError.value = exception.response?.data?.message || 'Unable to add comment.'
  } finally {
    submitting.value = false
  }
}

onMounted(() => fetchPost(route.params.id))
</script>

<template>
  <main class="mx-auto max-w-3xl px-6 py-16">
    <p v-if="loading" class="font-mono text-zinc-500">Loading post...</p>
    <p v-else-if="error" class="text-rose-400">{{ error }}</p>

    <template v-else-if="post">
      <article>
        <p class="font-mono text-xs uppercase tracking-[0.25em] text-purple-300/70">
          {{ new Date(post.created_at).toLocaleDateString() }}
        </p>

        <h1 class="mt-4 text-4xl font-bold tracking-tight text-zinc-50">
          {{ post.title }}
        </h1>

        <div class="mt-8 whitespace-pre-line text-lg leading-9 text-zinc-300">
          {{ post.content }}
        </div>
      </article>

      <section class="mt-16 border-t border-purple-500/20 pt-10">
        <h2 class="text-2xl font-semibold text-zinc-100">Comments</h2>

        <div v-if="comments.length" class="mt-6 space-y-5">
          <article
            v-for="comment in comments"
            :key="comment.id"
            class="rounded-xl border border-purple-500/15 bg-[#140d22]/60 p-5"
          >
            <div class="flex items-center justify-between gap-4">
              <strong class="font-mono text-sm text-fuchsia-300">{{ comment.author_name }}</strong>
              <span class="font-mono text-xs text-purple-300/60">
                {{ new Date(comment.created_at).toLocaleDateString() }}
              </span>
            </div>

            <p class="mt-3 whitespace-pre-line leading-7 text-zinc-400">
              {{ comment.content }}
            </p>
          </article>
        </div>

        <p v-else class="mt-6 text-zinc-500">No comments yet.</p>

        <form class="mt-10 space-y-5" @submit.prevent="submitComment">
          <input
            v-model="form.author_name"
            required
            maxlength="100"
            placeholder="Display name"
            class="w-full rounded-lg border border-purple-500/30 bg-[#0d0817] px-4 py-3 text-zinc-200 placeholder-zinc-600 outline-none transition focus:border-fuchsia-400/60 focus:ring-2 focus:ring-fuchsia-500/25"
          >

          <textarea
            v-model="form.content"
            required
            rows="5"
            placeholder="Write a comment..."
            class="w-full rounded-lg border border-purple-500/30 bg-[#0d0817] px-4 py-3 text-zinc-200 placeholder-zinc-600 outline-none transition focus:border-fuchsia-400/60 focus:ring-2 focus:ring-fuchsia-500/25"
          ></textarea>

          <p v-if="success" class="text-sm text-emerald-400">{{ success }}</p>
          <p v-if="commentError" class="text-sm text-rose-400">{{ commentError }}</p>

          <button
            type="submit"
            :disabled="submitting"
            class="rounded-lg bg-gradient-to-r from-purple-600 to-fuchsia-600 px-5 py-3 font-medium text-white shadow-[0_0_25px_rgba(192,132,252,0.35)] transition hover:brightness-110 hover:shadow-[0_0_35px_rgba(192,132,252,0.55)] disabled:cursor-not-allowed disabled:opacity-50"
          >
            {{ submitting ? 'Posting...' : 'Post comment' }}
          </button>
        </form>
      </section>
    </template>
  </main>
</template>
