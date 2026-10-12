import api from '../services/api'

export function useComments() {
  const addComment = async (postId, payload) => {
    const { data } = await api.post(`/posts/${postId}/comments`, payload)

    return data
  }

  return {
    addComment,
  }
}
