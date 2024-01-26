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
              Pessoa
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
              v-model="searchPerson"
              label="Buscar Pessoa"
              no-data-text="Nehuma pessoa encontrada"
              hide-details
              item-value="id"
              item-title="name"
              clearable
              return-object
              :items="people"
            />
          </v-col>

          <v-col
            cols="3"
            class="d-flex align-center"
          >
            <v-btn
              block
              size="large"
              @click="openCreatePeopleModal(null)"
            >
              Cadastrar Nova Pessoa
            </v-btn>
          </v-col>
        </v-row>
      </v-container>
      
      
      <v-container
        class="d-flex flex-column align-center"
      >
        <v-card
          v-for="person in people"
          :key="person.id"
          width="500"
          class="mt-5 pa-5"
        >
          <v-row>
            <v-col
              cols="9"
            >
              <p>
                Nome: <strong>{{ person.name }}</strong>
              </p>
              <p>CPF: {{ person.cpf }}</p>
              <p>Idade: {{ person.age }}</p>
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
                    @click="openCreatePeopleModal(person)"
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
                    @click="openDeletePeopleModal(person)"
                  />
                </template>
              </v-tooltip>
            </v-col>
          </v-row>
        </v-card>
      </v-container>
    </v-card>

    <create-people-modal
      v-if="shouldOpenCreatePeopleModal"
      :person="selectedPerson"
      @closeModal="closeCreatePeopleModal"
      @update="updatePeople"
    />

    <delete-people-modal
      v-if="shouldOpenDeletePeopleModal"
      :personId="selectedPerson.id"
      @closeModal="closeDeletePeopleModal"
      @update="updatePeople"
    />

  </v-dialog>
</template>

<script>
import axios from 'axios'

import CreatePeopleModal from '@/components/People/CreatePeopleModal.vue'
import DeletePeopleModal from '@/components/People/DeletePeopleModal.vue'

export default {
  name: 'PeopleIndexModal',
  components: {
    CreatePeopleModal,
    DeletePeopleModal,
  },
  data() {
    return {
      people: [],
      selectedPerson: null,
      searchPerson: null,
      shouldOpenCreatePeopleModal: false,
      shouldOpenDeletePeopleModal: false,
    }
  },
  watch: {
    searchPerson: {
      async handler(value) {
        if (!value) {
          this.updatePeople()
          return
        }

        const { data } = await axios.get(`/people/${value.id}`, {
          params: { id: value.id }
        })
        this.people = [data]
      },
    },
  },
  async mounted() {
    const { data } = await axios.get('/people')
    this.people = data
  },
  methods: {
    async updatePeople() {
      const { data } = await axios.get('/people')
      this.people = data
    },
    openCreatePeopleModal(person) {
      this.selectedPerson = person
      this.shouldOpenCreatePeopleModal = true
    },
    openDeletePeopleModal(person) {
      this.selectedPerson = person
      this.shouldOpenDeletePeopleModal = true
    },
    closeDeletePeopleModal() {
      this.shouldOpenDeletePeopleModal = false
    },
    closeCreatePeopleModal() {
      this.shouldOpenCreatePeopleModal = false
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