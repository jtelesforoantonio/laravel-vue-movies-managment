import Vue from "vue";
import Vuex from "vuex";
import app from './app';
import auth from './auth';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {},
  mutations: {},
  actions: {},
  modules: {
    app,
    auth
  }
});