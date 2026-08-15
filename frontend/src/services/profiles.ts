import api from './api'

export interface Profile {
  id: number
  name: string
  slug: string
  description: string | null
}

export async function listProfiles() {
  const { data } = await api.get<Profile[]>('/profiles')
  return data
}

export async function createProfile(payload: { name: string; slug: string; description?: string }) {
  const { data } = await api.post<Profile>('/profiles', payload)
  return data
}

export async function updateProfile(id: number, payload: { name: string; slug: string; description?: string }) {
  const { data } = await api.put<Profile>(`/profiles/${id}`, payload)
  return data
}

export async function deleteProfile(id: number) {
  await api.delete(`/profiles/${id}`)
}