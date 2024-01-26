<template>
  <v-dialog
    persistent
    width="850"
    :model-value="true"
  >
    <v-card>
      <v-container
        class="modal-title__container"
        fluid
      >
        <v-row>
          <v-col
            cols="11"
          >
            <h2>
              Cadastrar Nova Locação
            </h2>
          </v-col>

          <v-col
            cols="1"
            class="d-flex align-center justify-center"
          >
            <v-btn
              color="#E5E1DA"
              icon="mdi-close"
              @click="closeModal"
            />
          </v-col>
        </v-row>
      </v-container>

      <v-container
        class="input__container"
      >
        <v-row>
          <v-col
            class="d-flex align-center"
          >
            <v-autocomplete
              v-model="selectedPerson"
              item-title="name"
              item-value="id"
              label="Pessoa"
              no-data-text="Nenhuma pessoa encontrada"
              return-object
              hide-details
              :items="people"
            />
          </v-col>

          <v-col
            class="d-flex align-center"
          >
            <v-autocomplete
              v-model="selectedBook"
              item-title="title"
              item-value="id"
              label="Livro"
              no-data-text="Nenhum livro encontrado"
              return-object
              hide-details
              :items="books"
            />
          </v-col>
        </v-row>

        <v-row
          class="justify-center"
        >
          <v-col
            cols="auto"
          >
            <vue-date-picker
              v-model="deliveryDate"
              placeholder="Selecione uma data"
              locale="pt-BR"
              auto-apply
              :min-date="minDate"
              :max-date="maxDate"
            />
          </v-col>
        </v-row>

        <v-row
          class="justify-end"
        >
          <v-col
            cols="2"
            class="d-flex justify-center"
          >
            <v-btn
              color="red"
              @click="closeModal"
            >
              Cancelar
            </v-btn>
          </v-col>

          <v-col
            cols="2"
            class="d-flex justify-center"
          >
            <v-btn
              color="green"
              @click="createBookRental"
            >
              Cadastrar
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
import { add, format } from 'date-fns'

export default {
  name: 'CreateBookRentalModal',
  data() {
    return {
      books: [],
      deliveryDate: null,
      people: [],
      selectedBook: null,
      selectedPerson: null,
      shouldShowSnackbar: false,
      snackbarColor: null,
      snackbarText: null,
      minDate: new Date(),
      maxDate: add(new Date(), { months: 1}),
    }
  },
  async mounted() {
    const personReponse = await axios.get('/people')
    this.people = personReponse.data

    const bookReponse = await axios.get('/book/available')
    this.books = bookReponse.data
  },
  methods: {
    async createBookRental() {
      const response = await axios.post('/book_rental', {
        book_id: this.selectedBook.id,
        people_id: this.selectedPerson.id,
        delivery_date: format(this.deliveryDate, 'yyyy-MM-dd HH:mm:ss'),
      })

      if (response.status === 201) {
        this.snackbarText = 'Locação cadastrada com sucesso!'
        this.snackbarColor = 'green'
        this.shouldShowSnackbar = true
        this.$emit('update')
      } else if (response.status === 500) {
        this.snackbarText = 'Erro ao cadastrar locação, verifique os campos'
        this.snackbarColor = 'red'
        this.shouldShowSnackbar = true
      }
    },
    closeModal() {
      this.$emit('closeModal')
    },
  },
}
</script>

<style scoped>
.input__container {
  height: 550px;
}
</style>