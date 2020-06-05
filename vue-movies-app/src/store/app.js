export default {
  namespaced: true,
  state: {
    currentModule: 'Películas'
  },
  mutations: {
    SET_CURRENT_MODULE(state, payload) {
      state.currentModule = payload;
    }
  },
  actions: {
    setCurrentModule({commit}, payload) {
      commit('SET_CURRENT_MODULE', payload);
    }
  }
};
