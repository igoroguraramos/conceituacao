<script setup lang="ts">
import { ref } from 'vue'
import { login } from '../services/auth'
import { useRouter } from 'vue-router'

const email = ref('')
const password = ref('')
const error = ref('')
const loading = ref(false)
const router = useRouter()
async function handleLogin() {
  error.value = ''
  loading.value = true

  try {
    const response = await login(
      email.value,
      password.value
    )

    console.log('Token:', response.token)

    const user = response.user

    console.log('Usuário autenticado:', user)

    await router.push('/dashboard')
  } catch (e: any) {
    error.value = e.response?.data?.message || 'Erro ao realizar login'
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <div class="login-page">
    <div class="card login-card shadow-lg border-0">
      <div class="card-body p-5">

        <div class="text-center mb-4">
          <h2 class="fw-bold mb-2">
            Bem-vindo
          </h2>

          <p class="text-muted mb-0">
            Entre com sua conta para continuar
          </p>
        </div>

        <form @submit.prevent="handleLogin">

          <div class="mb-3">
            <label for="email" class="form-label">
              E-mail
            </label>

            <input id="email" v-model="email" type="email" class="form-control form-control-lg"
              placeholder="seu@email.com" required />
          </div>

          <div class="mb-4">
            <label for="password" class="form-label">
              Senha
            </label>

            <input id="password" v-model="password" type="password" class="form-control form-control-lg"
              placeholder="Digite sua senha" required />
          </div>

          <div v-if="error" class="alert alert-danger" role="alert">
            {{ error }}
          </div>

          <button type="submit" class="btn btn-primary btn-lg w-100" :disabled="loading">
            <span v-if="loading" class="spinner-border spinner-border-sm me-2" aria-hidden="true"></span>

            {{ loading ? 'Entrando...' : 'Entrar' }}
          </button>

        </form>

      </div>
    </div>
  </div>
</template>

<style scoped>
.login-page {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #f5f7fb;
  padding: 1rem;
}

.login-card {
  width: 100%;
  max-width: 430px;
  border-radius: 16px;
}

.form-control {
  border-radius: 10px;
}

.btn {
  border-radius: 10px;
}
</style>