import api from './api'
import type { Profile } from './profiles'

export interface User {
  id: number
  name: string
  email: string
  profiles: Profile[]
}

export async function listUsers() {
  const { data } = await api.get<User[]>('/users')
  return data
}

export async function createUser(payload: { name: string; email: string; password: string }) {
  const { data } = await api.post<User>('/users', payload)
  return data
}

export async function updateUser(id: number, payload: { name: string; email: string }) {
  const { data } = await api.put<User>(`/users/${id}`, payload)
  return data
}

export async function deleteUser(id: number) {
  await api.delete(`/users/${id}`)
}

export async function syncUserProfiles(userId: number, profileIds: number[]) {
  const { data } = await api.put<User>(`/users/${userId}/profiles`, { profiles: profileIds })
  return data
}

export async function detachUserProfile(userId: number, profileId: number) {
  await api.delete(`/users/${userId}/profiles`, { data: { profiles: [profileId] } })
}