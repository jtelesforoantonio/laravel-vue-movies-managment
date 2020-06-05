<template>
  <v-card width="400" class="mx-auto mt-12" shaped :loading="loading">
    <v-card-title>Administrador de Películas</v-card-title>
    <ValidationObserver v-slot="{ invalid, handleSubmit }" ref="form">
      <v-card-text>
        <form @submit.prevent="handleSubmit(login)" @keyup.enter="handleSubmit(login)">
          <Errors v-show="errors.length" :errors="errors"/>
          <ValidationProvider name="correo" rules="required|email" v-slot="{ errors }">
            <v-text-field
              type="email"
              label="Correo"
              outlined
              required
              autofocus
              v-model="email"
              :error-messages="errors"
            />
          </ValidationProvider>
          <ValidationProvider name="contraseña" rules="required" v-slot="{ errors }">
            <v-text-field
              label="Contraseña"
              outlined
              required
              :type="showPassword ? 'text' : 'password'"
              :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
              :error-messages="errors"
              v-model="password"
              @click:append="showPassword = !showPassword"
            />
          </ValidationProvider>
        </form>
      </v-card-text>
      <v-card-actions>
        <v-spacer/>
        <v-btn color="info" @click="handleSubmit(login)">Iniciar</v-btn>
      </v-card-actions>
    </ValidationObserver>
  </v-card>
</template>

<script>
  import { ValidationObserver, ValidationProvider } from 'vee-validate';
  import Errors from '../components/common/Errors';
  import validate from '../utils/validations/auth/login';
  import axios from '../config/axios';

  validate();

  export default {
    name: 'Login',
    components: {
      Errors,
      ValidationObserver,
      ValidationProvider,
    },
    data() {
      return {
        email: '',
        password: '',
        showPassword: false,
        loading: false,
        errors: []
      }
    },
    methods: {
      async login() {
        try {
          this.loading = true;
          this.errors = [];
          const response = await axios.post('/login', {
            email: this.email,
            password: this.password
          })
          this.$store.dispatch('auth/login', response.data);
        } catch (e) {
          const response = e.response;
          if (response.status === 422) {
            this.errors = response.data.errors;
          } else {
            this.errors = ['Ocurrió un error inesperado inténtalo de nuevo'];
          }
        } finally {
          this.loading = false
        }
      }
    }
  }
</script>
