<script setup lang="ts">
import { ref, onMounted } from 'vue'
import AppModal from '@/components/AppModal.vue'
import { listUsers, createUser, updateUser, deleteUser, syncUserProfiles, type User } from '@/services/users'
import { listProfiles, type Profile } from '@/services/profiles'

defineOptions({
    name: 'UsersView',
})

const users = ref<User[]>([])
const allProfiles = ref<Profile[]>([])
const currentUser = JSON.parse(localStorage.getItem('user') || 'null')
const isAdmin = currentUser?.profiles?.some((p: Profile) => p.slug === 'admin') ?? false

async function loadUsers() {
    users.value = await listUsers()
}

async function loadAllProfiles() {
    allProfiles.value = await listProfiles()
}

onMounted(async () => {
    await Promise.all([loadUsers(), loadAllProfiles()])
})

// --- criar/editar usuário ---
const showUserModal = ref(false)
const editingUser = ref<User | null>(null)
const userForm = ref({ name: '', email: '', password: '' })
const userFormError = ref('')

function openCreateModal() {
    editingUser.value = null
    userForm.value = { name: '', email: '', password: '' }
    userFormError.value = ''
    showUserModal.value = true
}

function openEditModal(user: User) {
    editingUser.value = user
    userForm.value = { name: user.name, email: user.email, password: '' }
    userFormError.value = ''
    showUserModal.value = true
}

async function submitUser() {
    userFormError.value = ''
    try {
        if (editingUser.value) {
            await updateUser(editingUser.value.id, {
                name: userForm.value.name,
                email: userForm.value.email,
            })
        } else {
            await createUser(userForm.value)
        }
        showUserModal.value = false
        await loadUsers()
    } catch (e: any) {
        userFormError.value = e.response?.data?.message || 'Erro ao salvar usuário'
    }
}

const showLinkModal = ref(false)
const linkingUser = ref<User | null>(null)
const selectedProfileIds = ref<number[]>([])

function openLinkModal(user: User) {
    linkingUser.value = user
    selectedProfileIds.value = user.profiles.map((p) => p.id)
    showLinkModal.value = true
}

async function submitLinkProfiles() {
    if (!linkingUser.value) return
    await syncUserProfiles(linkingUser.value.id, selectedProfileIds.value)
    showLinkModal.value = false
    await loadUsers()
}

async function removeUser(user: User) {
    if (!confirm(`Excluir o usuário "${user.name}"?`)) return
    await deleteUser(user.id)
    await loadUsers()
}
</script>

<template>
    <div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">
                    Usuários
                </h2>

                <p class="text-muted mb-0">
                    Gerencie os usuários do sistema
                </p>
            </div>

            <button class="btn btn-primary" @click="openCreateModal">
                + Novo usuário
            </button>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table align-middle">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>E-mail</th>
                                <th>Profile</th>
                                <th>Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="user in users" :key="user.id">
                                <td>{{ user.id }}</td>
                                <td>{{ user.name }}</td>
                                <td>{{ user.email }}</td>
                                <td>
                                    <span v-for="profile in user.profiles" :key="profile.id"
                                        class="badge bg-primary me-1">
                                        {{ profile.name }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary me-2" @click="openEditModal(user)">
                                        Editar
                                    </button>

                                    <button class="btn btn-sm btn-outline-danger me-2" @click="removeUser(user)">
                                        Excluir
                                    </button>

                                    <button v-if="isAdmin" class="btn btn-sm btn-outline-secondary"
                                        @click="openLinkModal(user)">
                                        Vincular perfil
                                    </button>
                                </td>
                            </tr>
                        </tbody>

                    </table>
                </div>

            </div>
        </div>

        <AppModal :show="showUserModal" :title="editingUser ? 'Editar usuário' : 'Novo usuário'"
            @close="showUserModal = false">
            <form @submit.prevent="submitUser">
                <div class="mb-3">
                    <label class="form-label">Nome</label>
                    <input v-model="userForm.name" type="text" class="form-control" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">E-mail</label>
                    <input v-model="userForm.email" type="email" class="form-control" required />
                </div>
                <div v-if="!editingUser" class="mb-3">
                    <label class="form-label">Senha</label>
                    <input v-model="userForm.password" type="password" class="form-control" minlength="8" required />
                </div>
                <div v-if="userFormError" class="alert alert-danger">
                    {{ userFormError }}
                </div>
            </form>

            <template #footer>
                <button class="btn btn-secondary" @click="showUserModal = false">Cancelar</button>
                <button class="btn btn-primary" @click="submitUser">Salvar</button>
            </template>
        </AppModal>


        <AppModal :show="showLinkModal" title="Vincular perfis" @close="showLinkModal = false">
            <div v-for="profile in allProfiles" :key="profile.id" class="form-check">
                <input class="form-check-input" type="checkbox" :id="`profile-${profile.id}`" :value="profile.id"
                    v-model="selectedProfileIds" />
                <label class="form-check-label" :for="`profile-${profile.id}`">
                    {{ profile.name }}
                </label>
            </div>

            <template #footer>
                <button class="btn btn-secondary" @click="showLinkModal = false">Cancelar</button>
                <button class="btn btn-primary" @click="submitLinkProfiles">Salvar</button>
            </template>
        </AppModal>

    </div>
</template>
