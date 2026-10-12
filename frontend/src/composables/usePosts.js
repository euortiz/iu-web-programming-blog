import { ref } from 'vue'
import api from '../services/api'

export function usePosts() {
  const posts = ref([])
  const post = ref(null)
  const loading = ref(false)
  const error = ref(null)

  const fetchPosts = async () => {
    loading.value = true
    error.value = null

    try {
      const { data } = await api.get('/posts')
      posts.value = data
    } catch (exception) {
      error.value = exception.response?.data?.message || 'Unable to load posts.'
    } finally {
      loading.value = false
    }
  }

  const fetchPost = async (id) => {
    loading.value = true
    error.value = null

    try {
      const { data } = await api.get(`/posts/${id}`)
      post.value = data
    } catch (exception) {
      error.value = exception.response?.data?.message || 'Unable to load post.'
    } finally {
      loading.value = false
    }
  }

  const createPost = async (payload) => {
    const { data } = await api.post('/posts', payload)
    posts.value.unshift(data)

    return data
  }

  const updatePost = async (id, payload) => {
    const { data } = await api.put(`/posts/${id}`, payload)
    const index = posts.value.findIndex((item) => item.id === id)

    if (index !== -1) {
      posts.value[index] = data
    }

    return data
  }

  const deletePost = async (id) => {
    await api.delete(`/posts/${id}`)
    posts.value = posts.value.filter((item) => item.id !== id)
  }

  return {
    posts,
    post,
    loading,
    error,
    fetchPosts,
    fetchPost,
    createPost,
    updatePost,
    deletePost,
  }
}
