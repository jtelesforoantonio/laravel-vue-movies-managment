import Vue from "vue";
import VueRouter from "vue-router";
import store from '../store';

Vue.use(VueRouter);

const routes = [
  {
    path: '/login',
    name: 'login',
    meta: {
      module: 'Login'
    },
    component: () => import(/* webpackChunkName: "login"*/ '../views/Login.vue')
  },
  {
    path: '/movies',
    name: 'movies.index',
    meta: {
      requiresAuth: true,
      module: 'Películas'
    },
    component: () => import(/* webpackChunkName: "movies"*/ '../views/Movies.vue')
  },
  {
    path: '/movies/:id/shifts',
    name: 'movies.shifts',
    props: true,
    meta: {
      requiresAuth: true,
      module: 'Turnos'
    },
    component: () => import(/* webpackChunkName: "movies"*/ '../views/Shifts.vue'),
  },
  {
    path: '*',
    redirect: {
      name: 'movies.index'
    }
  },
];

const router = new VueRouter({
  mode: 'history',
  routes
});

router.beforeEach((to, from, next) => {
  const currentModule = to.meta.module;
  document.title = currentModule;
  store.dispatch('app/setCurrentModule', currentModule);
  const isAuthenticated = store.getters['auth/isAuthenticated'];
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!isAuthenticated) {
      next({name: 'login'});
    } else {
      next();
    }
  } else if (isAuthenticated && to.name === 'login') {
    next({name: 'movies.index'});
  } else {
    next();
  }
});

export default router;
