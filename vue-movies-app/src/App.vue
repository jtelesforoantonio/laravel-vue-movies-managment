<template>
  <v-app>
    <AppBar v-if="isAuthenticated"/>
    <v-content>
      <v-container fluid>
        <v-row>
          <v-col>
            <router-view/>
          </v-col>
        </v-row>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
  import AppBar from './components/common/AppBar';
  import { mapGetters } from 'vuex';

  export default {
    name: "App",
    components: {
      AppBar
    },
    data: () => ({
      //
    }),
    computed: {
      ...mapGetters({
        isAuthenticated: 'auth/isAuthenticated'
      })
    }
  };
</script>
