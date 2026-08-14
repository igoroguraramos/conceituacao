<script setup lang="ts">
defineOptions({
  name: 'ProfilesView'
})
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

      <button class="btn btn-primary">
        + Novo profile
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
                <th>Descrição</th>
                <th>Usuários</th>
                <th>Ações</th>
              </tr>
            </thead>

            <tbody>
              <tr>
                <td>1</td>

                <td>
                  <strong>Admin</strong>
                </td>

                <td>
                  Administrador do sistema
                </td>

                <td>
                  5
                </td>

                <td>
                  <button class="btn btn-sm btn-outline-primary me-2">
                    Editar
                  </button>

                  <button class="btn btn-sm btn-outline-danger">
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