<script setup lang="ts">
import AppToasts from '@/components/AppToasts.vue'
import { RouterView } from 'vue-router'
</script>

<template>
  <RouterView />
  <AppToasts />
</template>