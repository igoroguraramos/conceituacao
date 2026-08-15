<script setup lang="ts">
import { useToastStore } from '@/stores/toast'

const toastStore = useToastStore()

const typeClass: Record<string, string> = {
    success: 'text-bg-success',
    error: 'text-bg-danger',
    info: 'text-bg-primary',
}
</script>

<template>
    <div class="toast-stack">
        <div v-for="toast in toastStore.toasts" :key="toast.id" class="toast show align-items-center border-0 mb-2"
            :class="typeClass[toast.type]" role="alert">
            <div class="d-flex">
                <div class="toast-body">{{ toast.message }}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto"
                    @click="toastStore.remove(toast.id)"></button>
            </div>
        </div>
    </div>
</template>

<style scoped>
.toast-stack {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 3000;
    min-width: 280px;
}
</style>