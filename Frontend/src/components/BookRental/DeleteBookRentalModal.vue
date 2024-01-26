<template>
  <v-dialog
    persistent
    width="500"
    :model-value="true"
  >
    <v-card>
      <v-container>
        <v-row
          class="justify-center"
        >
          <v-col
            cols="10"
          >
            <p
              class="text-center"
            >
              Ao clicar no botão confirmar a locação será excluída permanentemente do sistema
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
              @click="deleteBookRental"
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
  name: 'DeleteBookRentalModal',
  props: {
    bookRental: {
      type: Object,
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
    closeModal() {
      this.$emit('closeModal')
    },
    async deleteBookRental() {
      const response = await axios.delete('/book_rental', {
        data: {
          id: this.bookRental.id,
          book_id: this.bookRental.bookId,
        }
      })

      if (response.status === 200) {
        this.snackbarText = 'Locação exlcuída com sucesso!'
        this.snackbarColor = 'green'
        this.shouldShowSnackbar = true
        this.$emit('update')
      } else if (response.status === 500) {
        this.snackbarText = 'Erro ao excluir locação'
        this.snackbarColor = 'red'
        this.shouldShowSnackbar = true
      }
      this.closeModal()
    },
  },
}
</script>

<style>

</style>