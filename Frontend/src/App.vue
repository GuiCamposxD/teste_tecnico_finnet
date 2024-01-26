<template>
  <div>
    <the-header />

    <main>
      <v-container
        class="d-flex align-center flex-column mt-10"
      >
        <v-card
          class="d-flex flex-column pa-15"
          height="500"
          color="#FBF9F1"
        >
          <v-row
            v-for="option in selectionOptions"
            :key="option"
            class="align-center"
          >
            <v-col>
              <v-btn
                block
                @click="handleOpenModal(option.value)"
              >
                {{ option.title }}
              </v-btn>
            </v-col>
          </v-row>
        </v-card>
      </v-container>

      <people-index-modal
        v-if="shouldOpenPeopleModal"
        @closeModal=closePeopleModal
      />

      <book-index-modal
        v-if="shouldOpenBookModal"
        @closeModal=closeBookModal
      />

      <book-rental-index-modal
        v-if="shouldOpenBookRentalModal"
        @closeModal=closeBookRentalModal
      />
    </main>
  </div>
</template>

<script>
import axios from 'axios'

import BookIndexModal from '@/components/Book/BookIndexModal.vue'
import BookRentalIndexModal from '@/components/BookRental/BookRentalIndexModal.vue'
import PeopleIndexModal from '@/components/People/PeopleIndexModal.vue'
import TheHeader from '@/components/TheHeader.vue'

export default {
  name: 'Home',
  data() {
    return {
      shouldOpenBookModal: false,
      shouldOpenBookRentalModal: false,
      shouldOpenPeopleModal: false,
      selectionOptions: [
        {
          title: 'Pessoas',
          value: 'people',
        },
        {
          title: 'Livros',
          value: 'book',
        },
        {
          title: 'Locação de Livros',
          value: 'bookRental',
        }
      ]
    }
  },
  components: {
    BookIndexModal,
    BookRentalIndexModal,
    PeopleIndexModal,
    TheHeader,
  },
  methods: {
    async callApi() {
      axios.get('/teste')
    },
    handleOpenModal(option) {
      switch (option) {
        case 'people':
          this.shouldOpenPeopleModal = true
          break
        case 'book':
          this.shouldOpenBookModal = true
          break
        case 'bookRental':
          this.shouldOpenBookRentalModal = true
          break
        default:
          break
      }
    },
    closePeopleModal() {
      this.shouldOpenPeopleModal = false
    },
    closeBookModal() {
      this.shouldOpenBookModal = false
    },
    closeBookRentalModal() {
      this.shouldOpenBookRentalModal = false
    },
  }
}
</script>
