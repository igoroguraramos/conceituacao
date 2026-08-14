<script setup lang="ts">
defineProps<{
  show: boolean
  title: string
}>()

const emit = defineEmits<{
  close: []
}>()
</script>

<template>
  <div v-if="show">
    <div class="modal d-block" tabindex="-1" @click.self="emit('close')">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ title }}</h5>
            <button type="button" class="btn-close" @click="emit('close')" />
          </div>

          <div class="modal-body">
            <slot />
          </div>

          <div v-if="$slots.footer" class="modal-footer">
            <slot name="footer" />
          </div>
        </div>
      </div>
    </div>

    <div class="modal-backdrop show" />
  </div>
</template>
