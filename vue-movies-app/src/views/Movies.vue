<template>
  <div>
    <Errors v-if="errors.length" :errors="errors"/>
    <div class="text-right">
      <v-btn color="green" dark class="mb-2" @click="showFormDialog = true">Agregar</v-btn>
    </div>
    <MovieList
      :movies="movies"
      :total-movies="totalMovies"
      :get-movies="getMovies"
      :edit-movie="requestToEditMovie"
      :delete-movie="requestToDeleteMovie"
    />
    <MovieForm
      :movie-data="movie"
      :show-dialog="showFormDialog"
      :close-dialog="closeFormDialog"
      :save-movie="saveMovie"
      :errors="errorsForm"
    />
    <MovieDelete
      :show-dialog="showDeleteDialog"
      :close-dialog="closeDeleteDialog"
      :delete-movie="deleteMovie"
    />
  </div>
</template>

<script>
  import MovieList from '../components/movies/MovieList';
  import MovieForm from '../components/movies/MovieForm';
  import MovieDelete from '../components/movies/MovieDelete';
  import Errors from '../components/common/Errors';
  import axios from '../config/axios';

  export default {
    name: 'Movies',
    components: {
      MovieList,
      MovieForm,
      MovieDelete,
      Errors
    },
    data: () => ({
      movies: [],
      totalMovies: 0,
      movie: {},
      movieToDelete: {},
      showFormDialog: false,
      showDeleteDialog: false,
      errors: [],
      errorsForm: []
    }),
    methods: {
      async getMovies(options) {
        try {
          const {page, itemsPerPage, sortBy, sortDesc} = options;
          this.errors = [];
          let sortField = null;
          let sortDir = null;
          if (sortBy.length) {
            sortField = sortBy[0]
          }
          if (sortDesc.length) {
            if (sortDesc[0]) {
              sortDir = 'desc'
            } else {
              sortDir = 'asc'
            }
          }
          this.loading = true;
          const response = await axios.get('/movies', {
            params: {
              page,
              itemsPerPage,
              sortField,
              sortDir
            }
          });
          this.movies = response.data.data;
          this.totalMovies = response.data.meta.total;
        } catch (e) {
          this.errors = ['Ocurrió un error al tratar de obtener las películas'];
        } finally {
          this.loading = false;
        }
      },
      async storeMovie(movie) {
        try {
          const request = await axios.post('/movies', movie);
          this.movies.unshift(request.data.data);
          this.totalMovies++;
          this.closeFormDialog();
        } catch (e) {
          const response = e.response;
          if (response.status === 422) {
            this.errorsForm = response.data.errors;
          } else {
            this.errorsForm = ['Ocurrió un error al tratar de crear la película'];
          }
        }
      },
      async updateMovie(movie) {
        try {
          const request = await axios.put(`/movies/${movie.id}`, movie);
          const index = this.movies.findIndex(item => item.id === movie.id);
          this.movies.splice(index, 1, request.data.data);
          this.closeFormDialog();
        } catch (e) {
          const response = e.response;
          if (response.status === 422) {
            this.errorsForm = response.data.errors;
          } else {
            this.errorsForm = ['Ocurrió un error al tratar de actualizar la película'];
          }
        }
      },
      async deleteMovie() {
        try {
          const movie = this.movieToDelete;
          await axios.delete(`/movies/${movie.id}`);
          this.movies = this.movies.filter(item => item.id !== movie.id);
          this.totalMovies--;
        } catch (e) {
          this.errors = ['Ocurrió un error al tratar de eliminar la película'];
        } finally {
          this.closeDeleteDialog();
        }
      },
      saveMovie(movie) {
        if (movie.id) {
          this.updateMovie(movie)
        } else {
          this.storeMovie(movie);
        }
      },
      requestToEditMovie(movie) {
        this.movie = {...movie};
        this.showFormDialog = true;
      },
      closeFormDialog() {
        this.movie = {};
        this.showFormDialog = false;
        this.errorsForm = [];
      },
      requestToDeleteMovie(movie) {
        this.movieToDelete = {
          ...movie
        };
        this.showDeleteDialog = true;
      },
      closeDeleteDialog() {
        this.showDeleteDialog = false
      },
    }
  }
</script>
