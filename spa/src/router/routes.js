function page (path) {
  return () =>
    import(`@/views/${path}`).then(
      m => m.default || m
    )
}
function comp (path) {
  return () =>
    import(/* webpackChunkName: '' */ `@/components/${path}`).then(
      m => m.default || m
    )
}

export default [
  {
    path: '/',
    name: 'home',
    components: { default: page('home'), header: comp('core/appbar') },
    meta: {
      auth: true
    }
  },
  {
    path: '/login',
    name: 'auth-login',
    component: page('auth')
  },
  {
    path: '/register',
    name: 'auth-register',
    component: page('auth/Register.vue')
  },
  /*users*/
  {
    path: '/Users',
    name: 'Users',
    components: { default: page('users'), header: comp('core/appbar') },
    meta: {
      auth: true
    }
  },
  /*condominios*/
  {
    path: '/Urbanización',
    name: 'Condominios',
    components: { default: page('condominios'), header: comp('core/appbar') },
    meta: {
      auth: true
    }
  },
  /*pagos*/
  {
    path: '/Pagos',
    name: 'Pagos',
    components: { default: page('pagos'), header: comp('core/appbar') },
    meta: {
      auth: true
    }
  },
  /*tickets*/
  {
    path: '/Tickets',
    name: 'Tickets',
    components: { default: page('tickets'), header: comp('core/appbar') },
    meta: {
      auth: true
    }
  },
  /* Errors */
  {
    path: '*',
    name: 'error-404',
    props: false,
    component: page('errors/404.vue')
  }
]
