import { ref } from 'vue'
import api from '../services/api'

const user = ref(JSON.parse(localStorage.getItem('devlog_user') || 'null'))

export function useAuth() {
  const login = async (credentials) => {
    const { data } = await api.post('/login', credentials)

    localStorage.setItem('devlog_token', data.token)
    localStorage.setItem('devlog_user', JSON.stringify(data.user))
    user.value = data.user

    return data
  }

  const logout = async () => {
    await api.post('/logout').catch(() => {})

    localStorage.removeItem('devlog_token')
    localStorage.removeItem('devlog_user')
    user.value = null
  }

  const isAuthenticated = () => Boolean(localStorage.getItem('devlog_token'))

  return {
    user,
    login,
    logout,
    isAuthenticated,
  }
}
