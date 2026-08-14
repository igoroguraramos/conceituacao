<script setup lang="ts">
defineOptions({
  name: 'UsersView'
})
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

      <button class="btn btn-primary">
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
              <tr>
                <td>1</td>
                <td>Administrador</td>
                <td>admin@email.com</td>
                <td>
                  <span class="badge bg-primary">
                    Admin
                  </span>
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