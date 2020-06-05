<template>
  <v-data-table
    class="elevation-1"
    loading-text="cargando..."
    :server-items-length="totalMovies"
    :headers="headers"
    :items="movies"
    :loading="loading"
    :options.sync="options"
    :footer-props="{'items-per-page-options': itemsPerPage}"
  >
    <template v-slot:item.status="{item}">
      <v-chip
        text-color="white"
        small
        :color="statusColor(item.status)"
      >
        {{ statusLabel(item.status) }}
      </v-chip>
    </template>
    <template v-slot:item.actions="{item}">
      <v-icon
        small
        class="mr-2"
        color="primary"
        title="editar"
        @click="editMovie(item)"
      >
        mdi-pencil
      </v-icon>
      <v-icon
        small
        class="mr-2"
        title="ver turnos"
        @click="showShifts(item)"
      >
        mdi-menu
      </v-icon>
      <v-icon
        small
        color="red"
        title="eliminar"
        @click="deleteMovie(item)"
      >
        mdi-delete
      </v-icon>
    </template>
    <template v-slot:no-data>
      Sin datos para mostrar <br/>
      <v-btn color="primary" @click="handleGetMovies">Actualizar</v-btn>
    </template>
  </v-data-table>
</template>

<script>
  export default {
    name: 'MovieList',
    props: {
      movies: Array,
      totalMovies: Number,
      getMovies: Function,
      editMovie: Function,
      deleteMovie: Function
    },
    data: () => ({
      headers: [
        {
          text: 'Película',
          align: 'start',
          value: 'name',
        },
        {
          text: 'Fecha de publicación',
          value: 'publication_date',
        },
        {
          text: 'Estatus',
          value: 'status',
        },
        {
          text: 'Acciones',
          value: 'actions',
          sortable: false
        },
      ],
      itemsPerPage: [5, 10, 15],
      options: {},
      loading: false
    }),
    methods: {
      async handleGetMovies() {
        this.loading = true;
        await this.getMovies(this.options);
        this.loading = false;
      },
      statusColor(status) {
        let color = 'green';
        if (status === 'I') {
          color = 'orange'
        }

        return color;
      },
      statusLabel(status) {
        let label = 'Activo';
        if (status === 'I') {
          label = 'Inactivo';
        }

        return label;
      },
      showShifts(movie) {
        this.$router.push({name: 'movies.shifts', params: {id: movie.id, movie}});
      }
    },
    watch: {
      options: {
        handler() {
          this.handleGetMovies();
        },
        deep: true
      }
    }
  }
</script>
