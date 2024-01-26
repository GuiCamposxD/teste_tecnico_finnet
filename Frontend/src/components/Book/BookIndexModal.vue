<template>
  <v-dialog
    :model-value="true"
    fullscreen
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
            <h2
              class="text-white modal__title text-weigth-bold"
            >
              Livro
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
        <v-row
          class="justify-space-evenly"
        >
          <v-col
            cols="3"
            class="d-flex align-center"
          >
            <v-autocomplete
              v-model="searchBook"
              label="Buscar Livro"
              no-data-text="Nehum livro encontrado"
              hide-details
              item-value="id"
              item-title="title"
              clearable
              return-object
              :items="books"
            />
          </v-col>

          <v-col
            cols="3"
            class="d-flex align-center"
          >
            <v-btn
              block
              size="large"
              @click="openCreateBookModal(null)"
            >
              Cadastrar Novo Livro
            </v-btn>
          </v-col>
        </v-row>
      </v-container>
      
      
      <v-container
        class="d-flex flex-column align-center"
      >
        <v-card
          v-for="book in books"
          :key="book.id"
          width="500"
          class="mt-5 pa-5"
        >
          <v-row>
            <v-col
              cols="9"
            >
              <p>
                Título: <strong>{{ book.title }}</strong>
              </p>
              <p>Autor: {{ book.author }}</p>
              <p>Editora: {{ book.publisher }}</p>
              <p>Quantidade: {{ book.quantity }}</p>
            </v-col>

            <v-col
              class="d-flex align-center flex-column"
            >
              <v-tooltip
                text="Editar"
                location="top"
              >
                <template
                  v-slot:activator="{ props }"
                >
                  <v-btn
                    v-bind="props"
                    size="x-small"
                    icon="mdi-pencil"
                    @click="openCreateBookModal(book)"
                  />
                </template>
              </v-tooltip>

              <v-tooltip
                text="Excluir"
                location="top"
              >
                <template
                  v-slot:activator="{ props }"
                >
                  <v-btn
                    v-bind="props"
                    size="x-small"
                    icon="mdi-delete-forever"
                    color="red"
                    class="mt-5"
                    @click="openDeleteBookModal(book)"
                  />
                </template>
              </v-tooltip>
            </v-col>
          </v-row>
        </v-card>
      </v-container>
    </v-card>

    <create-book-modal
      v-if="shouldOpenCreateBookModal"
      :book="selectedBook"
      @closeModal="closeCreateBookModal"
      @update="updateBook"
    />

    <delete-book-modal
      v-if="shouldOpenDeleteBookModal"
      :bookId="selectedBook.id"
      @closeModal="closeDeleteBookModal"
      @update="updateBook"
    />
  </v-dialog>
</template>

<script>
import axios from 'axios'

import CreateBookModal from '@/components/Book/CreateBookModal.vue'
import DeleteBookModal from '@/components/Book/DeleteBookModal.vue'

export default {
  name: 'BookIndexModal',
  components: {
    CreateBookModal,
    DeleteBookModal,
  },
  data() {
    return {
      books: [],
      selectedBook: null,
      searchBook: null,
      shouldOpenCreateBookModal: false,
      shouldOpenDeleteBookModal: false,
    }
  },
  watch: {
    searchBook: {
      async handler(value) {
        if (!value) {
          this.updateBook()
          return
        }

        const { data } = await axios.get(`/book/${value.id}`, {
          params: { id: value.id }
        })
        this.books = [data]
      },
    },
  },
  async mounted() {
    const { data } = await axios.get('/book')
    this.books = data
  },
  methods: {
    async updateBook() {
      const { data } = await axios.get('/book')
      this.books = data
    },
    openCreateBookModal(book) {
      this.selectedBook = book
      this.shouldOpenCreateBookModal = true
    },
    openDeleteBookModal(book) {
      this.selectedBook = book
      this.shouldOpenDeleteBookModal = true
    },
    closeDeleteBookModal() {
      this.shouldOpenDeleteBookModal = false
    },
    closeCreateBookModal() {
      this.shouldOpenCreateBookModal = false
    },
    closeModal() {
      this.$emit('closeModal')
    }
  }
}
</script>

<style scoped>
.modal-title__container {
  background-color: #92C7CF;
}

.modal__title {
  font-size: 2rem;
}
</style>