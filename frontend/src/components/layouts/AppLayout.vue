<script setup lang="ts">
import { ref } from 'vue'
import { RouterView, RouterLink, useRouter } from 'vue-router'
import { useLoadingStore } from '@/stores/loading'

const loadingStore = useLoadingStore()

const router = useRouter()

const sidebarOpen = ref(false)

function logout() {
  localStorage.removeItem('token')
  localStorage.removeItem('user')
  router.push('/login')
}

function getUser() {
  const user = localStorage.getItem('user')
  return user ? JSON.parse(user) : null
}

const isAdmin = getUser()?.profiles?.some((p: any) => p.slug === 'admin') ?? false
</script>

<template>
  <div class="dashboard-layout">
    <div v-if="loadingStore.isLoading" class="global-loading-overlay">
      <div class="spinner-border text-light" role="status">
        <span class="visually-hidden">Carregando...</span>
      </div>
    </div>

    <!-- Sidebar -->
    <aside class="sidebar" :class="{ 'sidebar-open': sidebarOpen }">
      <div class="sidebar-header">
        <h4 class="mb-0 fw-bold">
          Gestão de Usuários
        </h4>

        <button class="btn-close d-lg-none" @click="sidebarOpen = false" />
      </div>

      <nav class="sidebar-nav">

        <RouterLink to="/dashboard" class="nav-item" @click="sidebarOpen = false">
          <span class="icon">📊</span>
          <span>Dashboard</span>
        </RouterLink>

        <RouterLink to="/users" class="nav-item" @click="sidebarOpen = false">
          <span class="icon">👤</span>
          <span>Usuários</span>
        </RouterLink>

        <RouterLink v-if="isAdmin" to="/profiles" class="nav-item" @click="sidebarOpen = false">
          <span class="icon">🛡️</span>
          <span>Profiles</span>
        </RouterLink>


      </nav>

      <div class="sidebar-footer">
        <button class="logout-button" @click="logout">
          <span class="icon">🚪</span>
          <span>Sair</span>
        </button>
      </div>
    </aside>

    <!-- Overlay mobile -->
    <div v-if="sidebarOpen" class="sidebar-overlay d-lg-none" @click="sidebarOpen = false" />

    <!-- Main -->
    <div class="main-content">

      <!-- Header -->
      <header class="topbar">

        <button class="btn btn-light d-lg-none" @click="sidebarOpen = true">
          ☰
        </button>

        <div class="topbar-title">
          <h5 class="mb-0">
            Dashboard
          </h5>
        </div>

        <div class="user-menu">
          <div class="avatar">
            {{ getUser()?.name.charAt(0) }}
          </div>

          <div class="user-info d-none d-md-block">
            <strong>{{ getUser()?.name }}</strong>
          </div>
        </div>

      </header>

      <!-- Content -->
      <main class="content">
        <RouterView />
      </main>

    </div>

  </div>
</template>

<style scoped>
.dashboard-layout {
  min-height: 100vh;
  background: #f5f7fb;
}

/* Sidebar */

.sidebar {
  position: fixed;
  top: 0;
  left: 0;
  width: 250px;
  height: 100vh;

  display: flex;
  flex-direction: column;

  background: #ffffff;
  border-right: 1px solid #e5e7eb;

  z-index: 1000;
}

.sidebar-header {
  height: 70px;

  display: flex;
  align-items: center;
  justify-content: space-between;

  padding: 0 24px;

  border-bottom: 1px solid #e5e7eb;
}

.sidebar-nav {
  flex: 1;
  padding: 20px 12px;
}

.nav-item {
  display: flex;
  align-items: center;
  gap: 12px;

  padding: 12px 16px;
  margin-bottom: 6px;

  border-radius: 10px;

  color: #4b5563;
  text-decoration: none;

  transition: 0.2s;
}

.nav-item:hover {
  background: #f3f4f6;
  color: #111827;
}

.nav-item.router-link-active {
  background: #0d6efd;
  color: white;
}

.icon {
  width: 22px;
  text-align: center;
}

.sidebar-footer {
  padding: 16px;
  border-top: 1px solid #e5e7eb;
}

.logout-button {
  width: 100%;

  display: flex;
  align-items: center;
  gap: 12px;

  padding: 12px 16px;

  border: 0;
  border-radius: 10px;

  background: transparent;
  color: #dc3545;

  text-align: left;

  transition: 0.2s;
}

.logout-button:hover {
  background: #fff1f2;
}

/* Main */

.main-content {
  margin-left: 250px;
  min-height: 100vh;
}

/* Topbar */

.topbar {
  height: 70px;

  display: flex;
  align-items: center;

  padding: 0 30px;

  background: white;
  border-bottom: 1px solid #e5e7eb;
}

.topbar-title {
  flex: 1;
  margin-left: 15px;
}

.user-menu {
  display: flex;
  align-items: center;
  gap: 10px;
}

.avatar {
  width: 40px;
  height: 40px;

  display: flex;
  align-items: center;
  justify-content: center;

  border-radius: 50%;

  background: #0d6efd;
  color: white;

  font-weight: bold;
}

.user-info {
  display: flex;
  flex-direction: column;
}

.user-info small {
  color: #6b7280;
}

/* Content */

.content {
  padding: 30px;
}

/* Mobile */

.sidebar-overlay {
  position: fixed;
  inset: 0;

  background: rgba(0, 0, 0, 0.4);

  z-index: 999;
}

@media (max-width: 991px) {
  .sidebar {
    transform: translateX(-100%);
    transition: transform 0.25s ease;
  }

  .sidebar.sidebar-open {
    transform: translateX(0);
  }

  .main-content {
    margin-left: 0;
  }

  .content {
    padding: 20px;
  }
}

.global-loading-overlay {
  position: fixed;
  inset: 0;
  z-index: 2000;

  display: flex;
  align-items: center;
  justify-content: center;

  background: rgba(0, 0, 0, 0.5);
}

.global-loading-overlay .spinner-border {
  width: 3rem;
  height: 3rem;
}

</style>