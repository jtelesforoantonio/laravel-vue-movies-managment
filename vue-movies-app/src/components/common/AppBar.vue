<template>
  <v-card>
    <v-navigation-drawer
      v-model="drawer"
      app
    >
      <v-list nav dense>
        <v-list-item-group color="primary">
          <router-link :to="{name: 'movies.index'}" tag="span">
            <v-list-item link color="primary">
              <v-list-item-action>
                <v-icon>mdi-filmstrip</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>
                  Películas
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </router-link>
        </v-list-item-group>
      </v-list>
    </v-navigation-drawer>
    <v-app-bar
      app
      color="indigo"
      dark
    >
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"/>
      <v-toolbar-title>{{currentModule}}</v-toolbar-title>
      <v-spacer/>
      {{user.email}}
      <v-menu
        left
        bottom
      >
        <template v-slot:activator="{ on }">
          <v-btn icon v-on="on">
            <v-icon>mdi-dots-vertical</v-icon>
          </v-btn>
        </template>

        <v-list>
          <v-list-item @click="logout">
            <v-list-item-title>Cerrar sesión</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
    </v-app-bar>
  </v-card>
</template>

<script>
  import { mapActions, mapState } from 'vuex';

  export default {
    name: 'AppBar',
    data() {
      return {
        drawer: true
      }
    },
    methods: {
      ...mapActions({
        logout: 'auth/logout'
      })
    },
    computed: {
      ...mapState('app', ['currentModule']),
      ...mapState('auth', ['user'])
    }
  }
</script>
