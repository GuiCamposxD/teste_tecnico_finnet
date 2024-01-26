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
              {{ handleTitleName }}
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

      <v-container>
        <v-row>
          <v-col>
            <v-text-field
              v-model="title"
              label="Título"
            />
          </v-col>

          <v-col>
            <v-text-field
              v-model="author"
              label="Autor"
            />
          </v-col>
        </v-row>

        <v-row>
          <v-col>
            <v-text-field
              v-model="publisher"
              label="Editora"
            />
          </v-col>

          <v-col>
            <v-text-field
              v-model="quantity"
              label="Quantidade Disponível"
            />
          </v-col>
        </v-row>

        <v-row
          class="justify-end"
        >
          <v-col
            cols="3"
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
            v-if="!book"
            cols="4"
            class="d-flex justify-center"
          >
            <v-btn
              color="green"
              @click="createBook"
            >
              Cadastrar
            </v-btn>
          </v-col>

          <v-col
            v-else
            cols="4"
            class="d-flex justify-center"
          >
            <v-btn
              color="green"
              @click="updateBook"
            >
              Atualizar Cadastro
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
  name: 'CreateBookModal',
  props: {
    book: {
      type: Object,
      default: () => ({}),
    },
  },
  data() {
    return {
      author: null,
      publisher: null,
      quantity: null,
      shouldShowSnackbar: false,
      snackbarColor: null,
      snackbarText: null,
      title: null,
    }
  },
  computed: {
    handleTitleName() {
      return this.book ? 'Editar Livro' : 'Cadastrar Novo Livro'
    },
  },
  mounted() {
    if (this.book) {
      this.author = this.book.author
      this.publisher = this.book.publisher
      this.title = this.book.title
      this.quantity = this.book.quantity
    }
  },
  methods: {
    async createBook() {
      const response = await axios.post('/book', {
        author: this.author,
        publisher: this.publisher,
        quantity: this.quantity,
        title: this.title,
      })

      if (response.status === 201) {
        this.snackbarText = 'Livro cadastrado com sucesso!'
        this.snackbarColor = 'green'
        this.shouldShowSnackbar = true
        this.$emit('update')
      } else if (response.status === 500) {
        this.snackbarText = 'Erro ao cadastrar livro, verifique os campos'
        this.snackbarColor = 'red'
        this.shouldShowSnackbar = true
      }
    },
    async updateBook() {
      const response = await axios.patch('/book', {
        author: this.author,
        id: this.book.id,
        publisher: this.publisher,
        quantity: this.quantity,
        title: this.title,
      })

      if (response.status === 200) {
        this.snackbarText = 'Livro Atualizado com sucesso!'
        this.snackbarColor = 'green'
        this.shouldShowSnackbar = true
        this.$emit('update')
      } else if (response.status === 500) {
        this.snackbarText = 'Erro ao atualizar livro, verifique os campos'
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

<style>

</style>