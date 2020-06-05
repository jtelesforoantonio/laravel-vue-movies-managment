import axios from 'axios';
import store from '../store';

axios.defaults.baseURL = process.env.VUE_APP_API_URL;

axios.interceptors.request.use(config => {
  const user = store.state.auth.user;
  if (user) {
    config.headers.Authorization = `Bearer ${user.token}`;
  }

  return config;
}, error => Promise.reject(error));

axios.interceptors.response.use(response => response, error => {
  const response = error.response;
  if (response.status === 401) {
    store.dispatch('auth/logout');
  }

  return Promise.reject(error);
});

export default axios;
