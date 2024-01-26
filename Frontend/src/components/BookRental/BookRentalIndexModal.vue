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
              Locação de Livros
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
            cols="4"
            class="d-flex align-center"
          >
            <v-autocomplete
              v-model="searchSelectedPeople"
              label="Buscar Locador"
              no-data-text="Nenhum locador encontrado"
              hide-details
              item-value="id"
              item-title="name"
              clearable
              return-object
              :items="people"
            />
          </v-col>

          <v-col
            cols="4"
            class="d-flex align-center"
          >
            <v-btn
              block
              size="large"
              @click="openCreateBookRentalModal(null)"
            >
              Cadastrar Nova Locação
            </v-btn>
          </v-col>
        </v-row>
      </v-container>
      
      
      <v-container
        class="d-flex flex-column align-center"
      >
        <v-card
          v-for="rental in booksRental"
          :key="rental.id"
          width="500"
          class="mt-5 pa-5"
        >
          <v-row
            class="mt-5"
          >
            <v-col
              cols="9"
            >
              <p>Locador: <strong>{{ rental.name }}</strong></p>
              <p>
                Título: <strong>{{ rental.title }}</strong>
              </p>
              <p>Autor: {{ rental.author }}</p>
              <p>Data de Locação: <strong>{{ rental.rentalDate }}</strong></p>
              <p>Data de Devolução: <strong>{{ rental.deliveryDate }}</strong></p>
            </v-col>

            <v-col
              class="d-flex align-center flex-column"
            >
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
                    @click="openDeleteBookRentalModal(rental)"
                  />
                </template>
              </v-tooltip>
            </v-col>
          </v-row>
        </v-card>
      </v-container>
    </v-card>

    <create-book-rental-modal
      v-if="shouldOpenCreateBookRentalModal"
      @closeModal="closeCreateBookRentalModal"
      @update="updateBookRental"
    />

    <delete-book-rental-modal
      v-if="shouldOpenDeleteBookModal"
      :bookRental="selectedBookRental"
      @closeModal="closeDeleteBookRentalModal"
      @update="updateBookRental"
    />
  </v-dialog>
</template>

<script>
import axios from 'axios'
import { format } from 'date-fns'

import CreateBookRentalModal from '@/components/BookRental/CreateBookRentalModal.vue'
import DeleteBookRentalModal from '@/components/BookRental/DeleteBookRentalModal.vue'

export default {
  name: 'BookRentalIndexModal',
  components: {
    CreateBookRentalModal,
    DeleteBookRentalModal,
  },
  data() {
    return {
      booksRental: [],
      people: [],
      searchSelectedPeople: null,
      selectedBookRental: null,
      shouldOpenCreateBookRentalModal: false,
      shouldOpenDeleteBookModal: false,
    }
  },
  watch: {
    searchSelectedPeople: {
      async handler(value) {
        if (!value) {
          this.updateBookRental()
          return
        }

        const { data } = await axios.get(`/book_rental/${value.id}`, {
          params: { id: value.id }
        })
        this.booksRental = this.formatBookRentalReponse(data)
      },
    },
  },
  async mounted() {
    const personReponse = await axios.get('/people')
    this.people = personReponse.data

    const bookRentalReponse = await axios.get('/book_rental')
    this.booksRental = this.formatBookRentalReponse(bookRentalReponse.data)
  },
  methods: {
    async updateBookRental() {
      const { data } = await axios.get('/book_rental')
      this.booksRental = this.formatBookRentalReponse(data)
    },
    formatBookRentalReponse(data) {
      return data.flatMap(book => book.people.map(person => ({
        author: book.author,
        bookId: book.id,
        deliveryDate: format(person.pivot.delivery_date, 'dd/MM/yyyy - HH:mm:ss'),
        rentalDate: format(person.pivot.created_at, 'dd/MM/yyyy - HH:mm:ss'),
        id: person.pivot.id,
        name: person.name,
        title: book.title,
      })))
    },
    openCreateBookRentalModal(bookRental) {
      this.selectedBook = bookRental
      this.shouldOpenCreateBookRentalModal = true
    },
    openDeleteBookRentalModal(bookRental) {
      this.selectedBookRental = {
        id: bookRental.id,
        bookId: bookRental.bookId,
      }
      this.shouldOpenDeleteBookModal = true
    },
    closeDeleteBookRentalModal() {
      this.shouldOpenDeleteBookModal = false
    },
    closeCreateBookRentalModal() {
      this.shouldOpenCreateBookRentalModal = false
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
