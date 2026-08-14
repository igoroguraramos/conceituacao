<script setup lang="ts">
import { ref } from 'vue'
import { login, getUser } from '../services/auth'

const email = ref('')
const password = ref('')
const error = ref('')
const userJson = ref('')

async function handleLogin() {
  error.value = ''
  userJson.value = ''

  try {
    const response = await login(
      email.value,
      password.value
    )

    console.log('Token:', response.token)

    const user = await getUser()

    console.log('Usuário autenticado:', user)

    userJson.value = JSON.stringify(user, null, 2)
  } catch (e) {
    error.value = (e as Error).message || 'Erro desconhecido'
  }
}
</script>

<template>
  <div>
    <form @submit.prevent="handleLogin">
      <input
        v-model="email"
        type="email"
        placeholder="E-mail"
      />

      <input
        v-model="password"
        type="password"
        placeholder="Senha"
      />

      <button type="submit">
        Entrar
      </button>

      <p v-if="error">
        {{ error }}
      </p>
    </form>

    <div v-if="userJson">
      <h3>Usuário retornado pelo /user:</h3>

      <pre>{{ userJson }}</pre>
    </div>
  </div>
</template>