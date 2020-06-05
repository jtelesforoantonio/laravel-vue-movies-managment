import router from '../router';

export default {
  namespaced: true,
  state: {
    user: JSON.parse(localStorage.getItem('user'))
  },
  mutations: {
    SET_USER(state, payload) {
      state.user = payload;
    }
  },
  actions: {
    login({commit}, payload) {
      localStorage.setItem('user', JSON.stringify(payload));
      commit('SET_USER', payload);
      router.push({name: 'movies.index'})
    },
    logout({commit}) {
      localStorage.removeItem('user');
      commit('SET_USER', null);
      router.push({name: 'login'});
    }
  },
  getters: {
    isAuthenticated: state => state.user !== null
  }
};
