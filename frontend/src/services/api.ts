import router from '@/router'
import { useLoadingStore } from '@/stores/loading'
import { useToastStore } from '@/stores/toast'
import axios from 'axios'

const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL,
  headers: {
    Accept: 'application/json',
    'Content-Type': 'application/json',
  },
})

api.interceptors.request.use((config) => {
  useLoadingStore().start()

  const token = localStorage.getItem('token')

  if (token) {
    config.headers.Authorization = `Bearer ${token}`
  }

  return config
})

api.interceptors.response.use(
  (response) => {
    useLoadingStore().stop()
    return response
  },
  (error) => {
    if (error.response?.status === 401) {
      localStorage.removeItem('token')
      localStorage.removeItem('user')
      router.push({ name: 'login' })
    } else {
      useToastStore().error(error.response?.data?.message || 'Ocorreu um erro inesperado.')
    }
    useLoadingStore().stop()
    return Promise.reject(error)
  },
)

export default api