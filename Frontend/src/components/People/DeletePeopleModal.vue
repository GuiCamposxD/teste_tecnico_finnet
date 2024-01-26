<template>
  <v-dialog
    persistent
    width="500"
    :model-value="true"
  >
    <v-card>
      <v-container>
        <v-row>
          <v-col
            cols="10"
            class="justify-center"
          >
            <p
              class="text-center"
            >
              Ao clicar no botão confirmar a pessoa será excluída permanentemente do sistema
            </p>
          </v-col>
        </v-row>
      </v-container>

      <v-container>
        <v-row>
          <v-col>
            <v-btn
              color="green"
              @click="closeModal"
            >
              Cancelar
            </v-btn>
          </v-col>

          <v-col>
            <v-btn
              color="red"
              @click="deletePerson"
            >
              Confimar Exlcusão
            </v-btn>
          </v-col>
        </v-row>
      </v-container>
    </v-card>

    <v-snackbar
      v-model="shouldShowSnackbar"
      elevation="24"
      :color="snackbarColor"
    >
      <p>{{ snackbarText }}</p>
    </v-snackbar>
  </v-dialog>
</template>

<script>
import axios from 'axios'

export default {
  name: 'DeletePeopleModal',
  props: {
    personId: {
      type: String,
      default: () => (null),
    },
  },
  data() {
    return {
      shouldShowSnackbar: false,
      snackbarColor: null,
      snackbarText: null,
    }
  },
  methods: {
    async deletePerson() {
      const response = await axios.delete('/people', {
        data: { id: this.personId }
      })

      if (response.status === 200) {
        this.snackbarText = 'Usuário exlcuído com sucesso!'
        this.snackbarColor = 'green'
        this.shouldShowSnackbar = true
        this.$emit('update')
      } else if (response.status === 500) {
        this.snackbarText = 'Erro ao excluir usuário'
        this.snackbarColor = 'red'
        this.shouldShowSnackbar = true
      }
      this.closeModal()
    },
    closeModal() {
      this.$emit('closeModal')
    },
  },
}
</script>

<style>

</style>