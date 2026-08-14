import api from './api'

interface LoginResponse {
  token: string
  user: {
    id: number
    name: string
    email: string
  }
}

export async function login(email: string, password: string) {
  const { data } = await api.post<LoginResponse>('/login', {
    email,
    password,
  })

  localStorage.setItem('token', data.token)
  localStorage.setItem('user', JSON.stringify(data.user))

  return data
}

export async function getUser() {
  const { data } = await api.get('/users')

  return data
}