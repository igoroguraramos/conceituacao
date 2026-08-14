<script setup lang="ts">
defineOptions({
    name: 'ProfilesView'
})

import { ref, onMounted } from 'vue'
import AppModal from '@/components/AppModal.vue'
import { listProfiles, createProfile, updateProfile, deleteProfile, type Profile } from '@/services/profiles'

const profiles = ref<Profile[]>([])

async function loadProfiles() {
    profiles.value = await listProfiles()
}

onMounted(loadProfiles)

const showModal = ref(false)
const editingProfile = ref<Profile | null>(null)
const form = ref({ name: '', description: '' })
const formError = ref('')

function openCreateModal() {
    editingProfile.value = null
    form.value = { name: '', description: '' }
    formError.value = ''
    showModal.value = true
}

function openEditModal(profile: Profile) {
    editingProfile.value = profile
    form.value = { name: profile.name, description: profile.description ?? '' }
    formError.value = ''
    showModal.value = true
}

async function submitProfile() {
    formError.value = ''
    try {
        if (editingProfile.value) {
            await updateProfile(editingProfile.value.id, form.value)
        } else {
            await createProfile(form.value)
        }
        showModal.value = false
        await loadProfiles()
    } catch (e: any) {
        formError.value = e.response?.data?.message || 'Erro ao salvar profile'
    }
}

async function removeProfile(profile: Profile) {
    if (!confirm(`Excluir o profile "${profile.name}"?`)) return
    await deleteProfile(profile.id)
    await loadProfiles()
}
</script>

<template>
    <div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">
                    Profiles
                </h2>

                <p class="text-muted mb-0">
                    Gerencie os profiles e permissões
                </p>
            </div>

            <button class="btn btn-primary" @click="openCreateModal">
                + Novo profile
            </button>
        </div>


    <AppModal :show="showModal" :title="editingProfile ? 'Editar profile' : 'Novo profile'" @close="showModal = false">
        <form @submit.prevent="submitProfile">
            <div class="mb-3">
                <label class="form-label">Nome</label>
                <input v-model="form.name" type="text" class="form-control" required />
            </div>
            <div class="mb-3">
                <label class="form-label">Descrição</label>
                <textarea v-model="form.description" class="form-control"></textarea>
            </div>
            <div v-if="formError" class="alert alert-danger">{{ formError }}</div>
        </form>

        <template #footer>
            <button class="btn btn-secondary" @click="showModal = false">Cancelar</button>
            <button class="btn btn-primary" @click="submitProfile">Salvar</button>
        </template>
    </AppModal>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table align-middle">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Usuários</th>
                            <th>Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="profile in profiles" :key="profile.id">
                            <td>{{ profile.id }}</td>

                            <td>
                                <strong>{{ profile.name }}</strong>
                            </td>

                            <td>
                                {{ profile.description }}
                            </td>

                            <td>
                                <button class="btn btn-sm btn-outline-primary me-2" @click="openEditModal(profile)">
                                    Editar
                                </button>

                                <button class="btn btn-sm btn-outline-danger" @click="removeProfile(profile)">
                                    Excluir
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    </div>
</template>