import { ref } from 'vue'
import { defineStore } from 'pinia'

export type ToastType = 'success' | 'error' | 'info'

export interface Toast {
    id: number
    message: string
    type: ToastType
}

let nextId = 0

export const useToastStore = defineStore('toast', () => {
    const toasts = ref<Toast[]>([])

    function push(message: string, type: ToastType = 'info', duration = 4000) {
        const id = nextId++
        toasts.value.push({ id, message, type })
        setTimeout(() => remove(id), duration)
    }

    function remove(id: number) {
        toasts.value = toasts.value.filter((t) => t.id !== id)
    }

    const success = (message: string) => push(message, 'success')
    const error = (message: string) => push(message, 'error')

    return { toasts, push, remove, success, error }
})
