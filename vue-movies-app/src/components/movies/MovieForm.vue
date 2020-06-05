<template>
  <v-dialog persistent v-model="showDialog" max-width="500px">
    <v-card>
      <v-card-title>
        <span class="headline">{{title}}</span>
      </v-card-title>
      <v-card-text>
        <v-container>
          <Errors v-if="errors.length" :errors="errors"/>
          <v-row>
            <v-col cols="12" sm="12" md="12">
              <v-text-field v-model="movie.name" label="Nombre"/>
            </v-col>
            <v-col cols="12" sm="12" md="12">
              <v-menu
                ref="menu"
                v-model="menu"
                :close-on-content-click="false"
                transition="scale-transition"
                offset-y
                min-width="290px"
              >
                <template v-slot:activator="{ on }">
                  <v-text-field
                    v-model="movie.publication_date"
                    label="Fecha de publicación"
                    readonly
                    v-on="on"
                  ></v-text-field>
                </template>
                <v-date-picker
                  ref="picker"
                  v-model="movie.publication_date"
                  :max="new Date().toISOString().substr(0, 10)"
                  min="1950-01-01"
                  @change="$refs.menu.save(movie.publication_date)"
                ></v-date-picker>
              </v-menu>
            </v-col>
            <v-col cols="12" sm="12" md="12">
              <v-select
                v-model="movie.status"
                label="Estatus"
                item-value="id"
                item-text="status"
                :items="status"
              />
            </v-col>
          </v-row>
        </v-container>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="blue darken-1" text @click="handleCancel">Cancelar</v-btn>
        <v-btn color="blue darken-1" text @click="handleSave">Guardar</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
  import Errors from '../common/Errors';

  export default {
    name: 'MovieForm',
    components: {Errors},
    props: {
      showDialog: Boolean,
      movieData: Object,
      closeDialog: Function,
      saveMovie: Function,
      errors: Array
    },
    data: () => ({
      title: 'Agregar película',
      movie: {
        name: '',
        publication_date: '',
        status: ''
      },
      menu: false,
      status: [
        {
          id: 'A',
          status: 'Activo'
        },
        {
          id: 'I',
          status: 'Inactivo'
        }
      ]
    }),
    methods: {
      handleCancel() {
        this.movie = {};
        this.closeDialog();
      },
      handleSave() {
        this.saveMovie(this.movie);
      }
    },
    watch: {
      movieData: {
        handler(data) {
          this.movie = {...data};
          if (data.id) {
            this.title = 'Editar película';
          } else {
            this.title = 'Agregar película';
          }
        },
        deep: true
      },
      menu(val) {
        val && setTimeout(() => (this.$refs.picker.activePicker = 'YEAR'))
      },
    }
  }
</script>
