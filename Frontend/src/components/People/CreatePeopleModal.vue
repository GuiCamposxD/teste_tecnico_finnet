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
          <v-col
            cols="4"
          >
            <v-text-field
              v-model="name"
              label="Nome"
            />
          </v-col>

          <v-col
            cols="4"
          >
            <v-text-field
              :disabled="Boolean(person)"
              v-model="cpf"
              label="CPF"
            />
            
          </v-col>

          <v-col
            cols="4"
          >
            <v-text-field
              v-model="address"
              label="Endereço"
            />
          </v-col>
        </v-row>

        <v-row>
          <v-col
            cols="6"
          >
            <v-select
              v-model="gender"
              label="Gênero"
              :items="genders"
            />
          </v-col>

          <v-col
            cols="6"
          >
            <v-text-field
              v-model="age"
              label="Idade"
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
            v-if="!person"
            cols="4"
            class="d-flex justify-center"
          >
            <v-btn
              color="green"
              @click="createPerson"
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
              @click="updatePerson"
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
import { cpf } from 'cpf-cnpj-validator'

export default {
  name: 'CreatePeopleModal',
  props: {
    person: {
      type: Object,
      default: () => ({}),
    },
  },
  data() {
    return {
      address: null,
      age: null,
      cpf: null,
      gender: null,
      name: null,
      shouldShowSnackbar: false,
      snackbarText: null,
      snackbarColor: null,
      genders: [
        'Masculino',
        'Feminino',
        'Outros',
      ]
    }
  },
  computed: {
    handleTitleName() {
      return this.person ? 'Editar Pessoa' : 'Cadastrar Nova Pessoa'
    },
  },
  mounted() {
    if (this.person) {
      this.address = this.person.address
      this.age = this.person.age
      this.cpf = this.person.cpf
      this.gender = this.person.gender
      this.name = this.person.name
    }
  },
  methods: {
    isCpfValid() {
      if (!cpf.isValid(this.cpf)) {
        this.snackbarText = 'CPF inválido'
        this.snackbarColor = 'red'
        this.shouldShowSnackbar = true
        return
      }
    },
    async createPerson() {
      this.isCpfValid()

      const response = await axios.post('/people', {
        address: this.address,
        age: this.age,
        cpf: this.cpf,
        gender: this.gender,
        name: this.name,
      })

      if (response.status === 201) {
        this.snackbarText = 'Usuário cadastrado com sucesso!'
        this.snackbarColor = 'green'
        this.shouldShowSnackbar = true
        this.$emit('update')
      } else if (response.status === 500) {
        this.snackbarText = 'Erro ao cadastrar usuário, verifique os campos'
        this.snackbarColor = 'red'
        this.shouldShowSnackbar = true
      }
    },
    async updatePerson() {
      const response = await axios.patch('/people', {
        address: this.address,
        age: this.age,
        gender: this.gender,
        id: this.person.id,
        name: this.name,
      })

      if (response.status === 200) {
        this.snackbarText = 'Usuário Atualizado com sucesso!'
        this.snackbarColor = 'green'
        this.shouldShowSnackbar = true
        this.$emit('update')
      } else if (response.status === 500) {
        this.snackbarText = 'Erro ao atualizar usuário, verifique os campos'
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